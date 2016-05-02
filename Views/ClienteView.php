<?php

require_once 'HtmlGeral.php';
require_once '../Classes/montahtml.php';
require_once '../Classes/datasehoras.php';
require_once '../Classes/cpf.php';
require_once '../Ados/ProdutoAdo.php';
include('../Classes/functions.php');

class ClienteView extends HtmlGeral {

    public function getDadosEntrada() {
        $DatasEHoras = new DatasEHoras();
        $CPF = new CPF();

        $clienteId = $this->getValorOuNull('clienteId');
        $clienteNome = $this->getValorOuNull('clienteNome');
        $clienteNacionalidade = $this->getValorOuNull('clienteNacionalidade');
        $clienteDataNascimento = $DatasEHoras->getDataEHorasInvertidaComTracos($this->getValorOuNull('clienteDataNascimento'));
        $clienteCPF = $CPF->retiraMascaraCPF($this->getValorOuNull('clienteCPF'));
        $clienteRG = $this->getValorOuNull('clienteRG');
        $clienteOrgaoEmissor = $this->getValorOuNull('clienteOrgaoEmissor');
        $clienteEstadoOrgaoEmissor = $this->getValorOuNull('clienteEstadoOrgaoEmissor');
        $clienteSexo = $this->getValorOuNull('clienteSexo');
        $clienteEstadoCivil = $this->getValorOuNull('clienteEstadoCivil');
        $clienteRegimeComunhao = $this->getValorOuNull('clienteRegimeComunhao');
        $clienteFiliacao = $this->getValorOuNull('clienteFiliacao');
        $clienteFiliacao2 = $this->getValorOuNull('clienteFiliacao2');
        $clienteTelefone = $this->getValorOuNull('clienteTelefone');
        $clienteTelefone2 = $this->getValorOuNull('clienteTelefone2');
        $clienteEndereco = $this->getValorOuNull('clienteEndereco');
        $clienteCidade = $this->getValorOuNull('clienteCidade');
        $clienteEstado = $this->getValorOuNull('clienteEstado');
        $clienteCEP = $this->getValorOuNull('clienteCEP');
        $clienteEmail = $this->getValorOuNull('clienteEmail');
        $clienteProfissao = $this->getValorOuNull('clienteProfissao');
        $clienteRenda = $CPF->retiraMascaraRenda($this->getValorOuNull('clienteRenda'));
        $clienteEmpresa = $this->getValorOuNull('clienteEmpresa');
        $clienteCargo = $this->getValorOuNull('clienteCargo');
        $clienteCppStatus = $this->getValorOuNull('clienteCppStatus');
        $clienteCppNome = $this->getValorOuNull('clienteCppNome');
        $clienteCppNacionalidade = $this->getValorOuNull('clienteCppNacionalidade');
        $clienteCppDataNascimento = $DatasEHoras->getDataEHorasInvertidaComTracos($this->getValorOuNull('clienteCppDataNascimento'));
        $clienteCppCPF = $CPF->retiraMascaraCPF($this->getValorOuNull('clienteCppCPF'));
        $clienteCppRG = $this->getValorOuNull('clienteCppRG');
        $clienteCppOrgaoEmissor = $this->getValorOuNull('clienteCppOrgaoEmissor');
        $clienteCppEstadoOrgaoEmissor = $this->getValorOuNull('clienteCppEstadoOrgaoEmissor');
        $clienteCppSexo = $this->getValorOuNull('clienteCppSexo');
        $clienteCppEstadoCivil = $this->getValorOuNull('clienteCppEstadoCivil');
        $clienteCppRegimeComunhao = $this->getValorOuNull('clienteCppRegimeComunhao');
        $clienteCppFiliacao = $this->getValorOuNull('clienteCppFiliacao');
        $clienteCppFiliacao2 = $this->getValorOuNull('clienteCppFiliacao2');
        $clienteCppTelefone = $this->getValorOuNull('clienteCppTelefone');
        $clienteCppTelefone2 = $this->getValorOuNull('clienteCppTelefone2');
        $clienteCppEndereco = $this->getValorOuNull('clienteCppEndereco');
        $clienteCppCidade = $this->getValorOuNull('clienteCppCidade');
        $clienteCppEstado = $this->getValorOuNull('clienteCppEstado');
        $clienteCppCEP = $this->getValorOuNull('clienteCppCEP');
        $clienteCppEmail = $this->getValorOuNull('clienteCppEmail');
        $clienteCppProfissao = $this->getValorOuNull('clienteCppProfissao');
        $clienteCppRenda = $CPF->retiraMascaraRenda($this->getValorOuNull('clienteCppRenda'));
        $clienteCppEmpresa = $this->getValorOuNull('clienteCppEmpresa');
        $clienteCppCargo = $this->getValorOuNull('clienteCppCargo');

        return new ClienteModel($clienteId, $clienteNome, $clienteNacionalidade, $clienteDataNascimento, $clienteCPF, $clienteRG, $clienteOrgaoEmissor, $clienteEstadoOrgaoEmissor, $clienteSexo, $clienteEstadoCivil, $clienteRegimeComunhao, $clienteFiliacao, $clienteFiliacao2, $clienteTelefone, $clienteTelefone2, $clienteEndereco, $clienteCidade, $clienteEstado, $clienteCEP, $clienteEmail, $clienteProfissao, $clienteRenda, $clienteEmpresa, $clienteCargo, $clienteCppStatus, $clienteCppNome, $clienteCppNacionalidade, $clienteCppDataNascimento, $clienteCppCPF, $clienteCppRG, $clienteCppOrgaoEmissor, $clienteCppEstadoOrgaoEmissor, $clienteCppSexo, $clienteCppEstadoCivil, $clienteCppRegimeComunhao, $clienteCppFiliacao, $clienteCppFiliacao2, $clienteCppTelefone, $clienteCppTelefone2, $clienteCppEndereco, $clienteCppCidade, $clienteCppEstado, $clienteCppCEP, $clienteCppEmail, $clienteCppProfissao, $clienteCppRenda, $clienteCppEmpresa, $clienteCppCargo);
    }

