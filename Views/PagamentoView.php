<?php

$nivel_gerente = true;
require_once 'HtmlGeral.php';
require_once '../Classes/montahtml.php';
require_once '../Models/ClienteModel.php';
require_once '../Ados/ClienteAdo.php';
require_once '../Models/ProdutoModel.php';
require_once '../Ados/ProdutoAdo.php';
require_once '../Classes/datasehoras.php';
require_once '../Classes/cpf.php';

class PagamentoView extends HtmlGeral {

    public function getDadosEntrada() {
        $DatasEHoras = new DatasEHoras();
        $CPF = new CPF();

        $pagamentoId = $this->getValorOuNull('pagamentoId');
        $clienteId = $this->getValorOuNull('clienteId');
        $produtoId = $this->getValorOuNull('produtoId');
        $pagamentoStatusProduto = $this->getValorOuNull('pagamentoStatusProduto');
        $pagamentoValorTotal = $CPF->retiraMascaraRenda($this->getValorOuNull('pagamentoValorTotal'));
        $pagamentoParcela = $this->getValorOuNull('pagamentoParcela');
        $pagamentoValorParcela = $CPF->retiraMascaraRenda($this->getValorOuNull('pagamentoValorParcela'));
        $pagamentoValorParcelaUnitario = $CPF->retiraMascaraRenda($this->getValorOuNull('pagamentoValorParcelaUnitario'));
        $pagamentoData = $DatasEHoras->getDataEHorasInvertidaComTracos($this->getValorOuNull('pagamentoData'));
        $pagamentoValor = $CPF->retiraMascaraRenda($this->getValorOuNull('pagamentoValor'));

        return new PagamentoModel($pagamentoId, $clienteId, $produtoId, $pagamentoStatusProduto, $pagamentoValorTotal, $pagamentoParcela, $pagamentoValorParcela, $pagamentoValorParcelaUnitario, $pagamentoData, $pagamentoValor);
    }

    public function montaOpcoesDePagamento($pagamentoSelected) {
        $opcoesDePagamentos = null;

        $pagamentoAdo = new PagamentoAdo();
        $arrayDePagamentos = $pagamentoAdo->consultaArrayDeObjeto();

        if ($arrayDePagamentos === 0) {
            return null;
        }

        if (is_array($arrayDePagamentos)) {
            foreach ($arrayDePagamentos as $pagamentoModel) {
                $selected = null;

                $pagamentoId = $pagamentoModel->getPagamentoId();
                $clienteId = $pagamentoModel->getClienteId();
                $produtoId = $pagamentoModel->getProdutoId();

                $cliente = new ClienteAdo();
                $idCliente = $cliente->consultaObjetoPeloId($clienteId);
                $clienteNome = $idCliente->getClienteNome();

                $produto = new ProdutoAdo();
                $idProduto = $produto->consultaObjetoPeloId($produtoId);
                $produtoApartamento = $idProduto->getProdutoApartamento();

                $text = 'Cliente: ' . $clienteNome . ' | ' . 'Apartamento: ' . $produtoApartamento;

                if ($pagamentoId == $pagamentoSelected) {
                    $selected = 1;
                }

                $opcoesDePagamentos[] = array("value" => $pagamentoId, "selected" => $selected, "text" => $text);
            }
        }
        return $opcoesDePagamentos;
    }

    public function montaOpcoesDeClientes($clienteSelected) {
        $opcoesDeClientes = null;

        $clienteAdo = new ClienteAdo();
        $arrayDeClientes = $clienteAdo->consultaArrayDeObjeto();

        if ($arrayDeClientes === 0) {
            return null;
        }

        if (is_array($arrayDeClientes)) {
            foreach ($arrayDeClientes as $clienteModel) {
                $selected = null;

                $clienteId = $clienteModel->getClienteId();
                $clienteNome = $clienteModel->getClienteNome();
                $clienteCPF = $clienteModel->getClienteCPF();

                $text = 'Nome: ' . $clienteNome . ' | CPF: ' . $clienteCPF;

                if ($clienteId == $clienteSelected) {
                    $selected = 1;
                }

                $opcoesDeClientes[] = array("value" => $clienteId, "selected" => $selected, "text" => $text);
            }
        }
        return $opcoesDeClientes;
    }

    public function montaOpcoesDeProduto($produtoSelected) {
        $opcoesDeProdutos = null;

        $produtoAdo = new ProdutoAdo();
        $arrayDeProdutos = $produtoAdo->consultaArrayDeObjeto();

        if ($arrayDeProdutos === 0) {
            return null;
        }

        if (is_array($arrayDeProdutos)) {
            foreach ($arrayDeProdutos as $produtoModel) {
                $selected = null;

                $produtoId = $produtoModel->getProdutoId();
                $produtoApartamento = $produtoModel->getProdutoApartamento();
                $produtoValor = $produtoModel->getProdutoValor();

                $text = 'Apartamento: ' . $produtoApartamento . ' | Valor: R$' . $produtoValor;

                if ($produtoId == $produtoSelected) {
                    $selected = 1;
                }

                $opcoesDeProdutos[] = array("value" => $produtoId, "selected" => $selected, "text" => $text);
            }
        }
        return $opcoesDeProdutos;
    }

