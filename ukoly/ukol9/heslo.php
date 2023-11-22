<?php 
    function heslo($delka) {
        $znaky = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $heslo = "";

        for ($i = 0; $i < $delka; $i++) {
            $index = rand(0, strlen($znaky) - 1);
            $heslo .= $znaky[$index];
        }

        return $heslo;

    }
