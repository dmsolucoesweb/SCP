<?php

require_once 'ADO.php';
require_once 'PagamentoAdo.php';
require_once 'ProdutoAdo.php';
require_once '../Classes/datasehoras.php';

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
        $PagamentoAdo = new PagamentoAdo();
        $arrayDePagamentos = $PagamentoAdo->consultaArrayDeObjeto();
        $valorParcelas = $ValorParcelasUnitarias = $parcelasIrreajustavel = $Irreajustavel = null;
        $ProdutoAdo = new ProdutoAdo();
        $CPF = new CPF();
        $DateTime = new DateTime();
        $DatasEHoras = new DatasEHoras();
                // Cria uma função que retorna o timestamp de uma data no formato AAAA-MM-DD
    function geraTimestamp($data = NULL) {
        $partes = explode('-', $data);
        return mktime(0, 0, 0, $partes['1'], $partes['2'], $partes['0']);
    }

    // Calcula a diferença entre duas datas
    function diferenca_datas($data1 = NULL, $data2 = NULL) {
    // Usa a função criada e pega o timestamp das duas datas:
        $time_inicial = geraTimestamp($data1);
        $time_final = geraTimestamp($data2);
    // Calcula a diferença de segundos entre as duas datas:
        $diferenca = $time_final - $time_inicial; 
    // Calcula a diferença de dias
        $dias = (int)floor($diferenca/(60 * 60 * 24)); 
        return $dias;
    }
        
        if (is_array($arrayDePagamentos)) {
            foreach ($arrayDePagamentos as $PagamentoModel) {
                $incc = $IndiceIncc / 100;
                $igpm = ($IndiceIgpm + 1) / 100;

                $pagamentoId = $PagamentoModel->getPagamentoId();
                $produtoId = $PagamentoModel->getProdutoId();
                $Produto = $ProdutoAdo->consultaObjetoPeloId($produtoId);
                $produtoDataVenda = $Produto->getProdutoDataVenda();
                $pagamentoStatusProduto = $PagamentoModel->getPagamentoStatusProduto();
                $pagamentoAtualizacaoMonetaria = $Produto->getProdutoParcelasAtualizacaoMonetaria();
                $pagamentoValorParcela = $PagamentoModel->getPagamentoValorParcela();
                $pagamentoValorParcelaUnitario = $PagamentoModel->getPagamentoValorParcelaUnitario();

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
                        $valorParcelas .= $arrayValorParcelas[$i];
                        $ValorParcelasUnitarias .= $arrayValorParcelasUnitario[$i];
                    } else {
                        $valorParcelas .= $arrayValorParcelas[$i] . ";";
                        $ValorParcelasUnitarias .= $arrayValorParcelasUnitario[$i] . ";";
                    }

                    $atualizacaoMonetaria = $arrayAtualizacaoMonetaria[$i];

                    if ($atualizacaoMonetaria == 2) {
                        $vP = $arrayValorParcelas[$i];
                        $ValorParcelaSemMascara = $CPF->retiraMascaraRenda($vP);
                        $parcelasIrreajustavel += $ValorParcelaSemMascara;
                    }
                }

                $data1 = $DatasEHoras->getDataEHorasInvertidaComTracos($produtoDataVenda);
                $data2 = $indiceData;
                $intervaloData = diferenca_datas($data1, $data2);
                if ($data1 > $data2) { var_dump($intervaloData.'teste');} 
                else { var_dump('teste'.$intervaloData);
                if ($intervaloData < 30) {
                    $incc = ($incc / 30) * $intervaloData;
                    $igpm = ($igpm / 30) * $intervaloData;

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
                } else {
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
                }

                $VP = $valorParcelas . $ValorIndice;
                $VPU = $ValorParcelasUnitarias . $ValorIndice2;

                $query = "update Pagamentos set pagamentoValorParcela = '{$VP}',"
                        . " pagamentoValorParcelaUnitario = '{$VPU}'"
                        . " where pagamentoId = '{$pagamentoId}'";

                $query2 = "insert into Historicos_Indices(historicoInId, historicoInPagamentoId, historicoInIndiceId, historicoInIndiceInccValor, historicoInIndiceIgpmValor, historicoInIndiceData) values (null, '$pagamentoId', '$indiceId', '$incc', '$igpm', '$indiceData')";
                $valorParcelas = $ValorParcelasUnitarias = $parcelasIrreajustavel = null;

                $resultado = parent::executaQuery($query);
                $resultado2 = parent::executaQuery($query2);
            }
        }
        }

        if ($resultado && $resultado2) {
            return true;
        } else {
            parent::setMensagem("Erro no insert do adicionaIndice: " . parent::getBdError());
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

    public function excluiIndicePorSeguranca($indiceId) {
        $query = "delete from Indices "
                . "where indiceId = {$indiceId}";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no delete de excluiIndicePorSeguranca: " . parent::getBdError());
            return false;
        }
    }

}
