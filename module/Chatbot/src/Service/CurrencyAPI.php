<?php
namespace Chatbot\Service;

use Zend\Cache\StorageFactory;

class CurrencyAPI 
{    
    private $access_key;
    
    private $cache;

    public function __construct($access_key)
    {
        $this->access_key = $access_key;
        $this->cache = StorageFactory::factory([
            'adapter' => [
                'name'      => 'filesystem',
                'options'   => [
                    'ttl'       => 600,
                    'cache_dir' => './cache' // diretório onde será armazenado o arquivo de cache
                ],
            ],
        ]);
    }
    
    public function convertAmount($from, $to, $amount) {
        
        if($from == $to){
            return $amount;
        }
        // set API Endpoint, access key, required parameters
        $endpoint = 'latest';
        $access_key = $this->access_key;

        $parameters= $endpoint.'?access_key='.$access_key.'';
        
        $response = $this->cache->getItem('CurrencyAPI'.$endpoint);
        if(is_null($response)){
            $response = $this->curlFixer($parameters);
            $this->cache->addItems([
                'CurrencyAPI'.$endpoint => $response,
            ]);
        }
        
        $response = json_decode($response, true);
        
        if($response["success"]){
            $tempAmount = ($amount / $response["rates"][$from]);
            $newAmount = ($tempAmount * $response["rates"][$to]);
        }
        return $newAmount;
    }
    
    public function convertAmountPaidVersion($from, $to, $amount) {
        // set API Endpoint, access key, required parameters
        $endpoint = 'convert';
        $access_key = $this->access_key;

        $parameters= $endpoint.'?access_key='.$access_key.
            '&from='.$from.
            '&to='.$to.
            '&amount='.$amount.'';

        $response = $this->curlFixer($parameters);
        
        return $response;
    }
    
    public function getAvailableCurrencies() {
        // set API Endpoint, access key, required parameters
        $endpoint = 'symbols';
        $access_key = $this->access_key;

        $parameters= $endpoint.'?access_key='.$access_key.'';
        
        $response = $this->cache->getItem('CurrencyAPI'.$endpoint);
        if(is_null($response)){
            $response = $this->curlFixer($parameters);
            $this->cache->addItems([
                'CurrencyAPI'.$endpoint => $response,
            ]);
        }
        return json_decode($response, true);
    }

    public function curlFixer($parameters){
        // initialize CURL:
        $ch = curl_init('http://data.fixer.io/api/'.$parameters);   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // get the JSON data:
        $json = curl_exec($ch);
        curl_close($ch);
        
        return $json;
    }
}
