<?php

class Session
{

    static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    static function get($key, $default = null)
    {
        return (isset($_SESSION) && isset($_SESSION[$key])) ? $_SESSION[$key] : $default;
    }

    /**
     * Deleta toda a sessao
     * @return void
     */
    static function deleteAll()
    {
        session_start();
        $_SESSION = array();
        if (isset($_COOKIE[session_name()]))
            setcookie(session_name(), '', time() - 42000, '/');
        session_destroy();
    }

    static function start()
    {
        if (!isset($_SESSION)) session_start();
    }

    /**
     * deleta uma variavel da sessao
     * @param $key
     */
    static function delete($key)
    {
        unset($_SESSION[$key]);
    }

}