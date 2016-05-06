<?php

ini_set("memory_limit", "-1");
define('MPDF_PATH', 'class/mpdf/');
require_once 'mpdf/mpdf.php';
require_once '../Ados/ClienteAdo.php';
require_once '../Ados/ProdutoAdo.php';
require_once '../Ados/IndiceAdo.php';
require_once '../Ados/PagamentoAdo.php';

class RelatorioPagamentos {

    function EmitirRelatorioPagamentos() {
        $mpdf = new mPDF('pt', 'A4', 0, 'arial', 20, 20, 35, 20, 9, 9, 'P');
        $stylesheet = file_get_contents('../PDF/pdf_sistema.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->debug = true;
        $mpdf->simpleTables = true;
        $mpdf->useSubstitutions = false;
        $mpdf->SetHTMLHeader('<table class="header"><tbody><tr><td rowspan="3" class="logo"><img src="../IMG/logo89x50.png" /></td><td class="nopad_top">PARK VILLE INCORPORAÇÃO SPE LTDA - 23.501.469/0001-00</td></tr><tr><td class="nopad_top">Rua Francisco Soyer, nº 714, Centro, Inhumas/GO</td></tr><tr><td class="nopad_top"></td></tr><tr><td class="titulo_relatorio center" colspan="2">Demonstrativo de pagamentos</td></tr></tbody></table>');
        $Html1 = "<table class='proposta center'><thead><tr><td class='secao'>Apartamento</td>"
                . "<td class='secao'>Data da Venda</td>"
                . "<td class='secao'>Cliente</td>"
                . "<td class='secao'>Valor da Venda (R$)</td>"
                . "<td class='secao'>Recebidos (R$)</td>"
                . "<td class='secao'>Atualização monetária (R$)</td>"
                . "<td class='secao'>A Receber (R$)</td>"
                . "</tr></thead><tbody>";

        $pagamentoAdo = new PagamentoAdo();
        $CPF = new CPF();
        $ClienteAdo = new ClienteAdo();
        $ProdutoAdo = new ProdutoAdo();

        $arrayDePagamentos = $pagamentoAdo->consultaArrayDeObjeto();

        if (is_array($arrayDePagamentos)) {
            foreach ($arrayDePagamentos as $pagamentoModel) {

                $clienteId = $pagamentoModel->getClienteId();
                $Cliente = $ClienteAdo->consultaObjetoPeloId($clienteId);
                $clienteNome = $Cliente->getClienteNome();
                $produtoId = $pagamentoModel->getProdutoId();
                $Produto = $ProdutoAdo->consultaObjetoPeloId($produtoId);
                $produtoApartamento = $Produto->getProdutoApartamento();
                $produtoDataVenda = $Produto->getProdutoData;
                $pagamentoValorTotal = $pagamentoModel->getPagamentoValorTotal();
                $pagamentoValorParcela = $pagamentoModel->getPagamentoValorParcela();
                $arrayValorParcelas = explode(";", $pagamentoValorParcela);
                $ultimo = count($arrayValorParcelas);
                $ultimo--;

                for ($i = 0; $i < $ultimo; $i++) {
                    $ValorParcelas = $CPF->retiraMascaraRenda($arrayValorParcelas[$i]);
                    $HistPagamento += $ValorParcelas;
                }

                $Recebidos = $pagamentoValorTotal - $HistPagamento;
                $TotalIndice = $CPF->retiraMascaraRenda($arrayValorParcelas[$ultimo]);
                $TotalReceber = $TotalIndice - ($Recebidos - $pagamentoValorTotal);
                $T_vendas += $pagamentoValorTotal;
                $T_Pagtos += $Recebidos;
                $T_AReceber += $TotalReceber;
                $T_indices += $TotalIndice;
                $Html1 .= "<tr class='center'><td>$produtoApartamento</td><td>$produtoDataVenda</td><td>$clienteNome</td><td>" . number_format($pagamentoValorTotal, 2, ',', '.') . "</td><td>" . number_format($Recebidos, 2, ',', '.') . "</td><td>" . number_format($TotalIndice, 2, ',', '.') . "</td><td>" . number_format($TotalReceber, 2, ',', '.') . "</td></tr>";
                $HistPagamento = $TotalReceber = null;
            }
            $Html1 .= "<tr class='center'><td class='secao' colspan='3'>TOTAL GERAL</td><td>" . number_format($T_vendas, 2, ',', '.') . "</td><td>" . number_format($T_Pagtos, 2, ',', '.') . "</td><td>" . number_format($T_indices, 2, ',', '.') . "</td><td>" . number_format($T_AReceber, 2, ',', '.') . "</td></tr>";
            $Html1 .= "</tbody></table>";
        }

        $mpdf->WriteHTML($Html1);
        $arquivo = date("d-m-Y") . "-pagamentos.pdf";

        $mpdf->Output($arquivo, "I");
        exit();
    }

    function EmitirRelatorioPagamento($pagamentoId) {
        $mpdf = new mPDF('pt', 'A4', 0, 'arial', 20, 20, 35, 20, 9, 9, 'P');
        $stylesheet = file_get_contents('../PDF/pdf_sistema.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->debug = true;
        $mpdf->simpleTables = true;
        $mpdf->useSubstitutions = false;
        $mpdf->SetHTMLHeader('<table class="header"><tbody><tr><td rowspan="3" class="logo"><img src="../IMG/logo89x50.png" /></td><td class="nopad_top">PARK VILLE INCORPORAÇÃO SPE LTDA - 23.501.469/0001-00</td></tr><tr><td class="nopad_top">Rua Francisco Soyer, nº 714, Centro, Inhumas/GO</td></tr><tr><td class="nopad_top"></td></tr><tr><td class="titulo_relatorio center" colspan="2">Extrato do Cliente</td></tr></tbody></table>'); 
        
        $PagamentoAdo = new PagamentoAdo();
        $CPF = new CPF();
        $ClienteAdo = new ClienteAdo();
        $ProdutoAdo = new ProdutoAdo();
        $IndiceAdo = new IndiceAdo();

        $pagamentoModel = $PagamentoAdo->consultaObjetoPeloId($pagamentoId);

        $clienteId = $pagamentoModel->getClienteId();
        $clienteModel = $ClienteAdo->consultaObjetoPeloId($clienteId);
        $nomeCliente = $clienteModel->getClienteNome();
        $produtoId = $pagamentoModel->getProdutoId();
        $produtoModel = $ProdutoAdo->consultaObjetoPeloId($produtoId);
        $numeroApto = $produtoModel->getProdutoApartamento();
        $Html1 = "<div>Cliente: $nomeCliente<br/>Apto: $numeroApto <br /><br /></div>"
                . "<table class='proposta center'><thead><tr>"
                . "<td class='secao'>Data</td>"
                . "<td class='secao'>Descrição</td>"
                . "<td class='secao'>Entradas (R$)</td>"
                . "<td class='secao'>Saídas (R$)</td>"
                . "<td class='secao'>Saldo (R$)</td>"
                . "</tr></thead><tbody>";
        $pagamentoStatusProduto = $pagamentoModel->getPagamentoStatusProduto();
        $pagamentoValorTotal = $pagamentoModel->getPagamentoValorTotal();
        $pagamentoParcela = $pagamentoModel->getPagamentoParcela();
        $pagamentoValorParcela = $pagamentoModel->getPagamentoValorParcela();
        $pagamentoValorParcelaUnitario = $pagamentoModel->getPagamentoValorParcelaUnitario();
        $pagamentoData = $pagamentoModel->getPagamentoData();
        $pagamentoValor = $pagamentoModel->getPagamentoValor();
        $pagamentoId = $pagamentoModel->getPagamentoId();
        $Pagamento = $PagamentoAdo->consultaObjetoPeloId($pagamentoId);

        $pagamentoValorRestante = null;
        $pagamentoValorRestante = $Pagamento->getPagamentoValorTotal();
        $arrayGeral = $PagamentoAdo->consultaGeralHistorico($pagamentoId);

        if (is_array($arrayGeral)) {
            foreach ($arrayGeral as $historicoGeral) {
                $id = $historicoGeral['0'];
                // $pagamentoId = $historicoGeral['1'];
                $pagamentoValorTotalIncc = $historicoGeral['2'];
                $pagamentoValorUnitarioIgpm = $historicoGeral['3'];
                $Data = $historicoGeral['1'];

                $timestamp = strtotime($Data);
                $mes = date('M', $timestamp);
                $ano = date('Y', $timestamp);
                $mess = array("Jan" => "JANEIRO", "Feb" => "FEVEREIRO", "Mar" => "MARÇO", "Apr" => "ABRIL", "May" => "MAIO", "Jun" => "JUNHO", "Jul" => "JULHO", "Aug" => "AGOSTO", "Nov" => "NOVEMBRO", "Sep" => "SETEMBRO", "Oct" => "OUTUBRO", "Dec" => "DEZEMBRO");

                if ($pagamentoValorRestante > 0) {
                    $saldo = number_format($pagamentoValorRestante, 2, ',', '.') . ' (D)';
                } else {
                    $saldo = number_format($pagamentoValorRestante, 2, ',', '.') . ' (C)';
                }

                if ($mes != $mesAtual) {
                    $Html1 .= "<tr><td colspan='4' class='titulo'>MÊS DE $mess[$mes] DE $ano</td><td class='titulo'>$saldo</td></tr>";
                    $mesAtual = $mes;
                }

                if ($pagamentoValorTotalIncc == 0 || $pagamentoValorUnitarioIgpm == 0) {
                    $arrayDeIndices = $IndiceAdo->consultaHistoricoPeloId($id);

                    foreach ($arrayDeIndices as $indice) {
                        $indiceId = $indice['0'];
                        $indiceInccValor = $indice['2'];
                        $indiceIgpmValor = $indice['3'];
                        $indiceData = $indice['4'];
                       // $usuarioId = $indice['4'];

                        if ($indiceInccValor != null) {
                            $indiceValor = $pagamentoValorRestante * $indiceInccValor;
                            $indicep = number_format($indiceInccValor, 4, '.', ',');
                            $indice = "INCC";
                        } else {
                            $indiceValor = $pagamentoValorRestante * $indiceIgpmValor;
                            $indicep = number_format($indiceIgpmValor, 4, '.', ',');
                            $indice = "IGP-M +1";
                        }

                        $indiceValor = round($indiceValor, 2);
                        $pagamentoValorRestante += $indiceValor;

                        if ($pagamentoValorRestante > 0) {
                            $saldo = number_format($pagamentoValorRestante, 2, ',', '.') . ' (D)';
                        } else {
                            $saldo = number_format($pagamentoValorRestante, 2, ',', '.') . ' (C)';
                        }

                        $Html1 .= "<tr><td>$indiceData</td>"
                                . "<td>ATUALIZAÇÃO MONETÁRIA ($indice: $indicep)</td>"
                                . "<td>-</td>"
                                . "<td>" . number_format($indiceValor, 2, ',', '.') . " (D)</td>"
                                . "<td>$saldo</td></tr>";

                        $indiceValor = null;

                        break;
                    }
                } else {
                    $arrayDePagamentos = $PagamentoAdo->consultaHistoricoPagamentoPorData($id);

                    foreach ($arrayDePagamentos as $pagamento) {
                        $historicoPagamentoId = $pagamento['0'];
                        $clienteId = $pagamento['1'];
                        $Cliente = $ClienteAdo->consultaObjetoPeloId($clienteId);
                        $clienteNome = $Cliente->getClienteNome();
                        $produtoId = $pagamento['2'];
                        $Produto = $ProdutoAdo->consultaObjetoPeloId($produtoId);
                        $produtoApartamento = $Produto->getProdutoApartamento();
                        $pagamentoValorTotal = $pagamento['4'];
                        $pagamentoParcela = $pagamento['5'];
                        $pagamentoValorParcela = $pagamento['6'];
                        $pagamentoValorParcelaUnitario = $pagamento['7'];
                        $pagamentoData = $pagamento['8'];
                        $pagamentoValor = $pagamento['9'];

                        $pagamentoValorRestante -= $pagamentoValor;
                        if ($pagamentoValorRestante > 0) {
                            $saldo = number_format($pagamentoValorRestante, 2, ',', '.') . ' (D)';
                        } else {
                            $saldo = number_format($pagamentoValorRestante, 2, ',', '.') . ' (C)';
                        }
                        $Html1 .= "<tr><td>$pagamentoData</td>"
                                . "<td>PAGAMENTO PARCELA</td>"
                                . "<td>" . number_format($pagamentoValor, 2, ',', '.') . " (C)</td>"
                                . "<td>-</td>"
                                . "<td>$saldo</td></tr>";
                        break;
                    }
                }
            }
        }

        $Html1 .= "</tbody></table>"
                . "<div style='font-size: 5pt;'>* Alguns valores de índices foram calculados proporcionalmente, por isso, diferem do valor do índice oficial.</div>";
        $mpdf->WriteHTML($Html1);
        $arquivo = date("d-m-Y") . "-extrato.pdf";
        //$mpdf->debug = true;
        $mpdf->Output($arquivo, "I");
        exit();
    }

}
