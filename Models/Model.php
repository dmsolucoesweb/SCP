<?php

abstract class Model {

    private $mensagem = null;

    function getMensagem() {
        return $this->mensagem;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    function adicionaMensagem($mensagem) {
        $this->mensagem[] = $mensagem;
    }

    abstract public function checaAtributos();
}
