<?php
namespace Chatbot\Model\Factory;

use Chatbot\Model\Transactions;
use Chatbot\Model\TransactionsRepository;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class TransactionsRepositoryFactory
{
    function __invoke(ContainerInterface $containerInterface)
    {
        $resultPrototype=new ResultSet();
        $resultPrototype->setArrayObjectPrototype($containerInterface->get(Transactions::class));
        return new TransactionsRepository(new TableGateway('tbl_transactions',$containerInterface->get(AdapterInterface::class),null,$resultPrototype));
    }

}