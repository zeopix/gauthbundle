<?php

namespace Iga\OAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use \Zend_Gdata_Photos;
use \Zend_Gdata_ClientLogin;

require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/apiClient.php';
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/contrib/apiPlusService.php';

class DefaultController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function testAction()
    {
        
        $client = $this->getClient();

// update the second argument to be CompanyName-ProductName-Version

        ob_start();
            print_r($client);
            $v = ob_get_clean();
             return new Response($v);
             
    }
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
             $session = $this->getRequest()->getSession();
        
        $session = $this->getRequest()->getSession();
        
        $client = $this->getClient();
        
        $authUrl = $client->createAuthUrl();
        $at =  $session->get('access_token');
        if(isset($at)){
            
            return $this->redirect($this->generateUrl('event'));
            
        }else{
        
           return $this->render('IgaOAuthBundle:Default:index.html.twig',array('googleUrl' => $authUrl));
   
        }
    }
 
    
    private function getClient(){
        $client = new \apiClient();
$client->setApplicationName("Comertial example app");
// Visit https://code.google.com/apis/console to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
 $client->setClientId('345503510563.apps.googleusercontent.com');
 $client->setClientSecret('-2CZEJhe2Kk1nBuv52bkjq3V');
 $client->setRedirectUri('http://www.comertial.com/GoogleAuth');
 $client->setDeveloperKey('AI39si6UVXj7WRM4bHgY8RxcGW8UsWL2muY7oJxOCf2KFJkLE6zdw-U_tyhp3mWRqE4LBkuciwigXqROKhzsD35KWHRy8TF-BA');
$client->setScopes(array('https://www.googleapis.com/auth/plus.me','http://picasaweb.google.com/data/feed/api/
user/default'));
        return $client;
        
    }
    
    private function getPlus($client){
        
        return new \apiPlusService($client);
    }
}
