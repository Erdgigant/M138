<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

$action = ($_POST['action'] ?? 'index') . 'Action';
$action();

function indexAction(){
    echo "
        <form method='POST'>
            <label>Save login</label>
            <input type='hidden' name='action' value='login' />
            <input type='checkbox' name='save' value='1'/>
            <button>Login</button>
        </form>
    ";
}

function loginAction(){
    setcookie(
        'loggedin',
        'true',
        (array_key_exists('savegit', $_POST) && $_POST['save']) ? time() + 86400 * 14 : 0
    );

    echo 'You logged in';
}

function secretAction(){
    if(array_key_exists('loggedin', $_COOKIE) && $_COOKIE['loggedin']){
        echo 'Secret stuff';
    }
    else {
        echo 'You are not authenticated';
    }
}


echo "
        <form method='POST'>
            <input type='hidden' name='action' value='secret' />
            <button>Restricted content</button>
        </form>
    ";