<?php

require_once 'ADO.php';
require_once '../Models/ProdutoModel.php';

class ProdutoAdo extends ADO {
    /* Função: consultaApartamentoEBoxPeloId
     * Utilidade: buscar o apartamento e box do cliente (caso exista). É usada na cliente view para montar a tabela de apartamentos do cliente.
     */

    public function consultaApartamentoEBoxPeloId($clienteId) {
        $query = "select produtoApartamento, produtoBox from Produtos where clienteId = '{$clienteId}'";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaApartamentoEBoxPeloId: " . parent::getBdError());
            return false;
        }

        $produto = parent::leTabelaBD();

        return $produto;
    }

    /* Função: consultaProdutoPeloCliente
     * Utilidade: Busca os Produtos do Cliente. É usado no relatório de cliente e de vendedores.
     */

    public function consultaProdutoPeloCliente($clienteId) {
        $produtoModel = null;
        $query = "select * from Produtos where clienteId = $clienteId";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaProdutoPeloCliente: " . parent::getBdError());
            return false;
        }

        $produtosModel = null;
        $DatasEHoras = new DatasEHoras();

        while ($produto = parent::leTabelaBD()) {
            $produtoDataVenda = $DatasEHoras->getDataEHorasDesinvertidaComBarras($produto['produtoDataVenda']);
            $vendedorDataVencimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($produto['vendedorDataVencimento']);
            $produtoModel = new ProdutoModel($produto['produtoId'], $produto['produtoApartamento'], $produto['produtoBox'], $produto['produtoValor'], $produtoDataVenda, $produto['produtoStatus'], $produto['produtoParcelas'], $produto['produtoParcelasPeriodicidade'], $produto['produtoParcelasDataVencimento'], $produto['produtoParcelasValorUnitario'], $produto['produtoParcelasValorTotal'], $produto['produtoParcelasAtualizacaoMonetaria'], $produto['produtoParcelasFormaPagamento'], $produto['produtoParcelasObservacoes'], $produto['clienteId'], $produto['vendedorId'], $vendedorDataVencimento, $produto['vendedorComissao'], $produto['vendedorFormaPagamento'], $produto['vendedorObservacao']);
            $produtosModel[] = $produtoModel;
        }

        return $produtosModel;
    }

    public function consultaBoletos($id) {
        
    }

    public function consultaObjetoPeloId($id) {
        $query = "select * from Produtos where produtoId = '{$id}' ";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaObjetoPeloId: " . parent::getBdError());
            return false;
        }

        $DatasEHoras = new DatasEHoras();

        $produto = parent::leTabelaBD();
        $produtoDataVenda = $DatasEHoras->getDataEHorasDesinvertidaComBarras($produto['produtoDataVenda']);
        $vendedorDataVencimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($produto['vendedorDataVencimento']);
        return new ProdutoModel($produto['produtoId'], $produto['produtoApartamento'], $produto['produtoBox'], $produto['produtoValor'], $produtoDataVenda, $produto['produtoStatus'], $produto['produtoParcelas'], $produto['produtoParcelasPeriodicidade'], $produto['produtoParcelasDataVencimento'], $produto['produtoParcelasValorUnitario'], $produto['produtoParcelasValorTotal'], $produto['produtoParcelasAtualizacaoMonetaria'], $produto['produtoParcelasFormaPagamento'], $produto['produtoParcelasObservacoes'], $produto['clienteId'], $produto['vendedorId'], $vendedorDataVencimento, $produto['vendedorComissao'], $produto['vendedorFormaPagamento'], $produto['vendedorObservacao']);
    }

    public function consultaArrayDeObjeto() {
        $produtoModel = null;
        $query = "select * from Produtos order by produtoApartamento";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaArrayDeObjeto: " . parent::getBdError());
            return false;
        }

        $produtosModel = null;
        $DatasEHoras = new DatasEHoras();

        while ($produto = parent::leTabelaBD()) {
            $produtoDataVenda = $DatasEHoras->getDataEHorasDesinvertidaComBarras($produto['produtoDataVenda']);
            $vendedorDataVencimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($produto['vendedorDataVencimento']);
            $produtoModel = new ProdutoModel($produto['produtoId'], $produto['produtoApartamento'], $produto['produtoBox'], $produto['produtoValor'], $produtoDataVenda, $produto['produtoStatus'], $produto['produtoParcelas'], $produto['produtoParcelasPeriodicidade'], $produto['produtoParcelasDataVencimento'], $produto['produtoParcelasValorUnitario'], $produto['produtoParcelasValorTotal'], $produto['produtoParcelasAtualizacaoMonetaria'], $produto['produtoParcelasFormaPagamento'], $produto['produtoParcelasObservacoes'], $produto['clienteId'], $produto['vendedorId'], $vendedorDataVencimento, $produto['vendedorComissao'], $produto['vendedorFormaPagamento'], $produto['vendedorObservacao']);
            $produtosModel[] = $produtoModel;
        }

        return $produtosModel;
    }

    public function insereObjeto(Model $ProdutoModel) {
        $produtoApartamento = $ProdutoModel->getProdutoApartamento();
        $produtoBox = $ProdutoModel->getProdutoBox();
        $produtoValor = $ProdutoModel->getProdutoValor();
        $produtoDataVenda = $ProdutoModel->getProdutoDataVenda();
        $produtoStatus = $ProdutoModel->getProdutoStatus();
        $produtoParcelas = $ProdutoModel->getProdutoParcelas();
        $produtoParcelasPeriodicidade = $ProdutoModel->getProdutoParcelasPeriodicidade();
        $produtoParcelasDataVencimento = $ProdutoModel->getProdutoParcelasDataVencimento();
        $produtoParcelasValorUnitario = $ProdutoModel->getProdutoParcelasValorUnitario() . ';0';
        $produtoParcelasValorTotal = $ProdutoModel->getProdutoParcelasValorTotal() . ';0';
        $produtoParcelasAtualizacaoMonetaria = $ProdutoModel->getProdutoParcelasAtualizacaoMonetaria();
        $produtoParcelasFormaPagamento = $ProdutoModel->getProdutoParcelasFormaPagamento();
        $produtoParcelasObservacoes = $ProdutoModel->getProdutoParcelasObservacoes();
        $clienteId = $ProdutoModel->getClienteId();
        $vendedorId = $ProdutoModel->getVendedorId();
        $vendedorDataVencimento = $ProdutoModel->getVendedorDataVencimento();
        $vendedorComissao = $ProdutoModel->getVendedorComissao();
        $vendedorFormaPagamento = $ProdutoModel->getVendedorFormaPagamento();
        $vendedorObservacao = $ProdutoModel->getVendedorObservacao();

        $query = "insert into Produtos (produtoId, produtoApartamento, produtoBox, produtoValor, produtoDataVenda, produtoStatus, produtoParcelas, produtoParcelasPeriodicidade, produtoParcelasDataVencimento, produtoParcelasValorUnitario, produtoParcelasValorTotal, produtoParcelasAtualizacaoMonetaria, produtoParcelasFormaPagamento, produtoParcelasObservacoes, clienteId, vendedorId, vendedorDataVencimento, vendedorComissao, vendedorFormaPagamento, vendedorObservacao) values (null, '$produtoApartamento', '$produtoBox','$produtoValor', '$produtoDataVenda', '$produtoStatus', '$produtoParcelas', '$produtoParcelasPeriodicidade', '$produtoParcelasDataVencimento', '$produtoParcelasValorUnitario', '$produtoParcelasValorTotal', '$produtoParcelasAtualizacaoMonetaria', '$produtoParcelasFormaPagamento', '$produtoParcelasObservacoes', '$clienteId', '$vendedorId', '$vendedorDataVencimento', '$vendedorComissao', '$vendedorFormaPagamento', '$vendedorObservacao')";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no insert de insereObjeto: " . parent::getBdError());
            return false;
        }
    }

    public function insereBoleto(Model $ProdutoModel) {
        $produtoId = $ProdutoModel->getProdutoId();
        $produtoApartamento = $ProdutoModel->getProdutoApartamento();
        $produtoBox = $ProdutoModel->getProdutoBox();
        $produtoValor = $ProdutoModel->getProdutoValor();
        $produtoDataVenda = $ProdutoModel->getProdutoDataVenda();
        $produtoStatus = $ProdutoModel->getProdutoStatus();
        $produtoParcelas = $ProdutoModel->getProdutoParcelas();
        $produtoParcelasPeriodicidade = $ProdutoModel->getProdutoParcelasPeriodicidade();
        $produtoParcelasDataVencimento = $ProdutoModel->getProdutoParcelasDataVencimento();
        $produtoParcelasValorUnitario = $ProdutoModel->getProdutoParcelasValorUnitario() . ';0';
        $produtoParcelasValorTotal = $ProdutoModel->getProdutoParcelasValorTotal() . ';0';
        $produtoParcelasAtualizacaoMonetaria = $ProdutoModel->getProdutoParcelasAtualizacaoMonetaria();
        $produtoParcelasFormaPagamento = $ProdutoModel->getProdutoParcelasFormaPagamento();
        $produtoParcelasObservacoes = $ProdutoModel->getProdutoParcelasObservacoes();
        $clienteId = $ProdutoModel->getClienteId();
        $vendedorId = $ProdutoModel->getVendedorId();
        $vendedorDataVencimento = $ProdutoModel->getVendedorDataVencimento();
        $vendedorComissao = $ProdutoModel->getVendedorComissao();
        $vendedorFormaPagamento = $ProdutoModel->getVendedorFormaPagamento();
        $vendedorObservacao = $ProdutoModel->getVendedorObservacao();

        $query = "insert into Boletos (boletoId, boletoNumeroDocumento, boletoNossoNumero, boletoSacado, boletoRemetido, boletoDataVencimento, boletoNumeroParcela, boletoValor, boletoProdutoId) values (null, '$produtoApartamento', '$produtoBox','$produtoValor', '$produtoDataVenda', '$produtoStatus', '$produtoParcelas', '$produtoParcelasPeriodicidade', '$produtoParcelasDataVencimento', '$produtoParcelasValorUnitario', '$produtoParcelasValorTotal', '$produtoParcelasAtualizacaoMonetaria', '$produtoParcelasFormaPagamento', '$produtoParcelasObservacoes', '$clienteId', '$vendedorId', '$vendedorDataVencimento', '$vendedorComissao', '$vendedorFormaPagamento', '$vendedorObservacao')";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no insert de insereObjeto: " . parent::getBdError());
            return false;
        }
    }

    public function alteraObjeto(Model $ProdutoModel) {
        $produtoId = $ProdutoModel->getProdutoId();
        $produtoStatus = $ProdutoModel->getProdutoStatus();

        $query = "update Produtos set produtoStatus = '{$produtoStatus}'"
                . " where produtoId = '{$produtoId}'";

        $query2 = "update Pagamentos set pagamentoStatusProduto = '{$produtoStatus}'"
                . " where produtoId = '{$produtoId}'";

        $resultado = parent::executaQuery($query);
        $resultado2 = parent::executaQuery($query2);

        if ($resultado && $resultado2) {
            return true;
        } else {
            parent::setMensagem("Erro no update de alteraObjeto: " . parent::getBdError());
            return false;
        }
    }

    public function excluiObjeto(Model $ProdutoModel) {
        $produtoId = $ProdutoModel->getProdutoId();

        $query = "delete from Produtos "
                . "where produtoId = {$produtoId}";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no delete de excluiObjeto: " . parent::getBdError());
            return false;
        }
    }

    public function excluiBoleto(Model $ProdutoModel) {
        
    }

}
