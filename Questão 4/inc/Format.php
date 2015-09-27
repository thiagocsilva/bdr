<?php

class Format
{
    const FORMAT_DATE = 'd/m/Y';
    const FORMAT_DATETIME = 'd/m/Y H:m';
    const FORMAT_TIME = 'H:i:s';

    const FORMAT_MYSQL_DATE = 'Y-m-d';
    const FORMAT_MYSQL_DATETIME = 'Y-m-d H:i:s';
    const FORMAT_MYSQL_TIME = 'H:i:s';

//
//define("DATE_TIME_FORMAT_MYSQL", "Y-m-d H:i:s");
//define("DATE_FORMAT_MYSQL", "Y-m-d");
//define("DATE_TIME_FORMAT_WEB", "d/m/Y H:m");
//define("DATE_TIME_FORMAT_WEB_MIN", "d/m/y H:m");
//define("DATE_FORMAT_WEB", "d/m/Y");


    /**
     * '87.332.587/0001-14' => '87332587000114'
     * 'ABS-1234' => 'ABS1234'
     * @param $value
     * @return mixed
     */
    public static function word($value)
    {
//        $pattern = '/[^\w]/'; //funciona tbm
        $pattern = '/\W/';
        $replacement = '';
        $string = $value;
        return preg_replace($pattern, $replacement, $string);
    }


    /**
     * Remove formatacao e retorna somente os numeros
     * @param $value '87.332.587/0001-14'
     * @return mixed 87332587000114
     */
    public static function digit($value)
    {
//        $pattern = '/[^0-9]/';
        $pattern = '/\D/';
        $replacement = '';
        $string = $value;
        return preg_replace($pattern, $replacement, $string);
    }

    /**
     * mascara para cnpj
     * @param $value
     * accept:
     * 87332587000114 success
     * '87.332.587/0001-14' success
     * @return string '87.332.587/0001-14'
     */
    public static function  cnpj($value)
    {
        $pattern = '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/';
        $replacement = '$1.$2.$3/$4-$5';
        $string = self::digit($value);
        return preg_replace($pattern, $replacement, $string);
    }

    /**
     * mascara para placa de veiculo
     * @param $value 'ABS1234'
     * @return mixed 'ABS-1234'
     */
    public static function placa($value)
    {
        $pattern = '/^(\w{3})(\d{4})$/';
        $replacement = '$1-$2';
        $string = self::word($value);
        return preg_replace($pattern, $replacement, $string);
    }


    public static function cep($value)
    {
        $pattern = '/^(\d{5})(\d{3})$/';
        $replacement = '$1-$2';
        $string = self::digit($value);
        return preg_replace($pattern, $replacement, $string);
    }

    /**
     * @param $value 12345.012
     * @param int $fixed
     * @return string 12.345,01
     */
    public static function float($value, $fixed = 2)
    {
        return number_format($value, $fixed, ',', '.');
    }


    /**
     * Ex:
     *    echo Format::phone('5548995330467') .'</br>';
     *    echo Format::phone('554899533046') .'</br>';
     *    echo Format::phone('48995330467') .'</br>';
     *    echo Format::phone('4899533046') .'</br>';
     *    echo Format::phone('995330467') .'</br>';
     *    echo Format::phone('99533046') .'</br>';
     *
     * @param $value +554899533043
     * @param $options
     * @return mixed
     */
    public static function phone($value, $options = null)
    {
        $string = self::digit($value);
        switch (strlen($string)) {
            case 13:
                $pattern = '/^(\d{2})(\d{2})(\d{4})(\d{5})$/';
                $replacement = '+$1 ($2)$3-$4';
                break;
            case 12:
                $pattern = '/^(\d{2})(\d{2})(\d{4})(\d{4})$/';
                $replacement = '+$1 ($2)$3-$4';
                break;
            case 11:
                $pattern = '/^(\d{2})(\d{4})(\d{5})$/';
                $replacement = '($1)$2-$3';
                break;
            case 10:
                $pattern = '/^(\d{2})(\d{4})(\d{4})$/';
                $replacement = '($1)$2-$3';
                break;
            case 9:
                $pattern = '/^(\d{4})(\d{5})$/';
                $replacement = '$1-$2';
                break;
            case 8:
                $pattern = '/^(\d{4})(\d{4})$/';
                $replacement = '$1-$2';
                break;
            default:
                $pattern = '/^(\d{4})(\d{4})$/';
                $replacement = '$1-$2';
                break;
        }
        return preg_replace($pattern, $replacement, $string);
    }


    public static function date($date, $format = self::FORMAT_DATE)
    {
        $dateObject = $date instanceof DateTime ? $date : new DateTime($date);
        return $dateObject->format($format);
    }


    /**
     * mascara para cpf
     * @param $value
     * accept:
     * 08144225942 success
     * 081.442.259-42 success
     * @return string '081.442.259-42'
     */
    public static function  cpf($value)
    {
        $pattern = '/^(\d{3})(\d{3})(\d{3})(\d{2})$/';
        $replacement = '$1.$2.$3-$4';
        $string = self::digit($value);
        return preg_replace($pattern, $replacement, $string);
    }


    /**
     * calcula a idade atraves da data de nascimento
     * @param $date
     * @return int
     */
    public static function idade($date)
    {
        # object oriented
        $from = $date instanceof DateTime ? $date : new DateTime($date);
        $to = new DateTime('today');
        return $from->diff($to)->y;

//# procedural
//        echo date_diff(date_create('1970-02-01'), date_create('today'))->y;


//        // Declara a data! :P
//        $data = '29/08/2008';
//
//        // Separa em dia, mês e ano
//        list($dia, $mes, $ano) = explode('/', $data);
//
//        // Descobre que dia é hoje e retorna a unix timestamp
//        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
//        // Descobre a unix timestamp da data de nascimento do fulano
//        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
//
//        // Depois apenas fazemos o cálculo já citado :)
//        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
//
//        print $idade;
    }
}