<?php
namespace Chatbot\Model;

class Users
{
    private $id;
    private $userLogin;
    private $userPassword;
    private $defaultCurrency;
    private $accountBalance;
    private $createdAt;

    public function exchangeArray(array $data){
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->userLogin = !empty($data['user_login']) ? $data['user_login'] : null;
        $this->userPassword = !empty($data['user_password']) ? $data['user_password'] : null;
        $this->defaultCurrency = !empty($data['default_currency']) ? $data['default_currency'] : null;
        $this->accountBalance = !empty($data['account_balance']) ? $data['account_balance'] : null;
        $this->createdAt = !empty($data['created_at']) ? $data['created_at'] : null;
    }
        
    public function getId()
    {
        return $this->id;
    }

    public function getUserLogin()
    {
        return $this->userLogin;
    }

    public function getUserPassword()
    {
        return $this->userPassword;
    }

    public function getDefaultCurrency()
    {
        return $this->defaultCurrency;
    }

    public function getAccountBalance()
    {
        return $this->accountBalance;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUserLogin($userLogin)
    {
        $this->userLogin = $userLogin;
    }

    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;
    }

    public function setDefaultCurrency($defaultCurrency)
    {
        $this->defaultCurrency = $defaultCurrency;
    }

    public function setAccountBalance($accountBalance)
    {
        $this->accountBalance = $accountBalance;
    }
    
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'user_login' => $this->userLogin,
            'user_password' => $this->userPassword,
            'default_currency' => $this->defaultCurrency,
            'account_balance' => $this->accountBalance,
            'created_at' => $this->createdAt,
        ];
    }
}