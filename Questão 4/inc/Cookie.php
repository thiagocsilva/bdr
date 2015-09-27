<?php

class Cookie
{
    /**
     * @param $key
     * @param $value
     * @param $time  default = 1 mes
     * @param string $path
     */
    public static function set($key, $value, $time = null, $path = '/')
    {
        //$mes = (time() + 3600 * 24 * 30);//1mes  //time() + 3600 = 1hora
        $time = ($time) ?: (time() + 2592000);
        setcookie($key, $value, $time, $path);
    }

    public static function get($key, $default = null)
    {
        return (isset($_COOKIE[$key])) ? $_COOKIE[$key] : $default;
    }

    /**
     * unserialize array in cookie
     * @param $key
     * @return array
     */
    public static function get_array($key)
    {
        //unserialize
        return json_decode(self::get($key), true) ?: array();
    }

    /**
     * serialize array in cookie
     * @param $key
     * @param $arr
     */
    public static function set_array($key, $arr)
    {
        self::set($key, json_encode($arr)); //serialize($arr)
    }

    /**
     * adiciona um elemento no array que esta serializado em cookie
     * @param $key
     * @param $value
     * @param int $max maximo de elementos default=10
     * @param bool $is_duplicados se aceita duplicados default=false
     */
    public static function push_array($key, $value, $max = 10, $is_duplicados = false)
    {
        $arr = self::get_array($key);
        if ($max && count($arr) >= $max) //armazena so os 10 ultimos
            array_pop($arr);
        if (!$is_duplicados) { //nao aceita duplicados
            if (!in_array($value, $arr))
                array_unshift($arr, $value);
        } else //aceita
            array_unshift($arr, $value);
        self::set_array($key, $arr);
    }

    public static function delete($key)
    {
        if (isset($_COOKIE[$key])) {
            unset($_COOKIE[$key]);
            setcookie($key, '', time() - 3600); // empty value and old timestamp
        }
    }

    public static function deleteAll()
    {
        foreach ($_COOKIE as $key => $value) {
            unset($value);
            setcookie($key, '', time() - 3600);
        }
    }
}