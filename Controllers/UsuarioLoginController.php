<?php

require_once '../Views/UsuarioLoginView.php';
require_once '../Models/UsuarioLoginModel.php';
require_once '../Ados/UsuarioLoginAdo.php';

class UsuarioLoginController {

    private $UsuarioLoginView = null;
    private $UsuarioLoginModel = null;
    private $UsuarioLoginAdo = null;

    public function __construct() {

        $this->UsuarioLoginView = new UsuarioLoginView();
        $this->UsuarioLoginModel = new UsuarioLoginModel();
        $this->UsuarioLoginAdo = new UsuarioLoginAdo();

        $acao = $this->UsuarioLoginView->getAcao();

        switch ($acao) {
            case 'nov':
                $this->novoUsuario();
                break;

            case 'inc':
                $this->incluiUsuario();
                break;

            case 'con':
                $this->consultaUsuario();
                break;

            case 'alt':
                $this->alteraUsuario();

                break;

            case 'exc':
                $this->excluiUsuario();

                break;

            default:
                $this->UsuarioLoginModel = new UsuarioLoginModel();
                break;
        }

        $this->UsuarioLoginView->displayInterface($this->UsuarioLoginModel);
    }

    function novoUsuario() {
        $this->UsuarioLoginModel = new UsuarioLoginModel();
    }

    function consultaUsuario() {
        $usuarioLoginId = $this->UsuarioLoginView->getIdConsulta();

        if ($usuarioLoginId == '-1') {
            $this->UsuarioLoginView->adicionaMensagemAlerta("Escolha um usuário para consulta");
            return;
        }

        if ($usuarioLoginModel = $this->UsuarioLoginAdo->consultaObjetoPeloId($usuarioLoginId)) {
            $this->UsuarioLoginModel = $usuarioLoginModel;
        } else {
            $this->UsuarioLoginView->adicionaMensagemErro("Erro na consulta!");
            $this->UsuarioLoginView->adicionaMensagemErro($this->UsuarioLoginAdo->getMensagem());
            $this->UsuarioLoginModel = new UsuarioLoginModel();
        }
    }

    function incluiUsuario() {
        $this->UsuarioLoginModel = $this->UsuarioLoginView->getDadosEntrada();

        if ($this->UsuarioLoginModel->checaAtributos()) {
            if ($this->UsuarioLoginAdo->insereObjeto($this->UsuarioLoginModel)) {
                $this->UsuarioLoginView->adicionaMensagemSucesso("O usuário " . $this->UsuarioLoginModel->getUsuarioLoginNome() . " foi cadastrado com sucesso!");
                $this->UsuarioLoginModel = new UsuarioLoginModel();
            } else {
                $this->UsuarioLoginView->adicionaMensagemErro("Erro ao cadastrar usuário " . $this->UsuarioLoginModel->getUsuarioLoginNome() . "!");
            }
        } else {
            $this->UsuarioLoginView->adicionaMensagemAlerta($this->UsuarioLoginModel->getMensagem(), "Erro");
        }
    }

    function alteraUsuario() {
        $this->UsuarioLoginModel = $this->UsuarioLoginView->getDadosEntrada();

        if ($this->UsuarioLoginModel->checaAtributos()) {
            if ($this->UsuarioLoginAdo->alteraObjeto($this->UsuarioLoginModel)) {
                $this->UsuarioLoginView->adicionaMensagemSucesso("O usuário " . $this->UsuarioLoginModel->getUsuarioLoginNome() . " foi alterado com sucesso! ");
                $this->UsuarioLoginModel = new UsuarioLoginModel();
            } else {
                $this->UsuarioLoginView->adicionaMensagemErro("Erro ao alterar usuário " . $this->UsuarioLoginModel->getUsuarioLoginNome() . "!");
            }
        } else {
            $this->UsuarioLoginView->adicionaMensagemAlerta($this->UsuarioLoginModel->getMensagem(), "Erro");
        }
    }

    function excluirUsuario() {
        $this->UsuarioLoginModel = $this->UsuarioLoginView->getDadosEntrada();

        if ($this->UsuarioLoginAdo->excluiObjeto($this->UsuarioLoginModel)) {
            $this->UsuarioLoginView->adicionaMensagemSucesso("O usuário " . $this->UsuarioLoginModel->getUsuarioLoginNome() . " foi excluído com sucesso!");
            $this->UsuarioLoginModel = new UsuarioLoginModel();
        } else {
            $this->UsuarioLoginView->adicionaMensagemErro("Erro ao excluir usuário " . $this->UsuarioLoginModel->getUsuarioLoginNome() . "!");
        }
    }

}
