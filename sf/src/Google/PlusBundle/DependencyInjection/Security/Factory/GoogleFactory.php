<?php


namespace Google\PlusBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/apiClient.php';
require_once dirname(__FILE__) . '/../../../../vendor/Sf2GoogleApi/src/contrib/apiPlusService.php';

class GoogleFactory extends AbstractFactory
{
    public function __construct()
    {
        $this->addOption('app_name');
        $this->addOption('client_id');
        $this->addOption('client_secret');
        $this->addOption('redirect_uri');
        $this->addOption('developer_key');
        $this->addOption('scopes');
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'google_plus';
    }

    protected function getListenerId()
    {
        return 'google_plus.security.authentication.listener';
    }

    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        // with user provider
        if (isset($config['provider'])) {
            $authProviderId = 'google_plus.auth.'.$id;

            $container
                ->setDefinition($authProviderId, new DefinitionDecorator('google_plus.auth'))
                ->addArgument(new Reference($userProviderId))
                ->addArgument(new Reference('security.user_checker'))
            ;

            return $authProviderId;
        }

        // without user provider
        return 'google_plus.auth';
    }

    protected function createEntryPoint($container, $id, $config, $defaultEntryPointId)
    {
        $entryPointId = 'google_plus.security.authentication.entry_point.'.$id;
        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('google_plus.security.authentication.entry_point'))
            ->replaceArgument(1, $config)
        ;

        // set options to container for use by other classes
        $container->setParameter('google_plus.options.'.$id, $config);

        return $entryPointId;
    }
}
