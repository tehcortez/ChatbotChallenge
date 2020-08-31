<?php
namespace Chatbot\Model\Factory;

use Chatbot\Model\Users;
use Interop\Container\ContainerInterface;

class UsersFactory
{
    public function __invoke(ContainerInterface $containerInterface)
    {
        return new Users();
    }
}