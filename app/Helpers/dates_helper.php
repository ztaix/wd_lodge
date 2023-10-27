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
}