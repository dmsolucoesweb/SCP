<?php

require_once 'Model.php';

class IndiceModel extends Model {

    private $indiceId = null;
    private $indiceInccValor = null;
    private $indiceIgpmValor = null;
    private $indiceData = null;
    private $usuarioId = null;

    function __construct($indiceId = null, $indiceInccValor = null, $indiceIgpmValor = null, $indiceData = null, $usuarioId = null) {
        $this->indiceId = $indiceId;
        $this->indiceInccValor = $indiceInccValor;
        $this->indiceIgpmValor = $indiceIgpmValor;
        $this->indiceData = $indiceData;
        $this->usuarioId = $usuarioId;
    }

    function getIndiceId() {
        return $this->indiceId;
    }

    function getIndiceInccValor() {
        return $this->indiceInccValor;
    }

    function getIndiceIgpmValor() {
        return $this->indiceIgpmValor;
    }

    function getIndiceData() {
        return $this->indiceData;
    }

    function getUsuarioId() {
        return $this->usuarioId;
    }

    function setIndiceId($indiceId) {
        $this->indiceId = $indiceId;
    }

    function setIndiceInccValor($indiceInccValor) {
        $this->indiceInccValor = $indiceInccValor;
    }

    function setIndiceIgpmValor($indiceIgpmValor) {
        $this->indiceIgpmValor = $indiceIgpmValor;
    }

    function setIndiceData($indiceData) {
        $this->indiceData = $indiceData;
    }

    function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
    }

    public function checaAtributos() {
        $atributosValidos = TRUE;

        if (is_null($this->indiceInccValor)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Valor do &Iacute;ndice INCC.");
        }

        if (is_null($this->indiceIgpmValor)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o Valor do &Iacute;ndice IGPM.");
        }

        if (is_null($this->indiceData)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite uma Data valida do &Iacute;ndice.");
        }

        return $atributosValidos;
    }

}
