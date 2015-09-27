<?php

require_once('Format.php');

/**
 * Classe utilizada para formatar os dados para o banco de dados
 * Class Sanatize
 */
class Sanatize
{

    public static function date($date_str, $format_out = Format::FORMAT_MYSQL_DATETIME, $format_in = Format::FORMAT_DATETIME)
    {
        if (empty($date_str))
            return null;
//        echo $date_str;
        $date = DateTime::createFromFormat($format_in, $date_str);
//        var_dump($date);
        if ($date != null)
            return $date->format($format_out);
        return null;
    }
}