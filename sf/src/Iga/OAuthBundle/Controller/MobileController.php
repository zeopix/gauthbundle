<?php

namespace Iga\OAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Iga\OAuthBundle\Entity\Event;
use Google\PlusBundle\Entity\GoogleUser;
use Iga\OAuthBundle\Form\EventType;

require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/apiClient.php';
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/contrib/apiPlusService.php';

/**
 * Event controller.
 *
 * @Route("/mobile")
 */
class MobileController extends Controller
{
    /**
     * Lists all Event entities.
     *
     * @Route("/", name="mobile")
     * @Template()
     */
    public function indexAction()
    {
        
        $session = $this->getRequest()->getSession();
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();
        $at =  $session->get('access_token');
        
        if((!isset($at)) || ($at == false)){
            return $this->redirect($this->generateUrl('GoogleToken'));
        }
        
        try{
            $client->setAccessToken($at);
            $plus = $this->getPlus($client);
            $me = $plus->people->get('me');
            $user = $this->checkUser($me);
        }catch(Exception $e){
            return $this->redirect($this->generateUrl('GoogleToken'));
        }
        
        
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('IgaOAuthBundle:Event')->findAll();
        //$client = $this->getClient();
        $id = 1;
        
        return array('entities' => $entities, 'user' => $user);
    }

    /**
     * Finds and displays a Event entity.
     *
     * @Route("/show/{id}", name="mobile_event_show")
     * @Template()
     */
    public function showAction($id)
    {
        $session = $this->getRequest()->getSession();
        $client = $this->getClient();
        $at =  $session->get('access_token');
        if(!isset($at)){
            //do normal
            $authUrl = $client->createAuthUrl();

            //return $this->redirect($this->generateUrl('GoogleToken'));
            
        }
        
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaOAuthBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }


        $boss = $em->getRepository('GooglePlusBundle:GoogleUser')->findOneByGoogleid($entity->getGoogleuser());
        if(!$boss){ $boss = false;}
        return array(
            'entity'      => $entity,
            'boss' => $boss,      );
    }

    /**
     * Displays a form to create a new Event entity.
     *
     * @Route("/new", name="mobile_event_new")
     * @Template()
     */
    public function newAction()
    {
        $session = $this->getRequest()->getSession();
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();
        $at =  $session->get('access_token');
        if(!isset($at)){
            //do normal
            return $this->redirect($this->generateUrl('GoogleToken'));
            
        }
        $entity = new Event();
        $form   = $this->createForm(new EventType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Event entity.
     *
     * @Route("/create", name="mobile_event_create")
     * @Method("post")
     * @Template("IgaOAuthBundle:Mobile:new.html.twig")
     */
    public function createAction()
    {
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
        
        
        $entity  = new Event();
        $request = $this->getRequest();
        $form    = $this->createForm(new EventType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            
            $entity->setCreatedAt(new \DateTime());
            $entity->setUpdatedAt(new \DateTime());
            $entity->setGoogleUser($user->getGoogleid());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('event_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    
    
    
    /**
     * @Route("/savephoto/{eid}/", name="mobilePicasaSave")
     */
    public function mobilePicasaSaveAction($eid){
        
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
        
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $request = $this->getRequest()->request;
        
        $evt = $em->getRepository('IgaOAuthBundle:Event')->find($eid);
        
        if($evt){
            
            $pid = $request->get('id');
            $title = $request->get('title');
            $src = $request->get('src');
            
            if(strlen($src) > 0){
                
                $photo = new Photo;
                $photo->setEvent($evt);
                $photo->setGoogleid($pid);
                $photo->setPath($src);
                $photo->setTitle($title);
                $photo->setSlug($title);
                $photo->setGoogleuser($user->getGoogleid());
                $photo->setCreatedAt(new \DateTime());
                
                $em->persist($photo);
                $em->flush();
            }
            
            
        }
        
        return $this->redirect($this->generateUrl('mobile_event_show',Array('id' => $eid )));

    }
    
    
    /**
     * @Route("/picasa/{eid}", name="mobile_picasa")
     */
    public function mobilePicasaAction($eid)
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
        $albums = $this->getAlbums($client,$user->getGoogleid());
        
        /*
        
        $albums = Array();
        $photos = Array();
        */
        
             return $this->render('IgaOAuthBundle:Mobile:picasaAlbums.html.twig',Array('albums'=>$albums,'photos'=>false,'eid'=>$eid));
             
    }
    /**
     * @Route("/picasa/{eid}/{id}", name="mobilePicasaAlbum")
     */
    public function mobilePicasaAlbumAction($eid,$id)
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
       
        $albums = $this->getAlbums($client,$user->getGoogleid());
        $photos = $this->getPhotos($client,$user->getGoogleid(),$id);
        /*
        $albums =Array();
        $photos = Array();
*/        
            return $this->render('IgaOAuthBundle:Mobile:picasaPhotos.html.twig',Array('albums'=>$albums,'photos'=>$photos,'eid'=>$eid));
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
    
    private function getAlbums(&$client,$gid){
        
        $request = new \apiHttpRequest("https://picasaweb.google.com/data/feed/api/user/" . $gid,"GET");
        $response = $client->getIo()->makeRequest($request);
        $albums = Array();
        $aresponse = simplexml_load_string($response->getResponseBody());
               
        $ralbums = $aresponse->entry;
        
        foreach($ralbums as $key => $album){
            
            $url = $album->id;
            $parts = explode("/",$url);
            $id = $parts[(count($parts)-1)];
            
            $albums[] = Array(
                'title' => $album->title,
                'id' => $id,
            );
            
        }
        
        return $albums;
        
        
    }
    
    
    private function getPhotos(&$client,$gid,$albumid){
        
        $request = new \apiHttpRequest("https://picasaweb.google.com/data/feed/api/user/" . $gid . "/albumid/" . $albumid,"GET");
        $response = $client->getIo()->makeRequest($request);
        $photos = Array();
        $aresponse = simplexml_load_string($response->getResponseBody());
               
        $rphotos = $aresponse->entry;
        
        foreach($rphotos as $key => $photo){
            
            $url = $photo->id;
            $parts = explode("/",$url);
            $id = $parts[(count($parts)-1)];
            $content = $photo->content->attributes();
            
            $photos[] = Array(
                'title' => $photo->title,
                'id' => $id,
                'src' => $content['src'],
                'type' => $content['type'],
            );
            
        }
        
        return $photos;
        
        
    }
    
}
