<?php

require_once 'Model.php';
require_once '../Classes/cpf.php';

class BoletoModel extends Model {

    private $boletoId = null;
    private $boletoNumeroDocumento = null;
    private $boletoNossoNumero = null;
    private $boletoSacado = null;
    private $boletoRemetido = null;
    private $boletoDataVencimento = null;
    private $boletoDataEmissao = null;
    private $boletoValor = null;
    private $boletoProdutoId = null;

    function __construct($boletoId = null, $boletoNumeroDocumento = null, $boletoNossoNumero = null, $boletoSacado = null, $boletoRemetido = null, $boletoDataVencimento = null, $boletoDataEmissao = null, $boletoValor = null, $boletoProdutoId = null) {
        $this->boletoId = $boletoId;
        $this->boletoNumeroDocumento = $boletoNumeroDocumento;
        $this->boletoNossoNumero = $boletoNossoNumero;
        $this->boletoRemetido = $boletoRemetido;
        $this->boletoSacado = $boletoSacado;
        $this->boletoDataVencimento = $boletoDataVencimento;
        $this->boletoDataEmissao = $boletoDataEmissao;
        $this->boletoValor = $boletoValor;
        $this->boletoProdutoId = $boletoProdutoId;
    }

    function getBoletoId() {
        return $this->boletoId;
    }

    function getBoletoNumeroDocumento() {
        return $this->boletoNumeroDocumento;
    }

    function getBoletoNossoNumero() {
        return $this->boletoNossoNumero;
    }

    function getBoletoRemetido() {
        return $this->boletoRemetido;
    }

    function getBoletoSacado() {
        return $this->boletoSacado;
    }

    function getBoletoDataVencimento() {
        return $this->boletoDataVencimento;
    }

    function getBoletoDataEmissao() {
        return $this->boletoDataEmissao;
    }

    function getBoletoValor() {
        return $this->boletoValor;
    }

    function getBoletoProdutoId() {
        return $this->boletoProdutoId;
    }

    function setBoletoId($boletoId) {
        $this->boletoId = $boletoId;
    }

    function setBoletoNumeroDocumento($boletoNumeroDocumento) {
        $this->boletoNumeroDocumento = $boletoNumeroDocumento;
    }

    function setBoletoNossoNumero($boletoNossoNumero) {
        $this->boletoNossoNumero = $boletoNossoNumero;
    }

    function setBoletoRemetido($boletoRemetido) {
        $this->boletoRemetido = $boletoRemetido;
    }

    function setBoletoSacado($boletoSacado) {
        $this->boletoSacado = $boletoSacado;
    }

    function setBoletoDataVencimento($boletoDataVencimento) {
        $this->boletoDataVencimento = $boletoDataVencimento;
    }

    function setBoletoDataEmissao($boletoDataEmissao) {
        $this->boletoDataEmissao = $boletoDataEmissao;
    }

    function setBoletoValor($boletoValor) {
        $this->boletoValor = $boletoValor;
    }

    function setBoletoProdutoId($boletoProdutoId) {
        $this->boletoProdutoId = $boletoProdutoId;
    }

    public function checaAtributos() {
        $atributosValidos = TRUE;

        if (is_null($this->boletoDataVencimento) && ($this->boletoDataVencimento == "0000-00-00")) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("A data de vencimento está incorreta.");
        }


        if (is_null($this->boletoValor)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("O valor do boleto está incorreto.");
        }

        if (is_null($this->boletoProdutoId)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Nenhum produto selecionado para geração do boleto.");
        }

        return $atributosValidos;
    }

}
