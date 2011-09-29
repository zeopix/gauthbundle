<?php

namespace Iga\OAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

require_once dirname(__FILE__) . '/../../../../../google-api-php-client/src/apiClient.php';
require_once dirname(__FILE__) . '/../../../../../google-api-php-client/src/contrib/apiPlusService.php';

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
             $session = $this->getRequest()->getSession();
        
        $session = $this->getRequest()->getSession();
        
        $client = $this->getClient();
        
        $authUrl = $client->createAuthUrl();
   
        
        return array('access_token' => $session->get('access_token'),'googleUrl' => $authUrl);
    }
    /**
     * @Route("/GoogleToken", name="GoogleToken")
     */
    public function googleAction()
    {
        
        $session = $this->getRequest()->getSession();
        
        $client = $this->getClient();
        
        $authUrl = $client->createAuthUrl();

        return $this->redirect($authUrl);
    }
    
    /**
     * @Route("/GoogleAuth", name="GoogleAuth")
     */
    public function googleAuthAction(){

        $session = $this->getRequest()->getSession();
        $request = $this->getRequest()->query;
        
        $client = $this->getClient();
        $code = $request->get('code');
        
        if(!empty($code)){
       		ob_start();
		print_r($code);
		die(ob_get_clean());    
            $client->authenticate();
            $session->set('access_token',$client->getAccessToken());
            $this->redirect($this->generateUrl('home'));
            
        }

        $session->set('access_token',false);
       die("havent code");
       // return $this->redirect($this->generateUrl('home'));
    
          
    }
    
    /**
     * @Route("/GoogleLogout", name="GoogleLogout")
     */
    public function googleLogoutAction(){

        $session = $this->getRequest()->getSession();

        $session->set('access_token',false);
        
        return $this->redirect($this->generateUrl('home'));
    
          
    }
    
    private function getClient(){
        $client = new \apiClient();
$client->setApplicationName("Google+ PHP Starter Application");
// Visit https://code.google.com/apis/console to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
 $client->setClientId('345503510563.apps.googleusercontent.com');
 $client->setClientSecret('-2CZEJhe2Kk1nBuv52bkjq3V');
 $client->setRedirectUri('http://www.comertial.com/GoogleAuth');
 $client->setDeveloperKey('AI39si6UVXj7WRM4bHgY8RxcGW8UsWL2muY7oJxOCf2KFJkLE6zdw-U_tyhp3mWRqE4LBkuciwigXqROKhzsD35KWHRy8TF-BA');
$client->setScopes(array('https://www.googleapis.com/auth/plus.me'));
        return $client;
        
    }
    
    private function getPlus($client){
        
        return new \apiPlusService($client);
    }
}
