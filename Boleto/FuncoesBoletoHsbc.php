<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers�o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est� dispon�vel sob a Licen�a GPL dispon�vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc� deve ter recebido uma c�pia da GNU Public License junto com     |
// | esse pacote; se n�o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora��es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo�o Prado Maia e Pablo Martins F. Costa                |
// | 																	  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Equipe Coordena��o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto HSBC: Bruno Leonardo M. F. Gon�alves          |
// +----------------------------------------------------------------------+
require_once 'modulo_11.php';

class FuncoesBoletoHsbc {

    private $linha = null;
    private $codigo_barras = null;
    private $linha_digitavel = null;
    private $agencia_codigo = null;
    private $nosso_numero = null;
    private $codigo_banco_com_dv = null;

    public function __construct($dadosboleto) {
        $codigobanco = '399';
        $parte1 = substr($codigobanco, 0, 3);
        $codigo_banco_com_dv = $parte1 . "-" . modulo_11($parte1);
        $nummoeda = "9";
        $fator_vencimento = $this->calcula_fator($dadosboleto["data_vencimento"]);

        //valor tem 10 digitos, sem virgula
        $valor = $this->formata_numero($dadosboleto["valor_boleto"], 10, 0, "valor");
        //carteira � CNR
        $carteira = $dadosboleto["carteira"];
        //codigocedente deve possuir 7 caracteres
        $codigocedente = $this->formata_numero($dadosboleto["codigo_cedente"], 7, 0);

        $ndoc = $dadosboleto["numero_documento"];
        $vencimento = $dadosboleto["data_vencimento"];

        // n�mero do documento (sem dvs) � 13 digitos
        $nnum = $dadosboleto["numero_documento"];
        // nosso n�mero (com dvs) � 16 digitos
        /* $nossonumero = geraNossoNumero($nnum,$codigocedente,$vencimento,'4'); */
        $nossonumero = $dadosboleto["nosso_numero"];

        $vencjuliano = $this->dataJuliano($vencimento);
        $app = "1";

        $agencia_codigo = $dadosboleto["agencia"];
        $range = substr($nossonumero, 0, 5);
        $sequencial = substr($nossonumero, 5, 6);
        // 43 numeros para o calculo do digito verificador do codigo de barras
        $grupo1 = $codigobanco.$nummoeda.$range;
        $grupo1dv = $this->modulo_10($grupo1);
        
        $grupo2 = $sequencial.$agencia_codigo;
        $grupo2dv = $this->modulo_10($grupo2);
        
        $grupo3 = $codigocedente.$carteira.$app;
        $grupo3dv = $this->modulo_10($grupo3);
        
        // DAC
        $grupo4 = $codigobanco.$nummoeda.$fator_vencimento.$valor.$nossonumero.$agencia_codigo.$codigocedente.$carteira.$app;//$dac;
        $dac = $this->digitoVerificador_barra($grupo4, 9, 0);
        
        $grupo5 = $fator_vencimento.$valor;
        
        $linha = $grupo1.$grupo1dv.$grupo2.$grupo2dv.$grupo3.$grupo3dv.$dac.$grupo5;
        $barra = $codigobanco.$nummoeda.$dac.$fator_vencimento.$valor.$nossonumero.$agencia_codigo.$codigocedente.$carteira.$app;
        //$barra, 9, 0);
        // Numero para o codigo de barras com 44 digitos

        $this->linha = $linha;
        $this->codigo_barras = $barra;
        $this->linha_digitavel = $this->linha_digitavel($this->linha);
        $this->agencia_codigo = $agencia_codigo;
        $this->nosso_numero = $nossonumero;
        $this->codigo_banco_com_dv = $codigo_banco_com_dv;
    }

    function pegarAtributos() {
        return array($this->codigo_barras, $this->linha_digitavel, $this->agencia_codigo, $this->nosso_numero, $this->codigo_banco_com_dv);
    }
// 1 a 3    N�mero do banco
// 4        C�digo da Moeda - 9 para Real
// 5 a 9    Numero Range
// 10       Digito Verificador
// 11 a 16  Sequencial Nosso Numero
// 17 a 20  Código da Agência
// 21       Digito Verificador
// 22 a 28  Conta da Agencia
// 29 a 30  Código da carteira "00"
// 31       Código do aplicativo  = 1
// 32       Digito Verificador
// 33       DAC
// 34 a 37  Fator de vencimento
// 38 a 47  Valor do título
    function linha_digitavel($barra) {
        $novabarra = substr($barra, 0, 5).".".substr($barra, 5,5)." ".substr($barra,10,5).".".substr($barra,15,6)." ".substr($barra,21,5).".".substr($barra,26,6)." ".substr($barra,32,1)." ".substr($barra,33,14);
        return $novabarra;
    }
    
    function geraCodigoBanco($numero) {
        $parte1 = substr($numero, 0, 3);
        $parte2 = modulo_11($parte1);
        return $parte1 . "-" . $parte2;
    }

