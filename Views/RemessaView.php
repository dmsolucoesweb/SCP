<?php

require_once 'HtmlGeral.php';
require_once '../Classes/montahtml.php';
require_once '../Classes/datasehoras.php';
require_once '../Classes/cpf.php';
require_once '../Classes/functions.php';
require_once '../Models/RemessaModel.php';
require_once '../Ados/ProdutoAdo.php';

class RemessaView extends HtmlGeral {

    public function getDadosEntrada() {
        $boletoId = $this->getValorOuNull('boletoId');
        $boletoNumeroDocumento = $this->getValorOuNull('boletoNumeroDocumento');
        $boletoNossoNumero = $this->getValorOuNull('boletoNossoNumero');
        $boletoRemetido = $this->getValorOuNull('boletoRemetido');
        $boletoSacado = $this->getValorOuNull('boletoSacado');
        $boletoDataVencimento = $this->getValorOuNull('boletoDataVencimento');
        $boletoDataEmissao = $this->getValorOuNull('boletoDataEmissao');
        $boletoValor = $this->getValorOuNull('boletoValor');
        $boletoProdutoId = $this->getValorOuNull('boletoProdutoId');

        return new ProdutoModel($boletoId, $boletoNumeroDocumento, $boletoNossoNumero, $boletoRemetido, $boletoSacado, $boletoDataVencimento, $boletoDataEmissao, $boletoValor, $boletoProdutoId);
    }

    public function montaOpcoesDeProduto($produtoSelected) {
        $opcoesDeProdutos = null;

        $produtoAdo = new ProdutoAdo();
        $arrayDeProdutos = $produtoAdo->consultaArrayDeObjeto();

        if ($arrayDeProdutos == 0) {
            return null;
        }

        if (is_array($arrayDeProdutos)) {
            foreach ($arrayDeProdutos as $ProdutoModel) {
                $selected = null;
                $ClienteAdo = new ClienteAdo();

                $produtoId = $ProdutoModel->getProdutoId();
                $produtoApartamento = $ProdutoModel->getProdutoApartamento();
                $clienteId = $ProdutoModel->getClienteId();
                $Cliente = $ClienteAdo->consultaObjetoPeloId($clienteId);
                $clienteNome = $Cliente->getClienteNome();

                $text = 'Apartamento: ' . $produtoApartamento . ' | Nome: ' . $clienteNome;

                if ($produtoId == $produtoSelected) {
                    $selected = 1;
                }

                $opcoesDeProdutos[] = array("value" => $produtoId, "selected" => $selected, "text" => $text);
            }
        }
        return $opcoesDeProdutos;
    }

    public function montaOpcoesDeCliente($clienteSelected) {
        $opcoesDeClientes = null;

        $clienteAdo = new ClienteAdo();
        $arrayDeClientes = $clienteAdo->consultaArrayDeObjeto();

        if ($arrayDeClientes == 0) {
            return null;
        }

        if (is_array($arrayDeClientes)) {
            foreach ($arrayDeClientes as $clienteModel) {
                $selected = null;

                $clienteId = $clienteModel->getClienteId();
                $clienteNome = $clienteModel->getClienteNome();
                $clienteCPF = $clienteModel->getClienteCPF();

                $text = 'NOME: ' . $clienteNome . ' | CPF: ' . mascara($clienteCPF, "###.###.###-##");

                if ($clienteId == $clienteSelected) {
                    $selected = 1;
                }

                $opcoesDeClientes[] = array("value" => $clienteId, "selected" => $selected, "text" => $text);
            }
        }
        return $opcoesDeClientes;
    }

