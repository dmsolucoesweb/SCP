<?php

require_once 'ADO.php';
require_once '../Classes/datasehoras.php';
require_once '../Models/ClienteModel.php';
require_once '../Classes/cpf.php';

class ClienteAdo extends ADO {

    public function consultaObjetoPeloId($id) {
        $query = "select * from Clientes where clienteId = '{$id}' ";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaObjetoPeloId: " . parent::getBdError());
            return false;
        }

        $DatasEHoras = new DatasEHoras();

        $cliente = parent::leTabelaBD();
        $clienteDataNascimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($cliente['clienteDataNascimento']);
        $clienteCppDataNascimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($cliente['clienteCppDataNascimento']);
        return new ClienteModel($cliente['clienteId'], $cliente['clienteNome'], $cliente['clienteNacionalidade'], $clienteDataNascimento, $cliente['clienteCPF'], $cliente['clienteRG'], $cliente['clienteOrgaoEmissor'], $cliente['clienteEstadoOrgaoEmissor'], $cliente['clienteSexo'], $cliente['clienteEstadoCivil'], $cliente['clienteRegimeComunhao'], $cliente['clienteFiliacao'], $cliente['clienteFiliacao2'], $cliente['clienteTelefone'], $cliente['clienteTelefone2'], $cliente['clienteEndereco'], $cliente['clienteCidade'], $cliente['clienteEstado'], $cliente['clienteCEP'], $cliente['clienteEmail'], $cliente['clienteProfissao'], $cliente['clienteRenda'], $cliente['clienteEmpresa'], $cliente['clienteCargo'], $cliente['clienteCppStatus'], $cliente['clienteCppNome'], $cliente['clienteCppNacionalidade'], $clienteCppDataNascimento, $cliente['clienteCppCPF'], $cliente['clienteCppRG'], $cliente['clienteCppOrgaoEmissor'], $cliente['clienteCppEstadoOrgaoEmissor'], $cliente['clienteCppSexo'], $cliente['clienteCppEstadoCivil'], $cliente['clienteCppRegimeComunhao'], $cliente['clienteCppFiliacao'], $cliente['clienteCppFiliacao2'], $cliente['clienteCppTelefone'], $cliente['clienteCppTelefone2'], $cliente['clienteCppEndereco'], $cliente['clienteCppCidade'], $cliente['clienteCppEstado'], $cliente['clienteCppCEP'], $cliente['clienteCppEmail'], $cliente['clienteCppProfissao'], $cliente['clienteCppRenda'], $cliente['clienteCppEmpresa'], $cliente['clienteCppCargo']);
    }

    public function consultaArrayDeObjeto() {
        $clienteModel = null;
        $query = "select * from Clientes order by clienteNome";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaArrayDeObjeto: " . parent::getBdError());
            return false;
        }

        $clientesModel = null;
        $DatasEHoras = new DatasEHoras();

        while ($cliente = parent::leTabelaBD()) {
            $clienteDataNascimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($cliente['clienteDataNascimento']);
            $clienteCppDataNascimento = $DatasEHoras->getDataEHorasDesinvertidaComBarras($cliente['clienteCppDataNascimento']);
            $clienteModel = new ClienteModel($cliente['clienteId'], $cliente['clienteNome'], $cliente['clienteNacionalidade'], $clienteDataNascimento, $cliente['clienteCPF'], $cliente['clienteRG'], $cliente['clienteOrgaoEmissor'], $cliente['clienteEstadoOrgaoEmissor'], $cliente['clienteSexo'], $cliente['clienteEstadoCivil'], $cliente['clienteRegimeComunhao'], $cliente['clienteFiliacao'], $cliente['clienteFiliacao2'], $cliente['clienteTelefone'], $cliente['clienteTelefone2'], $cliente['clienteEndereco'], $cliente['clienteCidade'], $cliente['clienteEstado'], $cliente['clienteCEP'], $cliente['clienteEmail'], $cliente['clienteProfissao'], $cliente['clienteRenda'], $cliente['clienteEmpresa'], $cliente['clienteCargo'], $cliente['clienteCppStatus'], $cliente['clienteCppNome'], $cliente['clienteCppNacionalidade'], $clienteCppDataNascimento, $cliente['clienteCppCPF'], $cliente['clienteCppRG'], $cliente['clienteCppOrgaoEmissor'], $cliente['clienteCppEstadoOrgaoEmissor'], $cliente['clienteCppSexo'], $cliente['clienteCppEstadoCivil'], $cliente['clienteCppRegimeComunhao'], $cliente['clienteCppFiliacao'], $cliente['clienteCppFiliacao2'], $cliente['clienteCppTelefone'], $cliente['clienteCppTelefone2'], $cliente['clienteCppEndereco'], $cliente['clienteCppCidade'], $cliente['clienteCppEstado'], $cliente['clienteCppCEP'], $cliente['clienteCppEmail'], $cliente['clienteCppProfissao'], $cliente['clienteCppRenda'], $cliente['clienteCppEmpresa'], $cliente['clienteCppCargo']);
            $clientesModel[] = $clienteModel;
        }

        return $clientesModel;
    }

    public function insereObjeto(Model $clienteModel) {
        $clienteNome = $clienteModel->getClienteNome();
        $clienteNacionalidade = $clienteModel->getClienteNacionalidade();
        $clienteDataNascimento = $clienteModel->getClienteDataNascimento();
        $clienteCPF = $clienteModel->getClienteCPF();
        $clienteRG = $clienteModel->getClienteRG();
        $clienteOrgaoEmissor = $clienteModel->getClienteOrgaoEmissor();
        $clienteEstadoOrgaoEmissor = $clienteModel->getClienteEstadoOrgaoEmissor();
        $clienteSexo = $clienteModel->getClienteSexo();
        $clienteEstadoCivil = $clienteModel->getClienteEstadoCivil();
        $clienteRegimeComunhao = $clienteModel->getClienteRegimeComunhao();
        $clienteFiliacao = $clienteModel->getClienteFiliacao();
        $clienteFiliacao2 = $clienteModel->getClienteFiliacao2();
        $clienteTelefone = $clienteModel->getClienteTelefone();
        $clienteTelefone2 = $clienteModel->getClienteTelefone2();
        $clienteEndereco = $clienteModel->getClienteEndereco();
        $clienteCidade = $clienteModel->getClienteCidade();
        $clienteEstado = $clienteModel->getClienteEstado();
        $clienteCEP = $clienteModel->getClienteCEP();
        $clienteEmail = $clienteModel->getClienteEmail();
        $clienteProfissao = $clienteModel->getClienteProfissao();
        $clienteRenda = $clienteModel->getClienteRenda();
        $clienteEmpresa = $clienteModel->getClienteEmpresa();
        $clienteCargo = $clienteModel->getClienteCargo();
        $clienteCppStatus = $clienteModel->getClienteCppStatus();
        $clienteCppNome = $clienteModel->getClienteCppNome();
        $clienteCppNacionalidade = $clienteModel->getClienteCppNacionalidade();
        $clienteCppDataNascimento = $clienteModel->getClienteCppDataNascimento();
        $clienteCppCPF = $clienteModel->getClienteCppCPF();
        $clienteCppRG = $clienteModel->getClienteCppRG();
        $clienteCppOrgaoEmissor = $clienteModel->getClienteCppOrgaoEmissor();
        $clienteCppEstadoOrgaoEmissor = $clienteModel->getClienteCppEstadoOrgaoEmissor();
        $clienteCppSexo = $clienteModel->getClienteCppSexo();
        $clienteCppEstadoCivil = $clienteModel->getClienteCppEstadoCivil();
        $clienteCppRegimeComunhao = $clienteModel->getClienteCppRegimeComunhao();
        $clienteCppFiliacao = $clienteModel->getClienteCppFiliacao();
        $clienteCppFiliacao2 = $clienteModel->getClienteCppFiliacao2();
        $clienteCppTelefone = $clienteModel->getClienteCppTelefone();
        $clienteCppTelefone2 = $clienteModel->getClienteCppTelefone2();
        $clienteCppEndereco = $clienteModel->getClienteCppEndereco();
        $clienteCppCidade = $clienteModel->getClienteCppCidade();
        $clienteCppEstado = $clienteModel->getClienteCppEstado();
        $clienteCppCEP = $clienteModel->getClienteCppCEP();
        $clienteCppEmail = $clienteModel->getClienteCppEmail();
        $clienteCppProfissao = $clienteModel->getClienteCppProfissao();
        $clienteCppRenda = $clienteModel->getClienteCppRenda();
        $clienteCppEmpresa = $clienteModel->getClienteCppEmpresa();
        $clienteCppCargo = $clienteModel->getClienteCppCargo();

        $query = "insert into Clientes (clienteId, clienteNome, clienteNacionalidade, clienteDataNascimento,"
                . " clienteCPF, clienteRG, clienteOrgaoEmissor, clienteEstadoOrgaoEmissor,"
                . " clienteSexo, clienteEstadoCivil, clienteRegimeComunhao, clienteFiliacao,"
                . " clienteFiliacao2, clienteTelefone, clienteTelefone2, clienteEndereco,"
                . " clienteCidade, clienteEstado, clienteCEP, clienteEmail, clienteProfissao,"
                . " clienteRenda, clienteEmpresa, clienteCargo, clienteCppStatus, clienteCppNome, clienteCppNacionalidade, clienteCppDataNascimento,"
                . " clienteCppCPF, clienteCppRG, clienteCppOrgaoEmissor, clienteCppEstadoOrgaoEmissor,"
                . " clienteCppSexo, clienteCppEstadoCivil, clienteCppRegimeComunhao, clienteCppFiliacao,"
                . " clienteCppFiliacao2, clienteCppTelefone, clienteCppTelefone2, clienteCppEndereco,"
                . " clienteCppCidade, clienteCppEstado, clienteCppCEP, clienteCppEmail, clienteCppProfissao,"
                . " clienteCppRenda, clienteCppEmpresa, clienteCppCargo) values (null, '$clienteNome', '$clienteNacionalidade',"
                . " '$clienteDataNascimento', '$clienteCPF', '$clienteRG', '$clienteOrgaoEmissor', '$clienteEstadoOrgaoEmissor',"
                . " '$clienteSexo', '$clienteEstadoCivil', '$clienteRegimeComunhao', '$clienteFiliacao', '$clienteFiliacao2',"
                . " '$clienteTelefone', '$clienteTelefone2', '$clienteEndereco', '$clienteCidade', '$clienteEstado', '$clienteCEP',"
                . " '$clienteEmail', '$clienteProfissao', '$clienteRenda', '$clienteEmpresa', '$clienteCargo', '$clienteCppStatus', '$clienteCppNome', '$clienteCppNacionalidade',"
                . " '$clienteCppDataNascimento', '$clienteCppCPF', '$clienteCppRG', '$clienteCppOrgaoEmissor', '$clienteCppEstadoOrgaoEmissor',"
                . " '$clienteCppSexo', '$clienteCppEstadoCivil', '$clienteCppRegimeComunhao', '$clienteCppFiliacao', '$clienteCppFiliacao2',"
                . " '$clienteCppTelefone', '$clienteCppTelefone2', '$clienteCppEndereco', '$clienteCppCidade', '$clienteCppEstado', '$clienteCppCEP',"
                . " '$clienteCppEmail', '$clienteCppProfissao', '$clienteCppRenda', '$clienteCppEmpresa', '$clienteCppCargo')";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no insert de insereObjeto: " . parent::getBdError());
            return false;
        }
    }

    public function alteraObjeto(Model $clienteModel) {
        $clienteId = $clienteModel->getClienteId();
        $clienteNome = $clienteModel->getClienteNome();
        $clienteNacionalidade = $clienteModel->getClienteNacionalidade();
        $clienteDataNascimento = $clienteModel->getClienteDataNascimento();
        $clienteCPF = $clienteModel->getClienteCPF();
        $clienteRG = $clienteModel->getClienteRG();
        $clienteOrgaoEmissor = $clienteModel->getClienteOrgaoEmissor();
        $clienteEstadoOrgaoEmissor = $clienteModel->getClienteEstadoOrgaoEmissor();
        $clienteSexo = $clienteModel->getClienteSexo();
        $clienteEstadoCivil = $clienteModel->getClienteEstadoCivil();
        $clienteRegimeComunhao = $clienteModel->getClienteRegimeComunhao();
        $clienteFiliacao = $clienteModel->getClienteFiliacao();
        $clienteFiliacao2 = $clienteModel->getClienteFiliacao2();
        $clienteTelefone = $clienteModel->getClienteTelefone();
        $clienteTelefone2 = $clienteModel->getClienteTelefone2();
        $clienteEndereco = $clienteModel->getClienteEndereco();
        $clienteCidade = $clienteModel->getClienteCidade();
        $clienteEstado = $clienteModel->getClienteEstado();
        $clienteCEP = $clienteModel->getClienteCEP();
        $clienteEmail = $clienteModel->getClienteEmail();
        $clienteProfissao = $clienteModel->getClienteProfissao();
        $clienteRenda = $clienteModel->getClienteRenda();
        $clienteEmpresa = $clienteModel->getClienteEmpresa();
        $clienteCargo = $clienteModel->getClienteCargo();
        $clienteCppStatus = $clienteModel->getClienteCppStatus();
        $clienteCppNome = $clienteModel->getClienteCppNome();
        $clienteCppNacionalidade = $clienteModel->getClienteCppNacionalidade();
        $clienteCppDataNascimento = $clienteModel->getClienteCppDataNascimento();
        $clienteCppCPF = $clienteModel->getClienteCppCPF();
        $clienteCppRG = $clienteModel->getClienteCppRG();
        $clienteCppOrgaoEmissor = $clienteModel->getClienteCppOrgaoEmissor();
        $clienteCppEstadoOrgaoEmissor = $clienteModel->getClienteCppEstadoOrgaoEmissor();
        $clienteCppSexo = $clienteModel->getClienteCppSexo();
        $clienteCppEstadoCivil = $clienteModel->getClienteCppEstadoCivil();
        $clienteCppRegimeComunhao = $clienteModel->getClienteCppRegimeComunhao();
        $clienteCppFiliacao = $clienteModel->getClienteCppFiliacao();
        $clienteCppFiliacao2 = $clienteModel->getClienteCppFiliacao2();
        $clienteCppTelefone = $clienteModel->getClienteCppTelefone();
        $clienteCppTelefone2 = $clienteModel->getClienteCppTelefone2();
        $clienteCppEndereco = $clienteModel->getClienteCppEndereco();
        $clienteCppCidade = $clienteModel->getClienteCppCidade();
        $clienteCppEstado = $clienteModel->getClienteCppEstado();
        $clienteCppCEP = $clienteModel->getClienteCppCEP();
        $clienteCppEmail = $clienteModel->getClienteCppEmail();
        $clienteCppProfissao = $clienteModel->getClienteCppProfissao();
        $clienteCppRenda = $clienteModel->getClienteCppRenda();
        $clienteCppEmpresa = $clienteModel->getClienteCppEmpresa();
        $clienteCppCargo = $clienteModel->getClienteCppCargo();

        $query = "update Clientes set clienteNome = '{$clienteNome}',"
                . " clienteNacionalidade = '{$clienteNacionalidade}',"
                . " clienteDataNascimento = '{$clienteDataNascimento}',"
                . " clienteCPF = '{$clienteCPF}',"
                . " clienteRG = '{$clienteRG}',"
                . " clienteOrgaoEmissor = '{$clienteOrgaoEmissor}',"
                . " clienteEstadoOrgaoEmissor = '{$clienteEstadoOrgaoEmissor}',"
                . " clienteSexo = '{$clienteSexo}',"
                . " clienteEstadoCivil = '{$clienteEstadoCivil}',"
                . " clienteRegimeComunhao = '{$clienteRegimeComunhao}',"
                . " clienteFiliacao = '{$clienteFiliacao}',"
                . " clienteFiliacao2 = '{$clienteFiliacao2}',"
                . " clienteTelefone = '{$clienteTelefone}',"
                . " clienteTelefone2 = '{$clienteTelefone2}',"
                . " clienteEndereco = '{$clienteEndereco}',"
                . " clienteCidade = '{$clienteCidade}',"
                . " clienteEstado = '{$clienteEstado}',"
                . " clienteCEP = '{$clienteCEP}',"
                . " clienteEmail = '{$clienteEmail}',"
                . " clienteProfissao = '{$clienteProfissao}',"
                . " clienteRenda = '{$clienteRenda}',"
                . " clienteEmpresa = '{$clienteEmpresa}',"
                . " clienteCargo = '{$clienteCargo}',"
                . " clienteCppStatus = '{$clienteCppStatus}',"
                . " clienteCppNome = '{$clienteCppNome}',"
                . " clienteCppNacionalidade = '{$clienteCppNacionalidade}',"
                . " clienteCppDataNascimento = '{$clienteCppDataNascimento}',"
                . " clienteCppCPF = '{$clienteCppCPF}',"
                . " clienteCppRG = '{$clienteCppRG}',"
                . " clienteCppOrgaoEmissor = '{$clienteCppOrgaoEmissor}',"
                . " clienteCppEstadoOrgaoEmissor = '{$clienteCppEstadoOrgaoEmissor}',"
                . " clienteCppSexo = '{$clienteCppSexo}',"
                . " clienteCppEstadoCivil = '{$clienteCppEstadoCivil}',"
                . " clienteCppRegimeComunhao = '{$clienteCppRegimeComunhao}',"
                . " clienteCppFiliacao = '{$clienteCppFiliacao}',"
                . " clienteCppFiliacao2 = '{$clienteCppFiliacao2}',"
                . " clienteCppTelefone = '{$clienteCppTelefone}',"
                . " clienteCppTelefone2 = '{$clienteCppTelefone2}',"
                . " clienteCppEndereco = '{$clienteCppEndereco}',"
                . " clienteCppCidade = '{$clienteCppCidade}',"
                . " clienteCppEstado = '{$clienteCppEstado}',"
                . " clienteCppCEP = '{$clienteCppCEP}',"
                . " clienteCppEmail = '{$clienteCppEmail}',"
                . " clienteCppProfissao = '{$clienteCppProfissao}',"
                . " clienteCppRenda = '{$clienteCppRenda}',"
                . " clienteCppEmpresa = '{$clienteCppEmpresa}',"
                . " clienteCppCargo = '{$clienteCppCargo}'"
                . " where clienteId = '{$clienteId}'";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no update de alteraObjeto: " . parent::getBdError());
            return false;
        }
    }

    public function excluiObjeto(Model $clienteModel) {
        $clienteId = $clienteModel->getClienteId();
        $query = "delete from Clientes "
                . "where clienteId = {$clienteId}";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no delete de excluiObjeto: " . parent::getBdError());
            return false;
        }
    }

}