    function geraNossoNumero($ndoc, $cedente, $venc, $tipoid) {
        $ndoc = $ndoc . modulo_11_invertido($ndoc) . $tipoid;
        $venc = substr($venc, 0, 2) . substr($venc, 3, 2) . substr($venc, 8, 2);
        $res = $ndoc + $cedente + $venc;
        return $ndoc . '0'; // . modulo_11_invertido($res);
    }

    function dataJuliano($data) {
        $dia = (int) substr($data, 0, 2);
        $mes = (int) substr($data, 3, 2);
        $ano = (int) substr($data, 6, 4);
        $dataf = strtotime("$ano/$mes/$dia");
        $datai = strtotime(($ano - 1) . '/12/31');
        $dias = (int) (($dataf - $datai) / (60 * 60 * 24));
        return str_pad($dias, 3, '0', STR_PAD_LEFT) . substr($data, 9, 4);
    }

    function digitoVerificador_nossonumero($numero) {
        $resto2 = modulo_11($numero, 9, 1);
        $digito = 11 - $resto2;
        if ($digito == 10 || $digito == 11) {
            $dv = 0;
        } else {
            $dv = $digito;
        }
        return $dv;
    }

    function digitoVerificador_barra($numero) {
        $resto2 = modulo_11($numero, 9, 1);
        if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
            $dv = 1;
        } else {
            $dv = 11 - $resto2;
        }
        return $dv;
    }
    
    function calcula_fator($data) {
$DataVenc = explode('/',$data);
$DiaVenc = $DataVenc[0];
$MesVenc = $DataVenc[1];
$AnoVenc = $DataVenc[2];

$DataInic = explode('/','07/10/1997');
$DiaInic = $DataInic[0];
$MesInic = $DataInic[1];
$AnoInic = $DataInic[2];
        
$DataInic1 = mktime(0,0,0,$MesInic,$DiaInic,$AnoInic);
$DataVenc1 = mktime(0,0,0,$MesVenc,$DiaVenc,$AnoVenc);

$FatorVenc = $DataVenc1 - $DataInic1;

$Segundos = 24*60*60; // 24 horas * 60 minutos * 60 segundos

$FatorVenc1 = ceil($FatorVenc/$Segundos);
return $FatorVenc1;
    }
    

// FUN��ES
// Algumas foram retiradas do Projeto PhpBoleto e modificadas para atender as particularidades de cada banco

    function formata_numero($numero, $loop, $insert, $tipo = "geral") {
        if ($tipo == "geral") {
            $numero = str_replace(",", "", $numero);
            while (strlen($numero) < $loop) {
                $numero = $insert . $numero;
            }
        }
        if ($tipo == "valor") {
            /*
              retira as virgulas
              formata o numero
              preenche com zeros
             */
            $numero = str_replace(",", "", $numero);
            while (strlen($numero) < $loop) {
                $numero = $insert . $numero;
            }
        }
        if ($tipo == "convenio") {
            while (strlen($numero) < $loop) {
                $numero = $numero . $insert;
            }
        }
        return $numero;
    }

    function fbarcode($valor) {
        $fino = 1;
        $largo = 3;
        $altura = 50;

        $barcodes[0] = "00110";
        $barcodes[1] = "10001";
        $barcodes[2] = "01001";
        $barcodes[3] = "11000";
        $barcodes[4] = "00101";
        $barcodes[5] = "10100";
        $barcodes[6] = "01100";
        $barcodes[7] = "00011";
        $barcodes[8] = "10010";
        $barcodes[9] = "01010";

        for ($f1 = 9; $f1 >= 0; $f1--) {
            for ($f2 = 9; $f2 >= 0; $f2--) {
                $f = ($f1 * 10) + $f2;
                $texto = "";

                for ($i = 1; $i < 6; $i++) {
                    $texto .= substr($barcodes[$f1], ($i - 1), 1) . substr($barcodes[$f2], ($i - 1), 1);
                }
                $barcodes[$f] = $texto;
            }
        }

// Desenho da barra
// Guarda inicial 
        ?>
        <img src=imagens/p.png width=<?php echo $fino ?> height=<?php echo $altura ?> border=0><img src=imagens/b.png width=<?php echo $fino ?> height=<?php echo $altura ?> border=0><img src=imagens/p.png width=<?php echo $fino ?> height=<?php echo $altura ?> border=0><img src=imagens/b.png width=<?php echo $fino ?> height=<?php echo $altura ?> border=0><img 
        <?php
        $texto = $valor;
        if ((strlen($texto) % 2) <> 0) {
            $texto = "0" . $texto;
        }

// Draw dos dados
        while (strlen($texto) > 0) {
            $i = round(substr($texto, 0, 2));
//$texto = direita($texto, strlen($texto) - 2);
            $texto = substr($texto, strlen(strlen($texto) - 2) - 2, strlen($texto) - 2);
//substr($entra, strlen($entra) - $comp, $comp);
            $f = $barcodes[$i];

            for ($i = 1; $i < 11; $i+=2) {
                if (substr($f, ($i - 1), 1) == "0") {
                    $f1 = $fino;
                } else {
                    $f1 = $largo;
                }
                ?>
                    src=imagens/p.png width=<?php echo $f1 ?> height=<?php echo $altura ?> border=0><img 
                    <?php
                    if (substr($f, $i, 1) == "0") {
                        $f2 = $fino;
                    } else {
                        $f2 = $largo;
                    }
                    ?>
                    src=imagens/b.png width=<?php echo $f2 ?> height=<?php echo $altura ?> border=0><img 
                    <?php
                }
            }
// Draw guarda final
            ?>
            src=imagens/p.png width=<?php echo $largo ?> height=<?php echo $altura ?> border=0><img 
            src=imagens/b.png width=<?php echo $fino ?> height=<?php echo $altura ?> border=0><img 
            src=imagens/p.png width=<?php echo 1 ?> height=<?php echo $altura ?> border=0> 
        <?php
    }

