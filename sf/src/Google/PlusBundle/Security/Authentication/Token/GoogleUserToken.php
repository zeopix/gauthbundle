<?php

namespace Google\PlusBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/apiClient.php';
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/contrib/apiPlusService.php';

class GoogleUserToken extends AbstractToken
{
    public function __construct($uid = '', array $roles = array())
    {
        parent::__construct($roles);

        $this->setUser($uid);

        if (!empty($uid)) {
            $this->setAuthenticated(true);
        }
    }

    public function getCredentials()
    {
        return '';
    }
}