<?php

require_once '../Views/ProdutoView.php';
require_once '../Models/ProdutoModel.php';
require_once '../Ados/ProdutoAdo.php';
require_once '../Models/PagamentoModel.php';
require_once '../Ados/PagamentoAdo.php';
require_once '../PDF/RelatorioProdutos.php';

class ProdutoController {

    private $ProdutoView = null;
    private $ProdutoModel = null;
    private $ProdutoAdo = null;
    private $PagamentoModel = null;
    private $PagamentoAdo = null;

    public function __construct() {
        $this->ProdutoView = new ProdutoView();
        $this->ProdutoModel = new ProdutoModel();
        $this->ProdutoAdo = new ProdutoAdo();

        $this->PagamentoModel = new PagamentoModel();
        $this->PagamentoAdo = new PagamentoAdo();

        $acao = $this->ProdutoView->getAcao();

        switch ($acao) {
            case 'nov':
                $this->novoProduto();
                break;

            case 'inc':
                $this->incluiProduto();
                break;

            case 'con':
                $this->consultaProduto();
                break;

            case 'alt':
                $this->alteraProduto();
                break;

            case 'erl':
                $this->emitirRelatorio();
                break;

            case 'exc':
                $this->excluiProduto();
                break;

            case 'vbl':
                $this->validarBoleto();
                break;

            case 'ibl':
                $this->imprimirBoleto();
                break;

            default:
                $this->ProdutoModel = new ProdutoModel();
                break;
        }

        $this->ProdutoView->displayInterface($this->ProdutoModel);
    }

    function novoProduto() {
        $this->ProdutoModel = new ProdutoModel();
    }

    function incluiProduto() {
        $this->ProdutoModel = $this->ProdutoView->getDadosEntrada();

        //Iniciando as variaveis do Produto Model para inclusão do Pagamento automatico
        $Parcelas = $this->ProdutoModel->getProdutoParcelas();
        $ValorUnitario = $this->ProdutoModel->getProdutoParcelasValorUnitario();
        $ValorTotal = $this->ProdutoModel->getProdutoParcelasValorTotal();

        //buscando alguns dados e inicializando variaveis para a inclusão do pagamento automatico
        $clienteId = $this->ProdutoModel->getClienteId();
        $produtoStatus = $this->ProdutoModel->getProdutoStatus();
        $apt = $this->ProdutoModel->getProdutoApartamento();
        $produtoParcela = $this->ProdutoModel->getProdutoParcelas($Parcelas . ';1');
        $valorUnitario = $this->ProdutoModel->getProdutoParcelasValorUnitario($ValorUnitario . ';1');
        $valorParcelaTotal = $this->ProdutoModel->getProdutoParcelasValorTotal($ValorTotal . ';1');
        $CPF = new CPF();

        if ($this->ProdutoModel->checaAtributos()) {
            if ($this->ProdutoAdo->insereObjeto($this->ProdutoModel)) {
                $this->ProdutoView->adicionaMensagemSucesso("Venda do apartamento " . $this->ProdutoModel->getProdutoApartamento() . " realizada com sucesso! ");
                // pegando o id do produto pelo apartamento por causa da ligação do banco de dados
                $produtoId = $this->PagamentoAdo->consultaProdutoPeloApartamento($apt);

                //trecho de código utilizado para explodir(expandir) o vetor das ParcelasTotais para soma, formando assim o valor total do produto
                //para assim passar para o pagamento para inclusão automatica
                $array = explode(";", $ValorTotal);
                $ultimo = count($array);
                $Total = $i = $soma = null;

                for ($i = 0; $i < $ultimo; $i++) {
                    $campoSemMascara = $CPF->retiraMascaraRenda($array[$i]);
                    $float = floatval($campoSemMascara);
                    $soma += $float;
                    $Total = $soma;
                }
                //fim
                //inclusão automatica do Pagamento junto ao Produto
                $this->PagamentoAdo->inserePagamento($clienteId, $produtoId, $produtoStatus, $Total, $produtoParcela, $valorUnitario, $valorParcelaTotal);

                $this->ProdutoModel = new ProdutoModel();
            } else {
                $this->ProdutoView->adicionaMensagemErro("Erro ao realizar a venda do apartamento " . $this->ProdutoModel->getProdutoApartamento() . "!");
                $this->ProdutoView->adicionaMensagemErro($this->ProdutoAdo->getMensagem());
            }
        } else {
            $this->ProdutoView->adicionaMensagemAlerta($this->ProdutoModel->getMensagem(), "Erro");
        }
    }