    public function montaDados($pagamentoModel) {
        $dados = null;
        $MontaHtml = new MontaHTML();
        $PagamentoAdo = new PagamentoAdo();
        $ClienteAdo = new ClienteAdo();
        $ProdutoAdo = new ProdutoAdo();

        $pagamentoId = $pagamentoModel->getPagamentoId();
        $clienteId = $pagamentoModel->getClienteId();
        $Cliente = $ClienteAdo->consultaObjetoPeloId($clienteId);
        $clienteNome = $Cliente->getClienteNome();
        $produtoId = $pagamentoModel->getProdutoId();
        $Produto = $ProdutoAdo->consultaObjetoPeloId($produtoId);
        $produtoApartamento = $Produto->getProdutoApartamento();
        $pagamentoStatusProduto = $pagamentoModel->getPagamentoStatusProduto();
        $pagamentoValorTotal = $pagamentoModel->getPagamentoValorTotal();
        $pagamentoParcela = $pagamentoModel->getPagamentoParcela();
        $pagamentoValorParcela = $pagamentoModel->getPagamentoValorParcela();
        $pagamentoValorParcelaUnitario = $pagamentoModel->getPagamentoValorParcelaUnitario();
        $arredondaParcelas = $ParcelasUnitario = $pagValorParcela = $ValorParcelasUnitario = null;

        if ($pagamentoId != '-1' && $pagamentoId != NULL) {
            $arrayParcelas = explode(";", $pagamentoParcela);
            $arrayValorParcelas = explode(";", $pagamentoValorParcela);
            $arrayValorParcelasUnitario = explode(";", $pagamentoValorParcelaUnitario);
            $ultimo = count($arrayParcelas);

            for ($i = 0; $i < $ultimo; $i++) {
                $Parcelas = $arrayParcelas[$i];
                $ValorParcelas = $arrayValorParcelas[$i];
                $ValorParcelasUnitario = $arrayValorParcelasUnitario[$i];

                if ($Parcelas != 0 && $ValorParcelas != 0 && $ValorParcelasUnitario != 0) {
                    $arredondaParcelas = ceil($Parcelas);

                    if ($ValorParcelas == 0) {
                        $i++;
                    } else {
                        $pagamentoParcela = $Parcelas;
                        $pagValorParcela = $ValorParcelas;
                        break;
                    }
                }
            }

            $pagamentoValorTotal = number_format($pagamentoValorTotal, 2, ",", ".");
        }

        $ParcelasUnitario = $ValorParcelasUnitario;
        $pagamentoParcelaFinal = $arredondaParcelas;

        if ($pagamentoId != null && $pagamentoId != '-1' && $pagValorParcela == 0 && $ParcelasUnitario == 0 && $pagamentoParcelaFinal == 0) {
            $this->adicionaMensagemSucesso("O Produto já foi quitado!");
        }

        $pagamentoData = $pagamentoModel->getPagamentoData();
        $pagamentoValor = number_format($pagamentoModel->getPagamentoValor(), 2, ",", ".");

        $htmlComboPagamentos = array("label" => "Produtos", "name" => "idConsulta", "options" => $this->montaOpcoesDePagamento($pagamentoId));
        $comboDePagamentos = $MontaHtml->montaCombobox($htmlComboPagamentos, $textoPadrao = 'Escolha um Pagamento...', $onChange = null, $disabled = false);

        $dados .= "<form action='Pagamento.php' method='post'>
                    <h1>Efetuar Pagamentos</h1>
                    <div class='well'><legend>Consulta</legend>";

        $dados .= $comboDePagamentos;

        $dados .= "<button name='bt' type='submit' class='btn btn-info' value='con'><i class='glyphicon glyphicon-search'></i> Consultar</button>
                   <button name='bt' type='submit' class='btn btn-info' value='erl'><i class='glyphicon glyphicon-print'></i> Emitir Relatório</button></div>";
        ////////
        $disabled = false;
        ///////
        $hiddenId = "<div class='row'>";
        $dadosfieldsetHidden = array("name" => "pagamentoId", "value" => $pagamentoId);
        $hiddenId .= $MontaHtml->montaInputHidden($dadosfieldsetHidden);

        $dadosfieldsetHidden2 = array("name" => "clienteId", "value" => $clienteId);
        $hiddenId2 = $MontaHtml->montaInputHidden($dadosfieldsetHidden2);

        $htmlFieldsetCliente = array("label" => "Cliente", "classefg" => "col-md-4", "disabled" => $disabled, "type" => "text", "name" => "pagamentoCliente", "value" => $clienteNome, "placeholder" => null);
        $fieldsetCliente = $MontaHtml->montaInput($htmlFieldsetCliente);

        $dadosfieldsetHidden3 = array("name" => "produtoId", "value" => $produtoId);
        $hiddenId3 = $MontaHtml->montaInputHidden($dadosfieldsetHidden3);

        $htmlFieldsetProduto = array("label" => "Apartamento", "classefg" => "col-md-2", "disabled" => $disabled, "type" => "text", "name" => "pagamentoApartamento", "value" => $produtoApartamento, "placeholder" => null);
        $fieldsetProduto = $MontaHtml->montaInput($htmlFieldsetProduto);

        $selected1 = $selected2 = null;
        switch ($pagamentoStatusProduto) {
            case '1':
                $selected1 = "selected='selected'";
                break;
            case '2':
                $selected2 = "selected='selected'";
                break;
        }

        $htmlComboStatusProduto = array("label" => "Status do Produto", "classefg" => "col-md-3", "name" => "pagamentoStatusProduto",
            "options" => array(array("value" => "1", "selected" => $selected1, "text" => "Aguardando"),
                array("value" => "2", "selected" => $selected2, "text" => "Entregue")));
        $comboDeStatusProduto = $MontaHtml->montaCombobox($htmlComboStatusProduto, $textoPadrao = 'Escolha um Status do Produto...', $onChange = null, $disabled = $disabled);

        $htmlFieldsetValorTotal = array("label" => "Valor do Produto", "type" => "text", "classefg" => "col-md-3", "disabled" => $disabled, "name" => "pagamentoValorTotal", "classecampo" => "moeda", "value" => $pagamentoValorTotal, "placeholder" => null);
        $fieldsetValorTotal = $MontaHtml->montaInput($htmlFieldsetValorTotal);
        $fieldsetValorTotal .= "</div><div class='row'>";
        if ($pagamentoParcela < 1 && $pagamentoParcela != NULL) {
            $pagamentoParcela = 'Parcela Extra(Excedida)';
        }

        $dadosfieldsetHidden4 = array("name" => "pagamentoParcela", "value" => $pagamentoParcelaFinal);
        $hiddenId4 = $MontaHtml->montaInputHidden($dadosfieldsetHidden4);

        $htmlFieldsetParcela = array("label" => "Parcelas", "classefg" => "col-md-3", "type" => "text", "name" => "pagamentoParcelaInt", "value" => $pagamentoParcelaFinal, "placeholder" => null, "disabled" => $disabled);
        $fieldsetParcela = $MontaHtml->montaInput($htmlFieldsetParcela);
        $fieldsetParcela .= "<div class='col-md-1 vs hidden-xs hidden-sm'>X</div>";

        $htmlFieldsetValorUnitario = array("label" => "Valor Unitario", "classefg" => "col-md-4", "disabled" => $disabled, "type" => "text", "name" => "pagamentoValorParcelaUnitario", "classecampo" => "moeda", "value" => $ParcelasUnitario, "placeholder" => null);
        $fieldsetValorUnitario = $MontaHtml->montaInput($htmlFieldsetValorUnitario);

        $htmlFieldsetValorParcelas = array("label" => "Valor Total das Parcelas", "classefg" => "col-md-4", "disabled" => $disabled, "type" => "text", "name" => "pagamentoValorParcela", "classecampo" => "moeda", "value" => $pagValorParcela, "placeholder" => null);
        $fieldsetValorParcelas = $MontaHtml->montaInput($htmlFieldsetValorParcelas);
        $fieldsetValorParcelas .= "</div><div class='row'>";

        $htmlFieldsetData = array("label" => "Data do Pagamento", "classefg" => "col-md-6", "name" => "pagamentoData", "value" => $pagamentoData, "placeholder" => null, "disabled" => false);
        $fieldsetData = $MontaHtml->montaInputDeData($htmlFieldsetData);

        $htmlFieldsetValor = array("label" => "Valor Pagamento", "classefg" => "col-md-6", "type" => "text", "name" => "pagamentoValor", "classecampo" => "moeda", "value" => $pagamentoValor, "placeholder" => null, "disabled" => false);
        $fieldsetValor = $MontaHtml->montaInput($htmlFieldsetValor);
        $fieldsetValor .= "<div class='row'>";

        $dados .= $hiddenId
                . $hiddenId2
                . $fieldsetCliente
                . $hiddenId3
                . $fieldsetProduto
                . $comboDeStatusProduto
                . $fieldsetValorTotal;
        if ($i == $ultimo) {
            
        } else {
            $c = $i + 1;
            $dados .= "<div class='col-md-12'><h4>" . $c . "ª série de parcelas</h4></div>";
        }
        $dados .= $fieldsetParcela
                . $hiddenId4
                . $fieldsetValorUnitario
                . $fieldsetValorParcelas
                . $fieldsetData
                . $fieldsetValor;

        $dados .="</div></div><div class='col-md-12'>
                <button name='bt' type='submit' class='btn btn-info' value='nov'><i class='glyphicon glyphicon-asterisk'></i> Novo</button>
                <button name='bt' type='submit' class='btn btn-success' value='pg'><i class='glyphicon glyphicon-ok'></i> Pagar</button>
                </form>";

        $this->setDados($dados);
    }

}
