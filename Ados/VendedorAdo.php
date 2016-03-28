<?php

require_once 'ADO.php';
require_once '../Classes/datasehoras.php';

class VendedorAdo extends ADO {

    public function consultaObjetoPeloId($id) {
        $query = "select * from Vendedores where vendedorId = '{$id}' ";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaObjetoPeloId: " . parent::getBdError());
            return false;
        }
        $DatasEHoras = new DatasEHoras();

        $vendedor = parent::leTabelaBD();
        $vendedorDataNascimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($vendedor['vendedorDataNascimento']);
        return new VendedorModel($vendedor['vendedorId'], $vendedor['vendedorNome'], $vendedor['vendedorNacionalidade'], $vendedorDataNascimento, $vendedor['vendedorCPF'], $vendedor['vendedorRG'], $vendedor['vendedorOrgaoEmissor'], $vendedor['vendedorEstadoOrgaoEmissor'], $vendedor['vendedorSexo'], $vendedor['vendedorEstadoCivil'], $vendedor['vendedorRegimeComunhao'], $vendedor['vendedorFiliacao'], $vendedor['vendedorFiliacao2'], $vendedor['vendedorTelefone'], $vendedor['vendedorTelefone2'], $vendedor['vendedorEndereco'], $vendedor['vendedorCidade'], $vendedor['vendedorEstado'], $vendedor['vendedorCEP'], $vendedor['vendedorEmail'], $vendedor['vendedorProfissao'], $vendedor['vendedorRenda'], $vendedor['vendedorEmpresa']);
    }

    public function consultaArrayDeObjeto() {
        $vendedorModel = null;
        $query = "select * from Vendedores order by vendedorNome";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaArrayDeObjeto: " . parent::getBdError());
            return false;
        }

        $vendedoresModel = null;
        $DatasEHoras = new DatasEHoras();

        while ($vendedor = parent::leTabelaBD()) {
            $vendedorDataNascimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($vendedor['vendedorDataNascimento']);
            $vendedorModel = new VendedorModel($vendedor['vendedorId'], $vendedor['vendedorNome'], $vendedor['vendedorNacionalidade'], $vendedorDataNascimento, $vendedor['vendedorCPF'], $vendedor['vendedorRG'], $vendedor['vendedorOrgaoEmissor'], $vendedor['vendedorEstadoOrgaoEmissor'], $vendedor['vendedorSexo'], $vendedor['vendedorEstadoCivil'], $vendedor['vendedorRegimeComunhao'], $vendedor['vendedorFiliacao'], $vendedor['vendedorFiliacao2'], $vendedor['vendedorTelefone'], $vendedor['vendedorTelefone2'], $vendedor['vendedorEndereco'], $vendedor['vendedorCidade'], $vendedor['vendedorEstado'], $vendedor['vendedorCEP'], $vendedor['vendedorEmail'], $vendedor['vendedorProfissao'], $vendedor['vendedorRenda'], $vendedor['vendedorEmpresa']);
            $vendedoresModel[] = $vendedorModel;
        }

        return $vendedoresModel;
    }

    public function consultaVendedoresComIdMaiorQueUm() {
        $vendedorModel = null;
        $query = "select * from Vendedores where vendedorId > 1 order by vendedorNome";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaVendedoresComIdMaiorQueUm: " . parent::getBdError());
            return false;
        }

        $vendedoresModel = null;
        $DatasEHoras = new DatasEHoras();

        while ($vendedor = parent::leTabelaBD()) {
            $vendedorDataNascimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($vendedor['vendedorDataNascimento']);
            $vendedorModel = new VendedorModel($vendedor['vendedorId'], $vendedor['vendedorNome'], $vendedor['vendedorNacionalidade'], $vendedorDataNascimento, $vendedor['vendedorCPF'], $vendedor['vendedorRG'], $vendedor['vendedorOrgaoEmissor'], $vendedor['vendedorEstadoOrgaoEmissor'], $vendedor['vendedorSexo'], $vendedor['vendedorEstadoCivil'], $vendedor['vendedorRegimeComunhao'], $vendedor['vendedorFiliacao'], $vendedor['vendedorFiliacao2'], $vendedor['vendedorTelefone'], $vendedor['vendedorTelefone2'], $vendedor['vendedorEndereco'], $vendedor['vendedorCidade'], $vendedor['vendedorEstado'], $vendedor['vendedorCEP'], $vendedor['vendedorEmail'], $vendedor['vendedorProfissao'], $vendedor['vendedorRenda'], $vendedor['vendedorEmpresa']);
            $vendedoresModel[] = $vendedorModel;
        }

        return $vendedoresModel;
    }

    public function insereObjeto(Model $VendedorModel) {
        $vendedorNome = $VendedorModel->getVendedorNome();
        $vendedorNacionalidade = $VendedorModel->getVendedorNacionalidade();
        $vendedorDataNascimento = $VendedorModel->getVendedorDataNascimento();
        $vendedorCPF = $VendedorModel->getVendedorCPF();
        $vendedorRG = $VendedorModel->getVendedorRG();
        $vendedorOrgaoEmissor = $VendedorModel->getVendedorOrgaoEmissor();
        $vendedorEstadoOrgaoEmissor = $VendedorModel->getVendedorEstadoOrgaoEmissor();
        $vendedorSexo = $VendedorModel->getVendedorSexo();
        $vendedorEstadoCivil = $VendedorModel->getVendedorEstadoCivil();
        $vendedorRegimeComunhao = $VendedorModel->getVendedorRegimeComunhao();
        $vendedorFiliacao = $VendedorModel->getVendedorFiliacao();
        $vendedorFiliacao2 = $VendedorModel->getVendedorFiliacao2();
        $vendedorTelefone = $VendedorModel->getVendedorTelefone();
        $vendedorTelefone2 = $VendedorModel->getVendedorTelefone2();
        $vendedorEndereco = $VendedorModel->getVendedorEndereco();
        $vendedorCidade = $VendedorModel->getVendedorCidade();
        $vendedorEstado = $VendedorModel->getVendedorEstado();
        $vendedorCEP = $VendedorModel->getVendedorCEP();
        $vendedorEmail = $VendedorModel->getVendedorEmail();
        $vendedorProfissao = $VendedorModel->getVendedorProfissao();
        $vendedorRenda = $VendedorModel->getVendedorRenda();
        $vendedorEmpresa = $VendedorModel->getVendedorEmpresa();

        $query = "insert into Vendedores (vendedorId, vendedorNome, vendedorNacionalidade, vendedorDataNascimento,"
                . " vendedorCPF, vendedorRG, vendedorOrgaoEmissor, vendedorEstadoOrgaoEmissor,"
                . " vendedorSexo, vendedorEstadoCivil, vendedorRegimeComunhao, vendedorFiliacao,"
                . " vendedorFiliacao2, vendedorTelefone, vendedorTelefone2, vendedorEndereco,"
                . " vendedorCidade, vendedorEstado, vendedorCEP, vendedorEmail, vendedorProfissao,"
                . " vendedorRenda, vendedorEmpresa) values (null, '$vendedorNome', '$vendedorNacionalidade',"
                . " '$vendedorDataNascimento', '$vendedorCPF', '$vendedorRG', '$vendedorOrgaoEmissor', '$vendedorEstadoOrgaoEmissor',"
                . " '$vendedorSexo', '$vendedorEstadoCivil', '$vendedorRegimeComunhao', '$vendedorFiliacao', '$vendedorFiliacao2',"
                . " '$vendedorTelefone', '$vendedorTelefone2', '$vendedorEndereco', '$vendedorCidade', '$vendedorEstado', '$vendedorCEP',"
                . " '$vendedorEmail', '$vendedorProfissao', '$vendedorRenda', '$vendedorEmpresa')";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no insert de insereObjeto: " . parent::getBdError());
            return false;
        }
    }

    public function alteraObjeto(Model $VendedorModel) {
        $vendedorId = $VendedorModel->getVendedorId();
        $vendedorNome = $VendedorModel->getVendedorNome();
        $vendedorNacionalidade = $VendedorModel->getVendedorNacionalidade();
        $vendedorDataNascimento = $VendedorModel->getVendedorDataNascimento();
        $vendedorCPF = $VendedorModel->getVendedorCPF();
        $vendedorRG = $VendedorModel->getVendedorRG();
        $vendedorOrgaoEmissor = $VendedorModel->getVendedorOrgaoEmissor();
        $vendedorEstadoOrgaoEmissor = $VendedorModel->getVendedorEstadoOrgaoEmissor();
        $vendedorSexo = $VendedorModel->getVendedorSexo();
        $vendedorEstadoCivil = $VendedorModel->getVendedorEstadoCivil();
        $vendedorRegimeComunhao = $VendedorModel->getVendedorRegimeComunhao();
        $vendedorFiliacao = $VendedorModel->getVendedorFiliacao();
        $vendedorFiliacao2 = $VendedorModel->getVendedorFiliacao2();
        $vendedorTelefone = $VendedorModel->getVendedorTelefone();
        $vendedorTelefone2 = $VendedorModel->getVendedorTelefone2();
        $vendedorEndereco = $VendedorModel->getVendedorEndereco();
        $vendedorCidade = $VendedorModel->getVendedorCidade();
        $vendedorEstado = $VendedorModel->getVendedorEstado();
        $vendedorCEP = $VendedorModel->getVendedorCEP();
        $vendedorEmail = $VendedorModel->getVendedorEmail();
        $vendedorProfissao = $VendedorModel->getVendedorProfissao();
        $vendedorRenda = $VendedorModel->getVendedorRenda();
        $vendedorEmpresa = $VendedorModel->getVendedorEmpresa();

        $query = "update Vendedores set vendedorNome = '{$vendedorNome}',"
                . " vendedorNacionalidade = '{$vendedorNacionalidade}',"
                . " vendedorDataNascimento = '{$vendedorDataNascimento}',"
                . " vendedorCPF = '{$vendedorCPF}',"
                . " vendedorRG = '{$vendedorRG}',"
                . " vendedorOrgaoEmissor = '{$vendedorOrgaoEmissor}',"
                . " vendedorEstadoOrgaoEmissor = '{$vendedorEstadoOrgaoEmissor}',"
                . " vendedorSexo = '{$vendedorSexo}',"
                . " vendedorEstadoCivil = '{$vendedorEstadoCivil}',"
                . " vendedorRegimeComunhao = '{$vendedorRegimeComunhao}',"
                . " vendedorFiliacao = '{$vendedorFiliacao}',"
                . " vendedorFiliacao2 = '{$vendedorFiliacao2}',"
                . " vendedorTelefone = '{$vendedorTelefone}',"
                . " vendedorTelefone2 = '{$vendedorTelefone2}',"
                . " vendedorEndereco = '{$vendedorEndereco}',"
                . " vendedorCidade = '{$vendedorCidade}',"
                . " vendedorEstado = '{$vendedorEstado}',"
                . " vendedorCEP = '{$vendedorCEP}',"
                . " vendedorEmail = '{$vendedorEmail}',"
                . " vendedorProfissao = '{$vendedorProfissao}',"
                . " vendedorRenda = '{$vendedorRenda}',"
                . " vendedorEmpresa = '{$vendedorEmpresa}'"
                . "where vendedorId = '{$vendedorId}'";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no update de alteraObjeto: " . parent::getBdError());
            return false;
        }
    }

    public function excluiObjeto(Model $VendedorModel) {
        $vendedorId = $VendedorModel->getVendedorId();

        $query = "delete from Vendedores "
                . "where vendedorId = {$vendedorId}";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no delete de excluiObjeto: " . parent::getBdError());
            return false;
        }
    }

}
