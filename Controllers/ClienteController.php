<?php

require_once '../Views/ClienteView.php';
require_once '../Models/ClienteModel.php';
require_once '../Ados/ClienteAdo.php';
require_once '../PDF/RelatorioClientes.php';
require_once '../Views/ProdutoView.php';
require_once '../Models/ProdutoModel.php';
require_once '../Ados/ProdutoAdo.php';

class ClienteController {

    private $ClienteView = null;
    private $ClienteModel = null;
    private $ClienteAdo = null;
    private $ProdutoView = null;
    private $ProdutoModel = null;
    private $ProdutoAdo = null;

    public function __construct() {
        $this->ClienteView = new ClienteView();
        $this->ClienteModel = new ClienteModel();
        $this->ClienteAdo = new ClienteAdo();

        $this->ProdutoView = new ProdutoView();
        $this->ProdutoModel = new ProdutoModel();
        $this->ProdutoAdo = new ProdutoAdo();

        $acao = $this->ClienteView->getAcao();

        if (is_numeric($acao)) {
            $this->buscaProduto($acao);
        }

        switch ($acao) {
            case 'nov':
                $this->novoCliente();
                break;

            case 'inc':
                $this->incluiCliente();
                break;

            case 'con':
                $this->consultaCliente();
                break;

            case 'erl':
                $this->emitirRelatorio();
                break;

            case 'alt':
                $this->alteraCliente();

                break;

            case 'exc':
                $this->excluiCliente();

                break;

            default:
                $this->ClienteModel = new ClienteModel();
                break;
        }
        if ($this->teste != 1) {
            $this->ClienteView->displayInterface($this->ClienteModel);
        }
    }

    function novoCliente() {
        $this->ClienteModel = new ClienteModel();
    }

    function incluiCliente() {
        $this->ClienteModel = $this->ClienteView->getDadosEntrada();

        if ($this->ClienteModel->checaAtributos()) {
            if ($this->ClienteAdo->insereObjeto($this->ClienteModel)) {
                $this->ClienteView->adicionaMensagemSucesso("O cliente " . $this->ClienteModel->getClienteNome() . " foi cadastrado com sucesso!");
                $this->ClienteModel = new ClienteModel();
            } else {
                $this->ClienteView->adicionaMensagemErro("Erro ao cadastrar o cliente " . $this->ClienteModel->getClienteNome() . "!");
                //$this->clienteView->adicionaMensagemErro($this->clienteAdo->getMensagem());
            }
        } else {
            $this->ClienteView->adicionaMensagemAlerta($this->ClienteModel->getMensagem(), "Erro");
        }
    }

    function consultaCliente() {
        $clienteId = $this->ClienteView->getIdConsulta();

        if ($clienteId == '-1') {
            $this->ClienteView->adicionaMensagemAlerta("Escolha um cliente para consulta.");
            return;
        }

        if ($clienteModel = $this->ClienteAdo->consultaObjetoPeloId($clienteId)) {
            $this->ClienteModel = $clienteModel;
        } else {
            $this->ClienteView->adicionaMensagemErro("Erro na consulta!");
            $this->ClienteView->adicionaMensagemErro($this->ClienteAdo->getMensagem());
            $this->ClienteModel = new ClienteModel();
        }
    }

    function emitirRelatorio() {
        $EmitirRelatorio = new RelatorioClientes();
        $clienteId = $this->ClienteView->getIdConsulta();

        if ($clienteId == '-1') {
            $EmitirRelatorio->EmitirRelatorioDeClientes();
        } else {
            $clienteModel = $this->ClienteAdo->consultaObjetoPeloId($clienteId);
            $EmitirRelatorio->EmitirRelatorioDeCliente($clienteModel);
        }
    }

    function alteraCliente() {
        $this->ClienteModel = $this->ClienteView->getDadosEntrada();

        if ($this->ClienteModel->checaAtributos()) {
            if ($this->ClienteAdo->alteraObjeto($this->ClienteModel)) {
                $this->ClienteView->adicionaMensagemSucesso("O cliente " . $this->ClienteModel->getClienteNome() . " foi alterado com sucesso! ");
                $this->ClienteModel = new ClienteModel();
            } else {
                $this->ClienteView->adicionaMensagemErro("Erro ao alterar o cliente " . $this->ClienteModel->getClienteNome() . "!");
            }
        } else {
            $this->ClienteView->adicionaMensagemAlerta($this->ClienteModel->getMensagem(), "Erro");
        }
    }

    function excluiCliente() {
        $this->ClienteModel = $this->ClienteView->getDadosEntrada();

        if ($this->ClienteAdo->excluiObjeto($this->ClienteModel)) {
            $this->ClienteView->adicionaMensagemSucesso("O cliente " . $this->ClienteModel->getClienteNome() . " foi excluido com sucesso! ");
            $this->ClienteModel = new ClienteModel();
        } else {
            $this->ClienteView->adicionaMensagemErro("Erro ao excluir o Cliente " . $this->ClienteModel->getClienteNome() . "!");
        }
    }

    function buscaProduto($id) {
        $produtoId = $id;

        if ($produtoModel = $this->ProdutoAdo->consultaObjetoPeloId($produtoId)) {
            $this->ProdutoModel = $produtoModel;
            $this->ProdutoView->displayInterface($this->ProdutoModel);
            $this->teste = 1;
        } else {
            $this->ClienteView->adicionaMensagemErro("Erro na consulta!");
            $this->ClienteView->adicionaMensagemErro($this->ClienteAdo->getMensagem());
            $this->ClienteModel = new ClienteModel();
        }
    }

}
