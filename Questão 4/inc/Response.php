<?php

class Response
{
    static function json($array = array(), $code = 200)
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($array ? $array : array());
        exit();
    }

    static function error($code = 404, $error = array())
    {
//        if (!empty($message)) {
//            header('Content-Type: application/json');
//            echo json_encode($message);
//        }
        http_response_code($code);
        switch ($code) {
            case 404:
                if (empty($error))
                    $error = array('message' => 'página não encontrada');
                include(ABSPATH_VIEW . '/code.php');
                break;
            case 503:
                if (empty($error))
                    $error = array('message' => 'não autorizado');
                include(ABSPATH_VIEW . '/code.php');
                break;
            default:
                include(ABSPATH_VIEW . '/code.php');
                break;
        }
        exit();
    }

    /**
     * retornar a string da url que seria redirecionada
     * @param $url
     * @return string
     */
    static function redirect_string($url)
    {
        return (strpos($url, 'http') === false) ? url($url) : $url;
    }

    /**
     * redireciona para uma url
     * @param $url
     */
    static function redirect($url)
    {
        $url_redirect = (strpos($url, 'http') === false) ? url($url) : $url;
        header("location:$url_redirect");
        exit();
    }


    /**
     * volta para a pagina que fez a requisicao
     */
    static function  redirect_back()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    /**
     * Salva a url atual em uma session para posteriormente poder usar ela
     * ex: acessou uma tela, mas precisa fazer login antes, entao redireciona para tela de login
     * e depois de feito o login consegue voltar nessa url de partida
     *
     * @param $url
     */
    public static function guest($url)
    {
        Session::set('url.intended', url_current());
        self::redirect($url);
    }

    /**
     * Verifica se existe alguma url salva em sessao, se nao, redireciona para a url passada como parametro
     * @param $default
     */
    public static function intended($default)
    {
        $url = Session::get('url.intended', $default);
        Session::delete('url.intended');
        self::redirect($url);
    }

    public static function intended_string($default)
    {
        $url = Session::get('url.intended', $default);
        Session::delete('url.intended');
        return self::redirect_string($url);
    }


}
