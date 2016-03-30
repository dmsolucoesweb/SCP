<?php

require_once 'ADO.php';
require_once 'PagamentoAdo.php';
require_once 'ProdutoAdo.php';

class IndiceAdo extends ADO {
    /* Função: consultaIdPelaData
     * Utilidade: Buscar o id do indice pela data para a função de adicionar indice aos produtos    * 
     */

    public function consultaIdPelaData($data) {
        $query = "select indiceId from Indices where indiceData = '{$data}'";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select do consultaIdPelaData: " . parent::getBdError());
            return false;
        }

        $cliente = parent::leTabelaBD();

        return $cliente['indiceId'];
    }

    /* Função: consultaHistoricoPeloId
     * Utilidade: Busca todos os atributos de Historicos_Indices para o relatário de Pagamentos.
     */

    public function consultaHistoricoPeloId($historicoIndiceId) {
        $query = "select * from Historicos_Indices where historicoInId = '{$historicoIndiceId}'";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaHistoricoPeloId: " . parent::getBdError());
            return false;
        }

        $historicoIndicesModel = null;
        $DatasEHoras = new DatasEHoras();

        while ($historicoIndice = parent::leTabelaBD()) {
            $indiceData = $DatasEHoras->getDataEHorasDesinvertidaComBarras($historicoIndice['historicoInIndiceData']);
            $historicoIndiceModel = array($historicoIndice['historicoInId'], $historicoIndice['historicoInPagamentoId'], $historicoIndice['historicoInIndiceInccValor'], $historicoIndice['historicoInIndiceIgpmValor'], $indiceData);
            $historicoIndicesModel[] = $historicoIndiceModel;
        }

        return $historicoIndicesModel;
    }

    public function consultaObjetoPeloId($id) {
        $query = "select * from Indices where indiceId = '{$id}' ";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaObjetoPeloId: " . parent::getBdError());
            return false;
        }
        $DatasEHoras = new DatasEHoras();

        $indice = parent::leTabelaBD();
        $indiceData = $DatasEHoras->getDataEHorasDesinvertidaComBarras($indice['indiceData']);
        return new IndiceModel($indice['indiceId'], $indice['indiceInccValor'], $indice['indiceIgpmValor'], $indiceData, $indice['usuarioId']);
    }

    public function consultaArrayDeObjeto() {
        $indiceModel = null;
        $query = "select * from Indices order by indiceData";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaArrayDeObjeto: " . parent::getBdError());
            return false;
        }

        $indicesModel = null;
        $DatasEHoras = new DatasEHoras();

        while ($indice = parent::leTabelaBD()) {
            $indiceData = $DatasEHoras->getDataEHorasDesinvertidaComBarras($indice['indiceData']);
            $indiceModel = new IndiceModel($indice['indiceId'], $indice['indiceInccValor'], $indice['indiceIgpmValor'], $indiceData, $indice['usuarioId']);
            $indicesModel[] = $indiceModel;
        }

        return $indicesModel;
    }

    public function insereObjeto(\Model $IndiceModel) {
        $indiceInccValor = $IndiceModel->getIndiceInccValor();
        $indiceIgpmValor = $IndiceModel->getIndiceIgpmValor();
        $indiceData = $IndiceModel->getIndiceData();
        $usuarioId = $IndiceModel->getUsuarioId();
        $incc = $indiceInccValor / 100;
        $igpm = ($indiceIgpmValor + 1) / 100;

        $month = substr($indiceData, 5, 2);
        $query = "select indiceData from Indices where Month(indiceData) = '{$month}' ";
        $resultado = parent::executaQuery($query);
        $indice = parent::leTabelaBD();

        if ($indice == null || $indice == false) {
            $query2 = "insert into Indices (indiceId, indiceInccValor, indiceIgpmValor, indiceData, usuarioId) values (null, '$incc', '$igpm', '$indiceData', '$usuarioId')";

            $resultado2 = parent::executaQuery($query2);
            if ($resultado2) {
                return true;
            } else {
                parent::setMensagem("Erro no insert de insereObjeto: " . parent::getBdError());
                return false;
            }
        } else {
            $indiceView = new IndiceView();
            $indiceView->adicionaMensagemErro("Um indice já foi adicionado neste mês!");
            return false;
        }
    }

    public function adicionaIndice($IndiceIncc, $IndiceIgpm, $indiceId, $indiceData) {
        $pagamentoAdo = new PagamentoAdo();
        $arrayDePagamentos = $pagamentoAdo->consultaArrayDeObjeto();
        $ValorParcelas = $ValorParcelasUnitarias = $parcelasIrreajustavel = $Irreajustavel = null;
        $ProdutoAdo = new ProdutoAdo();
        $CPF = new CPF();

        if (is_array($arrayDePagamentos)) {
            foreach ($arrayDePagamentos as $pagamentoModel) {
                $incc = $IndiceIncc / 100;
                $igpm = ($IndiceIgpm + 1) / 100;

                $pagamentoId = $pagamentoModel->getPagamentoId();
                $produtoId = $pagamentoModel->getProdutoId();
                $pagamentoStatusProduto = $pagamentoModel->getPagamentoStatusProduto();
                $Produto = $ProdutoAdo->consultaObjetoPeloId($produtoId);
                $pagamentoAtualizacaoMonetaria = $Produto->getProdutoParcelasAtualizacaoMonetaria();
                $pagamentoValorParcela = $pagamentoModel->getPagamentoValorParcela();
                $pagamentoValorParcelaUnitario = $pagamentoModel->getPagamentoValorParcelaUnitario();

                $arrayValorParcelas = explode(";", $pagamentoValorParcela);
                $arrayValorParcelasUnitario = explode(";", $pagamentoValorParcelaUnitario);
                $arrayAtualizacaoMonetaria = explode(";", $pagamentoAtualizacaoMonetaria);
                $ultimo = count($arrayValorParcelas);
                $ultimo--;

                $CPF = new CPF();
                $ultimaPP = end($arrayValorParcelas);
                $ultimaPPU = end($arrayValorParcelasUnitario);
                $ultimaPosicaoParcelas = $CPF->retiraMascaraRenda($ultimaPP);
                $ultimaPosicaoParcelasUnitarias = $CPF->retiraMascaraRenda($ultimaPPU);

                for ($i = 0; $i < $ultimo; $i++) {
                    if ($i == $ultimo) {
                        $ValorParcelas .= $arrayValorParcelas[$i];
                        $ValorParcelasUnitarias .= $arrayValorParcelasUnitario[$i];
                    } else {
                        $ValorParcelas .= $arrayValorParcelas[$i] . ";";
                        $ValorParcelasUnitarias .= $arrayValorParcelasUnitario[$i] . ";";
                    }

                    $atualizacaoMonetaria = $arrayAtualizacaoMonetaria[$i];

                    if ($atualizacaoMonetaria == 2) {
                        $vP = $arrayValorParcelas[$i];
                        $ValorParcelaSemMascara = $CPF->retiraMascaraRenda($vP);
                        $parcelasIrreajustavel += $ValorParcelaSemMascara;
                    }
                }

                if ($pagamentoStatusProduto == 1) {
                    $ValorExcedidoAux = (($parcelasIrreajustavel + $ultimaPosicaoParcelas) * $incc);
                    $valorExcedido = $ultimaPosicaoParcelas + $ValorExcedidoAux;
                    $valorExcedido2 = $ultimaPosicaoParcelasUnitarias + $ValorExcedidoAux;
                    $ValorIndice = number_format($valorExcedido, 2, ",", ".");
                    $ValorIndice2 = number_format($valorExcedido2, 2, ",", ".");
                    $igpm = null;
                } else {
                    $ValorExcedidoAux = (($parcelasIrreajustavel + $ultimaPosicaoParcelas) * $igpm);
                    $valorExcedido = $ultimaPosicaoParcelas + $ValorExcedidoAux;
                    $valorExcedido2 = $ultimaPosicaoParcelasUnitarias + $ValorExcedidoAux;
                    $ValorIndice = number_format($valorExcedido, 2, ",", ".");
                    $ValorIndice2 = number_format($valorExcedido2, 2, ",", ".");
                    $incc = null;
                }

                $VP = $ValorParcelas . $ValorIndice;
                $VPU = $ValorParcelasUnitarias . $ValorIndice2;

                $query = "update Pagamentos set pagamentoValorParcela = '{$VP}',"
                        . " pagamentoValorParcelaUnitario = '{$VPU}'"
                        . " where pagamentoId = '{$pagamentoId}'";

                $query2 = "insert into Historicos_Indices (historicoInId, historicoInPagamentoId, historicoInIndiceId, historicoInIndiceInccValor, historicoInIndiceIgpmValor, historicoInIndiceData) values (null, '$pagamentoId', '$indiceId', '$incc', '$igpm', '$indiceData')";
                $ValorParcelas = $ValorParcelasUnitarias = $parcelasIrreajustavel = null;

                $resultado = parent::executaQuery($query);
                $resultado2 = parent::executaQuery($query2);
            }
        }

        if ($resultado && $resultado2) {
            return true;
        } else {
            parent::setMensagem("Erro no update do adicionaIndice: " . parent::getBdError());
            return false;
        }
    }

    public function alteraObjeto(\Model $IndiceModel) {
        
    }

    public function excluiObjeto(\Model $IndiceModel) {
        $indiceId = $IndiceModel->getIndiceId();
        $query = "delete from Indices "
                . "where indiceId = {$indiceId}";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no delete de excluiObjeto: " . parent::getBdError());
            return false;
        }
    }

}
