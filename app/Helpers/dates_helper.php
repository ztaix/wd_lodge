<?php

if (! function_exists('convert_date_format'))
{
    function sql_date_to_dmY($input_date)
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $input_date);
        if ($date === false) {
            return false;
        }
        return $date->format('d-m-Y');
    }
    function countNights($startDate, $endDate) {
        // Convertir les chaînes de date en objets DateTime
        $start = DateTime::createFromFormat('d-m-Y', $startDate);
        $end = DateTime::createFromFormat('d-m-Y', $endDate);
    
        // Vérifier que les dates sont des objets DateTime valides
        if ($start === false || $end === false) {
            // Gérer l'erreur ici, peut-être en retournant false ou en lançant une exception
            // Par exemple :
            // throw new Exception("Invalid date format.");
            return false; // Ou tout autre valeur/exception qui a du sens dans votre contexte
        }
    
        // Calculer la différence entre les deux dates
        $interval = $start->diff($end);
    
        // Retourner le nombre de nuits
        return $interval->days;
    }
    
}