    public function montaOpcoesDeClientes($clienteSelected) {
        $opcoesDeClientes = null;

        $clienteAdo = new ClienteAdo();
        $arrayDeClientes = $clienteAdo->consultaArrayDeObjeto();

        if ($arrayDeClientes === 0) {
            return null;
        }

        if (is_array($arrayDeClientes)) {
            foreach ($arrayDeClientes as $clienteModel) {
                $selected = null;

                $clienteId = $clienteModel->getClienteId();
                $clienteNome = $clienteModel->getClienteNome();
                $clienteCPF = $clienteModel->getClienteCPF();

                $text = 'Nome: ' . $clienteNome . ' | CPF: ' . mascara($clienteCPF, '###.###.###-##');

                if ($clienteId == $clienteSelected) {
                    $selected = 1;
                }

                $opcoesDeClientes[] = array("value" => $clienteId, "selected" => $selected, "text" => $text);
            }
        }
        return $opcoesDeClientes;
    }

    public function montaDados($clienteModel) {
        $dados = null;
        $MontaHtml = new MontaHTML();
        $ClienteAdo = new ClienteAdo();
        $ProdutoAdo = new ProdutoAdo();

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
        $clienteRenda = number_format($clienteModel->getClienteRenda(), 2, ",", ".");
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
        $clienteCppRenda = number_format($clienteModel->getClienteCppRenda(), 2, ",", ".");
        $clienteCppEmpresa = $clienteModel->getClienteCppEmpresa();
        $clienteCppCargo = $clienteModel->getClienteCppCargo();
        $Produto = $ProdutoAdo->consultaProdutoPeloCliente($clienteId);



        $htmlComboClientes = array("label" => "Clientes", "name" => "idConsulta", "options" => $this->montaOpcoesDeClientes($clienteId));
        $comboDeClientes = $MontaHtml->montaCombobox($htmlComboClientes, $textoPadrao = 'Escolha um Cliente...', $onChange = null, $disabled = false);

        $dados .= "<form action='Cliente.php' method='post'>
                    <h1>Cadastro de Cliente</h1>
                    <div class='well'><legend>Consulta</legend>";

        $dados .= $comboDeClientes;

        $dados .= "<button name='bt' type='submit' class='btn btn-info' value='con'><i class='glyphicon glyphicon-search'></i> Consultar</button>
                   <button name='bt' type='submit' class='btn btn-info' value='erl'><i class='glyphicon glyphicon-print'></i> Emitir Relatório</button></div>";

        if (is_array($Produto)) {
            $dados .= "<div class='aptos_cliente'><h3 class='h3aptos_cliente'>Apartamentos adquiridos pelo cliente</h3>";
            foreach ($Produto as $Produto) {
                $produtoApartamento = $Produto->getProdutoApartamento();
                $produtoBox = $Produto->getProdutoBox();
                $produtoId = $Produto->getProdutoId();

                $dados .= "<button name='bt' type='submit' class='btn btn-block btn-cliente' value='$produtoId'><div class='esquerda'><i class='glyphicon glyphicon-flag'></i></div> <div class='esquerda'><span>ID:</span> $produtoId<br /><span>Apartamento:</span> [$produtoApartamento]<br /><span>Box:</span> [$produtoBox]</div></button>";
            }
            $dados .= "</div>";
        }

        $dadosfieldsetHidden = array("name" => "clienteId", "value" => $clienteId);
        $hiddenId = $MontaHtml->montaInputHidden($dadosfieldsetHidden);
        $hiddenId .= "<div class='row'>";

        $htmlFieldsetNome = array("label" => "Nome", "obg" => true,"classefg" => "col-md-12", "type" => "text", "name" => "clienteNome", "value" => $clienteNome, "placeholder" => null, "disabled" => false);
        $fieldsetNome = $MontaHtml->montaInput($htmlFieldsetNome);
        $fieldsetNome .= "</div><div class='row'>";

        $selected1 = $selected2 = null;
        switch ($clienteNacionalidade) {
            case '1':
                $selected1 = "selected='selected'";
                break;
            case '2':
                $selected2 = "selected='selected'";
                break;
        }

        $htmlComboNacionalidade = array("label" => "Nacionalidade", "obg" => true, "classefg" => "col-md-6", "name" => "clienteNacionalidade",
            "options" => array(array("value" => "1", "selected" => $selected1, "text" => "Brasileiro(a)"),
                array("value" => "2", "selected" => $selected2, "text" => "Internacional")));
        $comboDeNacionalidade = $MontaHtml->montaCombobox($htmlComboNacionalidade, $textoPadrao = 'Escolha uma Nacionalidade...');

        $htmlFieldsetData = array("label" => "Data de Nascimento", "obg" => true, "classefg" => "col-md-6", "name" => "clienteDataNascimento", "value" => $clienteDataNascimento, "disabled" => false);
        $fieldsetDataNascimento = $MontaHtml->montaInputDeData($htmlFieldsetData);
        $fieldsetDataNascimento .= "</div><div class='row'>";

        $htmlFieldsetCPF = array("label" => "CPF", "obg" => true, "classefg" => "col-md-7", "type" => "text", "classecampo" => "cpf", "name" => "clienteCPF", "value" => $clienteCPF, "placeholder" => null, "disabled" => false);
        $fieldseCPF = $MontaHtml->montaInput($htmlFieldsetCPF);

        $m = $f = null;
        switch ($clienteSexo) {
            case 'M':
                $m = 1;
                break;
            case 'F':
                $f = 1;
                break;
        }

        $htmlDadosRadioSexo = array("label" => "Sexo", "obg" => true, "classefg" => "col-md-5", "buttons" => array
                (array("name" => "clienteSexo", "value" => "M", "checked" => $m, "text" => "Masculino"),
                array("name" => "clienteSexo", "value" => "F", "checked" => $f, "text" => "Feminino")));
        $sexoHtml = $MontaHtml->montaRadioEmLinha($htmlDadosRadioSexo);
        $sexoHtml .= "</div><div class='row'>";

        $htmlFieldsetRG = array("label" => "RG ", "obg" => true, "classefg" => "col-md-4", "type" => "text", "name" => "clienteRG", "value" => $clienteRG, "placeholder" => null, "disabled" => false);
        $fieldseRG = $MontaHtml->montaInput($htmlFieldsetRG);

        $htmlFieldsetOE = array("label" => "Org. Exped.", "obg" => true, "classefg" => "col-md-4", "type" => "text", "name" => "clienteOrgaoEmissor", "value" => $clienteOrgaoEmissor, "placeholder" => null, "disabled" => false);
        $fieldseOE = $MontaHtml->montaInput($htmlFieldsetOE);

        $estadosBrasileirosHtml = parent::montaHtmlEstadosBrasileiros("UF", "clienteEstadoOrgaoEmissor", true, "col-md-4", $clienteEstadoOrgaoEmissor);
        $estadosBrasileirosHtml .= "</div><div class='row'>";

        $selected3 = $selected4 = $selected5 = $selected6 = $selected7 = null;
        switch ($clienteEstadoCivil) {
            case '1':
                $selected3 = "selected='selected'";
                $disabled_regime = true;
                break;
            case '2':
                $selected4 = "selected='selected'";
                $disabled_regime = false;
                break;
            case '3':
                $selected5 = "selected='selected'";
                $disabled_regime = true;
                break;
            case '4':
                $selected6 = "selected='selected'";
                $disabled_regime = true;
                break;
            case '5':
                $selected7 = "selected='selected'";
                $disabled_regime = false;
                break;
        }

        $htmlComboEstadoCivil = array("label" => "Estado Civil",  "obg" => true, "classefg" => "col-md-4", "name" => "clienteEstadoCivil",
            "options" => array(array("value" => "1", "selected" => $selected3, "text" => "Solteiro(a)"),
                array("value" => "2", "selected" => $selected4, "text" => "Casado(a)"),
                array("value" => "3", "selected" => $selected5, "text" => "Divorciado(a)"),
                array("value" => "4", "selected" => $selected6, "text" => "Viuvo(a)"),
                array("value" => "5", "selected" => $selected7, "text" => "União Estável")));
        $comboDeEstadoCivil = $MontaHtml->montaCombobox($htmlComboEstadoCivil, $textoPadrao = 'Escolha um Estado Civil...');

        $selected8 = $selected9 = $selected10 = $selected11 = $selected12 = null;
        switch ($clienteRegimeComunhao) {
            case '1':
                $selected8 = "selected='selected'";
                break;
            case '2':
                $selected9 = "selected='selected'";
                break;
            case '3':
                $selected10 = "selected='selected'";
                break;
            case '4':
                $selected11 = "selected='selected'";
                break;
        }

        $htmlComboRegimeComunhao = array("label" => "Regime de Bens", "obg" => true, "classefg" => "col-md-4", "name" => "clienteRegimeComunhao",
            "options" => array(array("value" => "1", "selected" => $selected8, "text" => "Comunhão Parcial de Bens"),
                array("value" => "2", "selected" => $selected9, "text" => "Comunhão Universal de Bens"),
                array("value" => "3", "selected" => $selected10, "text" => "Separação Total de Bens"),
                array("value" => "4", "selected" => $selected11, "text" => "Participação Final de Aquestos")));
        $comboDeEstadoRegimeComunhao = $MontaHtml->montaCombobox($htmlComboRegimeComunhao, $textoPadrao = 'Escolha um Regime de Bens...', $onChange = null, $disabled = $disabled_regime);

        $htmlFieldsetRenda = array("label" => "Renda", "obg" => true, "classefg" => "col-md-4", "classecampo" => "moeda", "type" => "text", "name" => "clienteRenda", "value" => $clienteRenda, "placeholder" => null, "disabled" => false);
        $fieldseRenda = $MontaHtml->montaInput($htmlFieldsetRenda);
        $fieldseRenda .= "</div><div class='row'>";

        $labelFiliacao = "<div class='col-md-2'><legend>Filiação</legend></div><div class='col-md-10'>";

        $htmlFieldsetFiliacao2 = array("label" => "Mãe", "obg" => true, "classefg" => "col-md-11", "type" => "text", "name" => "clienteFiliacao2", "value" => $clienteFiliacao2, "placeholder" => null, "disabled" => false);
        $fieldseFiliacao2 = $MontaHtml->montaInput($htmlFieldsetFiliacao2);

        $htmlFieldsetFiliacao = array("label" => "Pai", "obg" => false, "classefg" => "col-md-11", "type" => "text", "name" => "clienteFiliacao", "value" => $clienteFiliacao, "placeholder" => null, "disabled" => false);
        $fieldseFiliacao = $MontaHtml->montaInput($htmlFieldsetFiliacao) . "</div></div><div class='row'>";

        $htmlFieldsetEndereco = array("label" => "Endereço", "obg" => true, "classefg" => "col-md-12", "type" => "text", "name" => "clienteEndereco", "value" => $clienteEndereco, "placeholder" => null, "disabled" => false);
        $fieldseEndereco = $MontaHtml->montaInput($htmlFieldsetEndereco) . "</div><div class='row'>";

        $htmlFieldsetCEP = array("label" => "CEP", "obg" => true, "classefg" => "col-md-4", "type" => "text", "classecampo" => "cep", "name" => "clienteCEP", "value" => $clienteCEP, "placeholder" => null, "disabled" => false);
        $fieldseCEP = $MontaHtml->montaInput($htmlFieldsetCEP);

        $htmlFieldsetCidade = array("label" => "Cidade", "obg" => true, "classefg" => "col-md-4", "type" => "text", "name" => "clienteCidade", "value" => $clienteCidade, "placeholder" => null, "disabled" => false);
        $fieldseCidade = $MontaHtml->montaInput($htmlFieldsetCidade);

        $estadosBrasileirosHtml2 = parent::montaHtmlEstadosBrasileiros("UF", "clienteEstado", true, "col-md-4", $clienteEstado);
        $estadosBrasileirosHtml2 .="</div><div class='row'>";

        $htmlFieldsetTelefone = array("label" => "Telefone Celular", "obg" => true, "classefg" => "col-md-4", "classecampo" => "fone", "type" => "text", "name" => "clienteTelefone", "value" => $clienteTelefone, "placeholder" => null, "disabled" => false);
        $fieldseTelefone = $MontaHtml->montaInput($htmlFieldsetTelefone);

        $htmlFieldsetTelefone2 = array("label" => "Telefone Fixo", "type" => "text", "classefg" => "col-md-4", "classecampo" => "fone", "name" => "clienteTelefone2", "value" => $clienteTelefone2, "placeholder" => null, "disabled" => false);
        $fieldseTelefone2 = $MontaHtml->montaInput($htmlFieldsetTelefone2);

        $htmlFieldsetEmail = array("label" => "E-mail", "type" => "email", "classefg" => "col-md-4", "name" => "clienteEmail", "value" => $clienteEmail, "placeholder" => null, "disabled" => false);
        $fieldseEmail = $MontaHtml->montaInput($htmlFieldsetEmail);
        $fieldseEmail .= "</div><div class='row'>";

        $htmlFieldsetProfissao = array("label" => "Profissão", "obg" => true, "classefg" => "col-md-4", "type" => "text", "name" => "clienteProfissao", "value" => $clienteProfissao, "placeholder" => null, "disabled" => false);
        $fieldseProfissao = $MontaHtml->montaInput($htmlFieldsetProfissao);

        $htmlFieldsetEmpresa = array("label" => "Empresa", "classefg" => "col-md-4", "type" => "text", "name" => "clienteEmpresa", "value" => $clienteEmpresa, "placeholder" => null, "disabled" => false);
        $fieldseEmpresa = $MontaHtml->montaInput($htmlFieldsetEmpresa);

        $htmlFieldsetCargo = array("label" => "Cargo", "classefg" => "col-md-4", "type" => "text", "name" => "clienteCargo", "value" => $clienteCargo, "placeholder" => null, "disabled" => false);
        $fieldseCargo = $MontaHtml->montaInput($htmlFieldsetCargo) . "</div>";

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $cpp1 = $cpp2 = $cpp3 = $cpp4 = null;
        switch ($clienteCppStatus) {
            case 'C':
                $cpp1 = 1;
                break;
            case 'SP':
                $cpp2 = 1;
                break;
            case 'P':
                $cpp3 = 1;
                break;
            case 'N':
                $cpp4 = 1;
                break;
            case null:
                $cpp4 = 1;
                break;
        }

        $htmlDadosRadioStatusCpp = array("label" => "Possui Cônjuge, Segundo Proponente ou Procurador?",  "obg" => true, "classefg" => "col-md-10", "buttons" => array
                (array("name" => "clienteCppStatus", "value" => "C", "checked" => $cpp1, "text" => "Cônjuge"),
                array("name" => "clienteCppStatus", "value" => "SP", "checked" => $cpp2, "text" => "Segundo Proponente"),
                array("name" => "clienteCppStatus", "value" => "P", "checked" => $cpp3, "text" => "Procurador"),
                array("name" => "clienteCppStatus", "value" => "N", "checked" => $cpp4, "text" => "Nenhum")));
        $radioHtmlStatusCpp = $MontaHtml->montaRadioEmLinha($htmlDadosRadioStatusCpp) . "</div>";

        $htmlFieldsetNomeCpp = array("label" => "Nome", "obg" => true, "classefg" => "col-md-12", "type" => "text", "name" => "clienteCppNome", "value" => $clienteCppNome, "placeholder" => null, "disabled" => false);
        $fieldsetNomeCpp = "<div class='row'>" . $MontaHtml->montaInput($htmlFieldsetNomeCpp);
        $fieldsetNomeCpp .= "</div><div class='row'>";

        $selected13 = $selected14 = null;
        switch ($clienteCppNacionalidade) {
            case '1':
                $selected13 = "selected='selected'";
                break;
            case '2':
                $selected14 = "selected='selected'";
                break;
        }

        $htmlComboNacionalidadeCpp = array("label" => "Nacionalidade", "obg" => true, "classefg" => "col-md-6", "name" => "clienteCppNacionalidade",
            "options" => array(array("value" => "1", "selected" => $selected13, "text" => "Brasileiro(a)"),
                array("value" => "2", "selected" => $selected14, "text" => "Internacional")));
        $comboDeNacionalidadeCpp = $MontaHtml->montaCombobox($htmlComboNacionalidadeCpp, $textoPadrao = 'Escolha uma Nacionalidade');

        $htmlFieldsetDataCpp = array("label" => "Data de Nascimento", "obg" => true, "name" => "clienteCppDataNascimento", "classefg" => "col-md-6", "value" => $clienteCppDataNascimento, "disabled" => false);
        $fieldsetDataNascimentoCpp = $MontaHtml->montaInputDeData($htmlFieldsetDataCpp);
        $fieldsetDataNascimentoCpp .= "</div><div class='row'>";

        $htmlFieldsetCPFCpp = array("label" => "CPF", "obg" => true, "classefg" => "col-md-7", "type" => "text", "classecampo" => "cpf", "name" => "clienteCppCPF", "value" => $clienteCppCPF, "placeholder" => null, "disabled" => false);
        $fieldseCPFCpp = $MontaHtml->montaInput($htmlFieldsetCPFCpp);

        $mcpp = $fcpp = null;
        switch ($clienteCppSexo) {
            case 'M':
                $mcpp = 1;
                break;
            case 'F':
                $fcpp = 1;
                break;
        }

        $htmlDadosRadioSexoCpp = array("label" => "Sexo", "obg" => true, "classefg" => "col-md-5", "buttons" => array
                (array("name" => "clienteCppSexo", "value" => "M", "checked" => $mcpp, "text" => "Masculino"),
                array("name" => "clienteCppSexo", "value" => "F", "checked" => $fcpp, "text" => "Feminino")));
        $sexoHtmlCpp = $MontaHtml->montaRadioEmLinha($htmlDadosRadioSexoCpp) . "</div><div class='row'>";

        $htmlFieldsetRGCpp = array("label" => "RG", "obg" => true, "classefg" => "col-md-4", "type" => "text", "name" => "clienteCppRG", "value" => $clienteCppRG, "placeholder" => null, "disabled" => false);
        $fieldseRGCpp = $MontaHtml->montaInput($htmlFieldsetRGCpp);

        $htmlFieldsetOECpp = array("label" => "Org. Exped.", "obg" => true, "classefg" => "col-md-4", "type" => "text", "name" => "clienteCppOrgaoEmissor", "value" => $clienteCppOrgaoEmissor, "placeholder" => null, "disabled" => false);
        $fieldseOECpp = $MontaHtml->montaInput($htmlFieldsetOECpp);

        $estadosBrasileirosHtmlCpp = parent::montaHtmlEstadosBrasileiros("UF", "clienteCppEstadoOrgaoEmissor", true, "col-md-4", $clienteCppEstadoOrgaoEmissor) . "</div><div class='row'>";

        $selected15 = $selected16 = $selected17 = $selected18 = $selected19 = null;
        switch ($clienteCppEstadoCivil) {
            case '1':
                $selected15 = "selected='selected'";
                $disabled_regime2 = true;
                break;
            case '2':
                $selected16 = "selected='selected'";
                $disabled_regime2 = false;
                break;
            case '3':
                $selected17 = "selected='selected'";
                $disabled_regime2 = false;
                break;
            case '4':
                $selected18 = "selected='selected'";
                $disabled_regime2 = false;
                break;
            case '5':
                $selected19 = "selected='selected'";
                $disabled_regime2 = false;
                break;
        }

        $htmlComboEstadoCivilCpp = array("label" => "Estado Civil", "obg" => true, "classefg" => "col-md-4", "name" => "clienteCppEstadoCivil",
            "options" => array(array("value" => "1", "selected" => $selected15, "text" => "Solteiro(a)"),
                array("value" => "2", "selected" => $selected16, "text" => "Casado(a)"),
                array("value" => "3", "selected" => $selected17, "text" => "Divorciado(a)"),
                array("value" => "4", "selected" => $selected18, "text" => "Viuvo(a)"),
                array("value" => "5", "selected" => $selected19, "text" => "União Estável")));
        $comboDeEstadoCivilCpp = $MontaHtml->montaCombobox($htmlComboEstadoCivilCpp, $textoPadrao = 'Escolha um Estado Civil...');

        $selected20 = $selected21 = $selected22 = $selected23 = null;
        switch ($clienteCppRegimeComunhao) {
            case '1':
                $selected20 = "selected='selected'";
                break;
            case '2':
                $selected21 = "selected='selected'";
                break;
            case '3':
                $selected22 = "selected='selected'";
                break;
            case '4':
                $selected23 = "selected='selected'";
                break;
        }

        $htmlComboRegimeComunhaoCpp = array("label" => "Regime de Bens", "obg" => true, "classefg" => "col-md-4", "name" => "clienteCppRegimeComunhao",
            "options" => array(array("value" => "1", "selected" => $selected20, "text" => "Comunhão Parcial de Bens"),
                array("value" => "2", "selected" => $selected21, "text" => "Comunhão Universal de Bens"),
                array("value" => "3", "selected" => $selected22, "text" => "Separação Total de Bens"),
                array("value" => "4", "selected" => $selected23, "text" => "Participação Final nos Aquestos")));
        $comboDeEstadoRegimeComunhaoCpp = $MontaHtml->montaCombobox($htmlComboRegimeComunhaoCpp, $textoPadrao = 'Escolha um Regime de Bens...', $onChange = null, $disabled = $disabled_regime2);

        $htmlFieldsetRendaCpp = array("label" => "Renda", "obg" => true, "classefg" => "col-md-4", "type" => "text", "classecampo" => "moeda", "name" => "clienteCppRenda", "value" => $clienteCppRenda, "placeholder" => null, "disabled" => false);
        $fieldseRendaCpp = $MontaHtml->montaInput($htmlFieldsetRendaCpp) . "</div><div class='row'>";

        $labelFiliacaoCpp = "<div class='col-md-2'><legend>Filiação</legend></div><div class='col-md-10'>";

        $htmlFieldsetFiliacao2Cpp = array("label" => "Mãe", "obg" => true, "classefg" => "col-md-12", "type" => "text", "name" => "clienteCppFiliacao2", "value" => $clienteCppFiliacao2, "placeholder" => null, "disabled" => false);
        $fieldseFiliacao2Cpp = $MontaHtml->montaInput($htmlFieldsetFiliacao2Cpp);

        $htmlFieldsetFiliacaoCpp = array("label" => "Pai", "obg" => false, "classefg" => "col-md-12", "type" => "text", "name" => "clienteCppFiliacao", "value" => $clienteCppFiliacao, "placeholder" => null, "disabled" => false);
        $fieldseFiliacaoCpp = $MontaHtml->montaInput($htmlFieldsetFiliacaoCpp) . "</div></div><div class='row'>";

        $htmlFieldsetEnderecoCpp = array("label" => "Endereço", "obg" => true, "classefg" => "col-md-12", "type" => "text", "name" => "clienteCppEndereco", "value" => $clienteCppEndereco, "placeholder" => null, "disabled" => false);
        $fieldseEnderecoCpp = $MontaHtml->montaInput($htmlFieldsetEnderecoCpp) . "</div><div class='row'>";

        $htmlFieldsetCEPCpp = array("label" => "CEP", "obg" => true, "classefg" => "col-md-4", "type" => "text", "classecampo" => "cep", "name" => "clienteCppCEP", "value" => $clienteCppCEP, "placeholder" => null, "disabled" => false);
        $fieldseCEPCpp = $MontaHtml->montaInput($htmlFieldsetCEPCpp);

        $htmlFieldsetCidadeCpp = array("label" => "Cidade", "obg" => true, "classefg" => "col-md-4", "type" => "text", "name" => "clienteCppCidade", "value" => $clienteCppCidade, "placeholder" => null, "disabled" => false);
        $fieldseCidadeCpp = $MontaHtml->montaInput($htmlFieldsetCidadeCpp);

        $estadosBrasileirosHtml2Cpp = parent::montaHtmlEstadosBrasileiros("Estado", "clienteCppEstado", true, "col-md-4", $clienteCppEstado) . "</div><div class='row'>";

        $htmlFieldsetTelefoneCpp = array("label" => "Telefone Celular", "obg" => true, "classefg" => "col-md-4", "classecampo" => "fone", "type" => "text", "name" => "clienteCppTelefone", "value" => $clienteCppTelefone, "placeholder" => null, "disabled" => false);
        $fieldseTelefoneCpp = $MontaHtml->montaInput($htmlFieldsetTelefoneCpp);

        $htmlFieldsetTelefone2Cpp = array("label" => "Telefone Fixo", "type" => "text", "classefg" => "col-md-4", "classecampo" => "fone", "name" => "clienteCppTelefone2", "value" => $clienteCppTelefone2, "placeholder" => null, "disabled" => false);
        $fieldseTelefone2Cpp = $MontaHtml->montaInput($htmlFieldsetTelefone2Cpp);

        $htmlFieldsetEmailCpp = array("label" => "E-mail", "type" => "email", "classefg" => "col-md-4", "name" => "clienteCppEmail", "value" => $clienteCppEmail, "placeholder" => null, "disabled" => false);
        $fieldseEmailCpp = $MontaHtml->montaInput($htmlFieldsetEmailCpp) . "</div><div class='row'>";

        $htmlFieldsetProfissaoCpp = array("label" => "Profissão", "obg" => true, "classefg" => "col-md-4", "type" => "text", "name" => "clienteCppProfissao", "value" => $clienteCppProfissao, "placeholder" => null, "disabled" => false);
        $fieldseProfissaoCpp = $MontaHtml->montaInput($htmlFieldsetProfissaoCpp);

        $htmlFieldsetEmpresaCpp = array("label" => "Empresa", "classefg" => "col-md-4", "type" => "text", "name" => "clienteCppEmpresa", "value" => $clienteCppEmpresa, "placeholder" => null, "disabled" => false);
        $fieldseEmpresaCpp = $MontaHtml->montaInput($htmlFieldsetEmpresaCpp);

        $htmlFieldsetCargoCpp = array("label" => "Cargo", "classefg" => "col-md-4", "type" => "text", "name" => "clienteCargoCpp", "value" => $clienteCppCargo, "placeholder" => null, "disabled" => false);
        $fieldseCargoCpp = $MontaHtml->montaInput($htmlFieldsetCargoCpp) . "</div>";

        if($cpp4 == 1 or $cpp4 = null) {
            $cclinte = "col-md-12";
            $clinha = "hidden";
        } else {
            $ccliente = "col-md-6";
            $clinha = null;
        }
        $dados .= "<div class='conteudo'><div class='linha $clinha hidden-xs hidden-sm'> </div><div class='$ccliente cliente'><legend>Dados do Cliente</legend>";

        $dados .= $hiddenId
                . $fieldsetNome
                . $comboDeNacionalidade
                . $fieldsetDataNascimento
                . $fieldseCPF
                . $sexoHtml
                . $fieldseRG
                . $fieldseOE
                . $estadosBrasileirosHtml
                . $comboDeEstadoCivil
                . $comboDeEstadoRegimeComunhao
                . $fieldseRenda
                . $labelFiliacao
                . $fieldseFiliacao2
                . $fieldseFiliacao
                . $fieldseEndereco
                . $fieldseCEP
                . $fieldseCidade
                . $estadosBrasileirosHtml2
                . $fieldseTelefone
                . $fieldseTelefone2
                . $fieldseEmail
                . $fieldseProfissao
                . $fieldseEmpresa
                . $fieldseCargo
                . "<div class='row'>"
                . "<br>"
                . $radioHtmlStatusCpp;

        if ($cpp4 == 1 or $cpp4 = null) {
            $classe = 'escondida';
        } else {
            $classe = null;
        }

        $dados .= "</div><div class='col-md-6'><div class='spp row " . $classe . "'>
                <legend id='titulo_cpp'>Dados do Segundo Proponente ou Procurador</legend>";

        $dados .= $fieldsetNomeCpp
                . $comboDeNacionalidadeCpp
                . $fieldsetDataNascimentoCpp
                . $fieldseCPFCpp
                . $sexoHtmlCpp
                . $fieldseRGCpp
                . $fieldseOECpp
                . $estadosBrasileirosHtmlCpp
                . $comboDeEstadoCivilCpp
                . $comboDeEstadoRegimeComunhaoCpp
                . $fieldseRendaCpp
                . $labelFiliacaoCpp
                . $fieldseFiliacao2Cpp
                . $fieldseFiliacaoCpp
                . $fieldseEnderecoCpp
                . $fieldseCEPCpp
                . $fieldseCidadeCpp
                . $estadosBrasileirosHtml2Cpp
                . $fieldseTelefoneCpp
                . $fieldseTelefone2Cpp
                . $fieldseEmailCpp
                . $fieldseProfissaoCpp
                . $fieldseEmpresaCpp
                . $fieldseCargoCpp . "</div>";

        $dados .="</div></div><div class='col-md-12'>
                <button name='bt' type='submit' class='btn btn-info' value='nov'><i class='glyphicon glyphicon-asterisk'></i> Novo</button>
                <button name='bt' type='submit' class='btn btn-success' value='inc'><i class='glyphicon glyphicon-ok'></i> Incluir</button>
                <button name='bt' type='submit' class='btn btn-warning' value='alt'><i class='glyphicon glyphicon-refresh'></i> Alterar</button>
                <button name='bt' type='submit' class='btn btn-danger' value='exc'><i class='glyphicon glyphicon-trash'></i> Excluir</button></div></div>
                </form>";

        $this->setDados($dados);
    }

}
