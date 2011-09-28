<?php

namespace Iga\OAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use OAuth\OAuthStore;
use OAuth\OAuthRequester;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
    
        return Array("name" => "hi");
    }
      /**
     * @Route("/google")
     */
    public function googleAction()
    {
        
        $options = array('server' => 'localhost', 'username' => 'root',
                 'password' => 'root',  'database' => 'oauth');
$store   = \OAuth\OAuthStore::instance('MySQL', $options);


// Get the id of the current user (must be an int)
$user_id = 1;

// The server description
$server = array(
    'consumer_key' => 'comertial.com',
    'consumer_secret' => 'XLpa7FW2sXhKIRqdGSzmpMHI',
    'server_uri' => 'http://www.comertial.com/web/app_dev.php/',
    'signature_methods' => array('HMAC-SHA1', 'PLAINTEXT'),
    'request_token_uri' => 'https://www.google.com/accounts/OAuthGetRequestToken',
    'authorize_uri' => 'https://www.google.com/accounts/OAuthAuthorizeToken',
    'access_token_uri' => 'https://www.google.com/accounts/OAuthGetAccessToken'
);

// Save the server in the the OAuthStore
$consumer_key = $store->updateServer($server, $user_id);


// Obtain a request token from the server
$token = OAuthRequester::requestRequestToken($consumer_key, $user_id);

// Callback to our (consumer) site, will be called when the user finished the authorization at the server
$callback_uri = 'http://www.mysite.com/callback?consumer_key='.rawurlencode($consumer_key).'&usr_id='.intval($user_id);

// Now redirect to the autorization uri and get us authorized
if (!empty($token['authorize_uri']))
{
    // Redirect to the server, add a callback to our server
    if (strpos($token['authorize_uri'], '?'))
    {
        $uri = $token['authorize_uri'] . '&'; 
    }
    else
    {
        $uri = $token['authorize_uri'] . '?'; 
    }
    $uri .= 'oauth_token='.rawurlencode($token['token']).'&oauth_callback='.rawurlencode($callback_uri);
}
else
{
    // No authorization uri, assume we are authorized, exchange request token for access token
   $uri = $callback_uri . '&oauth_token='.rawurlencode($token['token']);
}



        return $this->redirect($uri);
    }
}
