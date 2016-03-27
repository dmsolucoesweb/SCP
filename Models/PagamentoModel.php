<?php

require_once 'Model.php';

class PagamentoModel extends Model {

    private $pagamentoId = null;
    private $clienteId = null;
    private $produtoId = null;
    private $pagamentoStatusProduto = null;
    private $pagamentoValorTotal = null;
    private $pagamentoParcela = null;
    private $pagamentoValorParcela = null;
    private $pagamentoValorParcelaUnitario = null;
    private $pagamentoData = null;
    private $pagamentoValor = null;

    function __construct($pagamentoId = null, $clienteId = null, $produtoId = null, $pagamentoStatusProduto = null, $pagamentoValorTotal = null, $pagamentoParcela = null, $pagamentoValorParcela = null, $pagamentoValorParcelaUnitario = null, $pagamentoData = null, $pagamentoValor = null) {
        $this->pagamentoId = $pagamentoId;
        $this->clienteId = $clienteId;
        $this->produtoId = $produtoId;
        $this->pagamentoStatusProduto = $pagamentoStatusProduto;
        $this->pagamentoValorTotal = $pagamentoValorTotal;
        $this->pagamentoParcela = $pagamentoParcela;
        $this->pagamentoValorParcela = $pagamentoValorParcela;
        $this->pagamentoValorParcelaUnitario = $pagamentoValorParcelaUnitario;
        $this->pagamentoData = $pagamentoData;
        $this->pagamentoValor = $pagamentoValor;
    }

    function getPagamentoId() {
        return $this->pagamentoId;
    }

    function getClienteId() {
        return $this->clienteId;
    }

    function getProdutoId() {
        return $this->produtoId;
    }

    function getPagamentoStatusProduto() {
        return $this->pagamentoStatusProduto;
    }

    function getPagamentoValorTotal() {
        return $this->pagamentoValorTotal;
    }

    function getPagamentoParcela() {
        return $this->pagamentoParcela;
    }

    function getPagamentoValorParcela() {
        return $this->pagamentoValorParcela;
    }

    function getPagamentoValorParcelaUnitario() {
        return $this->pagamentoValorParcelaUnitario;
    }

    function getPagamentoData() {
        return $this->pagamentoData;
    }

    function getPagamentoValor() {
        return $this->pagamentoValor;
    }

    function setPagamentoId($pagamentoId) {
        $this->pagamentoId = $pagamentoId;
    }

    function setClienteId($clienteId) {
        $this->clienteId = $clienteId;
    }

    function setProdutoId($produtoId) {
        $this->produtoId = $produtoId;
    }

    function setPagamentoStatusProduto($pagamentoStatusProduto) {
        $this->pagamentoStatusProduto = $pagamentoStatusProduto;
    }

    function setPagamentoValorTotal($pagamentoValorTotal) {
        $this->pagamentoValorTotal = $pagamentoValorTotal;
    }

    function setPagamentoParcela($pagamentoParcela) {
        $this->pagamentoParcela = $pagamentoParcela;
    }

    function setPagamentoValorParcela($pagamentoValorParcela) {
        $this->pagamentoValorParcela = $pagamentoValorParcela;
    }

    function setPagamentoValorParcelaUnitario($pagamentoValorParcelaUnitario) {
        $this->pagamentoValorParcelaUnitario = $pagamentoValorParcelaUnitario;
    }

    function setPagamentoData($pagamentoData) {
        $this->pagamentoData = $pagamentoData;
    }

    function setPagamentoValor($pagamentoValor) {
        $this->pagamentoValor = $pagamentoValor;
    }

    public function checaAtributos() {
        $atributosValidos = TRUE;

        if (is_null($this->pagamentoData)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite a Data na qual está efetuando este Pagamento.");
        }

        if (is_null($this->pagamentoValor)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o Valor do Pagamento.");
        }

        return $atributosValidos;
    }

}
