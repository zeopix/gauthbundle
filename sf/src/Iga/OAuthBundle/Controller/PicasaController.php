<?php

namespace Iga\OAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Google\PlusBundle\Entity\GoogleUser;
use \Zend_Gdata_Photos;
use \Zend_Gdata_ClientLogin;

require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/apiClient.php';
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/contrib/apiPlusService.php';

class PicasaController extends Controller
{
    /**
     * @Route("/picasa/me", name="picasa")
     */
    public function picasaAction()
    {
        

// update the second argument to be CompanyName-ProductName-Version

        $session = $this->getRequest()->getSession();
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();
        $at =  $session->get('access_token');
        if(!isset($at)){
            //do normal
            return $this->redirect($this->generateUrl('GoogleToken'));
            
        }
        
        
        $client->setAccessToken($at);

        
        $plus = $this->getPlus($client);
        $me = $plus->people->get('me');
        
        $user = $this->checkUser($me);
        
        
        $request = new \apiHttpRequest("https://picasaweb.google.com/data/feed/api/user/" . $user->getGoogleid(),"GET");
        $response = $client->getIo()->makeRequest($request);
        
        $aresponse = simplexml_load_string($response->getResponseBody());
        
        $albums = $aresponse['entry'];
        
        foreach($albums as $key=>$album){
            $url = $album['id'];
            $parts = explode($url,"/");
            $album['id'] = $parts[(count($parts)-1)];
            $albums[$key]= $album;
            
        }
        
        
        
        
             return $this->render('IgaOAuthBundle:Picasa:albums.html.twig',Array('albums'=>$albums,'photos'=>false));
             
    }
    /**
     * @Route("/picasa/album/{id}", name="picasaAlbum")
     */
    public function picasaAlbumAction($id)
    {
        

// update the second argument to be CompanyName-ProductName-Version

        $session = $this->getRequest()->getSession();
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();
        $at =  $session->get('access_token');
        if(!isset($at)){
            //do normal
            return $this->redirect($this->generateUrl('GoogleToken'));
            
        }
        
        
        $client->setAccessToken($at);

        
        $plus = $this->getPlus($client);
        $me = $plus->people->get('me');
        
        $user = $this->checkUser($me);
        
        
        $request = new \apiHttpRequest("https://picasaweb.google.com/data/feed/api/user/" . $user->getGoogleid(),"GET");
        $response = $client->getIo()->makeRequest($request);
        
        $aresponse = simplexml_load_string($response->getResponseBody());
        
        $albums = $aresponse['entry'];
        
        foreach($albums as $key=>$album){
            $url = $album['id'];
            $parts = explode($url,"/");
            $album['id'] = $parts[(count($parts)-1)];
            $albums[$key]= $album;
            
        }
        
        $prequest = new \apiHttpRequest("https://picasaweb.google.com/data/feed/api/user/" . $user->getGoogleid() . "/albumid/" . $id,"GET");
        $presponse = $client->getIo()->makeRequest($prequest);
        
        $aphotos = simplexml_load_string($presponse->getRsponseBody());
        
        $photos = $aphotos['entry'];
        
             return $this->render('IgaOAuthBundle:Picasa:albums.html.twig',Array('albums'=>$albums,'photos'=>$photos));
             
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
$client->setScopes(array('https://www.googleapis.com/auth/plus.me','https://picasaweb.google.com/data/'));
        return $client;
        
    }
    
    private function getPlus($client){
        
        return new \apiPlusService($client);
    }
    
    
    
    private function checkUser($user){
        $em= $this->getDoctrine()->getEntityManager();
        
        $guser = $em->getRepository('GooglePlusBundle:GoogleUser')->findOneByGoogleid($user['id']);
        if($guser){
            $guser->setLoggedAt(new \DateTime());
        }else{
            
            $guser = new GoogleUser();
            
            $guser->setKind($user['kind']);
            $guser->setGoogleid($user['id']);
            $guser->setDisplayname($user['displayName']);
            $guser->setAboutMe($user['aboutMe']);
            $guser->setUrl($user['url']);
            $guser->setGender($user['gender']);
            $guser->setImage($user['image']['url']);
            $guser->setCreatedAt(new \DateTime());
            $guser->setUpdatedAt(new \DateTime());
            $guser->setLoggedAt(new \DateTime());
            
        }
        
            $em->persist($guser);
            $em->flush();
            
            return $guser;
            
    }
    
}