<?php
namespace Chatbot\Service;

class ChatManager 
{
    public function showBalance($defaultCurrency,$accountBalance){
        if($accountBalance == 0){
            $accountBalance = '0.00';
        }
        $botResponse['answer'] = 'You have '.$defaultCurrency.'$'.$accountBalance
            . ' in your account. Is there anything else I can help you?';
        $botResponse['code'] = 5;
        return json_encode($botResponse);
    }
    
    public function notLoggedIn(){
        $botResponse['answer'] = 'First I need to know who you are. Do I '
            . 'know you?';
        $botResponse['code'] = 1;
        return json_encode($botResponse);
    }
    
    public function successfulWithdraw(){
        $botResponse['answer'] = 'Your withdraw was successful. Is there '
            . 'anything else I can help you with?';
        $botResponse['code'] = 5;
        return json_encode($botResponse);
    }
    
    public function notEnoughFundsOnWithdraw(){
        $botResponse['answer'] = 'Sorry, but you don\'t have enough '
            . 'funds for this withdraw. Is there anything else I can '
            . 'help you with?';
        $botResponse['code'] = 5;
        return json_encode($botResponse);
    }
    
    public function wrongCurrencyOnWithdraw(array $currencies){
        $botResponse['answer'] = 'Since you are having trouble setting '
        . 'the 3 digit code for this deposit currency, here is a list '
        . 'of currencies:<br>';
        foreach($currencies as $currencyCode => $currencyName){
            $botResponse['answer'] .= "$currencyCode-$currencyName<br>";
        }
        $botResponse['code'] = 9;
        return json_encode($botResponse);
    }
    
    public function wrongAmountOnWithdraw(){
        $botResponse['answer'] = 'The amount is invalid and I can\'t '
            . 'procced with this withdraw. Is there anything else I can '
            . 'help you with?';
        $botResponse['code'] = 5;
        return json_encode($botResponse);
    }
    
    public function successfulDeposit(){
        $botResponse['answer'] = 'Your deposit was successful. Is there '
            . 'anything else I can help you with?';
        $botResponse['code'] = 5;
        return json_encode($botResponse);
    }
    
    public function wrongCurrencyOnDeposit(array $currencies){
        $botResponse['answer'] = 'Since you are having trouble setting '
        . 'the 3 digit code for this deposit currency, here is a list '
        . 'of currencies:<br>';
        foreach($currencies as $currencyCode => $currencyName){
            $botResponse['answer'] .= "$currencyCode-$currencyName<br>";
        }
        $botResponse['code'] = 7;
        return json_encode($botResponse);
    }
    
    public function wrongAmountOnDeposit(){
        $botResponse['answer'] = 'The amount is invalid and I can\'t '
            . 'procced with this deposit. Is there anything else I can '
            . 'help you with?';
        $botResponse['code'] = 5;
        return json_encode($botResponse);
    }
    
    public function notLoggedInToLogOut(){
        $botResponse['answer'] = 'You are not logged in to be able to logout. '
            . 'Now, Do I know you?';
        $botResponse['code'] = 1;
        return json_encode($botResponse);
    }
    
    public function successfulLogOut(){
        $botResponse['answer'] = 'Hope to see you soon! Bye... Oh, Hi there! '
            . 'Do I know you?';
        $botResponse['code'] = 1;
        return json_encode($botResponse);
    }
    
    public function failedToFetchPostforCreateAccount(){
        $botResponse['answer'] = 'Something is not right with your info... '
            . 'Let\'s try again. Do I know you?'.
        $botResponse['code'] = 1;
        return json_encode($botResponse);
    }
    
    public function failedToCreateAccount($username){
        $botResponse['answer'] = 'There was an error creating your user. '
            . 'You are probably not who you say you are, or I '
            . 'already know someone named '.$username.'. Let\'s '
            . 'try again with a diferente name. Do I know you?';
        $botResponse['code'] = 1;
        return json_encode($botResponse);
    }
    
    public function successfulCreateAccount(){
        $botResponse['answer'] = 'All set! Welcome to our exchange account '
            . 'system. I don\'t have a name (I\'m a computer software), but '
            . 'I can help you to deposit, withdraw, and check your account '
            . 'balance. How can I help you today?';
        $botResponse['code'] = 5;
        return json_encode($botResponse);
    }
    
    public function wrongNameOnCreateAccount(){
        $botResponse['answer'] = 'You can\'t use special characters on your '
            . 'name. let\'s start over. Do I know you?';
        $botResponse['code'] = 1;
        return json_encode($botResponse);
    }
    
    public function wrongCurrencyOnCreateAccount(array $currencies){
        $botResponse['answer'] = 'Since you are having trouble setting '
            . 'the 3 digit code for your default currency, here is a list '
            . 'of currencies:<br>';
        foreach($currencies as $currencyCode => $currencyName){
            $botResponse['answer'] .= "$currencyCode-$currencyName<br>";
        }
        $botResponse['code'] = 4;
        return json_encode($botResponse);
    }
    
    public function loggedInSession($userLogin){
        $botResponse['answer'] = "Welcome back $userLogin! How can I help "
            . "you today?";
        $botResponse['code'] = 5;
        return json_encode($botResponse);
    }
    
    public function noLoggedInSession(){
        $botResponse['answer'] = 'Hello! Do I know you?';
        $botResponse['code'] = 1;
        return json_encode($botResponse);
    }
    
    public function failedLogin(){
        $botResponse['answer'] = 'Not a match... Let\'s try again. '
            . 'Do I know you?';
        $botResponse['code'] = 1;
        return json_encode($botResponse);
    }
    
    public function successfulLogin($userLogin){
        $botResponse['answer'] = "Hello $userLogin! How can I help you today?";
        $botResponse['code'] = 5;
        return json_encode($botResponse);
    }
    public function unpredictableError(){
        $botResponse['answer'] = 'An unpredictable error has happened and '
            . 'I don\'t know what to do. I gotta go, Bye!';
        $botResponse['code'] = 0;
        return json_encode($botResponse);
    }
}
