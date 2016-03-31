<?php

require_once 'HtmlGeral.php';
require_once '../Classes/montahtml.php';
require_once '../Models/ClienteModel.php';
require_once '../Ados/ClienteAdo.php';
require_once '../Models/VendedorModel.php';
require_once '../Ados/VendedorAdo.php';
require_once '../Classes/datasehoras.php';
require_once '../Classes/cpf.php';
require_once '../Ados/PagamentoAdo.php';

class ProdutoView extends HtmlGeral {

    public function getDadosEntrada() {
        $DatasEHoras = new DatasEHoras();
        $CPF = new CPF();

        $produtoId = $this->getValorOuNull('produtoId');
        $produtoApartamento = $this->getValorOuNull('produtoApartamento');
        $produtoBox = $this->getValorOuNull('produtoBox');
        $produtoValor = $CPF->retiraMascaraRenda($this->getValorOuNull('produtoValor'));
        $produtoDataVenda = $DatasEHoras->getDataEHorasInvertidaComTracos($this->getValorOuNull('produtoDataVenda'));
        $produtoStatus = $this->getValorOuNull('produtoStatus');
        $produtoParcelasArray = $_POST['produtoParcelas'];
        $produtoParcelas = implode(";", $produtoParcelasArray);
        $produtoParcelasPeriodicidadeArray = $_POST['produtoParcelasPeriodicidade'];
        $produtoParcelasPeriodicidade = implode(";", $produtoParcelasPeriodicidadeArray);
        $produtoParcelasDataVencimentoArray = $_POST['produtoParcelasDataVencimento'];
        $produtoParcelasDataVencimento = implode(";", $produtoParcelasDataVencimentoArray);
        $produtoParcelasValorUnitarioArray = $_POST['produtoParcelasValorUnitario'];
        $produtoParcelasValorUnitario = implode(";", $produtoParcelasValorUnitarioArray);
        $produtoParcelasValorTotalArray = $_POST['produtoParcelasValorTotal'];
        $produtoParcelasValorTotal = implode(";", $produtoParcelasValorTotalArray);
        $produtoParcelasAtualizacaoMonetariaArray = $_POST['produtoParcelasAtualizacaoMonetaria'];
        $produtoParcelasAtualizacaoMonetaria = implode(";", $produtoParcelasAtualizacaoMonetariaArray);
        $produtoParcelasFormaPagamentoArray = $_POST['produtoParcelasFormaPagamento'];
        $produtoParcelasFormaPagamento = implode(";", $produtoParcelasFormaPagamentoArray);
        $produtoParcelasObservacoesArray = $_POST['produtoParcelasObservacoes'];
        $produtoParcelasObservacoes = implode(";", $produtoParcelasObservacoesArray);
        $clienteId = $this->getValorOuNull('clienteId');
        $vendedorId = $this->getValorOuNull('vendedorId');
        $vendedorDataVencimento = $DatasEHoras->getDataEHorasInvertidaComTracos($this->getValorOuNull('vendedorDataVencimento'));
        $vendedorComissao = $CPF->retiraMascaraRenda($this->getValorOuNull('vendedorComissao'));
        $vendedorFormaPagamento = $this->getValorOuNull('vendedorFormaPagamento');
        $vendedorObservacao = $this->getValorOuNull('vendedorObservacao');

        return new ProdutoModel($produtoId, $produtoApartamento, $produtoBox, $produtoValor, $produtoDataVenda, $produtoStatus, $produtoParcelas, $produtoParcelasPeriodicidade, $produtoParcelasDataVencimento, $produtoParcelasValorUnitario, $produtoParcelasValorTotal, $produtoParcelasAtualizacaoMonetaria, $produtoParcelasFormaPagamento, $produtoParcelasObservacoes, $clienteId, $vendedorId, $vendedorDataVencimento, $vendedorComissao, $vendedorFormaPagamento, $vendedorObservacao);
    }

