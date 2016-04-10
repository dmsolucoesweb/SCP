<?php

require_once '../Views/RemessaView.php';
require_once '../Classes/cpf.php';
require_once '../Classes/datasehoras.php';
require_once '../Ados/RemessaAdo.php';
require_once '../Ados/ClienteAdo.php';
require_once '../Ados/RemessaAdo.php';

class RemessaController {

    private $RemessaView = null;
    private $RemessaAdo = null;

    public function __construct() {
        $this->RemessaView = new RemessaView();
        $this->RemessaAdo = new RemessaAdo();

        $acao = $this->RemessaView->getAcao();

        switch ($acao) {
            case 'grm':
                $this->gerarRemessas();
                break;

            case 'grma':
                $this->gerarRemessasAnteriores();
                break;

            default:
                $this->RemessaView = new RemessaView();
                break;
        }

        $this->RemessaView->displayInterface(NULL);
    }

    function gerarRemessas() {
        $arrayBoletoRemessa = $this->RemessaAdo->consultaBoletosParaRemessa();
        $ClienteAdo = new ClienteAdo();
        $data = date("dmy");
        $narquivo = date("dmyHi");
        $textCompleto = $text = null;

        $nomeDoArquivo = "R_" . $narquivo . "";
        $fp = fopen("C:\Remessas\\" . $nomeDoArquivo . ".seq", "w");
        //$data1 = explode("-", $data);
        $text .= "0"
                ."1"
                ."REMESSA"
                ."01"
                .str_pad("COBRANCA", 15, " ", STR_PAD_RIGHT)
                ."0"
                ."0501"
                ."55"
                ."05010030310"
                ."  "
                ."PARK VILLE INCORPORACAO S LTDA"
                ."399"
                .str_pad("HSBC", 15, " ", STR_PAD_RIGHT)
                .$data
                ."01600"
                ."BPI".
                "  "
                ."LANCV08"
                .str_pad("", 277, " ", STR_PAD_RIGHT)
                ."000001"
                ."\r\n";
        $i = 2;
        if (is_array($arrayBoletoRemessa)) {
            foreach ($arrayBoletoRemessa as $BoletoModel) {

                $boletoId = $BoletoModel['0'];
                $boletoNumeroDocumento = $BoletoModel['1'];
                $boletoNossoNumero = $BoletoModel['2'];
                $CPF = new CPF;
                $DatasEHoras = new DatasEHoras;
                $boletoSacado = $BoletoModel['3'];
                $Cliente = $ClienteAdo->consultaObjetoPeloId($boletoSacado);
                $clienteNome = $Cliente->getClienteNome();
                $clienteCPF = $Cliente->getClienteCPF();
                $clienteEndereco = $Cliente->getClienteEndereco();
                $clienteEstado = $Cliente->getClienteEstado();
                $clienteCidade = $Cliente->getClienteCidade();
                $clienteCEP = $CPF::retiraMascaraCPF($Cliente->getClienteCEP());

                $Sacado = $clienteNome . " - " . $clienteCPF;
                
                $boletoRemetido = $BoletoModel['4'];
                $boletoDataVencimento = $DatasEHoras->getDataInvertidaComTracos($BoletoModel['5']);
                $datavenc = date("dmy", strtotime($boletoDataVencimento));
                $boletoNumeroParcela = $BoletoModel['6'];
                $boletoValor = number_format($BoletoModel['7'], 2, "", "");
                
                
                $ncpf = $CPF::retiraMascaraCPF($clienteCPF);
                if (is_null($ncpf)) { $cod = "98"; } 
                else { if(strlen($ncpf) == 11) { $cod = "01"; }
                elseif(strlen($ncpf) > 11 ) { $cod = "02";} 
                else {$cod = "99";} }
                // 01 CPF // 02 CNPJ // 98 NÃO TEM // 99 OUTROS                                                                                   DESCONTO_DATA              VALOR                                                                                                  CARTEIRA.OC
                $text .= "1"
                        ."02"
                        ."23501469000100"
                        ."0"
                        ."0501"
                        ."55"
                        ."05010030310"
                        ."  "
                        .str_pad("", 25," ", STR_PAD_RIGHT)
                        .$boletoNossoNumero
                        .str_pad("", 6, " ", STR_PAD_RIGHT)
                        .str_pad("", 11, " ", STR_PAD_RIGHT)
                        .str_pad("", 6, " ", STR_PAD_RIGHT)
                        .str_pad("", 11, " ", STR_PAD_RIGHT)
                        ."0"
                        ."00"
                        .str_pad($boletoNumeroDocumento, 10, " ", STR_PAD_RIGHT)
                        .$datavenc
                        .str_pad($boletoValor, 13, "0", STR_PAD_LEFT)
                        ."399"
                        ."00000"
                        ."98"
                        ."N"
                        ."100416"
                        ."00"
                        ."00"
                        .str_pad("", 13, " ", STR_PAD_RIGHT)
                        ."000000"
                        .str_pad("", 13, "0", STR_PAD_LEFT)
                        .str_pad("", 13, "0", STR_PAD_LEFT)
                        .str_pad("", 13, "0", STR_PAD_LEFT)
                        .$cod
                        .str_pad($ncpf, 14, "0", STR_PAD_LEFT)
                        .str_pad($clienteNome, 40, " ", STR_PAD_RIGHT)
                        .str_pad($clienteEndereco, 38, " ", STR_PAD_RIGHT)
                        ."  "
                        .str_pad("0", 12, " ", STR_PAD_RIGHT)
                        .$clienteCEP
                        .str_pad($clienteCidade, 15, " ", STR_PAD_RIGHT)
                        .$clienteEstado
                        .str_pad("", 39, " ", STR_PAD_RIGHT)
                        ." "
                        ."  "
                        ."9"
                        .str_pad($i, 6, "0", STR_PAD_LEFT)
                        ."\r\n";
                $i++;
            }
        }
        if(!isset($i)) {$i = 2;}
        $text .= "9"
                .str_pad("", 393, " ", STR_PAD_RIGHT).
                str_pad($i, 6, "0", STR_PAD_LEFT);
        $escreve = fwrite($fp, $text);

        if ($fp == false)
            die('Não foi possível abrir o arquivo.');

        if ($fp == true) {
            $RemessaAdo = new RemessaAdo();
            $RemessaAdo->alteraRemetido();
            fclose($fp);
        }
    }

