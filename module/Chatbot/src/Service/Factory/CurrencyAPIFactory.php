<?php
namespace Chatbot\Service\Factory;

use Chatbot\Service\CurrencyAPI;
use Interop\Container\ContainerInterface;

class CurrencyAPIFactory
{
    public function __invoke(ContainerInterface $containerInterface)
    {
        return new CurrencyAPI($containerInterface->get('Config')["currencyAPI"]);
    }
}