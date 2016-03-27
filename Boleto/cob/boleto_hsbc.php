<?php ob_start(); ?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<html>
<head>
<title>GERA BOLETO</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type=text/css>
<!--
.cp {
	font: bold 10px Arial;
	color: black
}
<!--
.ti {
	font: 9px Arial, Helvetica, sans-serif
}
<!--
.ld {
	font: bold 15px Arial;
	color: #000000
}
<!--
.ct {
	FONT: 9px "Arial Narrow";
	COLOR: #000033
}
<!--
.cn {
	FONT: 9px Arial;
	COLOR: black
}
<!--
.bc {
	font: bold 20px Arial;
	color: #000000
}
<!--
.ld2 {
	font: bold 12px Arial;
	color: #000000
}
-->
</style>
</head>
<?php 
include("modulo_11.php");

// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO -------------------- //

// DADOS DO BOLETO PARA O SEU CLIENTE
// STRING UTILIZADA PARA CALCULAR DATA DE VENCIMENTO, PORÉM A FUNÇÃO FOI RETIRADA 
// $dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 5.00;
$data_venc = "20/03/2016"; 
$valor_cobrado = "2000,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal

// NUMERO DOCUMENTO - IDENTIFICAÇÃO DO BOLETO NO SISTEMA PARA DAR BAIXA (3 DIGITOS CLIENTE E 3 DIGITOS DOC. CLIENTE) EX. 001001
$dadosboleto["numero_documento"] = "001002"; 
// NOSSO NÚMERO (9 DIGITOS + 1 DIGITO VERIFICADOR) NO CASO DA PARK VILLE, INICIA EM 5641000000 E TERMINA EM 5641099999
$dadosboleto["nosso_numero"] = 5641000001; 
//ACRESCENTA DÍGITO VERIFICADOR
$dadosboleto["nosso_numero"] .= modulo_11($dadosboleto["nosso_numero"],7); 

// DADOS DO CLIENTE
$dadosboleto["sacado"] = 'EDUARDO DIAS MARTINS'; 
$dadosboleto["cpfsacado"] = '054.633.761-90'; //CPF OU CNPJ DO CLIENTE
$dadosboleto["endereco1"] = 'RUA CUIABA, 023' . 'QD 01-A, LT 03'; //NÃO ALTERE A ORDEM, PRECISA SER ASSIM PARA SER HOMOLOGADO
$dadosboleto["bairro"] = 'VALE DAS GOIABEIRAS';
$dadosboleto["endereco2"] = '75.400-000 INHUMAS';
$dadosboleto["estado"] = 'GO';

// DISCRIMINAÇÃO DO BOLETO (PAGAMENTO DE PARCELA 1/20 DE TAL TAL ... )
$dadosboleto["demonstrativo1"] = "Pagamento de parcela 1/20 do Empreendimento Park Ville";
$dadosboleto["demonstrativo2"] = "Apartamento 100 - Box(es) 10 e 15 <br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "TEXTO ADICIONAL";

// DATAS DO DOCUMENTO E DE PROCESSAMENTO
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto <-- SALVAR DATA NO BANCO
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional) <-- SALVAR DATA NO BANCO

// CALCULOS
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
$dadosboleto["data_vencimento"] = $data_venc; 
$dadosboleto["valor_boleto"] = $valor_boleto; 	


// --------------------------------------------------------------------- //
// ----------------- DADOS QUE NÃO PODEM SER ALTERADOS ----------------- //
// --------------------------------------------------------------------- //
$qtdePedidos = 1;
$dadosboleto["quantidade"] = "1"; //ALTERE APENAS A QUANTIDADE
$dadosboleto["valor_unitario"] = ""; //NAO ALTERE
$dadosboleto["aceite"] = "NÃO";	//NÃO ALTERE
$dadosboleto["especie"] = "REAL"; //NAO ALTERE
$dadosboleto["especie_doc"] = "PD"; //NAO ALTERE


// DADOS FIXOS DA AGÊNCIA, CODIGO CLIENTE E INSTRUÇÕES //
$dadosboleto["agencia"] = "0501"; //AGENCIA HSBC
$dadosboleto["codigo_cedente"] = "0030310"; // CODIGO CONTRATO COB SEM AGENCIA
$dadosboleto["carteira"] = "00";  // CÓDIGO DA CARTEIRA (NÃO ALTERE)

// DADOS EMISSOR DOS BOLETOS (PARK VILLE)
$dadosboleto["identificacao"] = "DM SOLUÇÕES WEB";
$dadosboleto["cpf_cnpj"] = "19.033.354/0001-60";
$dadosboleto["endereco"] = "Rua Cuiabá, 023";
$dadosboleto["cidade_uf"] = "INHUMAS / GO";
$dadosboleto["cedente"] = "DM SOLUÇÕES WEB";

// INSTRUÇÕES IGUAIS PARA TODOS OS CLIENTES
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: contato@seusite.com.br";
$dadosboleto["instrucoes4"] = "PARA MAIS INSTRUCOES, PREENCHA AQUI";

// FUNÇÕES E LAYOUT DO BOLETO
include("funcoes_hsbc.php"); 
include("layout_hsbc.php");