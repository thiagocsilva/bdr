<?php

class Input
{
    static function get($key, $default = null)
    {
        return (isset($_REQUEST[$key])) ? $_REQUEST[$key] : $default;
    }
}

