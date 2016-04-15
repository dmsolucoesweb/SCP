<?php

require_once '../Views/IndiceView.php';
require_once '../Models/IndiceModel.php';
require_once '../Ados/IndiceAdo.php';
require_once '../PDF/RelatorioIndice.php';

class IndiceController {

    private $IndiceView = null;
    private $IndiceModel = null;
    private $IndiceAdo = null;

    public function __construct() {
        $this->IndiceView = new IndiceView();
        $this->IndiceModel = new IndiceModel();
        $this->IndiceAdo = new IndiceAdo();

        $acao = $this->IndiceView->getAcao();

        switch ($acao) {
            case 'nov':
                $this->novoIndice();
                break;

            case 'inc':
                $this->incluiIndice();
                break;

            case 'con':
                $this->consultaIndice();
                break;

            case 'exc':
                $this->excluiIndice();

                break;

            case 'erl':
                $this->emitirRelatorio();
                break;

            default:
                $this->IndiceModel = new IndiceModel();
                break;
        }

        $this->IndiceView->displayInterface($this->IndiceModel);
    }

    function novoIndice() {
        $this->IndiceModel = new IndiceModel();
    }

    function incluiIndice() {
        $indiceAdo = new IndiceAdo();

        $this->IndiceModel = $this->IndiceView->getDadosEntrada();
        $indiceInccValor = $this->IndiceModel->getIndiceInccValor();
        $indiceIgpmValor = $this->IndiceModel->getIndiceIgpmValor();
        $indiceData = $this->IndiceModel->getIndiceData();

        if ($this->IndiceModel->checaAtributos()) {
            if ($this->IndiceAdo->insereObjeto($this->IndiceModel)) {
                $indiceId = $indiceAdo->consultaIdPelaData($indiceData);
                if ($this->IndiceAdo->adicionaIndice($indiceInccValor, $indiceIgpmValor, $indiceId, $indiceData)) {
                    $this->IndiceView->adicionaMensagemSucesso("Índices aplicados com sucesso! ");
                    $this->IndiceModel = new IndiceModel();
                } else {
                    $this->IndiceAdo->excluiIndicePorSeguranca($indiceId);
                    $this->IndiceView->adicionaMensagemErro("Erro ao aplicar Índice!");
                    $this->IndiceModel = new IndiceModel();
                }
            } else {
                $this->IndiceView->adicionaMensagemErro("Erro ao aplicar Índice!");
                //$this->indiceView->adicionaMensagemErro($this->indiceAdo->getMensagem());
            }
        } else {
            $this->IndiceView->adicionaMensagemAlerta($this->IndiceModel->getMensagem(), "Erro");
        }
    }

    function consultaIndice() {
        $indiceId = $this->IndiceView->getIdConsulta();

        if ($indiceId == '-1') {
            $this->IndiceView->adicionaMensagemAlerta("Escolha um Índice para consulta");
            return;
        }

        if ($indiceModel = $this->IndiceAdo->consultaObjetoPeloId($indiceId)) {
            $this->IndiceModel = $indiceModel;
        } else {
            $this->IndiceView->adicionaMensagemErro("Erro na consulta!");
            $this->IndiceView->adicionaMensagemErro($this->IndiceAdo->getMensagem());
            $this->IndiceModel = new IndiceModel();
        }
    }

    function excluiIndice() {
        $this->IndiceModel = $this->IndiceView->getDadosEntrada();

        if ($this->IndiceAdo->excluiObjeto($this->IndiceModel)) {
            $this->IndiceView->adicionaMensagemSucesso("O Índice foi excluido com sucesso! ");
        } else {
            $this->IndiceView->adicionaMensagemErro("O Índice foi excluido com sucesso! ");
            $this->IndiceModel = new IndiceModel();
        }
    }

    function emitirRelatorio() {
        $EmitirRelatorio = new RelatorioIndice();
        $indiceId = $this->IndiceView->getIdConsulta();

        if ($indiceId == '-1') {
            $EmitirRelatorio->EmitirRelatorioDeIndices();
        } else {
            $indiceModel = $this->IndiceAdo->consultaObjetoPeloId($indiceId);
            $EmitirRelatorio->EmitirRelatorioDeIndices($indiceModel);
        }
    }

}
