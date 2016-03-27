<?php

require_once 'Model.php';

class UsuarioLoginModel extends Model {

    private $usuarioLoginId = null;
    private $usuarioLoginNome = null;
    private $usuarioLoginEmail = null;
    private $usuarioLoginTipo = null;
    private $usuarioLoginLogin = null;
    private $usuarioLoginSenha = null;

    function __construct($usuarioLoginId = null, $usuarioLoginNome = null, $usuarioLoginEmail = null, $usuarioLoginTipo = null, $usuarioLoginLogin = null, $usuarioLoginSenha = null) {
        $this->usuarioLoginId = $usuarioLoginId;
        $this->usuarioLoginNome = $usuarioLoginNome;
        $this->usuarioLoginEmail = $usuarioLoginEmail;
        $this->usuarioLoginTipo = $usuarioLoginTipo;
        $this->usuarioLoginLogin = $usuarioLoginLogin;
        $this->usuarioLoginSenha = $usuarioLoginSenha;
    }

    function getUsuarioLoginId() {
        return $this->usuarioLoginId;
    }

    function getUsuarioLoginNome() {
        return $this->usuarioLoginNome;
    }

    function getUsuarioLoginEmail() {
        return $this->usuarioLoginEmail;
    }

    function getUsuarioLoginTipo() {
        return $this->usuarioLoginTipo;
    }

    function getUsuarioLoginLogin() {
        return $this->usuarioLoginLogin;
    }

    function getUsuarioLoginSenha() {
        return $this->usuarioLoginSenha;
    }

    function setUsuarioLoginId($usuarioLoginId) {
        $this->usuarioLoginId = $usuarioLoginId;
    }

    function setUsuarioLoginNome($usuarioLoginNome) {
        $this->usuarioLoginNome = $usuarioLoginNome;
    }

    function setUsuarioLoginEmail($usuarioLoginEmail) {
        $this->usuarioLoginEmail = $usuarioLoginEmail;
    }

    function setUsuarioLoginTipo($usuarioLoginTipo) {
        $this->usuarioLoginTipo = $usuarioLoginTipo;
    }

    function setUsuarioLoginLogin($usuarioLoginLogin) {
        $this->usuarioLoginLogin = $usuarioLoginLogin;
    }

    function setUsuarioLoginSenha($usuarioLoginSenha) {
        $this->usuarioLoginSenha = $usuarioLoginSenha;
    }

    public function checaAtributos() {
        return TRUE;
    }

}
