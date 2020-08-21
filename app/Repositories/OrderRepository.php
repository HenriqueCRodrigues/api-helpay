<?php

namespace App\Repositories;

use SimpleXMLElement;

class OrderRepository
{

    
    public function store($data) {
        try {
            \DB::beginTransaction();
            
            $xml = new SimpleXMLElement('<dados/>');
            array_walk_recursive($data, [$xml, 'addChild']);
            \DB::commit();

            return ['message' => [], 'status' => 200];
        } catch (\Exception $e) {
            \DB::rollback();
            return ['message' => $e->getMessage(), 'status' => 500];
        }
    }


    function validateCC($cc_num, $type) {
        //Validador inspirado no link abaixo
        //https://www.it-swarm.dev/pt/php/qual-e-melhor-maneira-de-validar-um-cartao-de-credito-em-php/958381794/

        $infoCC = [
            'American' => ['name' => 'American Express', 'regex' => '/^([34|37]{2})([0-9]{13})$/'], 
            'Dinners' => ['name' => 'Dinners', 'regex' => '/^([30|36|38]{2})([0-9]{12})$/'], 
            'Discover' => ['name' => 'Discover', 'regex' => '/^([6011]{4})([0-9]{12})$/'], 
            'Master' => ['name' => 'Master Card', 'regex' => '/^([51|52|53|54|55]{2})([0-9]{14})$/'], 
            'Visa' => ['name' => 'Visa', 'regex' => '/^([4]{1})([0-9]{12,15})$/'], 
        ];

        $verified = false;
        $cardInfo = $infoCC[$type];

        if (isset($cardInfo)) {
            if (preg_match($infoCC[$type]['regex'],$cc_num)) {
                $verified = true;
            }
        }
    
        return $verified;
    }
}
