<?php
namespace Chatbot\Model;

class Transactions
{
    private $id;
    private $transactionKind;
    private $currency;
    private $amount;
    private $balanceAfter;
    private $userId;
    private $createdAt;
    
    function getId()
    {
        return $this->id;
    }

    function getTransactionKind()
    {
        return $this->transactionKind;
    }

    function getCurrency()
    {
        return $this->currency;
    }

    function getAmount()
    {
        return $this->amount;
    }

    function getBalanceAfter()
    {
        return $this->balanceAfter;
    }

    function getUserId()
    {
        return $this->userId;
    }

    function getCreatedAt()
    {
        return $this->createdAt;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setTransactionKind($transactionKind)
    {
        if ($transactionKind == 'deposit' || $transactionKind == 'withdraw') {
            $this->transactionKind = $transactionKind;
        } else {
            throw new \Exception("Setter for transactionKind only accepts "
                . "deposit or withdraw.");
        }
    }

    function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    function setAmount($amount)
    {
        $this->amount = $amount;
    }

    function setBalanceAfter($balanceAfter)
    {
        $this->balanceAfter = $balanceAfter;
    }

    function setUserId($userId)
    {
        $this->userId = $userId;
    }

    function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function exchangeArray(array $data){
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->transactionKind = !empty($data['transaction_kind']) ? $data['transaction_kind'] : null;
        $this->currency = !empty($data['currency']) ? $data['currency'] : null;
        $this->amount = !empty($data['amount']) ? $data['amount'] : null;
        $this->balanceAfter = !empty($data['balance_after']) ? $data['balance_after'] : null;
        $this->userId = !empty($data['user_id']) ? $data['user_id'] : null;
        $this->createdAt = !empty($data['created_at']) ? $data['created_at'] : null;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'transaction_kind' => $this->transactionKind,
            'currency' => $this->currency,
            'amount' => $this->amount,
            'balance_after' => $this->balanceAfter,
            'user_id' => $this->userId,
            'created_at' => $this->createdAt,
        ];
    }
}