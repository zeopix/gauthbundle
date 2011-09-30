<?php
namespace Google\PlusBundle\Security\Firewall;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Google\PlusBundle\Security\Authentication\Token\GoogleUserToken;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\HttpFoundation\Request;

/**
 * Twitter authentication listener.
 */
class GoogleListener extends AbstractAuthenticationListener
{
    protected function attemptAuthentication(Request $request)
    {
       
            return $this->authenticationManager->authenticate(new GoogleUserToken());
    }
}