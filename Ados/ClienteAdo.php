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

    public function insereObjeto(Model $ClienteModel) {
        $clienteNome = $ClienteModel->getClienteNome();
        $clienteNacionalidade = $ClienteModel->getClienteNacionalidade();
        $clienteDataNascimento = $ClienteModel->getClienteDataNascimento();
        $clienteCPF = $ClienteModel->getClienteCPF();
        $clienteRG = $ClienteModel->getClienteRG();
        $clienteOrgaoEmissor = $ClienteModel->getClienteOrgaoEmissor();
        $clienteEstadoOrgaoEmissor = $ClienteModel->getClienteEstadoOrgaoEmissor();
        $clienteSexo = $ClienteModel->getClienteSexo();
        $clienteEstadoCivil = $ClienteModel->getClienteEstadoCivil();
        $clienteRegimeComunhao = $ClienteModel->getClienteRegimeComunhao();
        $clienteFiliacao = $ClienteModel->getClienteFiliacao();
        $clienteFiliacao2 = $ClienteModel->getClienteFiliacao2();
        $clienteTelefone = $ClienteModel->getClienteTelefone();
        $clienteTelefone2 = $ClienteModel->getClienteTelefone2();
        $clienteEndereco = $ClienteModel->getClienteEndereco();
        $clienteCidade = $ClienteModel->getClienteCidade();
        $clienteEstado = $ClienteModel->getClienteEstado();
        $clienteCEP = $ClienteModel->getClienteCEP();
        $clienteEmail = $ClienteModel->getClienteEmail();
        $clienteProfissao = $ClienteModel->getClienteProfissao();
        $clienteRenda = $ClienteModel->getClienteRenda();
        $clienteEmpresa = $ClienteModel->getClienteEmpresa();
        $clienteCargo = $ClienteModel->getClienteCargo();
        $clienteCppStatus = $ClienteModel->getClienteCppStatus();
        $clienteCppNome = $ClienteModel->getClienteCppNome();
        $clienteCppNacionalidade = $ClienteModel->getClienteCppNacionalidade();
        $clienteCppDataNascimento = $ClienteModel->getClienteCppDataNascimento();
        $clienteCppCPF = $ClienteModel->getClienteCppCPF();
        $clienteCppRG = $ClienteModel->getClienteCppRG();
        $clienteCppOrgaoEmissor = $ClienteModel->getClienteCppOrgaoEmissor();
        $clienteCppEstadoOrgaoEmissor = $ClienteModel->getClienteCppEstadoOrgaoEmissor();
        $clienteCppSexo = $ClienteModel->getClienteCppSexo();
        $clienteCppEstadoCivil = $ClienteModel->getClienteCppEstadoCivil();
        $clienteCppRegimeComunhao = $ClienteModel->getClienteCppRegimeComunhao();
        $clienteCppFiliacao = $ClienteModel->getClienteCppFiliacao();
        $clienteCppFiliacao2 = $ClienteModel->getClienteCppFiliacao2();
        $clienteCppTelefone = $ClienteModel->getClienteCppTelefone();
        $clienteCppTelefone2 = $ClienteModel->getClienteCppTelefone2();
        $clienteCppEndereco = $ClienteModel->getClienteCppEndereco();
        $clienteCppCidade = $ClienteModel->getClienteCppCidade();
        $clienteCppEstado = $ClienteModel->getClienteCppEstado();
        $clienteCppCEP = $ClienteModel->getClienteCppCEP();
        $clienteCppEmail = $ClienteModel->getClienteCppEmail();
        $clienteCppProfissao = $ClienteModel->getClienteCppProfissao();
        $clienteCppRenda = $ClienteModel->getClienteCppRenda();
        $clienteCppEmpresa = $ClienteModel->getClienteCppEmpresa();
        $clienteCppCargo = $ClienteModel->getClienteCppCargo();

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

    public function alteraObjeto(Model $ClienteModel) {
        $clienteId = $ClienteModel->getClienteId();
        $clienteNome = $ClienteModel->getClienteNome();
        $clienteNacionalidade = $ClienteModel->getClienteNacionalidade();
        $clienteDataNascimento = $ClienteModel->getClienteDataNascimento();
        $clienteCPF = $ClienteModel->getClienteCPF();
        $clienteRG = $ClienteModel->getClienteRG();
        $clienteOrgaoEmissor = $ClienteModel->getClienteOrgaoEmissor();
        $clienteEstadoOrgaoEmissor = $ClienteModel->getClienteEstadoOrgaoEmissor();
        $clienteSexo = $ClienteModel->getClienteSexo();
        $clienteEstadoCivil = $ClienteModel->getClienteEstadoCivil();
        $clienteRegimeComunhao = $ClienteModel->getClienteRegimeComunhao();
        $clienteFiliacao = $ClienteModel->getClienteFiliacao();
        $clienteFiliacao2 = $ClienteModel->getClienteFiliacao2();
        $clienteTelefone = $ClienteModel->getClienteTelefone();
        $clienteTelefone2 = $ClienteModel->getClienteTelefone2();
        $clienteEndereco = $ClienteModel->getClienteEndereco();
        $clienteCidade = $ClienteModel->getClienteCidade();
        $clienteEstado = $ClienteModel->getClienteEstado();
        $clienteCEP = $ClienteModel->getClienteCEP();
        $clienteEmail = $ClienteModel->getClienteEmail();
        $clienteProfissao = $ClienteModel->getClienteProfissao();
        $clienteRenda = $ClienteModel->getClienteRenda();
        $clienteEmpresa = $ClienteModel->getClienteEmpresa();
        $clienteCargo = $ClienteModel->getClienteCargo();
        $clienteCppStatus = $ClienteModel->getClienteCppStatus();
        $clienteCppNome = $ClienteModel->getClienteCppNome();
        $clienteCppNacionalidade = $ClienteModel->getClienteCppNacionalidade();
        $clienteCppDataNascimento = $ClienteModel->getClienteCppDataNascimento();
        $clienteCppCPF = $ClienteModel->getClienteCppCPF();
        $clienteCppRG = $ClienteModel->getClienteCppRG();
        $clienteCppOrgaoEmissor = $ClienteModel->getClienteCppOrgaoEmissor();
        $clienteCppEstadoOrgaoEmissor = $ClienteModel->getClienteCppEstadoOrgaoEmissor();
        $clienteCppSexo = $ClienteModel->getClienteCppSexo();
        $clienteCppEstadoCivil = $ClienteModel->getClienteCppEstadoCivil();
        $clienteCppRegimeComunhao = $ClienteModel->getClienteCppRegimeComunhao();
        $clienteCppFiliacao = $ClienteModel->getClienteCppFiliacao();
        $clienteCppFiliacao2 = $ClienteModel->getClienteCppFiliacao2();
        $clienteCppTelefone = $ClienteModel->getClienteCppTelefone();
        $clienteCppTelefone2 = $ClienteModel->getClienteCppTelefone2();
        $clienteCppEndereco = $ClienteModel->getClienteCppEndereco();
        $clienteCppCidade = $ClienteModel->getClienteCppCidade();
        $clienteCppEstado = $ClienteModel->getClienteCppEstado();
        $clienteCppCEP = $ClienteModel->getClienteCppCEP();
        $clienteCppEmail = $ClienteModel->getClienteCppEmail();
        $clienteCppProfissao = $ClienteModel->getClienteCppProfissao();
        $clienteCppRenda = $ClienteModel->getClienteCppRenda();
        $clienteCppEmpresa = $ClienteModel->getClienteCppEmpresa();
        $clienteCppCargo = $ClienteModel->getClienteCppCargo();

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

    public function excluiObjeto(Model $ClienteModel) {
        $clienteId = $ClienteModel->getClienteId();
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
