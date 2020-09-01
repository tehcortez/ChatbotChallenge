<?php
namespace Chatbot\Controller\Factory;

use Chatbot\Controller\IndexController;
use Chatbot\Service\ChatManager;
use Chatbot\Service\CurrencyAPI;
use Interop\Container\ContainerInterface;

class IndexControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $currency = $container->get(CurrencyAPI::class);
        $chat = $container->get(ChatManager::class);
        $salt = '';
        if(isset($container->get('Config')["salt"])){
            $salt = $container->get('Config')["salt"];
        }
        return new IndexController($container, $currency, $chat, $salt);
    }
}
