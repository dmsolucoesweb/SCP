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
        if (is_array($arrayDeBoletos)) {
            $b = count($arrayDeBoletos);
            foreach ($arrayDeBoletos as $BoletoModel) {
            $Html = null;
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
                $dias_de_prazo_para_pagamento = 0;
                $taxa_boleto = 0;
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
                $dadosboleto['data_vencimento'] = $boletoDataVencimento; // + ($dias_de_prazo_para_pagamento * 86400);
                $dadosboleto['valor_boleto'] = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

                // --------------------------------------------------------------------- //
                // ----------------- DADOS QUE NÃO PODEM SER ALTERADOS ----------------- //
                // --------------------------------------------------------------------- //
                $qtdePedidos = 1;
                $dadosboleto['quantidade'] = ""; //ALTERE APENAS A QUANTIDADE
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

                $Html .= '<style type="text/css">
#boleto_parceiro {
	height: 85px;
	width: 666px;
	font-family: Arial, Helvetica, sans-serif;
	margin-bottom: 15px;
	border-bottom-width: 1px;
	border-bottom-style: dashed;
	border-bottom-color: #000000;
}
.am {
	font-size: 9px;
	color: #333333;
	height: 10px;
	font-weight: bold;
	margin-bottom: 2px;
	text-align: center;
	width: 320px;
	border-top-width: 1px;
	border-right-width: 2px;
	border-left-width: 2px;
	border-top-style: solid;
	border-right-style: solid;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #000000;
	border-left-color: #000000;
}
#boleto{
	height: 416px;
	width: 666px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}

