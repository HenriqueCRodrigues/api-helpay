<?php

namespace App\Services;

class CreditCardService
{
    function validateCC($cc_num, $type) {
        //Validador inspirado no link abaixo
        //https://www.it-swarm.dev/pt/php/qual-e-melhor-maneira-de-validar-um-cartao-de-credito-em-php/958381794/

        $infoCC = [
            'American Express' => ['regex' => '/^([34|37]{2})([0-9]{13})$/'], 
            'Dinners' => ['regex' => '/^([30|36|38]{2})([0-9]{12})$/'], 
            'Discover Card' => ['regex' => '/^([6011]{4})([0-9]{12})$/'], 
            'MasterCard' => ['regex' => '/^([51|52|53|54|55]{2})([0-9]{14})$/'], 
            'Visa' => ['regex' => '/^([4]{1})([0-9]{12,15})$/'], 
            'Visa Retired' => ['regex' => '/^([4]{1})([0-9]{12,15})$/'], 
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