    function gerarRemessasAnteriores() {
        $arrayBoletoRemessa = $this->RemessaAdo->consultaBoletosParaRemessaAnterior();
        $ClienteAdo = new ClienteAdo();
        $data = date("d-m-Y");
        $textCompleto = $text = null;

        $nomeDoArquivo = "Remessa Anteriores (" . $data . ")";
        $fp = fopen("C:\Remessas\\" . $nomeDoArquivo . ".seq", "w");

        if (is_array($arrayBoletoRemessa)) {
            foreach ($arrayBoletoRemessa as $BoletoModel) {

                $boletoId = $BoletoModel['0'];
                $boletoNumeroDocumento = $BoletoModel['1'];
                $boletoNossoNumero = $BoletoModel['2'];

                $boletoSacado = $BoletoModel['3'];
                $Cliente = $ClienteAdo->consultaObjetoPeloId($boletoSacado);
                $clienteNome = $Cliente->getClienteNome();
                $clienteCPF = $Cliente->getClienteCPF();
                $clienteEndereco = $Cliente->getClienteEndereco();
                $clienteEstado = $Cliente->getClienteEstado();
                $clienteCidade = $Cliente->getClienteCidade();
                $clienteCEP = $Cliente->getClienteCEP();

                $Sacado = $clienteNome . " - " . $clienteCPF;

                $boletoRemetido = $BoletoModel['4'];
                $boletoDataVencimento = $BoletoModel['5'];
                $boletoNumeroParcela = $BoletoModel['6'];
                $boletoValor = $BoletoModel['7'];

                $text .= 'Numero do Documento: ' . $boletoNumeroDocumento . '| Nosso Numero: ' . $boletoNossoNumero . ' | Sacado: ' . $Sacado . ' | Remetido: ' . $boletoRemetido . ' | Data de Vencimento: ' . $boletoDataVencimento . ' | Numero da Parcela: ' . $boletoNumeroParcela . ' | Valor do Boleto: ' . $boletoValor . "<br><br>";
            }
        }

        $escreve = fwrite($fp, $text);

        fclose($fp);
    }

}
