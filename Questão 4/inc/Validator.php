<?php

class Validator
{

    /**
     * valida o cpf
     * aceita:
     * 28646418448 success
     * 286.464.184-48 success
     * @param $cpf
     * @return bool
     */
    public static function cpf($cpf)
    {
        if (empty($cpf))
            return false;
        $cpf = preg_replace('/\D/', '', $cpf);
        if (strlen($cpf) != 11)
            return false;
        if ($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999'
        )
            return false;
        // Calcula os digitos verificadores para verificar se o
        // CPF é válido

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++)
                $d += $cpf{$c} * (($t + 1) - $c);
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d)
                return false;
        }
        return true;
    }

//    public static function cnpj($cnpj)
//    {
//        if (empty($cnpj))
//            return false;
//        $cnpj = preg_replace('/\D/', '', $cnpj);
//        if (strlen($cnpj) != 11)
//            return false;
//        if ($cnpj == '00000000000' ||
//            $cnpj == '11111111111' ||
//            $cnpj == '22222222222' ||
//            $cnpj == '33333333333' ||
//            $cnpj == '44444444444' ||
//            $cnpj == '55555555555' ||
//            $cnpj == '66666666666' ||
//            $cnpj == '77777777777' ||
//            $cnpj == '88888888888' ||
//            $cnpj == '99999999999'
//        ) {
//            return false;
//        }

//        cnpj = cnpj.replace(/[^\d]+/g,'');
//
//    if(cnpj == '') return false;
//
//    if (cnpj.length != 14)
//        return false;
//
//    // Elimina CNPJs invalidos conhecidos
//    if (cnpj == "00000000000000" ||
//        cnpj == "11111111111111" ||
//        cnpj == "22222222222222" ||
//        cnpj == "33333333333333" ||
//        cnpj == "44444444444444" ||
//        cnpj == "55555555555555" ||
//        cnpj == "66666666666666" ||
//        cnpj == "77777777777777" ||
//        cnpj == "88888888888888" ||
//        cnpj == "99999999999999")
//        return false;
//
//    // Valida DVs
//    tamanho = cnpj.length - 2
//    numeros = cnpj.substring(0,tamanho);
//    digitos = cnpj.substring(tamanho);
//    soma = 0;
//    pos = tamanho - 7;
//    for (i = tamanho; i >= 1; i--) {
//        soma += numeros.charAt(tamanho - i) * pos--;
//        if (pos < 2)
//            pos = 9;
//    }
//    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
//    if (resultado != digitos.charAt(0))
//        return false;
//
//    tamanho = tamanho + 1;
//    numeros = cnpj.substring(0,tamanho);
//    soma = 0;
//    pos = tamanho - 7;
//    for (i = tamanho; i >= 1; i--) {
//        soma += numeros.charAt(tamanho - i) * pos--;
//        if (pos < 2)
//            pos = 9;
//    }
//    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
//    if (resultado != digitos.charAt(1))
//        return false;
//
//    return true;

//    }
}