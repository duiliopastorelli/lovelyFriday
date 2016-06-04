<?php

namespace OrderBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OrderBundle extends Bundle
{
    //Generate random codes for the orders
    private function generateNewCode($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //Get for the management code
    public function getManCode() {
        return $this->generateNewCode();
    }

    //Get for the user code
    public function getJoinCode() {
        return $this->generateNewCode();
    }

}
