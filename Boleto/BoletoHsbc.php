<?php

require_once '../Ados/BoletoAdo.php';
require_once 'LayoutBoletoHsbc.php';
require_once 'FuncoesBoletoHsbc.php';
ini_set("memory_limit", "-1");
if (!defined('MPDF_PATH')) {
    define('MPDF_PATH', 'class/mpdf/');
}
require_once '../PDF/mpdf/mpdf.php';

//include("modulo_11.php");

class BoletoHsbc {

    function geraBoleto($produtoId) {
        $dadosboleto = null;
        $BoletoAdo = new BoletoAdo();
        $ClienteAdo = new ClienteAdo();
        $LayoutBoleto = new LayoutBoletoHsbc();
        $FuncoesBoletoHsbc = new FuncoesBoletoHsbc($dadosboleto);
        $arrayDeBoletos = $BoletoAdo->consultaArrayDeBoletos($produtoId);
        $mpdf = new mPDF('pt', 'A4', 0, 'arial', 5, 5, 5, 5, 9, 9, 'P');
        $Html = null;
        
        if (is_array($arrayDeBoletos)) {
            foreach ($arrayDeBoletos as $BoletoModel) {

                $boletoId = $BoletoModel[0];
                $boletoNumeroDocumento = $BoletoModel[1];
                $boletoNossoNumero = $BoletoModel[2];
                $boletoSacado = $BoletoModel[3];
                $boletoRemetido = $BoletoModel[4];
                $boletoDataVencimento = $BoletoModel[5];
                $boletoNumeroParcela = $BoletoModel[6];
                $boletoValor = $BoletoModel[7];
                $boletoProdutoId = $BoletoModel[8];

                $Cliente = $ClienteAdo->consultaObjetoPeloId($boletoSacado);
                $clienteNome = $Cliente->getClienteNome();
                $clienteCPF = $Cliente->getClienteCPF();
                $clienteEndereco = $Cliente->getClienteEndereco();
                $clienteEstado = $Cliente->getClienteEstado();
                $clienteCidade = $Cliente->getClienteCidade();
                $clienteCEP = $Cliente->getClienteCEP();

                // ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO -------------------- //
                // DADOS DO BOLETO PARA O SEU CLIENTE
                // STRING UTILIZADA PARA CALCULAR DATA DE VENCIMENTO, PORÉM A FUNÇÃO FOI RETIRADA 
                $dias_de_prazo_para_pagamento = 5;
                $taxa_boleto = 5.00;
                //$data_venc = "20/03/2016";
                //$valor_cobrado = "2000,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
                // NUMERO DOCUMENTO - IDENTIFICAÇÃO DO BOLETO NO SISTEMA PARA DAR BAIXA (3 DIGITOS CLIENTE E 3 DIGITOS DOC. CLIENTE) EX. 001001
                $dadosboleto['numero_documento'] = $boletoNumeroDocumento;
                // NOSSO NÚMERO (9 DIGITOS + 1 DIGITO VERIFICADOR) NO CASO DA PARK VILLE, INICIA EM 5641000000 E TERMINA EM 5641099999
                $dadosboleto['nosso_numero'] = $boletoNossoNumero;
                //ACRESCENTA DÍGITO VERIFICADOR
                //$dadosboleto["nosso_numero"] .= modulo_11($dadosboleto["nosso_numero"], 7);
                // DADOS DO CLIENTE
                $dadosboleto['sacado'] = $clienteNome;
                $dadosboleto['cpfsacado'] = $clienteCPF; //CPF OU CNPJ DO CLIENTE
                $dadosboleto['endereco1'] = $clienteEndereco; //NÃO ALTERE A ORDEM, PRECISA SER ASSIM PARA SER HOMOLOGADO
                //$dadosboleto["bairro"] = 'VALE DAS GOIABEIRAS';
                $dadosboleto['endereco2'] = $clienteCEP . " | " . $clienteCidade;
                $dadosboleto['estado'] = $clienteEstado;

                // DISCRIMINAÇÃO DO BOLETO (PAGAMENTO DE PARCELA 1/20 DE TAL TAL ... )
                $dadosboleto['demonstrativo1'] = "Pagamento de parcela 1/20 do Empreendimento Park Ville";
                $dadosboleto['demonstrativo2'] = "Apartamento 100 - Box(es) 10 e 15 <br>Taxa bancária - R$ " . number_format($taxa_boleto, 2, ',', '');
                $dadosboleto['demonstrativo3'] = "TEXTO ADICIONAL";

                // DATAS DO DOCUMENTO E DE PROCESSAMENTO
                $dadosboleto['data_documento'] = date("d/m/Y"); // Data de emissão do Boleto <-- SALVAR DATA NO BANCO
                $dadosboleto['data_processamento'] = date("d/m/Y"); // Data de processamento do boleto (opcional) <-- SALVAR DATA NO BANCO
                // CALCULOS
                $valor_cobrado = str_replace(",", ".", $boletoValor);
                // $valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');
                $dadosboleto['data_vencimento'] = $boletoDataVencimento + ($dias_de_prazo_para_pagamento * 86400);
                $dadosboleto['valor_boleto'] = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

                // --------------------------------------------------------------------- //
                // ----------------- DADOS QUE NÃO PODEM SER ALTERADOS ----------------- //
                // --------------------------------------------------------------------- //
                $qtdePedidos = 1;
                $dadosboleto['quantidade'] = "1"; //ALTERE APENAS A QUANTIDADE
                $dadosboleto['valor_unitario'] = ""; //NAO ALTERE
                $dadosboleto['aceite'] = "NÃO"; //NÃO ALTERE
                $dadosboleto['especie'] = "REAL"; //NAO ALTERE
                $dadosboleto['especie_doc'] = "PD"; //NAO ALTERE
                // DADOS FIXOS DA AGÊNCIA, CODIGO CLIENTE E INSTRUÇÕES //
                $dadosboleto['agencia'] = "0501"; //AGENCIA HSBC
                $dadosboleto['codigo_cedente'] = "0030310"; // CODIGO CONTRATO COB SEM AGENCIA
                $dadosboleto['carteira'] = "00";  // CÓDIGO DA CARTEIRA (NÃO ALTERE)
                // DADOS EMISSOR DOS BOLETOS (PARK VILLE)
                $dadosboleto['identificacao'] = "DM SOLUÇÕES WEB";
                $dadosboleto['cpf_cnpj'] = "23501469000100";
                $dadosboleto['endereco'] = "Rua Cuiabá, 023";
                $dadosboleto['cidade_uf'] = "INHUMAS / GO";
                $dadosboleto['cedente'] = "DM SOLUÇÕES WEB";

                // INSTRUÇÕES IGUAIS PARA TODOS OS CLIENTES
                $dadosboleto['instrucoes1'] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
                $dadosboleto['instrucoes2'] = "- Receber até 10 dias após o vencimento";
                $dadosboleto['instrucoes3'] = "- Em caso de dúvidas entre em contato conosco: contato@seusite.com.br";
                $dadosboleto['instrucoes4'] = "PARA MAIS INSTRUCOES, PREENCHA AQUI";

                // FUNÇÕES E LAYOUT DO BOLETO
                // include("funcoes_hsbc.php");
                // include("layout_hsbc.php");

                $atributos = $FuncoesBoletoHsbc->pegarAtributos();
                $dadosboleto['codigo_barras'] = $atributos['0'];
                $dadosboleto['linha_digitavel'] = $atributos['1'];
                $dadosboleto['agencia_codigo'] = $atributos['2'];
                $dadosboleto['nosso_numero'] = $atributos['3'];
                $dadosboleto['codigo_banco_com_dv'] = $atributos['4'];

                $Html .= $LayoutBoleto->LayoutHsbc($dadosboleto);
                $mpdf->WriteHTML($Html);
            }
        }
        $arquivo = date("d-m-Y") . "-aptos_vendidos.pdf";
        $mpdf->Output($arquivo, "I");
        exit();
    }

}
