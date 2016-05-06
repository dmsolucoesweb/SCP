<?php

require_once '../Views/BoletoView.php';
require_once '../Models/BoletoModel.php';
require_once '../Ados/BoletoAdo.php';
require_once '../Boleto/BoletoHsbc.php';

class BoletoController {

    private $BoletoView = null;
    private $BoletoModel = null;
    private $BoletoAdo = null;

    public function __construct() {
        $this->BoletoView = new BoletoView();
        $this->BoletoModel = new BoletoModel();
        $this->BoletoAdo = new BoletoAdo();

        $acao = $this->BoletoView->getAcao();

        switch ($acao) {
            case 'nbo':
                $this->novoBoleto();
                break;

            case 'bbo':
                $this->buscarBoleto();
                break;

            case 'cbo':
                $this->cadastrarBoleto();
                break;

            case 'ebo':
                $this->excluirBoleto();
                break;

            case 'grm':
                $this->gerarRemessas();
                break;

            case 'ibo':
                $this->imprimirBoleto();
                break;

            default:
                $this->BoletoView = new BoletoView();
                break;
        }

        $this->BoletoView->displayInterface($this->BoletoModel);
    }

    function novoBoleto() {
        $this->BoletoModel = new BoletoModel();
    }

    function buscarBoleto() {
        $boletoId = $this->BoletoView->getIdConsulta();

        if ($boletoId == '-1') {
            $this->BoletoView->adicionaMensagemAlerta("Escolha um Boleto para consulta");
            return;
        }

        if ($boletoModel = $this->BoletoAdo->consultaObjetoPeloId($boletoId)) {
            $this->BoletoModel = $boletoModel;
        } else {
            $this->BoletoView->adicionaMensagemErro("Erro na consulta!");
            $this->BoletoView->adicionaMensagemErro($this->BoletoAdo->getMensagem());
            $this->BoletoModel = new BoletoModel();
        }
    }

    function cadastrarBoleto() {
        $this->BoletoModel = $this->BoletoView->getDadosEntrada();

        if ($this->BoletoModel->checaAtributos()) {
            if ($this->BoletoAdo->insereObjeto($this->BoletoModel)) {
                $this->BoletoView->adicionaMensagemSucesso("O Boleto foi cadastrado com sucesso!");
                $this->BoletoModel = new BoletoModel();
            } else {
                $this->BoletoView->adicionaMensagemErro("Erro ao cadastrar o Boleto.");
            }
        } else {
            $this->BoletoView->adicionaMensagemAlerta($this->BoletoModel->getMensagem(), "Erro");
        }
    }

    function excluirBoleto() {
        $this->BoletoModel = $this->BoletoView->getDadosEntrada();

        if ($this->BoletoAdo->excluiObjeto($this->BoletoModel)) {
            $this->BoletoView->adicionaMensagemSucesso("O Boleto foi excluido com sucesso! ");
            $this->BoletoModel = new BoletoModel();
        } else {
            $this->BoletoView->adicionaMensagemErro("Erro ao excluir o Boleto.");
        }
    }

