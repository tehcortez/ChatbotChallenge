<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ChatbotTest\Controller;

use Chatbot\Service\ChatManager;

use PHPUnit\Framework\TestCase;

class ChatManagerTest extends TestCase
{
    public function testShowBalance(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->showBalance('TST', 0);
            
        $botResponse['answer'] = 'You have TST$0.00'
            . ' in your account. Is there anything else I can help you?';
        $botResponse['code'] = 5;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testNotLoggedIn(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->notLoggedIn();
        $botResponse['answer'] = 'First I need to know who you are. Do I '
            . 'know you?';
        $botResponse['code'] = 1;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testSuccessfulWithdraw(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->successfulWithdraw();
        $botResponse['answer'] = 'Your withdraw was successful. Is there '
            . 'anything else I can help you with?';
        $botResponse['code'] = 5;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testNotEnoughFundsOnWithdraw(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->notEnoughFundsOnWithdraw();
        $botResponse['answer'] = 'Sorry, but you don\'t have enough '
            . 'funds for this withdraw. Is there anything else I can '
            . 'help you with?';
        $botResponse['code'] = 5;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testWrongCurrencyOnWithdraw(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->wrongCurrencyOnWithdraw(['BRL'=>'Brazilian Real','EUR'=>'Euro']);
        $botResponse['answer'] = 'Since you are having trouble setting '
        . 'the 3 digit code for this deposit currency, here is a list '
        . 'of currencies:<br>BRL-Brazilian Real<br>EUR-Euro<br>';
        $botResponse['code'] = 9;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testWrongAmountOnWithdraw(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->wrongAmountOnWithdraw();
        $botResponse['answer'] = 'The amount is invalid and I can\'t '
            . 'procced with this withdraw. Is there anything else I can '
            . 'help you with?';
        $botResponse['code'] = 5;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testSuccessfulDeposit(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->successfulDeposit();
        $botResponse['answer'] = 'Your deposit was successful. Is there '
            . 'anything else I can help you with?';
        $botResponse['code'] = 5;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testWrongCurrencyOnDeposit(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->wrongCurrencyOnDeposit(['BRL'=>'Brazilian Real','EUR'=>'Euro']);
        $botResponse['answer'] = 'Since you are having trouble setting '
        . 'the 3 digit code for this deposit currency, here is a list '
        . 'of currencies:<br>BRL-Brazilian Real<br>EUR-Euro<br>';
        $botResponse['code'] = 7;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testWrongAmountOnDeposit(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->wrongAmountOnDeposit();
        $botResponse['answer'] = 'The amount is invalid and I can\'t '
            . 'procced with this deposit. Is there anything else I can '
            . 'help you with?';
        $botResponse['code'] = 5;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testNotLoggedInToLogOut(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->notLoggedInToLogOut();
        $botResponse['answer'] = 'You are not logged in to be able to logout. '
            . 'Now, Do I know you?';
        $botResponse['code'] = 1;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testSuccessfulLogOut(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->successfulLogOut();
        $botResponse['answer'] = 'Hope to see you soon! Bye... Oh, Hi there! '
            . 'Do I know you?';
        $botResponse['code'] = 1;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testFailedToFetchPostforCreateAccount(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->failedToFetchPostforCreateAccount();
        $botResponse['answer'] = 'Something is not right with your info... '
            . 'Let\'s try again. Do I know you?'.
        $botResponse['code'] = 1;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testFailedToCreateAccount(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->failedToCreateAccount('TeSt');
        $botResponse['answer'] = 'There was an error creating your user. '
            . 'You are probably not who you say you are, or I '
            . 'already know someone named TeSt. Let\'s '
            . 'try again with a diferente name. Do I know you?';
        $botResponse['code'] = 1;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testSuccessfulCreateAccount(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->successfulCreateAccount();
        $botResponse['answer'] = 'All set! Welcome to our exchange account '
            . 'system. I don\'t have a name (I\'m a computer software), but '
            . 'I can help you to deposit, withdraw, and check your account '
            . 'balance. How can I help you today?';
        $botResponse['code'] = 5;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testWrongNameOnCreateAccount(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->wrongNameOnCreateAccount();
        $botResponse['answer'] = 'You can\'t use special characters on your '
            . 'name. let\'s start over. Do I know you?';
        $botResponse['code'] = 1;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testWrongCurrencyOnCreateAccount(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->wrongCurrencyOnCreateAccount(['BRL'=>'Brazilian Real','EUR'=>'Euro']);
        $botResponse['answer'] = 'Since you are having trouble setting '
            . 'the 3 digit code for your default currency, here is a list '
            . 'of currencies:<br>BRL-Brazilian Real<br>EUR-Euro<br>';
        $botResponse['code'] = 4;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testLoggedInSession(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->loggedInSession('TeSt');
        $botResponse['answer'] = "Welcome back TeSt! How can I help "
            . "you today?";
        $botResponse['code'] = 5;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testNoLoggedInSession(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->noLoggedInSession();
        $botResponse['answer'] = 'Hello! Do I know you?';
        $botResponse['code'] = 1;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testFailedLogin(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->failedLogin();
        $botResponse['answer'] = 'Not a match... Let\'s try again. '
            . 'Do I know you?';
        $botResponse['code'] = 1;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    
    public function testSuccessfulLogin(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->successfulLogin('TeSt');
        $botResponse['answer'] = "Hello TeSt! How can I help you today?";
        $botResponse['code'] = 5;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
    public function testUnpredictableError(){
        $chatbot = new ChatManager();
        $classResponse = $chatbot->unpredictableError();
        $botResponse['answer'] = 'An unpredictable error has happened and '
            . 'I don\'t know what to do. I gotta go, Bye!';
        $botResponse['code'] = 0;
        $expected = json_encode($botResponse);
        $this->assertEquals($expected, $classResponse);
    }
}
