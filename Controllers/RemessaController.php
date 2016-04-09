<?php

require_once '../Views/RemessaView.php';
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
        $data = date("d-m-Y");
        $textCompleto = $text = null;

        $nomeDoArquivo = "Remessa (" . $data . ")";
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
