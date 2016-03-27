<?php

require_once 'Model.php';

class ProdutoModel extends Model {

    private $produtoId = null;
    private $produtoApartamento = null;
    private $produtoBox = null;
    private $produtoValor = null;
    private $produtoDataVenda = null;
    private $produtoStatus = null;
    private $produtoParcelas = null;
    private $produtoParcelasPeriodicidade = null;
    private $produtoParcelasDataVencimento = null;
    private $produtoParcelasValorUnitario = null;
    private $produtoParcelasValorTotal = null;
    private $produtoParcelasAtualizacaoMonetaria = null;
    private $produtoParcelasFormaPagamento = null;
    private $produtoParcelasObservacoes = null;
    private $clienteId = null;
    private $vendedorId = null;
    private $vendedorDataVencimento = null;
    private $vendedorComissao = null;
    private $vendedorFormaPagamento = null;
    private $vendedorObservacao = null;

    function __construct($produtoId = null, $produtoApartamento = null, $produtoBox = null, $produtoValor = null, $produtoDataVenda = null, $produtoStatus = null, $produtoParcelas = null, $produtoParcelasPeriodicidade = null, $produtoParcelasDataVencimento = null, $produtoParcelasValorUnitario = null, $produtoParcelasValorTotal = null, $produtoParcelasAtualizacaoMonetaria = null, $produtoParcelasFormaPagamento = null, $produtoParcelasObservacoes = null, $clienteId = null, $vendedorId = null, $vendedorDataVencimento = null, $vendedorComissao = null, $vendedorFormaPagamento = null, $vendedorObservacao = null) {
        $this->produtoId = $produtoId;
        $this->produtoApartamento = $produtoApartamento;
        $this->produtoBox = $produtoBox;
        $this->produtoValor = $produtoValor;
        $this->produtoDataVenda = $produtoDataVenda;
        $this->produtoStatus = $produtoStatus;
        $this->produtoParcelas = $produtoParcelas;
        $this->produtoParcelasPeriodicidade = $produtoParcelasPeriodicidade;
        $this->produtoParcelasDataVencimento = $produtoParcelasDataVencimento;
        $this->produtoParcelasValorUnitario = $produtoParcelasValorUnitario;
        $this->produtoParcelasValorTotal = $produtoParcelasValorTotal;
        $this->produtoParcelasAtualizacaoMonetaria = $produtoParcelasAtualizacaoMonetaria;
        $this->produtoParcelasFormaPagamento = $produtoParcelasFormaPagamento;
        $this->produtoParcelasObservacoes = $produtoParcelasObservacoes;
        $this->clienteId = $clienteId;
        $this->vendedorId = $vendedorId;
        $this->vendedorDataVencimento = $vendedorDataVencimento;
        $this->vendedorComissao = $vendedorComissao;
        $this->vendedorFormaPagamento = $vendedorFormaPagamento;
        $this->vendedorObservacao = $vendedorObservacao;
    }

    function getProdutoId() {
        return $this->produtoId;
    }

    function getProdutoApartamento() {
        return $this->produtoApartamento;
    }

    function getProdutoBox() {
        return $this->produtoBox;
    }

    function getProdutoValor() {
        return $this->produtoValor;
    }

    function getProdutoDataVenda() {
        return $this->produtoDataVenda;
    }

    function getProdutoStatus() {
        return $this->produtoStatus;
    }

    function getProdutoParcelas() {
        return $this->produtoParcelas;
    }

    function getProdutoParcelasPeriodicidade() {
        return $this->produtoParcelasPeriodicidade;
    }

    function getProdutoParcelasDataVencimento() {
        return $this->produtoParcelasDataVencimento;
    }

    function getProdutoParcelasValorUnitario() {
        return $this->produtoParcelasValorUnitario;
    }

    function getProdutoParcelasValorTotal() {
        return $this->produtoParcelasValorTotal;
    }

    function getProdutoParcelasAtualizacaoMonetaria() {
        return $this->produtoParcelasAtualizacaoMonetaria;
    }

    function getProdutoParcelasFormaPagamento() {
        return $this->produtoParcelasFormaPagamento;
    }

    function getProdutoParcelasObservacoes() {
        return $this->produtoParcelasObservacoes;
    }

    function getClienteId() {
        return $this->clienteId;
    }

    function getVendedorId() {
        return $this->vendedorId;
    }

    function getVendedorDataVencimento() {
        return $this->vendedorDataVencimento;
    }

