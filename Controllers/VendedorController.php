<?php

require_once '../Views/VendedorView.php';
require_once '../Models/VendedorModel.php';
require_once '../Ados/VendedorAdo.php';

class VendedorController {

    private $VendedorView = null;
    private $VendedorModel = null;
    private $VendedorAdo = null;

    public function __construct() {
        $this->VendedorView = new VendedorView();
        $this->VendedorModel = new VendedorModel();
        $this->VendedorAdo = new VendedorAdo();

        $acao = $this->VendedorView->getAcao();

        switch ($acao) {
            case 'nov':
                $this->novoVendedor();
                break;

            case 'inc':
                $this->incluiVendedor();
                break;

            case 'con':
                $this->consultaVendedor();
                break;

            case 'alt':
                $this->alteraVendedor();

                break;

            case 'exc':
                $this->excluiVendedor();

                break;

            default:
                $this->VendedorModel = new VendedorModel();
                break;
        }

        $this->VendedorView->displayInterface($this->VendedorModel);
    }

    function novoVendedor() {
        $this->VendedorModel = new VendedorModel();
    }

    function incluiVendedor() {
        $this->VendedorModel = $this->VendedorView->getDadosEntrada();

        if ($this->VendedorModel->checaAtributos()) {
            if ($this->VendedorAdo->insereObjeto($this->VendedorModel)) {
                $this->VendedorView->adicionaMensagemSucesso("O vendedor " . $this->VendedorModel->getVendedorNome() . " foi cadastrado com sucesso! ");
                $this->VendedorModel = new VendedorModel();
            } else {
                $this->VendedorView->adicionaMensagemErro("Erro ao cadastrar vendedor " . $this->VendedorModel->getVendedorNome() . "!");
                $this->VendedorView->adicionaMensagemErro($this->VendedorAdo->getMensagem());
            }
        } else {
            $this->VendedorView->adicionaMensagemAlerta($this->VendedorModel->getMensagem(), "Erro");
        }
    }

    function consultaVendedor() {
        $vendedorId = $this->VendedorView->getIdConsulta();

        if ($vendedorId == '-1') {
            $this->VendedorView->adicionaMensagemAlerta("Escolha um vendedor para consulta");
            return;
        }

        if ($vendedorModel = $this->VendedorAdo->consultaObjetoPeloId($vendedorId)) {
            $this->VendedorModel = $vendedorModel;
        } else {
            $this->VendedorView->adicionaMensagemErro("Erro na consulta!");
            $this->VendedorView->adicionaMensagemErro($this->VendedorAdo->getMensagem());
            $this->VendedorModel = new VendedorModel();
        }
    }

    function alteraVendedor() {
        $this->VendedorModel = $this->VendedorView->getDadosEntrada();

        if ($this->VendedorModel->checaAtributos()) {
            if ($this->VendedorAdo->alteraObjeto($this->VendedorModel)) {
                $this->VendedorView->adicionaMensagemSucesso("O vendedor " . $this->VendedorModel->getVendedorNome() . " foi alterado com sucesso! ");
                $this->VendedorModel = new VendedorModel();
            } else {
                $this->VendedorView->adicionaMensagemErro("Erro ao alterar vendedor " . $this->VendedorModel->getVendedorNome() . "!");
            }
        } else {
            $this->VendedorView->adicionaMensagemErro($this->VendedorModel->getMensagem(), "Erro");
        }
    }

    function excluiVendedor() {
        $this->VendedorModel = $this->VendedorView->getDadosEntrada();

        if ($this->VendedorAdo->excluiObjeto($this->VendedorModel)) {
            $this->VendedorView->adicionaMensagemSucesso("O vendedor " . $this->VendedorModel->getVendedorNome() . " foi excluído com sucesso! ");
            $this->VendedorModel = new VendedorModel();
        } else {
            $this->VendedorView->adicionaMensagemErro("Erro ao excluir vendedor " . $this->VendedorModel->getVendedorNome() . "!");
        }
    }

}
