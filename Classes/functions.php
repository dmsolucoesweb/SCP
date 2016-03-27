<?php

// FUNÇÕES GERAIS DO SISTEMA
function mascara($valor, $mascara) {
    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mascara) - 1; $i++) {
        if ($mascara[$i] == '#') {
            if (isset($valor[$k]))
                $maskared .= $valor[$k++];
        }
        else {
            if (isset($mascara[$i]))
                $maskared .= $mascara[$i];
        }
    }
    return $maskared;
}
