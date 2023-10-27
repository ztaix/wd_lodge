<?php

function FreetextToVartext($input)
{
    $input = strtolower($input);
    
    $accents = ['à', 'á', 'â', 'ã', 'ä', 'å', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'è', 'é', 'ê', 'ë', 'ç', 'ì', 'í', 'î', 'ï', 'ù', 'ú', 'û', 'ü', 'ÿ', 'ñ', 'œ', 'æ'];
    $replace = ['a', 'a', 'a', 'a', 'a', 'a', 'o', 'o', 'o', 'o', 'o', 'o', 'e', 'e', 'e', 'e', 'c', 'i', 'i', 'i', 'i', 'u', 'u', 'u', 'u', 'y', 'n', 'oe', 'ae'];
    
    $input = str_replace($accents, $replace, $input);
    
    $input = str_replace([' ', "'"], '_', $input);
    $input = preg_replace('/[^a-z0-9_]/', '', $input);

    return $input;
}

function DiscountToArray($input){
    $result = [];
    $lines = explode("\n", trim($input));
    
    foreach ($lines as $line) {
        list($keyStr, $valueStr) = explode(":", $line);
        $key = (int) trim($keyStr);
        $value = (int) str_replace('%', '', trim($valueStr));
        $result[$key] = $value;
    }
    
    return $result;
}