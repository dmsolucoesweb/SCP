<?php

final class CPF {

    /**
     * Método retiraMascaraCPF
     * Retira a máscara do parâmetro e retorna o CPF puro.
     * @param $cpf = cpf com a máscara
     */
    public static function retiraMascaraCPF($cpf) {
        $cpf = trim(str_replace(".", "", str_replace(",", "", str_replace("-", "", str_replace("/", "", $cpf)))));
        return $cpf;
    }

    public static function retiraMascaraRenda($renda) {
        $source = array('.', ',');
        $replace = array('', '.');
        $renda = trim(str_replace($source, $replace, $renda));
        return $renda;
    }

    public static function validaCPF($cpf = NULL) {

        if (empty($cpf)) {
            return false;
        }

        // Retira máscara
        //$cpf = ereg_replace('[^0-9]', '', $cpf);
        $cpf = self::retiraMascaraCPF($cpf);
        // str_pad = formata a string com tamanho 11 e preenche com '0' à esquerda.
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        if (strlen($cpf) != 11) {
            return false;
        } else {
            if ($cpf == '00000000000' ||
                    $cpf == '11111111111' ||
                    $cpf == '22222222222' ||
                    $cpf == '33333333333' ||
                    $cpf == '44444444444' ||
                    $cpf == '55555555555' ||
                    $cpf == '66666666666' ||
                    $cpf == '77777777777' ||
                    $cpf == '88888888888' ||
                    $cpf == '99999999999') {
                return false;
            } else {
                for ($t = 9; $t < 11; $t++) {

                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf{$c} != $d) {
                        return false;
                    }
                }

                return true;
            }
        }
    }

}
