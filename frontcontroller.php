<?php

include_once "./vendor/oauth-php/library/OAuthStore.php";
include_once "./vendor/oauth-php/library/OAuthRequester.php";


$action = $_GET['action'];



$key = '???????'; // this is your consumer key
$secret = '????????'; // this is your secret key



$options = array('server' => 'localhost', 'username' => 'root',
                 'password' => 'root',  'database' => 'gauth');

$store   = OAuthStore::instance('MySQL', $options);

$user_id = 1;

// The server description
$server = array(
    'consumer_key' => 'comertial.com',
    'consumer_secret' => 'XLpa7FW2sXhKIRqdGSzmpMHI',
    'server_uri' => 'http://www.example.com/api/',
    'signature_methods' => array('HMAC-SHA1', 'PLAINTEXT'),
    'request_token_uri' => 'https://www.google.com/accounts/OAuthGetRequestToken',
    'authorize_uri' => 'https://www.google.com/accounts/OAuthAuthorizeToken',
    'access_token_uri' => 'https://www.google.com/accounts/OAuthGetAccessToken'
);

$consumer_key = $store->updateServer($server, $user_id);


?>