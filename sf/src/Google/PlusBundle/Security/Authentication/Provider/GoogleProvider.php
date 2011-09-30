<?php

namespace Google\PlusBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/apiClient.php';
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/contrib/apiPlusService.php';

use Google\PlusBundle\Security\Authentication\Token\GoogleUserToken;

class GoogleProvider implements AuthenticationProviderInterface
{
    protected $plus;
    protected $client;
    protected $userProvider;
    protected $userChecker;

    public function __construct(UserProviderInterface $userProvider = null, UserCheckerInterface $userChecker = null)
    {
        if (null !== $userProvider && null === $userChecker) {
            throw new \InvalidArgumentException('$userChecker cannot be null, if $userProvider is not null.');
        }

        $this->client = new \apiClient();
        $this->plus = new \apiPlusService($client);
        $this->userProvider = $userProvider;
        $this->userChecker = $userChecker;
    }

    public function authenticate(TokenInterface $token)
    {
        
        
        if (!$this->supports($token)) {
            return null;
        }

        try {
            $at = $this->client->authenticate($this->container->get('request')->get('code'));
            if($at){
                
              $me = $this->plus->people->get('@me');
            $uid = $me['id']; 
            if (!empty($uid)) {
                $token->setUser($uid);
                return $this->createAuthenticatedToken($uid);
            }  
                
            }
                    
            
        } catch (AuthenticationException $failed) {
            throw $failed;
        } catch (\Exception $failed) {
            throw new AuthenticationException('Unknown error', $failed->getMessage(), $failed->getCode(), $failed);
        }

        throw new AuthenticationException('The Google user could not be retrieved from the session.');
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof GoogleUserToken;
    }

    protected function createAuthenticatedToken($uid)
    {
        if (null === $this->userProvider) {
            return new GoogleUserToken($uid);
        }

        $user = $this->userProvider->loadUserByUsername($uid);
        if (!$user instanceof UserInterface) {
            throw new \RuntimeException('User provider did not return an implementation of user interface.');
        }

        $this->userChecker->checkPreAuth($user);
        $this->userChecker->checkPostAuth($user);

        return new GoogleUserToken($user, $user->getRoles());
    }
}