<?php

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

    echo "
        <h3>Logged in as $username</h3>
        <p>Check your mail</p>
";
    echo '
        <form method="POST">
            <input name="mode" type="hidden" value="fa" /> 
            <input name="token" type="text" />
            <button>Submit</button>
        </form>
    ';
}

function faView(){
    echo 'fa';
}



