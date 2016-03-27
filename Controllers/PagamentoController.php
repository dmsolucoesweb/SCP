<?php

require_once '../Views/PagamentoView.php';
require_once '../Models/PagamentoModel.php';
require_once '../Ados/PagamentoAdo.php';
require_once '../PDF/RelatorioPagamentos.php';

class PagamentoController {

    private $pagamentoAdo = null;
    private $pagamentoModel = null;
    private $pagamentoView = null;

    public function __construct() {
        $this->pagamentoView = new PagamentoView();
        $this->pagamentoModel = new PagamentoModel();
        $this->pagamentoAdo = new PagamentoAdo();

        $acao = $this->pagamentoView->getAcao();

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
                $this->pagamentoModel = new PagamentoModel();
                break;
        }

        $this->pagamentoView->displayInterface($this->pagamentoModel);
    }

    function novoPagamento() {
        $this->pagamentoModel = new PagamentoModel();
    }

    function incluiPagamento() {
        $this->pagamentoModel = $this->pagamentoView->getDadosEntrada();
        $id = $this->pagamentoModel->getPagamentoId();

        $PagamentoAdo = new PagamentoAdo();
        $ClienteAdo = new ClienteAdo();
        $PagamentoModel = $PagamentoAdo->consultaObjetoPeloId($id);
        $ClienteModel = $ClienteAdo->consultaObjetoPeloId($id);

        $pagamentoClienteNome = $ClienteModel->getClienteNome();

        if ($this->pagamentoModel->checaAtributos()) {

            if ($this->pagamentoAdo->alteraPagamento($this->pagamentoModel, $PagamentoModel) && $this->pagamentoAdo->insereHistoricoDePagamento($this->pagamentoModel)) {
                $this->pagamentoView->adicionaMensagemSucesso("O Pagamento do Cliente: " . $pagamentoClienteNome . "foi efetuado com sucesso! ");
                $this->pagamentoModel = new PagamentoModel();
            } else {
                $this->pagamentoView->adicionaMensagemErro("O Pagamento do Cliente: " . $pagamentoClienteNome . " não foi efetuado com sucesso! ");
            }
        } else {
            $this->pagamentoView->adicionaMensagemAlerta($this->pagamentoModel->getMensagem(), "Erro");
        }
    }

    function consultaPagamento() {
        $pagamentoId = $this->pagamentoView->getIdConsulta();

        if ($pagamentoId == '-1') {
            $this->pagamentoView->adicionaMensagemAlerta("Escolha um pagamento para consulta.");
            return;
        }

        if ($pagamentoModel = $this->pagamentoAdo->consultaObjetoPeloId($pagamentoId)) {
            $this->pagamentoModel = $pagamentoModel;
        } else {
            $this->pagamentoView->adicionaMensagemErro("Erro na consulta!");
            $this->pagamentoView->adicionaMensagemErro($this->pagamentoAdo->getMensagem());
            $this->pagamentoModel = new PagamentoModel();
        }
    }

    function emitirRelatorio() {
        $EmitirRelatorio = new RelatorioPagamentos();
        $pagamentoId = $this->pagamentoView->getIdConsulta();

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
