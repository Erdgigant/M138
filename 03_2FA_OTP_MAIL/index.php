<?php
error_reporting(E_ALL);
ini_set('display_errors',1);


require 'vendor/autoload.php';
include 'settings.php';

use Mailgun\Mailgun;


$mode = ($_POST['mode'] ?? 'default') . 'View';
$mode();

function defaultView(){
    echo '
        <form method="POST">
            <input name="mode" type="hidden" value="login" /> 
            <input name="username" type="text" />
            <input name="password" type="password" />
            <button>Submit</button>
        </form>
    ';
}

function loginView(){
    $password = $_POST['password'];
    $username = $_POST['username'];

    // insert username and password validation here

    $settings = getSettings();

    $mailgun = Mailgun::create($settings['apiKey']);
    $mailgun->messages()->send($settings['domain'], [
       'from' => 'info@mail.ch',
        'to' => $settings['mail'],
        'subject' => 'Token for authentication',
        'text' => getToken()
    ]);

    echo "
        <h3>Logged in as $username</h3>
        <p>Check your mail and insert token into field below</p>
        <form method=\"POST\">
            <input name=\"mode\" type=\"hidden\" value=\"fa\" /> 
            <input name=\"token\" type=\"text\" />
            <button>Submit</button>
        </form>
    ";
}

function faView(){
    $clientToken = $_POST['token'];
    $serverToken = getToken();

    if($clientToken === $serverToken){
        echo '<h3>Yay you managed to log in. As reward you get absolutely nothing. </h3>';
    }
    else{
        echo '<h3>It\'s not that hard...</h3>';
    }
}

function getToken(){
    // pseudo token (what do you mean this is the interesting part?)
    return '13214';
}