    function getVendedorComissao() {
        return $this->vendedorComissao;
    }

    function getVendedorFormaPagamento() {
        return $this->vendedorFormaPagamento;
    }

    function getVendedorObservacao() {
        return $this->vendedorObservacao;
    }

    function setProdutoId($produtoId) {
        $this->produtoId = $produtoId;
    }

    function setProdutoApartamento($produtoApartamento) {
        $this->produtoApartamento = $produtoApartamento;
    }

    function setProdutoBox($produtoBox) {
        $this->produtoBox = $produtoBox;
    }

    function setProdutoValor($produtoValor) {
        $this->produtoValor = $produtoValor;
    }

    function setProdutoDataVenda($produtoDataVenda) {
        $this->produtoDataVenda = $produtoDataVenda;
    }

    function setProdutoStatus($produtoStatus) {
        $this->produtoStatus = $produtoStatus;
    }

    function setProdutoParcelas($produtoParcelas) {
        $this->produtoParcelas = $produtoParcelas;
    }

    function setProdutoParcelasPeriodicidade($produtoParcelasPeriodicidade) {
        $this->produtoParcelasPeriodicidade = $produtoParcelasPeriodicidade;
    }

    function setProdutoParcelasDataVencimento($produtoParcelasDataVencimento) {
        $this->produtoParcelasDataVencimento = $produtoParcelasDataVencimento;
    }

    function setProdutoParcelasValorUnitario($produtoParcelasValorUnitario) {
        $this->produtoParcelasValorUnitario = $produtoParcelasValorUnitario;
    }

    function setProdutoParcelasValorTotal($produtoParcelasValorTotal) {
        $this->produtoParcelasValorTotal = $produtoParcelasValorTotal;
    }

    function setProdutoParcelasAtualizacaoMonetaria($produtoParcelasAtualizacaoMonetaria) {
        $this->produtoParcelasAtualizacaoMonetaria = $produtoParcelasAtualizacaoMonetaria;
    }

    function setProdutoParcelasFormaPagamento($produtoParcelasFormaPagamento) {
        $this->produtoParcelasFormaPagamento = $produtoParcelasFormaPagamento;
    }

    function setProdutoParcelasObservacoes($produtoParcelasObservacoes) {
        $this->produtoParcelasObservacoes = $produtoParcelasObservacoes;
    }

    function setClienteId($clienteId) {
        $this->clienteId = $clienteId;
    }

    function setVendedorId($vendedorId) {
        $this->vendedorId = $vendedorId;
    }

    function setVendedorDataVencimento($vendedorDataVencimento) {
        $this->vendedorDataVencimento = $vendedorDataVencimento;
    }

    function setVendedorComissao($vendedorComissao) {
        $this->vendedorComissao = $vendedorComissao;
    }

    function setVendedorFormaPagamento($vendedorFormaPagamento) {
        $this->vendedorFormaPagamento = $vendedorFormaPagamento;
    }

    function setVendedorObservacao($vendedorObservacao) {
        $this->vendedorObservacao = $vendedorObservacao;
    }

    public function checaAtributos() {
        $atributosValidos = TRUE;

        if (is_null($this->produtoApartamento)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o Numero do Apartamento.");
        }

        if (is_null($this->produtoBox)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Informe o Box do Apartamento.");
        }

        if ($this->produtoValor == 0) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Informe o Valor do Apartamento.");
        }

        if (is_null($this->produtoDataVenda)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Informe a Data da Venda do Apartamento.");
        }

        if (is_null($this->produtoStatus)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Status do Apartamento (Entregue/Aguardando).");
        }

        if ($this->produtoParcelas == 0) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Informe a Quantidade de Parcelas do Apartamento.");
        }

        if ($this->produtoParcelasPeriodicidade == 0) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Informe a Periodicidade da Parcela do Apartamento.");
        }

        if ($this->produtoParcelasDataVencimento == 0) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Informe a Data de Vencimento da Parcela do Apartamento.");
        }

        if ($this->produtoParcelasFormaPagamento == "-1") {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Informe a Forma de Pagamento da Parcela do Apartamento.");
        }

        if ($this->produtoParcelasAtualizacaoMonetaria == "-1") {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Informe o tipo de Atualização Monetária da Parcela do Apartamento.");
        }

        if (is_null($this->clienteId)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Cliente.");
        }

        if (is_null($this->vendedorId)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Vendedor.");
        }

        return $atributosValidos;
    }

}
