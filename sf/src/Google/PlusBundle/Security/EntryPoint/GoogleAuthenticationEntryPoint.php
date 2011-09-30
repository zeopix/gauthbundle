<?php



namespace Google\PlusBundle\Security\EntryPoint;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/apiClient.php';
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/contrib/apiPlusService.php';

/**
 * FacebookAuthenticationEntryPoint starts an authentication via Google.
 *
 * @author Iván Guillén <phyivn9@gmail.com>
 */
class GoogleAuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    protected $client;
    protected $options;
    protected $scopes;
    protected $plus;

    /**
     * Constructor
     *
     * @param array    $options
     */
    public function __construct(array $options = array())
    {
        $client = new \apiClient();
        $client->setApplicationName($this->options->get('app_name'));
        
        // Visit https://code.google.com/apis/console to generate your
        // oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
        
        $client->setClientId($this->options->get('client_id'));
        $client->setClientSecret($this->options->get('client_secret'));   
        $client->setRedirectUri($this->options->get('redirect_uri'));
        $client->setDeveloperKey($this->options->get('developer_key'));
        $client->setScopes(array($this->options->get('scopes')));

        $this->client = $client;
        $this->options = new ParameterBag($options);
        $this->scopes = $this->options->get('scopes');
        
        $this->plus = new \apiPlusService($client);
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $authUrl = $this->client->createAuthUrl();
            
        return new RedirectResponse($authUrl);
    }
}