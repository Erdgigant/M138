<?php
error_reporting(E_ALL);
ini_set('display_errors',1);


require 'vendor/autoload.php';


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

    $ga = new PHPGangsta_GoogleAuthenticator();
    $secret = $ga->createSecret();
    $qrUrl = $ga->getQRCodeGoogleUrl('Test M183', $secret);

    // save secret to file
    file_put_contents('temp.txt', $secret);

    echo "
        <h3>Logged in as $username</h3>
        <p>Scan this and enter the code:</p>
        <img src=\"$qrUrl\" alt=\"google auth qr code\" /> 
        <form method=\"POST\">
            <input name=\"mode\" type=\"hidden\" value=\"fa\" /> 
            <input name=\"code\" type=\"text\" />
            <button>Submit</button>
        </form>
    ";
}

function faView(){
    $code = $_POST['code'];

    $ga = new PHPGangsta_GoogleAuthenticator();
    $secret = file_get_contents('temp.txt');

    if($ga->verifyCode($secret, $code, 3)){
        echo '<h3>Yay you managed to log in. As reward you get absolutely nothing. </h3>';
    }
    else{
        echo '<h3>It\'s not that hard...</h3>';
    }
}


