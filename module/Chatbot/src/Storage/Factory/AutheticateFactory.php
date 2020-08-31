<?php
namespace Chatbot\Storage\Factory;

use Chatbot\Storage\Authenticate;
use Chatbot\Storage\AuthStorage;
use Interop\Container\ContainerInterface;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\AdapterInterface;

class AutheticateFactory
{
    public function __invoke(ContainerInterface $container)
    {
        // Configure the instance with constructor parameters:
        $dbAdapter =$container->get(AdapterInterface::class);
        $dbTableAuthAdapter = new AuthAdapter($dbAdapter,
            'tbl_users',
            'user_login',
            'user_password');
        $authService = new AuthenticationService();
        $authService->setAdapter($dbTableAuthAdapter);
        $authService->setStorage(new AuthStorage());
        return new Authenticate($authService);
    }
}