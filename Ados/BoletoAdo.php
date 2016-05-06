<?php

require_once 'ADO.php';
require_once '../Classes/cpf.php';
require_once '../Boleto/FuncoesBoletoHsbc.php';
require_once '../Ados/ProdutoAdo.php';

class BoletoAdo extends ADO {

    public function consultaBoletosParaRemessa() {
        $query = "select * from Boletos where boletoRemetido = '0' ";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.s
        } else {
            parent::setMensagem("Erro no select de consultaBoletosParaRemessa: " . parent::getBdError());
            return false;
        }
        $BoletosModel = null;
        $DatasEHoras = new DatasEHoras();

        while ($boleto = parent::leTabelaBD()) {
            $boletoDataVencimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($boleto['boletoDataVencimento']);
            $boletoDataEmissao = $DatasEHoras->getDataEHorasDesinvertidaComBarras($boleto['boletoDataEmissao']);
            $BoletoModel = new BoletoModel($boleto['boletoId'], $boleto['boletoNumeroDocumento'], $boleto['boletoNossoNumero'], $boleto['boletoSacado'], $boleto['boletoRemetido'], $boletoDataVencimento, $boletoDataEmissao, $boleto['boletoValor'], $boleto['boletoProdutoId']);
            $BoletosModel[] = $BoletoModel;
        }

        return $BoletosModel;
    }

    public function alteraRemetido() {
        $query = "update Boletos set boletoRemetido = '1' ";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no update de alteraRemetido: " . parent::getBdError());
            return false;
        }
    }

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

    public function consultarUltimoNumeroDocumento($id) {
        $query = "select max(boletoNumeroDocumento) from Boletos where boletoProdutoId = '{$id}' ";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultarUltimoNumeroDocumento: " . parent::getBdError());
            return false;
        }

        $boletoNumeroDocumento = parent::leTabelaBD();

        return $boletoNumeroDocumento;
    }

    public function consultaObjetoPeloId($id) {
        $BoletoModel = null;
        $query = "select * from Boletos where boletoId = '{$id}' ";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaArrayDeObjeto: " . parent::getBdError());
            return false;
        }

        $DatasEHoras = new DatasEHoras();

        $boleto = parent::leTabelaBD();
        $boletoDataVencimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($boleto['boletoDataVencimento']);
        $boletoDataEmissao = $DatasEHoras->getDataEHorasDesinvertidaComBarras($boleto['boletoDataEmissao']);
        return new BoletoModel($boleto['boletoId'], $boleto['boletoNumeroDocumento'], $boleto['boletoNossoNumero'], $boleto['boletoSacado'], $boleto['boletoRemetido'], $boletoDataVencimento, $boletoDataEmissao, $boleto['boletoValor'], $boleto['boletoProdutoId']);
    }

    public function consultaArrayDeObjeto() {
        $BoletoModel = null;
        $query = "select * from Boletos order by boletoDataVencimento";

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
            $boletoDataEmissao = $DatasEHoras->getDataEHorasDesinvertidaComBarras($boleto['boletoDataEmissao']);
            $BoletoModel = new BoletoModel($boleto['boletoId'], $boleto['boletoNumeroDocumento'], $boleto['boletoNossoNumero'], $boleto['boletoSacado'], $boleto['boletoRemetido'], $boletoDataVencimento, $boletoDataEmissao, $boleto['boletoValor'], $boleto['boletoProdutoId']);
            $BoletosModel[] = $BoletoModel;
        }

        return $BoletosModel;
    }
    
    public function consultaArrayDeBoletos($produtoId) {
        $BoletoModel = null;
        $query = "select * from Boletos where boletoId = '{$produtoId}' ";

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
            $boletoDataEmissao = $DatasEHoras->getDataEHorasDesinvertidaComBarras($boleto['boletoDataEmissao']);
            $BoletoModel = array($boleto['boletoId'], $boleto['boletoNumeroDocumento'], $boleto['boletoNossoNumero'], $boleto['boletoSacado'], $boleto['boletoRemetido'], $boletoDataVencimento, $boletoDataEmissao, $boleto['boletoNumeroParcela'], $boleto['boletoValor'], $boleto['boletoProdutoId']);
            $BoletosModel[] = $BoletoModel;
        }

        return $BoletosModel;
    }

    public function insereObjeto(\Model $BoletoModel) {
        $ProdutoAdo = new ProdutoAdo();
        $numeroDocumento = null;
        $DatasEHoras = new DatasEHoras();

        $boletoId = $BoletoModel->getBoletoId();
        $boletoNumeroDocumento = $BoletoModel->getBoletoNumeroDocumento();
        $boletoNossoNumero = $BoletoModel->getBoletoNossoNumero();
        $boletoRemetido = $BoletoModel->getBoletoRemetido();
        $boletoSacado = $BoletoModel->getBoletoSacado();
        $boletoDataVencimento = $DatasEHoras->getDataEHorasInvertidaComTracos($BoletoModel->getBoletoDataVencimento());
        $boletoDataEmissao = $BoletoModel->getBoletoDataEmissao();
        $boletoValor = $BoletoModel->getBoletoValor();
        $boletoProdutoId = $BoletoModel->getBoletoProdutoId();

        $Produto = $ProdutoAdo->consultaObjetoPeloId($boletoProdutoId);

        if ($numeroDocumento = $this->consultarUltimoNumeroDocumento($boletoProdutoId)) {
            $numeroDocumento = substr($numeroDocumento['max(boletoNumeroDocumento)'], 3, 6);
            $numeroDocumento++;
        } else {
            $numeroDocumento = 0;
        }

        $boletoContParcela = str_pad($numeroDocumento, 3, "0", STR_PAD_LEFT);
        $boletoNumeroDocumento = str_pad($boletoProdutoId, 3, "0", STR_PAD_LEFT) . $boletoContParcela;

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

        $boletoNossoNumero1 = 56410;
        $digitoVerificador = modulo_11($boletoNossoNumero1 . $boletoNossoNumero2, 7);
        $nossoNumeroCompleto = $boletoNossoNumero1 . $boletoNossoNumero2 . $digitoVerificador;

        $boletoRemetido = 0;
        $boletoSacado = $Produto->getClienteId();

        date_default_timezone_set('America/Sao_Paulo');
        $dataEmissao = date('Y-m-d-H-i-s');



        $query = "insert into Boletos (boletoId, boletoNumeroDocumento, boletoNossoNumero, boletoSacado, boletoRemetido, boletoDataVencimento, boletoDataEmissao, boletoValor, boletoProdutoId) values (null, '$boletoNumeroDocumento', '$nossoNumeroCompleto','$boletoSacado', '0', '$boletoDataVencimento', '$dataEmissao','$boletoValor', '$boletoProdutoId')";
        $resultado = parent::executaQuery($query);

        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no insert de insereBoleto: " . parent::getBdError());
            return false;
        }
    }

    public function alteraObjeto(\Model $objetoModelo) {
        
    }

    public function excluiObjeto(\Model $BoletoModel) {
        $boletoId = $BoletoModel->getBoletoId();

        $query = "delete from Boletos "
                . "where boletoId = {$boletoId}";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no delete de excluiObjeto: " . parent::getBdError());
            return false;
        }
    }

    function digitoVerificador_nossonumero($numero) {
        $resto2 = modulo_11($numero, 9, 1);
        $digito = 11 - $resto2;
        if ($digito == 10 || $digito == 11) {
            $dv = 0;
        } else {
            $dv = $digito;
        }
        return $dv;
    }

}
