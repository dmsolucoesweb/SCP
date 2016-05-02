<?php

function modulo_11($num, $base = 9, $r = 0) {
    $soma = 0;
    $fator = 2;

    /* Separacao dos numeros */
    for ($i = strlen($num); $i > 0; $i--) {
        // pega cada numero isoladamente
        $numeros[$i] = substr($num, $i - 1, 1);
        // Efetua multiplicacao do numero pelo falor
        $parcial[$i] = $numeros[$i] * $fator;
        // Soma dos digitos
        $soma += $parcial[$i];
        if ($fator == $base) {
            // restaura fator de multiplicacao para 2 
            $fator = 1;
        }
        $fator++;
    }

    /* Calculo do modulo 11 */
    if ($r == 0) {
        $soma *= 10;
        $digito = $soma % 11;
        if ($digito == 10) {
            $digito = 0;
        }
        return $digito;
    } elseif ($r == 1) {
        $resto = $soma % 11;
        return $resto;
    }
}

    function Modulo11($valor) {
            $multiplicador = '4329876543298765432987654329876543298765432';
            for ($i = 0; $i<=42; $i++ ) {
                 $parcial = $valor[$i] * $multiplicador[$i];
                         $total += $parcial;
            }
            $resultado = 11-($total%11);
            if (($resultado >= 10)||($resultado == 0)) {
                 $resultado = 1;
            }

            return $resultado;
    }