#tb_logo {
	height: 40px;
	width: 666px;
	border-bottom-width: 2px;
	border-bottom-style: solid;
	border-bottom-color: #000000;
}
#tb_logo #td_banco {
	height: 22px;
	width: 53px;
	border-right-width: 2px;
	border-left-width: 2px;
	border-right-style: solid;
	border-left-style: solid;
	border-right-color: #000000;
	border-left-color: #000000;
	font-size: 15px;
	font-weight: bold;
	text-align: center;
}
.ld {font: bold 15px Arial; color: #000000}
.td_7_sb {
	height: 26px;
	width: 7px;
}
.td_7_cb {
	width: 7px;
	border-left-width: 1px;
	border-left-style: solid;
	border-left-color: #000000;
	height: 26px;
}
.td_2 {
	width: 2px;
}
.tabelas td{
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #000000;
	vertical-align: top;
}
.direito {
	width: 178px;
}
.titulo {
	font-size: 9px;
	color: #333333;
	height: 10px;
	font-weight: bold;
	margin-bottom: 2px;
}
.var {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	height: 13px;
}
.direito .var{
	text-align: right;
}
.pag {font-weight: bold; font-size: 9px;}
.endereco {font-size:10px;}
</style>';
// GERA RECIBO DO PAGADOR
                $Html .= '<div id="boleto">
  <table border="0" cellpadding="0" cellspacing="0" id="tb_logo">
    <tr>
      <td rowspan="2" valign="bottom" style="width:150px;"><img src="../Boleto/imagens/logohsbc.jpg" alt="HSBC" title="HSBC" /></td>
      <td align="center" valign="bottom" style="font-size: 9px; border:none;">Banco</td>
      <td rowspan="2" align="right" valign="bottom" style="width:6px;"></td>
      <td rowspan="2" align="right" valign="bottom" style="font-size: 15px; font-weight:bold; width:445px;"><span class="ld">Recibo do Pagador</span></td>
      <td rowspan="2" align="right" valign="bottom" style="width:2px;"></td>
    </tr>
    <tr>
      <td id="td_banco">'.$dadosboleto['codigo_banco_com_dv'].'</td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb">&nbsp;</td>
      <td style="width: 468px;"><div class="titulo">Local do Pagamento</div>
      <div class="var pag">Pag&aacute;vel preferencialmente em Canais Eletrônicos ou na rede Bancária, até o vencimento</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">Vencimento</div>
        <div class="var">'.$dadosboleto['data_vencimento'].'</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
    <tr>
      <td class="td_7_sb" rowspan="2">&nbsp;</td>
      <td rowspan="2"><div class="titulo">Nome do Beneficiário/CNPJ/Endereço</div>
      <div class="var endereco">'.$dadosboleto['identificacao'].'  CNPJ - '.$dadosboleto['cpf_cnpj'].'<br>'.$dadosboleto['endereco1'].'<br>'.$dadosboleto['cidade_uf'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">Ag&ecirc;ncia / C&oacute;digo do Beneficiário</div>
      <div class="var">'.$dadosboleto['agencia'].' / '.$dadosboleto['codigo_cedente'].'</div></td>
      <td>&nbsp;</td>
    </tr>
	<tr>
	<td class="td_7_cb">&nbsp;</td>
	<td class="direito"><div class="titulo">Uso do Banco</div>
      <div class="var">&nbsp;</div></td>
	  <td>&nbsp;</td>
	  </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb">&nbsp;</td>
      <td style="width:103px;"><div class="titulo">Data do Documento</div>
        <div class="var">'.$dadosboleto['data_documento'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:133px;"><div class="titulo">N&uacute;mero do Documento</div>
      <div class="var">'.$dadosboleto['numero_documento'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:62px;"><div class="titulo">Esp&eacute;cie DOC</div>
      <div class="var">'.$dadosboleto['especie_doc'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:34px;"><div class="titulo">Aceite</div>
      <div class="var">'.$dadosboleto['aceite'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:103px;"><div class="titulo">Data Processamento</div>
      <div class="var">'.$dadosboleto['data_processamento'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">Nosso N&uacute;mero</div>
      <div class="var">'.$dadosboleto['nosso_numero'].'</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="td_7_sb">&nbsp;</td>
      <td style="width:118px;"><div class="titulo">Uso do Banco</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:55px;"><div class="titulo">Carteira</div>
      <div class="var">'.$dadosboleto['carteira'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:55px;"><div class="titulo">Esp&eacute;cie</div>
      <div class="var">'.$dadosboleto['especie'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:104px;"><div class="titulo">Quantidade da Moeda</div>
      <div class="var">'.$dadosboleto['quantidade'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:103px;"><div class="titulo">Valor</div>
      <div class="var">'.$dadosboleto['valor_unitario'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(=) Valor do Documento</div>
      <div class="var">R$ '.$dadosboleto['valor_boleto'].'</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td rowspan="5" class="td_7_sb">&nbsp;</td>
      <td rowspan="5" valign="top"><div class="titulo" style="margin-bottom:18px;">Instru&ccedil;&otilde;es de Responsabilidade do Beneficiário</div>
        <div class="var">'.$dadosboleto['instrucoes1'].'<br />'
                          .$dadosboleto['instrucoes2'].'<br />'
                          .$dadosboleto['instrucoes3'].'<br />'
                          .$dadosboleto['instrucoes4'].'</div>
      </td>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(-) Desconto / Abatimento</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
    <tr>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(-) Outras Dedu&ccedil;&otilde;es</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
    <tr>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(+) Juros / Multa</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
    <tr>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(+) Outros Acr&eacute;scimos</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
    <tr>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(=) Valor Cobrado</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; height:65px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb">&nbsp;</td>
      <td valign="top"><div class="titulo">Nome Pagador/CPF/CNPJ/Endereço/Cidade/UF/CEP</div>
        <div class="var" style="margin-bottom:5px; height:auto">'.$dadosboleto['sacado'].'<br />
        '.$dadosboleto['endereco1'].'<br />
        '.$dadosboleto['endereco2'].' '.$dadosboleto['estado'].'</div>
        <div class="titulo">Sacador / Avalista</div></td>
      <td class="td_7_sb">&nbsp;</td>
      <td class="direito" valign="top"><div class="titulo">CPF / CNPJ</div>
        <div class="var" style="text-align:left;">'.$dadosboleto['cpfsacado'].'</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
  </table>
  <table style="width:666px; border-top:solid; border-top-width:2px; border-top-color:#000000" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb">&nbsp;</td>
      <td style="width: 417px; height:62px;"></td>
      <td class="td_7_sb">&nbsp;</td>
      <td valign="top"><div class="titulo" style="text-align:left;">Autenticaçao Mecânica</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
  </table>
</div>';
                // GERA FICHA DE COMPENSAÇÃO
                $Html .= '<div id="boleto">
  <table border="0" cellpadding="0" cellspacing="0" id="tb_logo">
    <tr>
      <td rowspan="2" valign="bottom" style="width:150px;"><img src="../Boleto/imagens/logohsbc.jpg" alt="HSBC" title="HSBC" /></td>
      <td align="center" valign="bottom" style="font-size: 9px; border:none;">Banco</td>
      <td rowspan="2" align="right" valign="bottom" style="width:6px;"></td>
      <td rowspan="2" align="right" valign="bottom" style="font-size: 15px; font-weight:bold; width:445px;"><span class="ld">'.$dadosboleto['linha_digitavel'].'</span></td>
      <td rowspan="2" align="right" valign="bottom" style="width:2px;"></td>
    </tr>
    <tr>
      <td id="td_banco">'.$dadosboleto['codigo_banco_com_dv'].'</td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb">&nbsp;</td>
      <td style="width: 468px;"><div class="titulo">Local do Pagamento</div>
      <div class="var pag">Pag&aacute;vel preferencialmente em Canais Eletrônicos ou na rede Bancária, até o vencimento</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">Vencimento</div>
        <div class="var">'.$dadosboleto['data_vencimento'].'</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
    <tr>
      <td class="td_7_sb" rowspan="2">&nbsp;</td>
      <td rowspan="2"><div class="titulo">Nome do Beneficiário/CNPJ/Endereço</div>
      <div class="var endereco">'.$dadosboleto['identificacao'].'  CNPJ - '.$dadosboleto['cpf_cnpj'].'<br>'.$dadosboleto['endereco1'].'<br>'.$dadosboleto['cidade_uf'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">Ag&ecirc;ncia / C&oacute;digo do Beneficiário</div>
      <div class="var">'.$dadosboleto['agencia'].' / '.$dadosboleto['codigo_cedente'].'</div></td>
      <td>&nbsp;</td>
    </tr>
	<tr>
	<td class="td_7_cb">&nbsp;</td>
	<td class="direito"><div class="titulo">Uso do Banco</div>
      <div class="var">&nbsp;</div></td>
	  <td>&nbsp;</td>
	  </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb">&nbsp;</td>
      <td style="width:103px;"><div class="titulo">Data do Documento</div>
        <div class="var">'.$dadosboleto['data_documento'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:133px;"><div class="titulo">N&uacute;mero do Documento</div>
      <div class="var">'.$dadosboleto['numero_documento'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:62px;"><div class="titulo">Esp&eacute;cie DOC</div>
      <div class="var">'.$dadosboleto['especie_doc'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:34px;"><div class="titulo">Aceite</div>
      <div class="var">'.$dadosboleto['aceite'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:103px;"><div class="titulo">Data Processamento</div>
      <div class="var">'.$dadosboleto['data_processamento'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">Nosso N&uacute;mero</div>
      <div class="var">'.$dadosboleto['nosso_numero'].'</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="td_7_sb">&nbsp;</td>
      <td style="width:118px;"><div class="titulo">Uso do Banco</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:55px;"><div class="titulo">Carteira</div>
      <div class="var">'.$dadosboleto['carteira'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:55px;"><div class="titulo">Esp&eacute;cie</div>
      <div class="var">'.$dadosboleto['especie'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:104px;"><div class="titulo">Quantidade da Moeda</div>
      <div class="var">'.$dadosboleto['quantidade'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td style="width:103px;"><div class="titulo">Valor</div>
      <div class="var">'.$dadosboleto['valor_unitario'].'</div></td>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(=) Valor do Documento</div>
      <div class="var">R$ '.$dadosboleto['valor_boleto'].'</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td rowspan="5" class="td_7_sb">&nbsp;</td>
      <td rowspan="5" valign="top"><div class="titulo" style="margin-bottom:18px;">Instru&ccedil;&otilde;es de Responsabilidade do Beneficiário</div>
        <div class="var">'.$dadosboleto['instrucoes1'].'<br />'
                          .$dadosboleto['instrucoes2'].'<br />'
                          .$dadosboleto['instrucoes3'].'<br />'
                          .$dadosboleto['instrucoes4'].'</div>
      </td>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(-) Desconto / Abatimento</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
    <tr>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(-) Outras Dedu&ccedil;&otilde;es</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
    <tr>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(+) Juros / Multa</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
    <tr>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(+) Outros Acr&eacute;scimos</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
    <tr>
      <td class="td_7_cb">&nbsp;</td>
      <td class="direito"><div class="titulo">(=) Valor Cobrado</div>
      <div class="var">&nbsp;</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; height:65px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb">&nbsp;</td>
      <td valign="top"><div class="titulo">Nome Pagador/CPF/CNPJ/Endereço/Cidade/UF/CEP</div>
        <div class="var" style="margin-bottom:5px; height:auto">'.$dadosboleto['sacado'].'<br />
        '.$dadosboleto['endereco1'].'<br />
        '.$dadosboleto['endereco2'].' '.$dadosboleto['estado'].'</div>
        <div class="titulo">Sacador / Avalista</div></td>
      <td class="td_7_sb">&nbsp;</td>
      <td class="direito" valign="top"><div class="titulo">CPF / CNPJ</div>
        <div class="var" style="text-align:left;">'.$dadosboleto['cpfsacado'].'</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
  </table>
  <table style="width:666px; border-top:solid; border-top-width:2px; border-top-color:#000000" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb">&nbsp;</td>
      <td style="width: 417px; height:62px;">[  CÓDIGO DE BARRAS  ]</td>
      <td class="td_7_sb">&nbsp;</td>
      <td valign="top"><div class="titulo" style="text-align:left;">Autenticaçao Mecânica / Ficha de Compensação</div></td>
      <td class="td_2">&nbsp;</td>
    </tr>
  </table>
</div>';
                $mpdf->WriteHTML($Html);
                $b--;
                if ($b != 0) {$mpdf->AddPage();}
            }
        }
        $arquivo = date("d-m-Y") . "-boleto.pdf";
        $mpdf->Output($arquivo, "I");
        exit();
    }

}