//Fim da fun��o

    function esquerda($entra, $comp) {
        return substr($entra, 0, $comp);
    }

    function direita($entra, $comp) {
        return substr($entra, strlen($entra) - $comp, $comp);
    }

    function fator_vencimento($data) {
        $ndata = explode("-", $data);
        $ano = $mes = null;
        if (count($ndata) > 1) {
            $ano = $ndata[2];
            $mes = $ndata[1];
        }
        $dia = $ndata[0];

        return(abs(($this->_dateToDays("1997", "10", "07")) - ($this->_dateToDays($ano, $mes, $dia))));
    }

    function _dateToDays($year, $month, $day) {
        $century = substr($year, 0, 2);
        $year = substr($year, 2, 2);
        if ($month > 2) {
            $month -= 3;
        } else {
            $month += 9;
            if ($year) {
                $year--;
            } else {
                $year = 99;
                $century --;
            }
        }
        return ( floor(( 146097 * $century) / 4) +
                floor(( 1461 * $year) / 4) +
                floor(( 153 * $month + 2) / 5) +
                $day + 1721119);
    }

    function modulo_10($num) {
        $numtotal10 = 0;
        $fator = 2;

// Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--) {
// pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
// Efetua multiplicacao do numero pelo (falor 10)
// 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Ita�
            $temp = $numeros[$i] * $fator;
            $temp0 = 0;
            foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
                $temp0+=$v;
            }
            $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
// monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }

// v�rias linhas removidas, vide fun��o original
// Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }

        return $digito;
    }

    function modulo_11_invertido($num) { // Calculo de Modulo 11 "Invertido" (com pesos de 9 a 2  e n�o de 2 a 9)
        $ftini = 2;
        $ftfim = 9;
        $fator = $ftfim;
        $soma = 0;

        for ($i = strlen($num); $i > 0; $i--) {
            $soma += substr($num, $i - 1, 1) * $fator;
            if (--$fator < $ftini)
                $fator = $ftfim;
        }

        $digito = $soma % 11;
        if ($digito > 9)
            $digito = 0;

        return $digito;
    }

    function monta_linha_digitavel($codigo) {
        global $nossonumero, $numero_agencia, $codigocedente, $carteira;
// Posi��o 	Conte�do
// 1 a 3    N�mero do banco
// 4        C�digo da Moeda - 9 para Real
// 5 a 9    Numero Range
// 10       Digito Verificador
// 11 a 16  Sequencial Nosso Numero
// 17 a 20  Código da Agência
// 21       Digito Verificador
// 22 a 28  Conta da Agencia
// 29 a 30  Código da carteira "00"
// 31       Código do aplicativo  = 1
// 32       Digito Verificador
// 33       DAC
// 34 a 37  Fator de vencimento
// 38 a 47  Valor do título
// 1. Campo - composto pelo c�digo do banco, c�digo da mo�da, as cinco primeiras posi��es
// do campo livre e DV (modulo10) deste campo
        $campo1 = substr($codigo, 0, 4) . substr($nossonumero, 0, 1);
        $campo1 = $campo1 . substr($nossonumero, 1, 5);
        $campo1 = $campo1 . $this->modulo_10($campo1);
        $campo1 = substr($campo1, 0, 5) . '.' . substr($campo1, 5, 5);

// 2. Campo - composto pelas posi�oes 6 a 15 do campo livre
// e livre e DV (modulo10) deste campo
        $campo2 = substr($nossonumero, 5, 6) . substr($numero_agencia, 0, 4);
        $campo2 = $campo2 . $this->modulo_10($campo2);
        $campo2 = substr($campo2, 0, 5) . '.' . substr($campo2, 5, 6);

// 3. Campo composto pelas posicoes 16 a 25 do campo livre
// e livre e DV (modulo10) deste campo
        $campo3 = $codigocedente . $carteira . 1;
        $campo3 = $campo3 . $this->modulo_10($campo3);
        $campo3 = substr($campo3, 0, 5) . '.' . substr($campo3, 5, 6);

// 4. Campo - digito verificador do codigo de barras
        $campo4 = substr($codigo, 4, 1);

// 5. Campo composto pelo fator vencimento e valor nominal do documento, sem
// indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
// tratar de valor zerado, a representacao deve ser 000 (tres zeros).
        $campo5 = substr($codigo, 5, 4) . substr($codigo, 9, 10);

        return "$campo1 $campo2 $campo3 $campo4 $campo5";
    }

}
