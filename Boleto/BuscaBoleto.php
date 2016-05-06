<?php
require_once '../BD/ConexaoBancoDeDados.php';
require_once '../Classes/datasehoras.php';
header('Cache-Control: no-cache');
header('Content-type: application/xml; charset="utf-8"', true);
$idp = $_GET['idp'];

$BD = new ConexaoBancoDeDados();
$boletos = array();

$query = "SELECT boletoId, boletoNumeroDocumento, boletoDataEmissao, boletoValor FROM Boletos WHERE boletoProdutoId='$idp' ORDER BY boletoDataEmissao";

 $resultado = $BD->executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.s
        } else {
            $BD->setMensagem("Erro no select de consultaBoletosParaRemessa: " . $BD->getBdError());
            return false;
        }
        $BoletosModel = null;
        $DatasEHoras = new DatasEHoras();

        while ($boleto = $BD->leTabelaBD()) {
            $boletoDataEmissao = $DatasEHoras->getDataEHorasDesinvertidaComBarras($boleto['boletoDataEmissao']);
            $nome = "Documento: ".$boleto['boletoNumeroDocumento']." | Emissão: ".$boletoDataEmissao." | Valor: R$".number_format($boleto['boletoValor'], 2, ',', '.');
            $boletos[] = array(
		'boletoId' => $boleto['boletoId'],
		'titulo' => $nome);
        }
echo(json_encode($boletos));

