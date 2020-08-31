<?php
namespace Chatbot\Controller;
//use Zend\Db\Adapter\Driver\Sqlsrv\Result;


use Chatbot\Model\TransactionsRepository;
use Chatbot\Model\UsersRepository;
use Chatbot\Service\ChatManager;
use Chatbot\Storage\Authenticate;
use Exception;
use Interop\Container\ContainerInterface;
use Throwable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private $containerInterface;
    private $CurrencyAPI;
    private $chat;
    private $salt;

    public function __construct(ContainerInterface $containerInterface, $CurrencyAPI, ChatManager $chat, $salt)
	{
        $this->containerInterface = $containerInterface;
        $this->CurrencyAPI = $CurrencyAPI;
        $this->chat = $chat;
        $this->salt = $salt;
    }
	
    public function indexAction()
    {
        return new ViewModel();
    }
    
    protected $authenticate;

    public function getAuthenticate()
    {
        $this->authenticate=$this->containerInterface->get(Authenticate::class);
        return $this->authenticate;
    }
    
    private function authLogin($auth, $postData){
        $result = $auth->login(
                $postData['user'],
                md5($postData['password'].md5($this->salt)),
                $this->getRequest()->getServer('HTTP_USER_AGENT'),
                $this->getRequest()->getServer('REMOTE_ADDR'));
        return $result;
    }
    
    private function accountBalance(){
        if(!isset($_SESSION["Zend_Auth"]["storage"]->id)){
            echo $this->chat->unpredictableError();exit;
        }
        $usersSelected = $this->containerInterface->get(UsersRepository::class)
            ->select('id = '.$_SESSION["Zend_Auth"]["storage"]->id);
        foreach ($usersSelected as $userSelected){
            $accountBalance = $userSelected->getAccountBalance();
        }
        return $accountBalance;
    }
    
    private function getPostDataAmount($postData,$from){
        if(isset($postData['amount']) && is_numeric($postData['amount'])){
            $amount = $postData['amount'];
        } else {
            if($from == 'deposit'){
                echo $this->chat->wrongAmountOnDeposit();exit;
            }
            if($from == 'deposit'){
                echo $this->chat->wrongAmountOnWithdraw();exit;
            }
            echo $this->chat->unpredictableError();exit;
        }
        return $amount;
    }
    
    private function setNewAccountBalance($amount,$transaction){
        $accountBalance = $this->accountBalance();
        if($transaction=='deposit'){
            $newAccountBalance = $accountBalance+(int)($amount*100);
        }
        if($transaction=='withdraw'){
            $newAccountBalance = $accountBalance-(int)($amount*100);
        }
        if($newAccountBalance < 0 && $transaction=='withdraw'){
            echo $this->chat->notEnoughFundsOnWithdraw();exit;
        }
        if($newAccountBalance < 0){
            echo $this->chat->unpredictableError();exit;
        }
        $this->containerInterface->get(UsersRepository::class)
            ->update(['account_balance'=>$newAccountBalance],
                'id = '.$_SESSION["Zend_Auth"]["storage"]->id);
        $_SESSION["Zend_Auth"]["storage"]->account_balance = $newAccountBalance;
    }
    
    private function logTransaction($transactionkind,$currency,$amount,
        $balanceAfter=null,$userId=null){
        if(!isset($balanceAfter)){
            $balanceAfter = $_SESSION["Zend_Auth"]["storage"]->account_balance;
        }
        if(!isset($userId)){
            $userId = $_SESSION["Zend_Auth"]["storage"]->id;
        }
        $data=['transaction_kind'=>$transactionkind,
            'currency'=>mb_strtoupper($currency), 
            'amount'=>$amount*100,
            'balance_after'=>$balanceAfter,
            'user_id'=>$userId];
        $this->containerInterface->get(TransactionsRepository::class)->insert($data);
    }
    
    public function loginAction(){
        $auth = $this->getAuthenticate();
        if($this->params()->fromPost()){
            $postData = $this->params()->fromPost();
            $result = $this->authLogin($auth, $postData);
            if ($result->isValid()) {
                return $this->response->setContent($this->chat->successfulLogin(
                    $_SESSION["Zend_Auth"]["storage"]->user_login));
            }
        }
        return $this->response->setContent($this->chat->failedLogin());
    }
    
    public function loggedInAction(){
        $auth = $this->getAuthenticate();
        if($auth->hasIdentity()){
            $userLogin = $_SESSION["Zend_Auth"]["storage"]->user_login;
            return $this->response->setContent($this->chat->loggedInSession($userLogin));
        }
        return $this->response->setContent($this->chat->noLoggedInSession());
    }
    
    public function createAction(){
        if($this->params()->fromPost()){
            $postData = $this->params()->fromPost();
        }
        else {
            return $this->response->setContent($this->chat->failedToFetchPostforCreateAccount());
        }
        try{
            $currencies = $this->CurrencyAPI->getAvailableCurrencies();
            if(!isset($currencies["symbols"][mb_strtoupper($postData['currency'])])){
                return $this->response->setContent($this->chat->wrongCurrencyOnCreateAccount($currencies["symbols"]));
            }
            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $postData['user'])){
                return $this->response->setContent($this->chat->wrongNameOnCreateAccount());
            }
            $data=['user_login'=>$postData['user'],
                'user_password'=>md5($postData['password'].md5($this->salt)), 
                'default_currency'=>mb_strtoupper($postData['currency'])];
            $this->containerInterface->get(UsersRepository::class)->insert($data);
            $auth = $this->getAuthenticate();
            $result = $this->authLogin($auth, $postData);
            if ($result->isValid()) {
                return $this->response->setContent($this->chat->successfulCreateAccount());
            }
            else {
                return $this->response->setContent($this->chat->unpredictableError());
            }
        } catch (Throwable $e) { 
            // For PHP 7
            return $this->response->setContent($this->chat->failedToCreateAccount($postData['user']));
        } catch (Exception $e) { 
            // For PHP 5
            return $this->response->setContent($this->chat->failedToCreateAccount($postData['user']));
        }
        return $this->response->setContent($this->chat->unpredictableError());
    }

    public function logoutAction()
    {
        if ($this->getAuthenticate()->hasIdentity()) {
            $this->getAuthenticate()->logout();
            return $this->response->setContent($this->chat->successfulLogOut());
        }
        return $this->response->setContent($this->chat->notLoggedInToLogOut());
    }
    
    public function depositAction(){
        $auth = $this->getAuthenticate();
        if($auth->hasIdentity()){
            $postData = $this->params()->fromPost();
            $amount = $this->getPostDataAmount($postData,'deposit');
            $currencies = $this->CurrencyAPI->getAvailableCurrencies();
            if(!isset($currencies["symbols"][mb_strtoupper($postData['currency'])])){
                return $this->response->setContent($this->chat->wrongCurrencyOnDeposit($currencies));
            }
            $convertedAmount = $this->CurrencyAPI->convertAmount(
                mb_strtoupper($postData['currency']),
                $_SESSION["Zend_Auth"]["storage"]->default_currency,
                $amount);
            $this->setNewAccountBalance($convertedAmount, 'deposit');
            $this->logTransaction('deposit',$postData['currency'],$amount);
            return $this->response->setContent($this->chat->successfulDeposit());
        }else{
            return $this->response->setContent($this->chat->notLoggedIn());
        }
    }
    
    public function withdrawAction(){
        $auth = $this->getAuthenticate();
        if($auth->hasIdentity()){
            $postData = $this->params()->fromPost();
            $amount = $this->getPostDataAmount($postData,'withdraw');
            $currencies = $this->CurrencyAPI->getAvailableCurrencies();
            if(!isset($currencies["symbols"][mb_strtoupper($postData['currency'])])){
                return $this->response->setContent($this->chat->wrongCurrencyOnWithdraw($currencies["symbols"]));
            }
            $convertedAmount = $this->CurrencyAPI->convertAmount(
                mb_strtoupper($postData['currency']),
                $_SESSION["Zend_Auth"]["storage"]->default_currency,
                $amount);
            $this->setNewAccountBalance($convertedAmount, 'withdraw');
            $this->logTransaction('withdraw',$postData['currency'],$amount);
            return $this->response->setContent($this->chat->successfulWithdraw());
        }else{
            return $this->response->setContent($this->chat->notLoggedIn());
        }
    }
    
    public function showAction(){
        $auth = $this->getAuthenticate();
        if($auth->hasIdentity()){
            $usersSelected = $this->containerInterface->get(UsersRepository::class)
                ->select('id = '.$_SESSION["Zend_Auth"]["storage"]->id);
            foreach ($usersSelected as $userSelected){
                $accountBalance = $userSelected->getAccountBalance();
                $defaultCurrency = $userSelected->getDefaultCurrency();
            }
            $_SESSION["Zend_Auth"]["storage"]->account_balance = $accountBalance;

            $accountBalance = $accountBalance/100;
            return $this->response->setContent($this->chat->showBalance($defaultCurrency, $accountBalance));

        }else{
            return $this->response->setContent($this->chat->notLoggedIn());
        }
    }
}
