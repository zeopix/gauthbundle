<?php

namespace Iga\OAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/apiClient.php';
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/contrib/apiPlusService.php';

class SecuredController extends Controller
{
    /**
     * @Route("/secured/", name="secured_home")
     */
    public function indexAction()
    {   
        $session = $this->getRequest()->getSession();
        //$client = $this->getClient();
        
        //TODO: gplus logout url
        
        $logoutUrl = "";
        //$at =  $session->get('access_token');
        
        
        
        //if(!isset($at)){
            
            //return $this->redirect($this->generateUrl('home'));
            
        //}else{
        
           return $this->render('IgaOAuthBundle:Secured:index.html.twig',array('googleUrl' => $logoutUrl));
   
        //}
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
