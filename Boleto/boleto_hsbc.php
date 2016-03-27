<?php

// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto HSBC: Bruno Leonardo M. F. Gonçalves          |
// +----------------------------------------------------------------------+
// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//
// DADOS DO BOLETO PARA O SEU CLIENTE
$PagamentoAdo = new PagamentoAdo();
$ClienteAdo = new ClienteAdo();
$arrayDePagamentos = $PagamentoAdo->consultaArrayDeObjeto();

if (is_array($arrayDePagamentos)) {
    foreach ($arrayDePagamentos as $pagamentoModel) {
        $clienteId = $pagamentoModel->getClienteId();

        $ClienteModel = $ClienteAdo->consultaObjetoPeloId($clienteId);

        $clienteNome = $ClienteModel->getClienteNome();
        $clienteEndereco = $ClienteModel->getClienteEndereco();
        $produtoId = $pagamentoModel->getProdutoId();
        $pagamentoStatusProduto = $pagamentoModel->getPagamentoStatusProduto();
        $pagamentoValorTotal = $pagamentoModel->getPagamentoValorTotal();
        $pagamentoParcela = $pagamentoModel->getPagamentoParcela();
        $pagamentoValorParcela = $pagamentoModel->getPagamentoValorParcela();
        $pagamentoValorParcelaUnitario = $pagamentoModel->getPagamentoValorParcelaUnitario();
        $pagamentoData = $pagamentoModel->getPagamentoData();
        $pagamentoValor = $pagamentoModel->getPagamentoValor();
        $pagamentoId = $pagamentoModel->getPagamentoId();

        $arrayParcelas = explode(";", $pagamentoParcela);
        $arrayValorParcelas = explode(";", $pagamentoValorParcela);
        $arrayValorParcelasUnitario = explode(";", $pagamentoValorParcelaUnitario);
        $ultimo = count($arrayParcelas);
        $ultimo--;

        for ($i = 0; $i < $ultimo; $i++) {
            $Parcelas = $arrayParcelas[$i];
            $ValorParcelas = $arrayValorParcelas[$i];
            $ValorParcelasUnitario = $arrayValorParcelasUnitario[$i];

            for ($j = 0; $j < $Parcelas; $i++) {
                $dias_de_prazo_para_pagamento = 5;
                $taxa_boleto = 2.95;
                //$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
                $data_venc = $pagamentoData + ($dias_de_prazo_para_pagamento * 86400);
                $valor_cobrado = $ValorParcelasUnitario; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
                //$valor_cobrado = str_replace(",", ".", $valor_cobrado);
                $valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

                $dadosboleto["numero_documento"] = "12345678"; // Número do documento - REGRA: Máximo de 13 digitos
                $dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA

                if ($i == 1) {
                    //Não faz nada    
                } else {
                    $dadosboleto["data_vencimento"] = strtotime("+1 month", $data_venc);
                }

                $dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
                $dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
                $dadosboleto["valor_boleto"] = $valor_boleto;  // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

                $dadosboleto["sacado"] = $clienteNome;
                $dadosboleto["endereco1"] = $clienteEndereco['clienteEndereco'];
                $dadosboleto["endereco2"] = $clienteEndereco['clienteCidade'] . '-' . $clienteEndereco['clienteEstado'] . '-' . $clienteEndereco['clienteCEP'];

                $dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Nonononono";
                $dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ " . number_format($taxa_boleto, 2, ',', '');
                $dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
                $dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
                $dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
                $dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br";
                $dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

                $dadosboleto["quantidade"] = "";
                $dadosboleto["valor_unitario"] = "";
                $dadosboleto["aceite"] = "1";
                $dadosboleto["especie"] = "R$";
                $dadosboleto["especie_doc"] = "";

                $dadosboleto["codigo_cedente"] = "1122334"; // Código do Cedente (Somente 7 digitos)
                $dadosboleto["carteira"] = "CNR";  // Código da Carteira
                // SEUS DADOS
                $dadosboleto["identificacao"] = "Boleto DM Soluções";
                $dadosboleto["cpf_cnpj"] = "";
                $dadosboleto["endereco"] = "Coloque o endereço da sua empresa aqui";
                $dadosboleto["cidade_uf"] = "Inhumas / Goiás";
                $dadosboleto["cedente"] = "Coloque a Razão Social da sua empresa aqui";
            }
        }
    }
}

// NÃO ALTERAR!
include("include/funcoes_hsbc.php");
include("include/layout_hsbc.php");
?>