    function gerarRemessas() {
        $arrayBoletoRemessa = $this->BoletoAdo->consultaBoletosParaRemessa();
        $ClienteAdo = new ClienteAdo();
        $data = date("dmy");
        $narquivo = date("dmy");
        $textCompleto = $text = null;

        $nomeDoArquivo = "R_" . $narquivo . "";
        $fp = fopen("C:\Remessas\\" . $nomeDoArquivo . ".seq", "w");
        //$data1 = explode("-", $data);
        $text .= "0"
                . "1"
                . "REMESSA"
                . "01"
                . str_pad("COBRANCA", 15, " ", STR_PAD_RIGHT)
                . "0"
                . "0501"
                . "55"
                . "05010030310"
                . "  "
                . "PARK VILLE INCORPORACAO S LTDA"
                . "399"
                . str_pad("HSBC", 15, " ", STR_PAD_RIGHT)
                . $data
                . "01600"
                . "BPI" .
                "  "
                . "LANCV08"
                . str_pad("", 277, " ", STR_PAD_RIGHT)
                . "000001"
                . "\r\n";
        $i = 2;
        if (is_array($arrayBoletoRemessa)) {
            foreach ($arrayBoletoRemessa as $BoletoModel) {
                var_dump($BoletoModel);
                $boletoId = $BoletoModel->getBoletoId();
                $boletoNumeroDocumento = $BoletoModel->getBoletoNumeroDocumento();
                $boletoNossoNumero = $BoletoModel->getBoletoNossoNumero();
                $CPF = new CPF;
                $DatasEHoras = new DatasEHoras;
                $boletoSacado = $BoletoModel->getBoletoSacado();
                $Cliente = $ClienteAdo->consultaObjetoPeloId($boletoSacado);
                $clienteNome = $Cliente->getClienteNome();
                $clienteCPF = $Cliente->getClienteCPF();
                $clienteEndereco = $Cliente->getClienteEndereco();
                $clienteEstado = $Cliente->getClienteEstado();
                $clienteCidade = $Cliente->getClienteCidade();
                $clienteCEP = $CPF::retiraMascaraCPF($Cliente->getClienteCEP());

                $Sacado = $clienteNome . " - " . $clienteCPF;

                $boletoRemetido = $BoletoModel->getBoletoRemetido();
                $boletoDataVencimento = $DatasEHoras->getDataInvertidaComTracos($BoletoModel->getBoletoDataVencimento());
                $boletoDataEmissao = $DatasEHoras->getDataInvertidaComTracos($BoletoModel->getBoletoDataEmissao());
                $dataemissao = date("dmy", strtotime($boletoDataVencimento));
                $datavenc = date("dmy", strtotime($boletoDataVencimento));
                $boletoValor = number_format($BoletoModel->getBoletoValor(), 2, "", "");

                $ncpf = $CPF::retiraMascaraCPF($clienteCPF);
                if (is_null($ncpf)) {
                    $cod = "98";
                } else {
                    if (strlen($ncpf) == 11) {
                        $cod = "01";
                    } elseif (strlen($ncpf) > 11) {
                        $cod = "02";
                    } else {
                        $cod = "99";
                    }
                }
                // 01 CPF // 02 CNPJ // 98 NÃO TEM // 99 OUTROS                                                                                   DESCONTO_DATA              VALOR                                                                                                  CARTEIRA.OC
                $text .= "1"                                                        //POSIÇÃO 01 DE 01
                        . "02"                                                      //
                        . "23501469000100"                                          //
                        . "0"                                                       //
                        . "0501"                                                    //
                        . "55"                                                      //
                        . "05010030310"                                             //
                        . "  "                                                      //
                        . str_pad("", 25, " ", STR_PAD_RIGHT)                       //
                        . $boletoNossoNumero                                        //
                        . str_pad("", 6, " ", STR_PAD_RIGHT)                        //
                        . str_pad("", 11, " ", STR_PAD_RIGHT)                       //
                        . str_pad("", 6, " ", STR_PAD_RIGHT)                        //
                        . str_pad("", 11, " ", STR_PAD_RIGHT)                       //
                        . "1"                                                       // POSIÇÃO 108 DE 108 - TIPO CARTEIRA 1 - C0BRANÇA SIMPLES
                        . "01"                                                      // POSIÇÃO 109 DE 110 OCORRÊNCIA - REMESSA 01 
                        . str_pad($boletoNumeroDocumento, 10, " ", STR_PAD_RIGHT)  //
                        . $datavenc
                        . str_pad($boletoValor, 13, "0", STR_PAD_LEFT)
                        . "399"
                        . "00000"
                        . "98"
                        . "N"
                        . $dataemissao
                        . "15"                                                                                  // POSICAO 157 A 158 * INSTRUCAO 01
                        . "00"
                        . str_pad("", 8, " ", STR_PAD_LEFT) . "T" . "0003" //POSIÇÃO 161 A 173 JUROS DE MORA
                        . "000000"                                     //POSIÇÃO 174 A 179 DATA DESCONTO
                        . str_pad("", 13, "0", STR_PAD_LEFT)           //POSIÇÃO 180 A 192 VALOR DO DESCONTO
                        . str_pad("", 13, "0", STR_PAD_LEFT)           //POSIÇÃO 193 A 205 VALOR DO IOF
                        . $datavenc . "1000" . str_pad("", 3, " ", STR_PAD_LEFT)           //POSIÇÃO 206 A 218 VALOR DA MULTA
                        . $cod
                        . str_pad($ncpf, 14, "0", STR_PAD_LEFT)
                        . strtoupper(str_pad($CPF->retiraAcentos($clienteNome), 40, " ", STR_PAD_RIGHT))
                        . strtoupper(str_pad($CPF->retiraAcentos($clienteEndereco), 38, " ", STR_PAD_RIGHT))
                        . "  "
                        . str_pad("0", 12, " ", STR_PAD_RIGHT)
                        . $clienteCEP
                        . strtoupper(str_pad($CPF->retiraAcentos($clienteCidade), 15, " ", STR_PAD_RIGHT))
                        . strtoupper($CPF->retiraAcentos($clienteEstado))
                        . str_pad("", 39, " ", STR_PAD_RIGHT)
                        . " "
                        . "  "
                        . "9"
                        . str_pad($i, 6, "0", STR_PAD_LEFT)
                        . "\r\n";
                $i++;
            }
        }
        if (!isset($i)) {
            $i = 2;
        }
        $text .= "9"
                . str_pad("", 393, " ", STR_PAD_RIGHT) .
                str_pad($i, 6, "0", STR_PAD_LEFT);
        $escreve = fwrite($fp, $text);

        if ($fp == false)
            die('Não foi possível abrir o arquivo.');

        if ($fp == true) {
            $BoletoAdo = new BoletoAdo();
            $BoletoAdo->alteraRemetido();
            fclose($fp);
        }
    }

    function imprimirBoleto() {
        $BoletoHsbc = new BoletoHsbc();

        $this->BoletoModel = $this->BoletoView->getDadosEntrada();
        $produtoId = $this->BoletoModel->getBoletoId();

        $BoletoHsbc->geraBoleto($produtoId);
    }

}
