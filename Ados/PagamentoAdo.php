<?php

require_once 'ADO.php';
require_once '../Models/PagamentoModel.php';

class PagamentoAdo extends ADO {
    /* Função: consultaProdutoPeloApartamento
     * Utitlizado: Ele é utilizado para cadastrar um pagamento automaticamente junto ao cadastro do Produto
     */

    public function consultaProdutoPeloApartamento($produtoApartamento) {
        $query = "select produtoId from Produtos where produtoApartamento = '{$produtoApartamento}'";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaProdutoPeloApartamento: " . parent::getBdError());
            return false;
        }

        $produto = parent::leTabelaBD();

        return $produto['produtoId'];
    }

    /* Função: consultaIdPeloProduto
     * Utilidade: Buscar o id do produto para cadastrar um historico_indice automaticamente junto ao cadastro do indice
     */

    public function consultaIdPeloProduto($produtoId) {
        $query = "select pagamentoId from Pagamentos where produtoId = '{$produtoId}'";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaIdPeloProduto: " . parent::getBdError());
            return false;
        }

        $produto = parent::leTabelaBD();

        return $produto['pagamentoId'];
    }

    /* Função: consultaGeralHistorico
     * Utilidade: Utilizada para criar um tabela com o sql "UNION" para o relatorio de pagamentos
     */

    public function consultaGeralHistorico($pagamentoId) {
        $query = "select historicoPgId as 'Id', historicoPgPagamentoData as 'Data', historicoPgPagamentoValorParcela as 'pagamentoValorParcela/INCC', historicoPgPagamentoValorParcelaUnitario as 'pagamentoValorParcelaUnitario/IGPM' from Historicos_Pagamentos where historicoPgPagamentoId = '{$pagamentoId}' UNION ALL SELECT historicoInId, historicoInIndiceData, historicoInIndiceInccValor, historicoInIndiceIgpmValor from Historicos_Indices order by Data";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaGeralHistorico: " . parent::getBdError());
            return false;
        }

        $pagamentosModel = null;

        while ($pagamento = parent::leTabelaBD()) {
            $pagamentoModel = array($pagamento['Id'], $pagamento['Data'], $pagamento['pagamentoValorParcela/INCC'], $pagamento['pagamentoValorParcelaUnitario/IGPM']);
            $pagamentosModel[] = $pagamentoModel;
        }

        return $pagamentosModel;
    }

    public function consultaObjetoPeloId($id) {
        $query = "select * from Pagamentos where pagamentoId = '{$id}' ";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaObjetoPeloId: " . parent::getBdError());
            return false;
        }
        $DatasEHoras = new DatasEHoras();

        $pagamento = parent::leTabelaBD();
        $pagamentoData = $DatasEHoras->getDataEHorasDesinvertidaComBarras($pagamento['pagamentoData']);
        return new PagamentoModel($pagamento['pagamentoId'], $pagamento['clienteId'], $pagamento['produtoId'], $pagamento['pagamentoStatusProduto'], $pagamento['pagamentoValorTotal'], $pagamento['pagamentoParcela'], $pagamento['pagamentoValorParcela'], $pagamento['pagamentoValorParcelaUnitario'], $pagamentoData, $pagamento['pagamentoValor']);
    }

    public function consultaHistoricoPagamentoPorData($historicoPgId) {
        $PagamentoModel = null;
        $query = "select * from Historicos_Pagamentos where historicoPgId = '{$historicoPgId}' ORDER BY historicoPgPagamentoData";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaHistoricoPagamentoPorData: " . parent::getBdError());
            return false;
        }

        $PagamentosModel = null;
        $DatasEHoras = new DatasEHoras();

        while ($pagamento = parent::leTabelaBD()) {
            $pagamentoData = $DatasEHoras->getDataEHorasDesinvertidaComBarras($pagamento['historicoPgPagamentoData']);
            $PagamentoModel = array($pagamento['historicoPgId'], $pagamento['historicoPgClienteId'], $pagamento['historicoPgProdutoId'], $pagamento['historicoPgPagamentoStatusProduto'], $pagamento['historicoPgPagamentoValorTotal'], $pagamento['historicoPgPagamentoParcela'], $pagamento['historicoPgPagamentoValorParcela'], $pagamento['historicoPgPagamentoValorParcelaUnitario'], $pagamentoData, $pagamento['historicoPgPagamentoValor']);
            $PagamentosModel[] = $PagamentoModel;
        }

        return $PagamentosModel;
    }

    public function consultaArrayDeObjeto() {
        $pagamentoModel = null;
        $query = "select * from Pagamentos";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaArrayDeObjeto: " . parent::getBdError());
            return false;
        }

        $pagamentosModel = null;
        $DatasEHoras = new DatasEHoras();

        while ($pagamento = parent::leTabelaBD()) {
            $pagamentoData = $DatasEHoras->getDataEHorasDesinvertidaComBarras($pagamento['pagamentoData']);
            $pagamentoModel = new PagamentoModel($pagamento['pagamentoId'], $pagamento['clienteId'], $pagamento['produtoId'], $pagamento['pagamentoStatusProduto'], $pagamento['pagamentoValorTotal'], $pagamento['pagamentoParcela'], $pagamento['pagamentoValorParcela'], $pagamento['pagamentoValorParcelaUnitario'], $pagamentoData, $pagamento['pagamentoValor']);
            $pagamentosModel[] = $pagamentoModel;
        }

        return $pagamentosModel;
    }

    /*
     * Nome do Método: inserePagamento
     * Função: Cadastrar o Pagamento
     * Utitlizado: Ele é utilizado para cadastrar o Pagamento automaticamente quando cadastra um Produto
     */

    public function inserePagamento($cliId, $prodId, $pagStatusProd, $prodValor, $prodParcelas, $prodValorParcelas, $prodValorTotalParcelas) {
        $clienteId = $cliId;
        $produtoId = $prodId;
        $pagamentoStatusProduto = $pagStatusProd;
        $produtoValor = $prodValor;
        $produtoParcelas = $prodParcelas . ";1";
        $produtoValorParcela = $prodValorTotalParcelas . ";0";
        $produtoValorParcelaUnitario = $prodValorParcelas . ";0";

        $query = "insert into Pagamentos (pagamentoId, clienteId, produtoId, pagamentoStatusProduto, pagamentoValorTotal, pagamentoParcela, pagamentoValorParcela, pagamentoValorParcelaUnitario, pagamentoData, pagamentoValor) values (null, '$clienteId', '$produtoId', '$pagamentoStatusProduto', '$produtoValor', '$produtoParcelas', '$produtoValorParcela', '$produtoValorParcelaUnitario', null, null)";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no insert de inserePagamento: " . parent::getBdError());
            return false;
        }
    }

    /*
     * Nome do Método: insereHistoricoDePagamento
     * Função: Cadastrar o Historico do Pagamento cada vez que o Pagamento é alterado
     * Utitlizado: Ele é utilizado para cadastrar o Historico do Pagamento
     */

    public function insereHistoricoDePagamento($PagamentoModel) {
        $clienteId = $PagamentoModel->getClienteId();
        $produtoId = $PagamentoModel->getProdutoId();
        $pagamentoStatusProduto = $PagamentoModel->getPagamentoStatusProduto();
        $pagamentoValorTotal = $PagamentoModel->getPagamentoValorTotal();
        $pagamentoParcela = $PagamentoModel->getPagamentoParcela();
        $pagamentoValorParcela = $PagamentoModel->getPagamentoValorParcela();
        $pagamentoValorParcelaUnitario = $PagamentoModel->getPagamentoValorParcelaUnitario();
        $pagamentoData = $PagamentoModel->getPagamentoData();
        $pagamentoValor = $PagamentoModel->getPagamentoValor();
        $pagamentoId = $PagamentoModel->getPagamentoId();

        $query = "insert into Historicos_Pagamentos (historicoPgId, historicoPgClienteId, historicoPgProdutoId, historicoPgPagamentoStatusProduto, historicoPgPagamentoValorTotal, historicoPgPagamentoParcela, historicoPgPagamentoValorParcela, historicoPgPagamentoValorParcelaUnitario, historicoPgPagamentoData, historicoPgPagamentoValor, historicoPgPagamentoId) values (null, '$clienteId', '$produtoId', '$pagamentoStatusProduto', '$pagamentoValorTotal', '$pagamentoParcela', '$pagamentoValorParcela', '$pagamentoValorParcelaUnitario', '$pagamentoData', '$pagamentoValor', '$pagamentoId')";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no insert do insereHistoricoDePagamento: " . parent::getBdError());
            return false;
        }
    }

    public function alteraPagamento(Model $PagamentoModel, $PagamentoModelBanco) {
        $pagamentoId = $PagamentoModel->getPagamentoId();
        $clienteId = $PagamentoModel->getClienteId();
        $produtoId = $PagamentoModel->getProdutoId();
        $pagamentoParcela = $PagamentoModelBanco->getPagamentoParcela();
        $pagamentoValorParcela = $PagamentoModelBanco->getPagamentoValorParcela();
        $pagamentoValorParcelaUnitario = $PagamentoModelBanco->getPagamentoValorParcelaUnitario();
        $pagamentoValor = $PagamentoModel->getPagamentoValor();
        $CPF = new CPF();

        if ($pagamentoId != '-1' && $pagamentoId != NULL) {
            $arrayParcelas = explode(";", $pagamentoParcela);
            $arrayValorParcelas = explode(";", $pagamentoValorParcela);
            $arrayValorParcelasUnitario = explode(";", $pagamentoValorParcelaUnitario);
            $ultimo = count($arrayParcelas);

            for ($i = 0; $i < $ultimo;) {
                $Parcelas = $arrayParcelas[$i];
                $ValorParcelas = $arrayValorParcelas[$i];
                $ValorParcelasUnitario = $arrayValorParcelasUnitario[$i];

                $pagamentoParcela = $Parcelas;
                $pagValorParcela = $ValorParcelas;
                $pagamentoValorParcela = $CPF->retiraMascaraRenda($pagValorParcela);
                $pagValorUnitario = $ValorParcelasUnitario;
                $pagamentoValorParcelaUnitario = $CPF->retiraMascaraRenda($pagValorUnitario);

                if ($ValorParcelas == 0) {
                    $i++;
                } else {
                    $ValorParcelasTotal = $pagamentoValorParcela - $pagamentoValor;
                    $ParcelasAux = $pagamentoValor / $pagamentoValorParcelaUnitario;
                    $Parcela = $pagamentoParcela - $ParcelasAux;

                    $ValorUnitario = number_format($pagamentoValorParcelaUnitario, 2, ",", ".");
                    $ValorTotal = number_format($ValorParcelasTotal, 2, ",", ".");

                    if ($ValorTotal == 0) {
                        $ValorUnitario = 0;
                    }

                    for ($i++; $i <= $ultimo; $i++) {
                        $Parcelas = $arrayParcelas[$i];
                        $ValorParcelas = $arrayValorParcelas[$i];
                        $ValorParcelasUnitario = $arrayValorParcelasUnitario[$i];

                        if ($i == $ultimo) {
                            $Parcela .= $Parcelas;
                            $ValorTotal .= $ValorParcelas;
                            $ValorUnitario .= $ValorParcelasUnitario;
                        } else {
                            $Parcela .= ";" . $Parcelas;
                            $ValorTotal .= ";" . $ValorParcelas;
                            $ValorUnitario .= ";" . $ValorParcelasUnitario;
                        }
                    }

                    $query = "update Pagamentos set clienteId = '{$clienteId}',"
                            . " produtoId = '{$produtoId}',"
                            . " pagamentoParcela = '{$Parcela}',"
                            . " pagamentoValorParcela = '{$ValorTotal}',"
                            . " pagamentoValorParcelaUnitario = '{$ValorUnitario}',"
                            . " pagamentoValor = null"
                            . " where pagamentoId = '{$pagamentoId}'";

                    $resultado = parent::executaQuery($query);
                    if ($resultado) {
                        return true;
                    } else {
                        parent::setMensagem("Erro no update do alteraPagamento: " . parent::getBdError());
                        return false;
                    }

                    break;
                }
            }
        }
    }

    public function excluiPagamento($id) {

        if ($id == null) {
            return true;
        }

        $query = "delete from Pagamentos where produtoId = {$id}";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no delete de excluiPagamento: " . parent::getBdError());
            return false;
        }
    }

    public function excluiHistorico($produtoId, $pagamentoId) {

        if ($produtoId == null && $pagamentoId == null) {
            return true;
        }

        $query = "delete from Historicos_Pagamentos "
                . "where historicoPgProdutoId = {$produtoId}";

        $query2 = "delete from Historicos_Indices "
                . "where historicoInPagamentoId = {$pagamentoId}";

        $resultado = parent::executaQuery($query);
        $resultado2 = parent::executaQuery($query2);


        if ($resultado && $resultado2) {
            return true;
        } else {
            parent::setMensagem("Erro no delete de excluiHistorico: " . parent::getBdError());
            return false;
        }
    }

    public function excluiObjeto(\Model $objetoModelo) {
        
    }

    public function insereObjeto(\Model $objetoModelo) {
        
    }

    public function alteraObjeto(\Model $objetoModelo) {
        
    }

}
