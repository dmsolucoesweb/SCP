<?php

require_once '../Views/PagamentoView.php';
require_once '../Models/PagamentoModel.php';
require_once '../Ados/PagamentoAdo.php';
require_once '../PDF/RelatorioPagamentos.php';

class PagamentoController {

    private $PagamentoAdo = null;
    private $PagamentoModel = null;
    private $PagamentoView = null;

    public function __construct() {
        $this->PagamentoView = new PagamentoView();
        $this->PagamentoModel = new PagamentoModel();
        $this->PagamentoAdo = new PagamentoAdo();

        $acao = $this->PagamentoView->getAcao();

        switch ($acao) {
            case 'nov':
                $this->novoPagamento();
                break;

            case 'pg':
                $this->incluiPagamento();
                break;

            case 'con':
                $this->consultaPagamento();
                break;

            case 'alt':
                $this->alteraPagamento();
                break;

            case 'exc':
                $this->excluiPagamento();

                break;

            case 'erl':
                $this->emitirRelatorio();
                break;

            default:
                $this->PagamentoModel = new PagamentoModel();
                break;
        }

        $this->PagamentoView->displayInterface($this->PagamentoModel);
    }

    function novoPagamento() {
        $this->PagamentoModel = new PagamentoModel();
    }

    function incluiPagamento() {
        $this->PagamentoModel = $this->PagamentoView->getDadosEntrada();
        $id = $this->PagamentoModel->getPagamentoId();

        $PagamentoAdo = new PagamentoAdo();
        $ClienteAdo = new ClienteAdo();
        $PagamentoModel = $PagamentoAdo->consultaObjetoPeloId($id);
        $ClienteModel = $ClienteAdo->consultaObjetoPeloId($id);

        $pagamentoClienteNome = $ClienteModel->getClienteNome();

        if ($this->PagamentoModel->checaAtributos()) {

            if ($this->PagamentoAdo->alteraPagamento($this->PagamentoModel, $PagamentoModel) && $this->PagamentoAdo->insereHistoricoDePagamento($this->PagamentoModel)) {
                $this->PagamentoView->adicionaMensagemSucesso("O Pagamento do Cliente: " . $pagamentoClienteNome . "foi efetuado com sucesso! ");
                $this->PagamentoModel = new PagamentoModel();
            } else {
                $this->PagamentoView->adicionaMensagemErro("O Pagamento do Cliente: " . $pagamentoClienteNome . " não foi efetuado com sucesso! ");
            }
        } else {
            $this->PagamentoView->adicionaMensagemAlerta($this->PagamentoModel->getMensagem(), "Erro");
        }
    }

    function consultaPagamento() {
        $pagamentoId = $this->PagamentoView->getIdConsulta();

        if ($pagamentoId == '-1') {
            $this->PagamentoView->adicionaMensagemAlerta("Escolha um pagamento para consulta.");
            return;
        }

        if ($pagamentoModel = $this->PagamentoAdo->consultaObjetoPeloId($pagamentoId)) {
            $this->PagamentoModel = $pagamentoModel;
        } else {
            $this->PagamentoView->adicionaMensagemErro("Erro na consulta!");
            $this->PagamentoView->adicionaMensagemErro($this->PagamentoAdo->getMensagem());
            $this->PagamentoModel = new PagamentoModel();
        }
    }

    function emitirRelatorio() {
        $EmitirRelatorio = new RelatorioPagamentos();
        $pagamentoId = $this->PagamentoView->getIdConsulta();

        if ($pagamentoId == '-1' || $pagamentoId == null) {
            $EmitirRelatorio->EmitirRelatorioPagamentos();
        } else {
            $EmitirRelatorio->EmitirRelatorioPagamento($pagamentoId);
        }
    }

    function alteraPagamento() {
        
    }

    function excluiPagamento() {
        
    }

}
