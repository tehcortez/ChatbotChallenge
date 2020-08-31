<?php
namespace Chatbot\Service\Factory;

use Chatbot\Service\ChatManager;
use Interop\Container\ContainerInterface;

class ChatManagerFactory
{
    public function __invoke(ContainerInterface $containerInterface)
    {
        return new ChatManager();
    }
}