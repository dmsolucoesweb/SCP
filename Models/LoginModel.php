<?php

require_once 'Model.php';

class LoginModel extends Model {

    private $login = null;
    private $senha = null;

    function __construct($login = null, $senha = null) {
        $this->login = $login;
        $this->senha = $senha;
    }

    function getLogin() {
        return $this->login;
    }

    function getSenha() {
        return $this->senha;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    public function checaAtributos() {
        
    }

}
