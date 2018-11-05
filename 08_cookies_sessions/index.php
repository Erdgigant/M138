<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

// should be random and regenerated every time
const CSRF_TOKEN = 'afhjfh32ur8euir8efzhcdshftbwe';

$action = ($_POST['action'] ?? 'index') . 'Action';
$action();

function indexAction(){
    echo "
        <form method='POST'>
            <label>Save login</label>
            <input type='hidden' name='action' value='login' />
            <input type='hidden' name='csrf' value='". CSRF_TOKEN . "' />
            <input type='checkbox' name='save' value='1'/>
            <button>Login</button>
        </form>
    ";
}

function loginAction(){
    if(array_key_exists('csrf', $_POST) && $_POST['csrf'] === CSRF_TOKEN) {
        setcookie(
            'loggedin',
            'true',
            (array_key_exists('savegit', $_POST) && $_POST['save']) ? time() + 86400 * 14 : 0
        );

        echo 'You logged in';
    }
    else {
        echo 'Consider yourself #csrf\'ed';
    }
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