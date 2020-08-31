<?php
namespace Chatbot\Model\Factory;

use Chatbot\Model\Transactions;
use Interop\Container\ContainerInterface;

class TransactionsFactory
{
    public function __invoke(ContainerInterface $containerInterface)
    {
        return new Transactions();
    }
}