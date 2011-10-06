<?php

namespace Iga\OAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Iga\OAuthBundle\Entity\Event;
use Iga\OAuthBundle\Util\Slug;

use Ano\Bundle\GoogleMapsBundle\Service\GeocodeAPIQuery;

use Iga\OAuthBundle\Form\EventType;

require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/apiClient.php';
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/contrib/apiPlusService.php';

/**
 * Event controller.
 *
 * @Route("/maps")
 */
class MapController extends Controller
{
    /**
     * Lists all Event entities.
     *
     * @Route("/search", name="maps_search")
     */
    public function searchAction()
    {
        
            
            $request = $this->getRequest();
            
            $query = $request->query->get('query');
            
            $q = new Slug($query);
            
            $query = str_replace("-"," ",$q);
            
            $geocode = new GeocodeAPIQuery(array(
                'address' => $query,
                'sensor'  => 'false',
            ));

            $result = file_get_contents("http://maps.google.com/maps/api/geocode/json?latlng=41.5,2.2&sensor=false&address=" . urlencode($query));
            $result = json_decode($result);

           
            return $this->render('IgaOAuthBundle:Map:addresses.html.twig',Array('search' => $result ));

    }

         
    
  
    
    
}
