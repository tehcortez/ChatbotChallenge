var chatBotStep = 1;
var newUser = null;
var userLogin = '';
var passwordLogin = '';
var defaultCurrency = '';
var depositAmount = '';
var withdrawAmount = '';

function botText(botText) {
    var date = new Date;
    var seconds = date.getSeconds();
    var minutes = date.getMinutes();
    var hour = date.getHours();

    var fullText = '<div class="msgcontainer"><div class="avatar">CB</div><p>';
    fullText += botText;
    fullText += '</p><span class="time-right">' + hour + ':' + minutes + ':' + seconds + '</span></div>';

    return $(".message-area").html() + fullText;
}

function userText(userText) {
    var date = new Date;
    var seconds = date.getSeconds();
    var minutes = date.getMinutes();
    var hour = date.getHours();

    var fullText = '<div class="msgcontainer darker">\n\
<div class="avatar right">LC</div><p>';
    fullText += userText;
    fullText += '</p><span class="time-right">' + hour + ':' + minutes + ':' + seconds + '</span></div>';

    return $(".message-area").html() + fullText;
}

function whoAreYou(userAnswer) {
    if (userAnswer.toLowerCase() == 'yes') {
        newUser = false;
    }
    if (userAnswer.toLowerCase() == 'no') {
        newUser = true;
    }
    if (newUser == null){
        $(".message-area").html(botText('Please answer with yes or no. Do you have an account here?'));
        chatBotStep = 1;
    }
    else
    {
        var botAnswer;
        if(newUser == true){
            botAnswer = 'As this is your first time, please create a username.';
        }
        else
        {
            botAnswer = 'Who are you?';
        }
        $(".message-area").html(botText(botAnswer));
        chatBotStep = 2;
    }
}

function saveLogin(userAnswer) {
    userLogin = userAnswer;
    var botAnswer;
    if(newUser == true){
        botAnswer = 'Create a password';
    }
    else
    {
        botAnswer = 'What is your password?';
    }
    $(".message-area").html(botText(botAnswer));
    $(".txtarea").attr('type', 'password'); 
    chatBotStep = 3;
}

function savePassword(userAnswer) {
    $(".txtarea").attr('type', 'text'); 
    passwordLogin = userAnswer;
    if(newUser == true){
        $(".message-area").html(botText('You have to chose a default currency \n\
for your new account. Please enter the 3 digit code of the desired default currency.'));
        chatBotStep = 4;
    }
    else
    {
        loginAttempt();
    }
}

function saveDefaultCurrency(userAnswer){
    defaultCurrency = userAnswer;
    $.post(window.location.href +'bot/create', {
        user: userLogin,
        password: passwordLogin,
        currency: defaultCurrency
    }, function (data) {
        var botResponse = JSON.parse(data);
        $(".message-area").html(botText(botResponse.answer));
        chatBotStep = botResponse.code;
    });
}

function loginAttempt(){
    $.post(window.location.href +'bot/login', {
        user: userLogin,
        password: passwordLogin
    }, function (data) {
        var botResponse = JSON.parse(data);
        $(".message-area").html(botText(botResponse.answer));
        chatBotStep = botResponse.code;
    });
}

function logoutAttempt(){
    $.post(window.location.href +'bot/logout', null, function (data) {
        var botResponse = JSON.parse(data);
        $(".message-area").html(botText(botResponse.answer));
        chatBotStep = botResponse.code;
    });
}

function showBalance(){
    $.post(window.location.href +'bot/show', null, function (data) {
        var botResponse = JSON.parse(data);
        $(".message-area").html(botText(botResponse.answer));
        chatBotStep = botResponse.code;
    });
    chatBotStep = 5;
}

function saveDepositAmount(userAnswer){
    depositAmount = userAnswer;
    $(".message-area").html(botText('In which currency? Please provide only 3 digit currency code'));
    chatBotStep = 7;
}

