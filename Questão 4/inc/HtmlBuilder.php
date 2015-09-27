<?php

class HTML
{
    static function script($path, $async = false)
    {
        return '<script ' . ($async ? 'async ' : '') . 'src="' . base() . $path . '"></script>';
    }

    static function style($path)
    {
        return '<link type="text/css" rel="stylesheet" href="' . base() . $path . '">';
    }
}
