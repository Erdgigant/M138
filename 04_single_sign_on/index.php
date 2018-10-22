<?php
session_start();


error_reporting(E_ALL);
ini_set('display_errors',1);

require 'vendor/autoload.php';

$credentials = json_decode(file_get_contents('credentials.json'), true);

$provider = new League\OAuth2\Client\Provider\Google([
    'clientId'     => $credentials['client_id'],
    'clientSecret' => $credentials['client_secret'],
    'redirectUri'  => 'http://localhost/M138/04_single_sign_on',
]);

if (!empty($_GET['error'])) {

    exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
} elseif (empty($_GET['code'])) {
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);

    exit;
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);

    exit('Invalid state');
} else {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // i would create a session with this token, but sadly php doesn't like sessions on localhost
    echo 'Token: ' . $token->getToken(). '<br />';

    try {
        $ownerDetails = $provider->getResourceOwner($token)->toArray();
        echo 'Hallo ' . $ownerDetails['displayName'] . '<br />';
    } catch (Exception $e) {
        exit('An error occurred: ' . $e->getMessage());
    }

    echo 'Login erfolgreich';
}