    public function montaDados($boletoModelo) {
        $montahtml = new MontaHTML;
        $boletoModel = new RemessaModel;
        $boletoId = $boletoModel->getBoletoId();
        $boletoNumeroDocumento = $boletoModel->getBoletoNumeroDocumento();
        $boletoNossoNumero = $boletoModel->getBoletoNossoNumero();
        $boletoRemetido = $boletoModel->getBoletoRemetido();
        $boletoSacado = $boletoModel->getBoletoSacado();
        $boletoDataVencimento = $boletoModel->getBoletoDataVencimento();
        $boletoDataEmissao = $boletoModel->getBoletoDataEmissao();
        $boletoValor = number_format($boletoModel->getBoletoValor(), 2, ",", ".");
        $boletoProdutoId = $boletoModel->getBoletoProdutoId();

        $dados = null;

        $dados .= "<form action='Remessa.php' method='post'>
                    <h1>Gerar Remessa</h1>";
        $dados .= "<div class='well'><legend>Consulta</legend>";

        $htmlComboProdutos = array("label" => "Apartamentos vendidos", "name" => "idConsulta", "options" => $this->montaOpcoesDeProduto($boletoProdutoId));
        $comboDeProdutos = $montahtml->montaCombobox($htmlComboProdutos, $textoPadrao = 'Escolha um Apartamento', $onChange = null, $disabled = false);
        $dados .= $comboDeProdutos;
        $dados .= "<button name='bt' type='submit' class='btn btn-info' value='con'><i class='glyphicon glyphicon-search'></i> Consultar</button></div>
                   <legend>Dados do Boleto</legend>";

        $dadosfieldsetHidden = array("name" => "boletoId", "value" => $boletoId);
        $hiddenId = $montahtml->montaInputHidden($dadosfieldsetHidden);

        $htmlFieldsetND = array("label" => "Numero Documento", "type" => "text", "name" => "boletoNumeroDocumento", "classefg" => "col-md-2", "value" => $boletoNumeroDocumento, "placeholder" => null, "disabled" => false);
        $fieldsetND = $montahtml->montaInput($htmlFieldsetND);

        $htmlFieldsetNN = array("label" => "Nosso Número", "type" => "text", "name" => "boletoNossoNumero", "classefg" => "col-md-2", "value" => $boletoNossoNumero, "placeholder" => null, "disabled" => false);
        $fieldsetNN = $montahtml->montaInput($htmlFieldsetNN);

        $htmlFieldsetRemetido = array("label" => "Remetido?", "type" => "text", "name" => "boletoRemetido", "classefg" => "col-md-2", "value" => $boletoRemetido, "placeholder" => null, "disabled" => false);
        $fieldsetRe = $montahtml->montaInput($htmlFieldsetRemetido);

        $htmlSacado = array("label" => "Pagador", "name" => "idConsulta", "options" => $this->montaOpcoesDeCliente($boletoSacado));
        $comboDeSacado = $montahtml->montaCombobox($htmlSacado, $textoPadrao = 'Escolha um Cliente', $onChange = null, $disabled = false);

        $htmlFieldsetDataVencimento = array("label" => "Data de vencimento", "type" => "text", "name" => "boletoDataVencimento", "classefg" => "col-md-2", "value" => $boletoDataVencimento, "placeholder" => null, "disabled" => false);
        $fieldsetDV = $montahtml->montaInput($htmlFieldsetDataVencimento);

        $htmlFieldsetDataEmissao = array("label" => "Data de emissão", "type" => "text", "name" => "boletoDataEmissao", "classefg" => "col-md-2", "value" => $boletoDataEmissao, "placeholder" => null, "disabled" => false);
        $fieldsetDE = $montahtml->montaInput($htmlFieldsetDataEmissao);

        $htmlFieldsetVa = array("label" => "Valor", "type" => "text", "name" => "boletoValor", "classefg" => "col-md-2", "value" => $boletoValor, "placeholder" => null, "disabled" => false);
        $fieldsetVa = $montahtml->montaInput($htmlFieldsetVa);

        $htmlFieldsetPr = array("label" => "Apartamento", "type" => "text", "name" => "boletoProdutoId", "classefg" => "col-md-2", "value" => $boletoProdutoId, "placeholder" => null, "disabled" => false);
        $fieldsetPr = $montahtml->montaInput($htmlFieldsetPr);

        $dados .= $hiddenId
                . $fieldsetND
                . $fieldsetNN
                . $fieldsetRe
                . $comboDeSacado
                . $fieldsetDV
                . $fieldsetDE
                . $fieldsetVa
                . $fieldsetPr;
        $dados .= "<div class='col-md-12'>
                   <button name='bt' type='submit' class='btn btn-success' value='grm'><i class='glyphicon glyphicon-asterisk'></i> Gerar Remessa(s)</button>
                   <button name='bt' type='submit' class='btn btn-info' value='grma'><i class='glyphicon glyphicon-ok'></i> Gerar Remessa(s) Anterior(es)</button>
                   </div></form>";

        $this->setDados($dados);
    }

}
