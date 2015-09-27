<?php

/**
 * Class Config
 * Busca um dado de algum arquivo de configuracao
 * Ex:
 *
 * pasta config contem o arquivo site.php e ele retorna um array com alguns dados
 * return array ('nome'=> 'nomedosite');
 *
 * é possivel obter esse dado de qualquer lugar fazendo Config::get('site.nome'); // retorna 'nomedosite'
 *
 *
 *
 */
class Config
{
    private static $arrs_cache = array();

    /**
     * Busca um dado de algum arquivo de configuracao
     * ex:
     * Config::get('site.nome');
     * Config::get('site.social.facebook');
     * Config::get('site.social.twitter');
     * Config::get('email.username');
     *
     * @param $key (nome_do_arquivo.key_no_array)
     * @return mixed
     * @throws Exception
     */
    public static function get($key)
    {
        $segments = explode('.', $key);
        $file_name = $segments[0];
        unset($segments[0]); //remove do array;
        $key = implode('.', $segments);

        $path = ABSPATH_CONFIG . "/$file_name.php";
        if (array_key_exists($path, static::$arrs_cache)) {
            $arr = static::$arrs_cache[$path];
        } else {
            if (file_exists($path))
                $arr = include $path;
            else
                throw new Exception('o arquivo ' . $path . ' não existe');

            static::$arrs_cache[$path] = $arr;
        }
        return static::assignArrayByPath($arr, $key);
    }

    private static function assignArrayByPath($arr, $path)
    {
        $keys = explode('.', $path);
        while ($key = array_shift($keys))
            $arr = $arr[$key];
        return $arr;
    }


}