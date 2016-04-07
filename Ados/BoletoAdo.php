<?php

require_once 'ADO.php';

class BoletoAdo extends ADO {

    public function consultarUltimoNossoNumero() {
        $query = "select max(boletoNossoNumero) from Boletos";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultarUltimoNossoNumero: " . parent::getBdError());
            return false;
        }

        $boletoNossoNumero = parent::leTabelaBD();

        return $boletoNossoNumero;
    }

    public function consultaArrayDeBoletos($produtoId) {
        $BoletoModel = null;
        $query = "select * from Boletos where boletoProdutoId = '{$produtoId}' ";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaArrayDeObjeto: " . parent::getBdError());
            return false;
        }

        $DatasEHoras = new DatasEHoras();

        while ($boleto = parent::leTabelaBD()) {
            $boletoDataVencimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($boleto['boletoDataVencimento']);
            $BoletoModel = array($boleto['boletoId'], $boleto['boletoNumeroDocumento'], $boleto['boletoNossoNumero'], $boleto['boletoSacado'], $boleto['boletoRemetido'], $boletoDataVencimento, $boleto['boletoNumeroParcela'], $boleto['boletoValor'], $boleto['boletoProdutoId']);
            $BoletosModel[] = $BoletoModel;
        }

        return $BoletosModel;
    }

    public function consultaObjetoPeloId($id) {
        
    }

    public function consultaArrayDeObjeto() {
        
    }

    public function insereObjeto(\Model $ProdutoModel) {
        $ClienteAdo = new ClienteAdo();
        $DatasEHoras = new DatasEHoras();
        $contParcela = $boletoNossoNumero2 = NULL;
        $contElementos = 0;

        $clienteId = $ProdutoModel->getClienteId();
        $Cliente = $ClienteAdo->consultaObjetoPeloId($clienteId);
        $clienteNome = $Cliente->getClienteNome();
        $clienteCPF = $Cliente->getClienteCPF();
        $clienteEndereco = $Cliente->getClienteEndereco();

        $vendedorId = $ProdutoModel->getVendedorId();
        $produtoId = $ProdutoModel->getProdutoId();
        $boletoProdutoId = str_pad($produtoId, 3, "0", STR_PAD_LEFT);

        $produtoParcelas = $ProdutoModel->getProdutoParcelas();
        $produtoParcelasDataVencimento = $ProdutoModel->getProdutoParcelasDataVencimento();
        $produtoParcelasValorUnitario = $ProdutoModel->getProdutoParcelasValorUnitario();

        $Parcelas = explode(";", $produtoParcelas);
        $ParcelasDataVencimento = explode(";", $produtoParcelasDataVencimento);
        $ParcelasValorUnitario = explode(";", $produtoParcelasValorUnitario);

        foreach ($Parcelas as $numeroParcelas) {
            for ($i = 1; $i <= $numeroParcelas; $i++) {

                $nossoNumeroTeste = $this->consultarUltimoNossoNumero();

                if ($nossoNumeroTeste['max(boletoNossoNumero)'] == NULL) {
                    $boletoNossoNumero2 = '00000';
                } else {
                    $boletoNossoNumero2 = substr($nossoNumeroTeste['max(boletoNossoNumero)'], 5, 5);
                    $boletoNossoNumero2 += 1;
                    $boletoNossoNumero2 = str_pad($boletoNossoNumero2, 5, "0", STR_PAD_LEFT);

                    if ($boletoNossoNumero2 >= 99999) {
                        return false;
                    }
                }

                $contParcela += 1;
                $boletoContParcela = str_pad($contParcela, 3, "0", STR_PAD_LEFT);
                $boletoContParcela = str_pad($contParcela, 3, "0", STR_PAD_LEFT);
                $boletoNumeroDocumento = $boletoProdutoId . $boletoContParcela;
                $boletoNossoNumero1 = 56410;
                $digitoVerificador = digitoVerificador_nossonumero($boletoNossoNumero1 . $boletoNossoNumero2);
                $nossoNumeroCompleto = $boletoNossoNumero1 . $boletoNossoNumero2 . $digitoVerificador;

                if ($i == 1) {
                    $dataVencimento = $ParcelasDataVencimento[$contElementos];
                } else {
                    $dataVencimento = date("d/m/Y", strtotime("+30 day", strtotime($DatasEHoras->getDataEHorasInvertidaComTracos($ParcelasDataVencimento[$contElementos]))));
                }

                $valorUnitario = $ParcelasValorUnitario[$contElementos];

                $query = "insert into Boletos (boletoId, boletoNumeroDocumento, boletoNossoNumero, boletoSacado, boletoRemetido, boletoDataVencimento, boletoNumeroParcela, boletoValor, boletoProdutoId) values (null, '$boletoNumeroDocumento', '$nossoNumeroCompleto','$clienteId', '0', '$dataVencimento', '$contParcela', '$valorUnitario', '$produtoId')";

                $resultado = parent::executaQuery($query);
            }

            next($ParcelasDataVencimento);
            next($ParcelasValorUnitario);
            $contElementos += 1;
        }

        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no insert de insereBoleto: " . parent::getBdError());
            return false;
        }
    }

    public function alteraObjeto(\Model $objetoModelo) {
        
    }

    public function excluiObjeto(\Model $objetoModelo) {
        
    }

}