function makeDeposit(userAnswer){
    $.post(window.location.href +'bot/deposit', {
        amount: depositAmount,
        currency: userAnswer
    }, function (data) {
        var botResponse = JSON.parse(data);
        $(".message-area").html(botText(botResponse.answer));
        chatBotStep = botResponse.code;
    });
}
        
function saveWithdrawAmount(userAnswer){
    withdrawAmount = userAnswer;
    $(".message-area").html(botText('In which currency? Please provide only 3 digit currency code'));
    chatBotStep = 9;
}

function makeWithdraw(userAnswer){
    $.post(window.location.href +'bot/withdraw', {
        amount: withdrawAmount,
        currency: userAnswer
    }, function (data) {
        var botResponse = JSON.parse(data);
        $(".message-area").html(botText(botResponse.answer));
        chatBotStep = botResponse.code;
    });
}

function understandAction(userAnswer) {
    if (userAnswer.toLowerCase() == 'logout') {
        logoutAttempt();
        return;
    }
    if (userAnswer.toLowerCase() == 'balance') {
        showBalance();
        return;
    }
    if (userAnswer.toLowerCase() == 'deposit') {
        $(".message-area").html(botText('How much do you want to deposit?'));
        chatBotStep = 6;
        return;
    }
    if (userAnswer.toLowerCase() == 'withdraw') {
        $(".message-area").html(botText('How much do you want to withdraw?'));
        chatBotStep = 8;
        return;
    }
    $(".message-area").html(botText("I didn't understand. Try explaining with a single word. You can use logout, balance, deposit or withdraw, for example."));
    chatBotStep = 5;
}

function sendMessage() {
    userAnswer = $(".txtarea").val();
    $(".txtarea").val('');
    if (chatBotStep === 1) {
        $(".message-area").html(userText(userAnswer));
        whoAreYou(userAnswer);
        scrollBottom();
        return;
    }
    if (chatBotStep === 2) {
        $(".message-area").html(userText(userAnswer));
        saveLogin(userAnswer);
        scrollBottom();
        return;
    }
    if (chatBotStep === 3) {
//        $(".message-area").html(userText(userAnswer));
        savePassword(userAnswer);
        scrollBottom();
        return;
    }
    
    if (chatBotStep === 4) {
        $(".message-area").html(userText(userAnswer));
        saveDefaultCurrency(userAnswer);
        scrollBottom();
        return;
    }
    
    if (chatBotStep === 5) {
        $(".message-area").html(userText(userAnswer));
        understandAction(userAnswer);
        scrollBottom();
        return;
    }
    
    if (chatBotStep === 6) {
        $(".message-area").html(userText(userAnswer));
        saveDepositAmount(userAnswer);
        scrollBottom();
        return;
    }
    
    if (chatBotStep === 7) {
        $(".message-area").html(userText(userAnswer));
        makeDeposit(userAnswer);
        scrollBottom();
        return;
    }
    
    if (chatBotStep === 8) {
        $(".message-area").html(userText(userAnswer));
        saveWithdrawAmount(userAnswer);
        scrollBottom();
        return;
    }
    
    if (chatBotStep === 9) {
        $(".message-area").html(userText(userAnswer));
        makeWithdraw(userAnswer);
        scrollBottom();
        return;
    }
}

function scrollBottom(){
    $([document.documentElement, document.body]).animate({
        scrollTop: $(".btn-send").offset().top
    }, 1000);
}

$(document).on('keypress',function(e) {
    if(e.which == 13) {
        sendMessage();
    }
});

//$('.txtarea').on('keyup', function(){
//  $(this).val($(this).val().replace(/[\r\n\v]+/g, ''));
//});

$(document).ready(function () {
    $.post(window.location.href +'bot/loggedin', null, function (data) {
        var botResponse = JSON.parse(data);
            $(".message-area").html(botText(botResponse.answer));
            chatBotStep = botResponse.code;
    });
    $('.txtarea').focus();
});

//$(window).load(function() {
//  $("html, body").animate({ scrollTop: $(document).height() }, 1000);
//});