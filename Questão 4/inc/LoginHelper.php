<?php
include_once(ABSPATH_REPOSITORIES . '/UsuarioRepository.php');

Class LoginHelper
{
    const ERROR_EMAIL_INCORRETO = 1;
    const ERROR_SENHA_INCORRETA = 2;
    const SALT_KEY = 'welEJSaioBLyTEjwaQNqmNnljdYbY_kDyOmVhAIxEzWkAbWTlCuhg_cA'; // static salt (56 bytes)

    /**
     * verifica se o usuario está logado, verificando se a sessao existe.
     * @return bool
     */
    static function hasLogged()
    {
        return Session::get('usuario_email');
    }

    static function hasLoggedId()
    {
        return Session::get('usuario_id');
    }

    static function logout()
    {
        //Session::deleteAll();
        Session::delete('usuario_id');
        Session::delete('usuario_email');
    }

    /**
     * Recebe uma autenticacao para salvar a sessao
     * @param $autenticao  array('usuario_id'=>'123', 'usuario_email'=>'abc@gmail.com')
     */
    static function logged($autenticao)
    {
        Session::set('usuario_id', $autenticao['id']);
        Session::set('usuario_email', $autenticao['email']);
    }

    /**
     * Retorna os dados do usuario autenticado
     * @return array
     */
    static function user()
    {
        $autenticacao = array(
            'id' => Session::get('usuario_id'),
            'email' => Session::get('usuario_email'),
        );
        return $autenticacao;
    }

    /**
     * verifica se o usuario logado é o administrador
     * @return bool
     */
    public static function hasAdmin()
    {
        return self::user()['email'] == UsuarioRepository::ADM_EMAIL ? true : false;
    }

    public static function senhaSalt($senha)
    {
        $salt = self::random_salt();
        $senha_cript = hash("sha512", $salt . $senha); // salt 1
        $senha_cript = hash("sha512", self::SALT_KEY . $senha_cript); // salt 2

        $secure = array(
            'pass' => $senha_cript,
            'salt' => $salt
        );
        return $secure;
    }

    /**
     * compara as senhas do usuario
     * @param $usuario
     * @param $senha
     * @return bool
     */
    public static function comparaSenha($usuario, $senha)
    {
        $passdb = $usuario['pass'];
        $saltdb = $usuario['salt'];

        $enc_input = hash("sha512", $saltdb . $senha); // salt 1
        $enc_input = hash("sha512", self::SALT_KEY . $enc_input); // salt 2
        return ($enc_input == $passdb);
    }

    private static function random_salt()
    {
        // random salt stored on database (8 bytes)
        return self::random_str(8);
    }

    private static function random_str($n)
    {
        $rs = null;
        for ($i = 0; $i < $n; $i++) {
            $range = rand(0, 2);
            switch ($range) {
                case(0):
                    $rs .= chr(rand(48, 57));
                    break;
                case(1):
                    $rs .= chr(rand(65, 90));
                    break;
                case(2):
                    $rs .= chr(rand(97, 122));
                    break;
            }
        }
        return $rs;
    }

    public static function senha_aleatoria()
    {
        return self::random_str(4);
    }
}