    function consultaProduto() {
        $produtoId = $this->ProdutoView->getIdConsulta();

        if ($produtoId == '-1') {
            $this->ProdutoView->adicionaMensagemAlerta("Escolha um produto para consulta");
            return;
        }

        if ($produtoModel = $this->ProdutoAdo->consultaObjetoPeloId($produtoId)) {
            $this->ProdutoModel = $produtoModel;
        } else {
            $this->ProdutoView->adicionaMensagemErro("Erro na consulta!");
            $this->ProdutoView->adicionaMensagemErro($this->ProdutoAdo->getMensagem());
            $this->ProdutoModel = new ProdutoModel();
        }
    }

    function emitirRelatorio() {
        $EmitirRelatorio = new RelatorioProdutos();
        $produtoId = $this->ProdutoView->getIdConsulta();

        if ($produtoId == '-1') {
            $EmitirRelatorio->EmitirRelatorioDeProdutos();
        } else {
            $produtoModel = $this->ProdutoAdo->consultaObjetoPeloId($produtoId);
            $produtoM = $produtoModel;
            $EmitirRelatorio->EmitirRelatorioDeProduto($produtoM);
        }
    }

    function alteraProduto() {
        $this->ProdutoModel = $this->ProdutoView->getDadosEntradaSecundario();

        if ($this->ProdutoModel->checaAtributos()) {
            if ($this->ProdutoAdo->alteraObjeto($this->ProdutoModel)) {
                $this->ProdutoView->adicionaMensagemSucesso("Status do apartamento " . $this->ProdutoModel->getProdutoApartamento() . " atualizado com sucesso!");
                $this->ProdutoModel = new ProdutoModel();
            } else {
                $this->ProdutoView->adicionaMensagemErro("Status do apartamento " . $this->ProdutoModel->getProdutoApartamento() . " não foi alterado!");
            }
        } else {
            $this->ProdutoView->adicionaMensagemAlerta($this->ProdutoModel->getMensagem(), "Erro");
        }
    }

    function excluiProduto() {
        $this->ProdutoModel = $this->ProdutoView->getDadosEntradaSecundario();
        $produtoId = $this->ProdutoModel->getProdutoId();
        $pagamentoId = $this->PagamentoAdo->consultaIdPeloProduto($produtoId);

        if ($this->PagamentoAdo->excluiHistorico($produtoId, $pagamentoId) && $this->PagamentoAdo->excluiPagamento($produtoId) && $this->ProdutoAdo->excluiObjeto($this->ProdutoModel)) {
            $this->ProdutoView->adicionaMensagemSucesso("A venda do apartamento " . $this->ProdutoModel->getProdutoApartamento() . " foi excluida com sucesso! ");
            $this->ProdutoModel = new ProdutoModel();
        } else {
            $this->ProdutoView->adicionaMensagemErro("A venda do apartamento " . $this->ProdutoModel->getProdutoApartamento() . " não pôde ser excluída!");
        }
    }

    function validarBoleto() {
        $this->ProdutoModel = $this->ProdutoView->getDadosEntrada();

        if ($this->ProdutoModel->checaAtributos()) {
            if ($this->ProdutoAdo->insereObjeto($this->PagamentoModel)) {
                $this->ProdutoView->adicionaMensagemSucesso("O Boleto foi inserido com sucesso!");
                $this->PagamentoModel = new ProdutoModel();
            } else {
                $this->ProdutoView->adicionaMensagemErro("O Boleto não foi inserido! ");
                //$this->clienteView->adicionaMensagemErro($this->clienteAdo->getMensagem());
            }
        } else {
            $this->ProdutoView->adicionaMensagemAlerta($this->PagamentoModel->getMensagem(), "Erro");
        }
    }

    function imprimirBoleto() {
        
    }

}