    public function getDadosEntradaSecundario() {
        $produtoId = $this->getValorOuNull('produtoId');
        $produtoApartamento = $this->getValorOuNull('produtoApartamento');
        $produtoBox = $this->getValorOuNull('produtoBox');
        $produtoValor = $this->getValorOuNull('produtoValor');
        $produtoDataVenda = $this->getValorOuNull('produtoDataVenda');
        $produtoStatus = $this->getValorOuNull('produtoStatus');
        $clienteId = $this->getValorOuNull('clienteId');
        $vendedorId = $this->getValorOuNull('vendedorId');
        $vendedorDataVencimento = $this->getValorOuNull('vendedorDataVencimento');
        $vendedorComissao = $this->getValorOuNull('vendedorComissao');
        $vendedorFormaPagamento = $this->getValorOuNull('vendedorFormaPagamento');
        $vendedorObservacao = $this->getValorOuNull('vendedorObservacao');

        return new ProdutoModel($produtoId, $produtoApartamento, $produtoBox, $produtoValor, $produtoDataVenda, $produtoStatus, null, null, null, null, null, null, null, null, $clienteId, $vendedorId, $vendedorDataVencimento, $vendedorComissao, $vendedorFormaPagamento, $vendedorObservacao);
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

    public function montaOpcoesDeVendedor($vendedorSelected) {
        $opcoesDeVendedores = null;

        $vendedorAdo = new VendedorAdo();
        $arrayDeVendedores = $vendedorAdo->consultaArrayDeObjeto();

        if ($arrayDeVendedores == 0) {
            return null;
        }

        if (is_array($arrayDeVendedores)) {
            foreach ($arrayDeVendedores as $vendedorModel) {
                $selected = null;

                $vendedorId = $vendedorModel->getVendedorId();
                $vendedorNome = $vendedorModel->getVendedorNome();
                $vendedorCPF = $vendedorModel->getVendedorCPF();
                if ($vendedorId == 1) {
                    $text = $vendedorNome;
                } else {
                    $text = 'NOME: ' . $vendedorNome . ' | CPF: ' . mascara($vendedorCPF, "###.###.###-##");
                }

                if ($vendedorId == $vendedorSelected) {
                    $selected = 1;
                }

                $opcoesDeVendedores[] = array("value" => $vendedorId, "selected" => $selected, "text" => $text);
            }
        }
        return $opcoesDeVendedores;
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

    public function montaDados($produtoModel) {
        $dados = null;
        $montahtml = new MontaHTML();

        $produtoId = $produtoModel->getProdutoId();
        $produtoApartamento = $produtoModel->getProdutoApartamento();
        $produtoBox = $produtoModel->getProdutoBox();
        $produtoValor = number_format($produtoModel->getProdutoValor(), 2, ",", ".");
        $produtoDataVenda = $produtoModel->getProdutoDataVenda();
        $produtoStatus = $produtoModel->getProdutoStatus();
        $produtoParcelas = $produtoModel->getProdutoParcelas();
        $produtoParcelasPeriodicidade = $produtoModel->getProdutoParcelasPeriodicidade();
        $produtoParcelasDataVencimento = $produtoModel->getProdutoParcelasDataVencimento();
        $produtoParcelasValorUnitario = $produtoModel->getProdutoParcelasValorUnitario();
        $produtoParcelasValorTotal = $produtoModel->getProdutoParcelasValorTotal();
        $produtoParcelasAtualizacaoMonetaria = $produtoModel->getProdutoParcelasAtualizacaoMonetaria();
        $produtoParcelasFormaPagamento = $produtoModel->getProdutoParcelasFormaPagamento();
        $produtoParcelasObservacoes = $produtoModel->getProdutoParcelasObservacoes();
        $clienteId = $produtoModel->getClienteId();
        $vendedorId = $produtoModel->getVendedorId();
        $vendedorDataVencimento = $produtoModel->getVendedorDataVencimento();
        $vendedorComissao = number_format($produtoModel->getVendedorComissao(), 2, ",", ".");
        $vendedorFormaPagamento = $produtoModel->getVendedorFormaPagamento();
        $vendedorObservacao = $produtoModel->getVendedorObservacao();

        $dados .= "<form action='Produto.php' method='post'>
                        <h1>Cadastro de Vendas</h1>
                        <div class='well'><legend>Consulta</legend>";

        $htmlComboProdutos = array("label" => "Apartamentos vendidos", "name" => "idConsulta", "options" => $this->montaOpcoesDeProduto($produtoId));
        $comboDeProdutos = $montahtml->montaCombobox($htmlComboProdutos, $textoPadrao = 'Escolha um Apartamento', $onChange = null, $disabled = false);

        $dadosfieldsetHidden = array("name" => "produtoId", "value" => $produtoId);
        $hiddenId = $montahtml->montaInputHidden($dadosfieldsetHidden);

        $htmlComboClientes = array("label" => "Cliente", "name" => "clienteId", "classefg" => "col-md-6", "options" => $this->montaOpcoesDeCliente($clienteId));
        $comboDeClientes = "<div class='row'>" . $montahtml->montaCombobox($htmlComboClientes, $textoPadrao = 'Cliente', $onChange = null, $disabled = false);

        $htmlComboVendedores = array("label" => "Vendedor", "name" => "vendedorId", "classecampo" => "vendedor_produto", "classefg" => "col-md-6", "options" => $this->montaOpcoesDeVendedor($vendedorId));
        $comboDeVendedores = $montahtml->montaCombobox($htmlComboVendedores, $textoPadrao = 'Vendedor', $onChange = null, $disabled = false) . "</div>";

        $htmlFieldsetApartamento = array("label" => "Apto", "type" => "text", "classefg" => "col-md-1", "name" => "produtoApartamento", "value" => $produtoApartamento, "placeholder" => null, "disabled" => $disabled);
        $fieldsetApartamento = "<div class='row'>" . $montahtml->montaInput($htmlFieldsetApartamento);

        $htmlFieldsetBox = array("label" => "Box(es)", "type" => "text", "name" => "produtoBox", "classefg" => "col-md-2", "value" => $produtoBox, "placeholder" => null, "disabled" => false);
        $fieldsetBox = $montahtml->montaInput($htmlFieldsetBox);

        $htmlFieldsetData = array("label" => "Data da Venda", "name" => "produtoDataVenda", "classefg" => "col-md-3", "value" => $produtoDataVenda, "disabled" => false);
        $fieldsetData = $montahtml->montaInputDeData($htmlFieldsetData);

        $htmlFieldsetValor = array("label" => "Valor", "type" => "text", "name" => "produtoValor", "classecampo" => "valor_apto moeda", "classefg" => "col-md-3", "value" => $produtoValor, "placeholder" => null, "disabled" => false);
        $fieldsetValor = $montahtml->montaInput($htmlFieldsetValor);

        $selected1 = $selected2 = null;
        switch ($produtoStatus) {
            case '1':
                $selected1 = "selected='selected'";
                break;
            case '2':
                $selected2 = "selected='selected'";
                break;
        }

        $htmlComboStatus = array("label" => "Status do Produto", "classefg" => "col-md-3", "name" => "produtoStatus",
            "options" => array(array("value" => "1", "selected" => $selected1, "text" => "Aguardando"),
                array("value" => "2", "selected" => $selected2, "text" => "Entregue")));
        $comboDeStatus = $montahtml->montaCombobox($htmlComboStatus, $textoPadrao = 'Status do Produto') . "</div>";

        $htmlFieldsetDataVenc = array("label" => "Data de Vencimento", "name" => "vendedorDataVencimento", "classefg" => "col-md-3", "value" => $vendedorDataVencimento, "disabled" => false);
        $fieldsetDataVenc = $montahtml->montaInputDeData($htmlFieldsetDataVenc);

        $htmlFieldsetComissao = array("label" => "Comissão (%)", "type" => "text", "name" => "vendedorComissao", "classecampo" => "valor_apto moeda", "classefg" => "col-md-3", "value" => $vendedorComissao, "placeholder" => null, "disabled" => false);
        $fieldsetValorComissao = $montahtml->montaInput($htmlFieldsetComissao);

        $selected3 = $selected4 = null;
        switch ($vendedorFormaPagamento) {
            case '1':
                $selected3 = "selected='selected'";
                break;
            case '2':
                $selected4 = "selected='selected'";
                break;
        }

        $htmlComboFormaPagamentoVendedor = array("label" => "Formas de Pagamento", "classefg" => "col-md-3", "name" => "vendedorFormaPagamento",
            "options" => array(array("value" => "1", "selected" => $selected3, "text" => "Boleto"),
                array("value" => "2", "selected" => $selected4, "text" => "À Vista")));
        $comboDeFPagVendedor = $montahtml->montaCombobox($htmlComboFormaPagamentoVendedor, $textoPadrao = 'Escolha uma Forma de Pagamento...');

        $htmlFieldsetObservacao = array("label" => "Observação", "type" => "text", "name" => "vendedorObservacao", "classefg" => "col-md-3", "value" => $vendedorObservacao, "placeholder" => null, "disabled" => false);
        $fieldsetObservacao = $montahtml->montaInput($htmlFieldsetObservacao);

        $dados .= $comboDeProdutos;

        $dados .= "<button name='bt' type='submit' class='btn btn-info' value='con'><i class='glyphicon glyphicon-search'></i> Consultar</button>
                   <button name='bt' type='submit' class='btn btn-info' value='erl'><i class='glyphicon glyphicon-print'></i> Emitir Relatório</button></div>
                   <legend>Dados do Produto</legend>";

        $dados .= $hiddenId
                . $comboDeClientes
                . $comboDeVendedores
                . $fieldsetApartamento
                . $fieldsetBox
                . $fieldsetData
                . $fieldsetValor
                . $comboDeStatus;

        $dados .= "<h4>Parcelas</h4><p class='text-primary'>Adicione o número de parcelas necessárias para a quitação do apartamento.</p><div class='alert alert-info' id='alerta_parc' role='alert'>Para incluir ou alterar o produto, clique em verificar as parcelas para ter certeza de que a soma delas é igual ao valor do apartamento.</div>";
        if ($produtoId == '-1' || $produtoId == NULL) {
            $dados .= "<script>$(document).ready(function () { addCampos(); });
                    </script>"
                    . "<div id='campoPai'> </div><div class='parc'>"
                    . "<button type=\"button\" class=\"btn btn-default btn-sm\" onClick=\"addCampos()\"><span class='text-success'><i class=\"glyphicon glyphicon-plus-sign\"></i> Adicionar parcela</span></button>";
            //. "<button type=\"button\" class=\"btn btn-default btn-sm\" onClick=\"calcula_parc()\"><span class='text-info'><i class=\"glyphicon glyphicon-flash\"></i> Verificar parcelas</span></button></div>";
        }

        if ($produtoId != '-1' && $produtoId != NULL) {
            if ($produtoParcelas != 0) {
                $Parcelas = explode(";", $produtoParcelas);
                $ParcelasPeriodicidade = explode(";", $produtoParcelasPeriodicidade);
                $ParcelasDataVencimento = explode(";", $produtoParcelasDataVencimento);
                $ParcelasValorUnitario = explode(";", $produtoParcelasValorUnitario);
                $ParcelasValorTotal = explode(";", $produtoParcelasValorTotal);
                $ParcelasAtualizacaoMonetaria = explode(";", $produtoParcelasAtualizacaoMonetaria);
                $ParcelasFormaPagamento = explode(";", $produtoParcelasFormaPagamento);
                $ParcelasObservacoes = explode(";", $produtoParcelasObservacoes);
                $ultimo = count($Parcelas);
                //$ultimo--;
                $dados .= "<div id='campoPai'>";

                for ($i = 0; $i < $ultimo; $i++) {
                    $b = $i + 1;
                    $dados .= "<div id='filho$b' class='filho'>";
                    $Parcela = $Parcelas[$i];
                    $Periodicidade = $ParcelasPeriodicidade[$i];
                    $DataVencimento = $ParcelasDataVencimento[$i];
                    $ValorUnitario = $ParcelasValorUnitario[$i];
                    $ValorTotal = $ParcelasValorTotal[$i];
                    $AtualizacaoMonetaria = $ParcelasAtualizacaoMonetaria[$i];
                    $FormaPagamento = $ParcelasFormaPagamento[$i];
                    $Observacoes = $ParcelasObservacoes[$i];

                    $htmlFieldsetParcelas = array("label" => "Parcelas", "type" => "text", "classefg" => "form-group col-md-1", "name" => "produtoParcelas[$i]", "value" => $Parcela, "placeholder" => null, "disabled" => $disabled);
                    $fieldsetParcelas = "<div class='row'>" . $montahtml->montaInput($htmlFieldsetParcelas);

                    $selectedp = $selectedp2 = null;
                    switch ($Periodicidade) {
                        case '1':
                            $selectedp = "selected='selected'";
                            break;
                        case '2':
                            $selectedp2 = "selected='selected'";
                            break;
                    }

                    $htmlComboPeriodicidade = array("label" => "Periodicidade", "classefg" => "form-group col-md-2", "name" => "produtoParcelasPeriodicidade",
                        "options" => array(array("value" => "1", "selected" => $selectedp, "text" => "Única"),
                            array("value" => "2", "selected" => $selectedp2, "text" => "Mensal")));
                    $comboDePeriodicidade = $montahtml->montaCombobox($htmlComboPeriodicidade, $textoPadrao = 'Periodicidade');

                    $htmlFieldsetDataVencimento = array("label" => "Data de Vencimento", "type" => "text", "classefg" => "form-group col-md-3", "name" => "produtoParcelasDataVencimento", "value" => $DataVencimento, "placeholder" => null, "disabled" => $disabled);
                    $fieldsetDataVencimento = $montahtml->montaInput($htmlFieldsetDataVencimento);

                    $htmlFieldsetValorUnitario = array("label" => "Valor Unitario", "type" => "text", "classefg" => "form-group col-md-3", "name" => "produtoParcelasValorUnitario[$i]", "value" => $ValorUnitario, "placeholder" => null, "disabled" => $disabled);
                    $fieldsetValorUnitario = $montahtml->montaInput($htmlFieldsetValorUnitario);

                    $htmlFieldsetValorTotal = array("label" => "Valor Total", "type" => "text", "classefg" => "form-group col-md-3", "name" => "produtoParcelasValorTotal[$i]", "value" => $ValorTotal, "placeholder" => null, "disabled" => $disabled);
                    $fieldsetValorTotal = $montahtml->montaInput($htmlFieldsetValorTotal) . "</div><div class='row'>";

                    $selecteda = $selecteda2 = null;
                    switch ($AtualizacaoMonetaria) {
                        case '1':
                            $selecteda = "selected='selected'";
                            break;
                        case '2':
                            $selecteda2 = "selected='selected'";
                            break;
                    }

                    $htmlComboAtMonetaria = array("label" => "Atualização Monetária", "classefg" => "form-group col-md-3", "name" => "produtoParcelasAtualizacaoMonetaria[$i]",
                        "options" => array(array("value" => "1", "selected" => $selecteda, "text" => "Fixa e Irreajustavel"),
                            array("value" => "2", "selected" => $selecteda2, "text" => "Reajustavel")));
                    $comboDeAtMonetaria = $montahtml->montaCombobox($htmlComboAtMonetaria, $textoPadrao = 'Periodicidade');

                    $selectedf = $selectedf2 = null;
                    switch ($FormaPagamento) {
                        case '1':
                            $selectedf = "selected='selected'";
                            break;
                        case '2':
                            $selectedf2 = "selected='selected'";
                            break;
                    }

                    $htmlComboFormaPagamento = array("label" => "Formas de Pagamento", "classefg" => "form-group col-md-3", "name" => "produtoParcelasFormaPagamento[$i]",
                        "options" => array(array("value" => "1", "selected" => $selectedf, "text" => "À VISTA"),
                            array("value" => "2", "selected" => $selectedf2, "text" => "BOLETO")));
                    $comboDeFormaPagamento = $montahtml->montaCombobox($htmlComboFormaPagamento, $textoPadrao = 'Formas de Pagamento');

                    $htmlFieldsetObservacoes = array("label" => "Observa&ccedil;&otilde;es", "type" => "text", "classefg" => "form-group col-md-6", "name" => "produtoParcelasObservacoes[$i]", "value" => $Observacoes, "placeholder" => null, "disabled" => $disabled);
                    $fieldsetObservacoes = $montahtml->montaInput($htmlFieldsetObservacoes);
                    $fieldsetObservacoes .= "</div>";

                    $dados .= $fieldsetParcelas
                            . $comboDePeriodicidade
                            . $fieldsetDataVencimento
                            . $fieldsetValorUnitario
                            . $fieldsetValorTotal
                            . $comboDeAtMonetaria
                            . $comboDeFormaPagamento
                            . $fieldsetObservacoes . "</div>";
                }
                $dados .= "</div>";
            }
        }

        $dados .= "<div class='dados_int row'><h4>Informações sobre o vendedor</h4>"
                . $fieldsetDataVenc
                . $fieldsetValorComissao
                . $comboDeFPagVendedor
                . $fieldsetObservacao
                . "</div>";

        $dados .= "<div class='row'>
                <button name='bt' type='submit' class='btn btn-info' value='nov'><i class='glyphicon glyphicon-asterisk'></i> Novo</button>
                <button name='bt' id='inc' type='submit' class='btn btn-success' disabled='true' value='inc' ><i class='glyphicon glyphicon-ok'></i> Incluir</button>
                <button name='bt' id='alt' type='submit' class='btn btn-warning' disabled='true' value='alt'><i class='glyphicon glyphicon-refresh'></i> Alterar</button>
                <button name='bt' type='submit' class='btn btn-danger' value='exc'><i class='glyphicon glyphicon-trash'></i> Excluir</button></div>
                <button name='bt' id='inc' type='submit' class='btn btn-success' disabled='true' value='vbl' ><i class='glyphicon glyphicon-ok'></i> Validar Boletos</button>
                <button name='bt' id='inc' type='submit' class='btn btn-success' disabled='true' value='ibl' ><i class='glyphicon glyphicon-ok'></i> Imprimir Boletos</button>
                </form></div>";

        $this->setDados($dados);
    }

}
