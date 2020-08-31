<?php
namespace Chatbot;

use Chatbot\Model\Factory\UserRepositoryFactory;
use Chatbot\Model\Factory\UsersFactory;
use Chatbot\Model\Users;
use Chatbot\Model\UsersRepository;
use Chatbot\Service\ChatManager;
use Chatbot\Service\CurrencyAPI;
use Chatbot\Service\Factory\ChatManagerFactory;
use Chatbot\Service\Factory\CurrencyAPIFactory;
use Chatbot\Storage\Authenticate;
use Chatbot\Storage\Factory\AutheticateFactory;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ConfigProviderInterface, ServiceProviderInterface
{
    const VERSION = '3.1.4dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories'=>[
                Users::class=> UsersFactory::class,
                UsersRepository::class=> UserRepositoryFactory::class,
                CurrencyAPI::class=> CurrencyAPIFactory::class,
                Authenticate::class=> AutheticateFactory::class,
                ChatManager::class=> ChatManagerFactory::class,
                Model\Transactions::class=> Model\Factory\TransactionsFactory::class,
                Model\TransactionsRepository::class=> Model\Factory\TransactionsRepositoryFactory::class,
            ]
        ];
    }
}
