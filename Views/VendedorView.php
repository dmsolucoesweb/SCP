<?php

require_once 'HtmlGeral.php';
require_once '../Classes/montahtml.php';
require_once '../Classes/datasehoras.php';
require_once '../Classes/cpf.php';
include('../Classes/functions.php');

class VendedorView extends HtmlGeral {

    public function getDadosEntrada() {
        $DatasEHoras = new DatasEHoras();
        $CPF = new CPF();

        $vendedorId = $this->getValorOuNull('vendedorId');
        $vendedorNome = $this->getValorOuNull('vendedorNome');
        $vendedorNacionalidade = $this->getValorOuNull('vendedorNacionalidade');
        $vendedorDataNascimento = $DatasEHoras->getDataEHorasInvertidaComTracos($this->getValorOuNull('vendedorDataNascimento'));
        $vendedorCPF = $CPF->retiraMascaraCPF($this->getValorOuNull('vendedorCPF'));
        $vendedorRG = $this->getValorOuNull('vendedorRG');
        $vendedorOrgaoEmissor = $this->getValorOuNull('vendedorOrgaoEmissor');
        $vendedorEstadoOrgaoEmissor = $this->getValorOuNull('vendedorEstadoOrgaoEmissor');
        $vendedorSexo = $this->getValorOuNull('vendedorSexo');
        $vendedorEstadoCivil = $this->getValorOuNull('vendedorEstadoCivil');
        $vendedorRegimeComunhao = $this->getValorOuNull('vendedorRegimeComunhao');
        $vendedorFiliacao = $this->getValorOuNull('vendedorFiliacao');
        $vendedorFiliacao2 = $this->getValorOuNull('vendedorFiliacao2');
        $vendedorTelefone = $this->getValorOuNull('vendedorTelefone');
        $vendedorTelefone2 = $this->getValorOuNull('vendedorTelefone2');
        $vendedorEndereco = $this->getValorOuNull('vendedorEndereco');
        $vendedorCidade = $this->getValorOuNull('vendedorCidade');
        $vendedorEstado = $this->getValorOuNull('vendedorEstado');
        $vendedorCEP = $this->getValorOuNull('vendedorCEP');
        $vendedorEmail = $this->getValorOuNull('vendedorEmail');
        $vendedorProfissao = $this->getValorOuNull('vendedorProfissao');
        $vendedorRenda = $CPF->retiraMascaraRenda($this->getValorOuNull('vendedorRenda'));
        $vendedorEmpresa = $this->getValorOuNull('vendedorEmpresa');

        return new VendedorModel($vendedorId, $vendedorNome, $vendedorNacionalidade, $vendedorDataNascimento, $vendedorCPF, $vendedorRG, $vendedorOrgaoEmissor, $vendedorEstadoOrgaoEmissor, $vendedorSexo, $vendedorEstadoCivil, $vendedorRegimeComunhao, $vendedorFiliacao, $vendedorFiliacao2, $vendedorTelefone, $vendedorTelefone2, $vendedorEndereco, $vendedorCidade, $vendedorEstado, $vendedorCEP, $vendedorEmail, $vendedorProfissao, $vendedorRenda, $vendedorEmpresa);
    }

    public function montaOpcoesDeVendedores($vendedorSelected) {
        $opcoesDeVendedores = null;

        $vendedorAdo = new VendedorAdo();

        try {
            $arrayDeVendedores = $vendedorAdo->consultaArrayDeObjeto1();

            if ($arrayDeVendedores === 0) {
                return null;
            }
        } catch (SelecaoVaziaException $exc) {
            $this->adicionaMensagem("N&atilde;o existe nenhum vendedor cadastrado!", "Atencao");

            return NULL;
        } catch (ErroBDException $exc) {
            $this->adicionaMensagem("Erro no Banco de Dados! Contate o analista respons&aacute;vel.", "Erro");

            return FALSE;
        }

        if (is_array($arrayDeVendedores)) {
            foreach ($arrayDeVendedores as $vendedorModel) {
                $selected = null;

                $vendedorId = $vendedorModel->getVendedorId();
                $vendedorNome = $vendedorModel->getVendedorNome();
                $vendedorCPF = $vendedorModel->getVendedorCPF();

                $text = 'Nome: ' . $vendedorNome . ' | CPF: ' . mascara($vendedorCPF, '###.###.###-##');

                if ($vendedorId == $vendedorSelected) {
                    $selected = 1;
                }

                $opcoesDeVendedores[] = array("value" => $vendedorId, "selected" => $selected, "text" => $text);
            }
        }
        return $opcoesDeVendedores;
    }

    public function montaDados($vendedorModel) {
        $dados = null;
        $montahtml = new MontaHTML();

        $vendedorId = $vendedorModel->getVendedorId();
        $vendedorNome = $vendedorModel->getVendedorNome();
        $vendedorNacionalidade = $vendedorModel->getVendedorNacionalidade();
        $vendedorDataNascimento = $vendedorModel->getVendedorDataNascimento();
        $vendedorCPF = $vendedorModel->getVendedorCPF();
        $vendedorRG = $vendedorModel->getVendedorRG();
        $vendedorOrgaoEmissor = $vendedorModel->getVendedorOrgaoEmissor();
        $vendedorEstadoOrgaoEmissor = $vendedorModel->getVendedorEstadoOrgaoEmissor();
        $vendedorSexo = $vendedorModel->getVendedorSexo();
        $vendedorEstadoCivil = $vendedorModel->getVendedorEstadoCivil();
        $vendedorRegimeComunhao = $vendedorModel->getVendedorRegimeComunhao();
        $vendedorFiliacao = $vendedorModel->getVendedorFiliacao();
        $vendedorFiliacao2 = $vendedorModel->getVendedorFiliacao2();
        $vendedorTelefone = $vendedorModel->getVendedorTelefone();
        $vendedorTelefone2 = $vendedorModel->getVendedorTelefone2();
        $vendedorEndereco = $vendedorModel->getVendedorEndereco();
        $vendedorCidade = $vendedorModel->getVendedorCidade();
        $vendedorEstado = $vendedorModel->getVendedorEstado();
        $vendedorCEP = $vendedorModel->getVendedorCEP();
        $vendedorEmail = $vendedorModel->getVendedorEmail();
        $vendedorProfissao = $vendedorModel->getVendedorProfissao();
        $vendedorRenda = $vendedorModel->getVendedorRenda();
        $vendedorEmpresa = $vendedorModel->getVendedorEmpresa();

        $htmlComboVendedores = array("label" => "Vendedores", "name" => "idConsulta", "options" => $this->montaOpcoesDeVendedores($vendedorId));
        $comboDeVendedores = $montahtml->montaCombobox($htmlComboVendedores, $textoPadrao = 'Escolha um Vendedor...', $onChange = null, $disabled = false);

        $dados .= "<form action='Vendedor.php' method='post'>
                    <h1>Cadastro de Vendedores</h1>
                    <div class='well'><legend>Consulta</legend>";

        $dados .= $comboDeVendedores;

        $dados .= "<button name='bt' type='submit' class='btn btn-info' value='con'><i class='glyphicon glyphicon-search'></i> Consultar</button>
                   <button name='bt' type='submit' class='btn btn-info' value='erl'><i class='glyphicon glyphicon-print'></i> Emitir Relatório</button></div>";

        $dadosfieldsetHidden = array("name" => "vendedorId", "value" => $vendedorId);
        $hiddenId = $montahtml->montaInputHidden($dadosfieldsetHidden);
        $hiddenId .= "<div class='row'>";

        $htmlFieldsetNome = array("label" => "Nome", "classefg" => "col-md-10", "type" => "text", "name" => "vendedorNome", "value" => $vendedorNome, "placeholder" => null, "disabled" => false);
        $fieldsetNome = $montahtml->montaInput($htmlFieldsetNome);

        $selected1 = $selected2 = null;
        switch ($vendedorNacionalidade) {
            case '1':
                $selected1 = "selected='selected'";
                break;
            case '2':
                $selected2 = "selected='selected'";
                break;
        }

        $htmlComboNacionalidade = array("label" => "Nacionalidade", "classefg" => "col-md-3", "name" => "vendedorNacionalidade",
            "options" => array(array("value" => "1", "selected" => $selected1, "text" => "Brasileiro(a)"),
                array("value" => "2", "selected" => $selected2, "text" => "Internacional")));
        $comboDeNacionalidade = $montahtml->montaCombobox($htmlComboNacionalidade, $textoPadrao = 'Escolha uma Nacionalidade...');

        $htmlFieldsetData = array("label" => "Data de Nascimento", "name" => "vendedorDataNascimento", "classefg" => "col-md-3", "value" => $vendedorDataNascimento, "disabled" => false);
        $fieldsetDataNascimento = $montahtml->montaInputDeData($htmlFieldsetData);

        $htmlFieldsetCPF = array("label" => "CPF", "classefg" => "col-md-4", "type" => "text", "classecampo" => "cpf", "name" => "vendedorCPF", "value" => $vendedorCPF, "placeholder" => null, "disabled" => false);
        $fieldseCPF = $montahtml->montaInput($htmlFieldsetCPF);

        $htmlFieldsetRG = array("label" => "RG ", "classefg" => "col-md-3", "type" => "text", "name" => "vendedorRG", "value" => $vendedorRG, "placeholder" => null, "disabled" => false);
        $fieldseRG = $montahtml->montaInput($htmlFieldsetRG);

        $htmlFieldsetOE = array("label" => "Orgão Expedidor", "classefg" => "col-md-3", "type" => "text", "name" => "vendedorOrgaoEmissor", "value" => $vendedorOrgaoEmissor, "placeholder" => null, "disabled" => false);
        $fieldseOE = $montahtml->montaInput($htmlFieldsetOE);

        $estadosBrasileirosHtml = parent::montaHtmlEstadosBrasileiros("Estado", "vendedorEstadoOrgaoEmissor", "col-md-3", $vendedorEstadoOrgaoEmissor);
        $estadosBrasileirosHtml .= "</div><div class='row'>";

        $m = $f = null;
        switch ($vendedorSexo) {
            case 'M':
                $m = 1;
                break;
            case 'F':
                $f = 1;
                break;
        }

        $htmlDadosRadioSexo = array("label" => "Sexo", "classefg" => "col-md-3", "buttons" => array
                (array("name" => "vendedorSexo", "value" => "M", "checked" => $m, "text" => "Masculino"),
                array("name" => "vendedorSexo", "value" => "F", "checked" => $f, "text" => "Feminino")));
        $sexoHtml = $montahtml->montaRadioEmLinha($htmlDadosRadioSexo);

        $selected3 = $selected4 = $selected5 = $selected6 = $selected7 = null;
        switch ($vendedorEstadoCivil) {
            case '1':
                $selected3 = "selected='selected'";
                break;
            case '2':
                $selected4 = "selected='selected'";
                break;
            case '3':
                $selected5 = "selected='selected'";
                break;
            case '4':
                $selected6 = "selected='selected'";
                break;
            case '5':
                $selected7 = "selected='selected'";
                break;
        }

        $htmlComboEstadoCivil = array("label" => "Estado Civil", "classefg" => "col-md-3", "name" => "vendedorEstadoCivil",
            "options" => array(array("value" => "1", "selected" => $selected3, "text" => "Solteiro(a)"),
                array("value" => "2", "selected" => $selected4, "text" => "Casado(a)"),
                array("value" => "3", "selected" => $selected5, "text" => "Divorciado(a)"),
                array("value" => "4", "selected" => $selected6, "text" => "Viuvo(a)"),
                array("value" => "5", "selected" => $selected7, "text" => "União Estável")));
        $comboDeEstadoCivil = $montahtml->montaCombobox($htmlComboEstadoCivil, $textoPadrao = 'Escolha um Estado Civil...');

        $selected8 = $selected9 = $selected10 = $selected11 = $selected12 = null;
        switch ($vendedorRegimeComunhao) {
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

        $htmlComboRegimeComunhao = array("label" => "Regime de Bens", "classefg" => "col-md-3", "name" => "vendedorRegimeComunhao",
            "options" => array(array("value" => "1", "selected" => $selected8, "text" => "Comunhão Parcial de Bens"),
                array("value" => "2", "selected" => $selected9, "text" => "Comunhão Universal de Bens"),
                array("value" => "3", "selected" => $selected10, "text" => "Separação Total de Bens"),
                array("value" => "4", "selected" => $selected11, "text" => "Participação Final de Aquestos")));
        $comboDeEstadoRegimeComunhao = $montahtml->montaCombobox($htmlComboRegimeComunhao, $textoPadrao = 'Escolha um Regime de Bens...');

        $labelFiliacao = "<div class='row'><div class='col-md-10'><legend>Filiação</legend></div><div class='col-md-11'>";

        $htmlFieldsetFiliacao = array("label" => "Pai ", "classefg" => "col-md-9", "type" => "text", "name" => "vendedorFiliacao", "value" => $vendedorFiliacao, "placeholder" => null, "disabled" => false);
        $fieldseFiliacao = $montahtml->montaInput($htmlFieldsetFiliacao);

        $htmlFieldsetFiliacao2 = array("label" => "Mãe ", "classefg" => "col-md-9", "type" => "text", "name" => "vendedorFiliacao2", "value" => $vendedorFiliacao2, "placeholder" => null, "disabled" => false);
        $fieldseFiliacao2 = $montahtml->montaInput($htmlFieldsetFiliacao2);

        $htmlFieldsetTelefone = array("label" => "Telefone Celular", "classefg" => "col-md-4", "classecampo" => "fone", "type" => "text", "name" => "vendedorTelefone", "value" => $vendedorTelefone, "placeholder" => null, "disabled" => false);
        $fieldseTelefone = $montahtml->montaInput($htmlFieldsetTelefone);

        $htmlFieldsetTelefone2 = array("label" => "Telefone Fixo", "type" => "text", "classefg" => "col-md-4", "classecampo" => "fone", "name" => "vendedorTelefone2", "value" => $vendedorTelefone2, "placeholder" => null, "disabled" => false);
        $fieldseTelefone2 = $montahtml->montaInput($htmlFieldsetTelefone2);

        $htmlFieldsetEndereco = array("label" => "Endereço", "classefg" => "col-md-10", "type" => "text", "name" => "vendedorEndereco", "value" => $vendedorEndereco, "placeholder" => null, "disabled" => false);
        $fieldseEndereco = $montahtml->montaInput($htmlFieldsetEndereco);

        $htmlFieldsetCidade = array("label" => "Cidade", "classefg" => "col-md-3", "type" => "text", "name" => "vendedorCidade", "value" => $vendedorCidade, "placeholder" => null, "disabled" => false);
        $fieldseCidade = $montahtml->montaInput($htmlFieldsetCidade);

        $estadosBrasileirosHtml2 = parent::montaHtmlEstadosBrasileiros("Estado", "vendedorEstado", "col-md-3", $vendedorEstado);

        $htmlFieldsetCEP = array("label" => "CEP", "classefg" => "col-md-3", "type" => "text", "name" => "vendedorCEP", "value" => $vendedorCEP, "classecampo" => "cep", "placeholder" => null, "disabled" => false);
        $fieldseCEP = $montahtml->montaInput($htmlFieldsetCEP);

        $htmlFieldsetEmail = array("label" => "E-mail", "type" => "email", "classefg" => "col-md-5", "name" => "vendedorEmail", "value" => $vendedorEmail, "placeholder" => null, "disabled" => false);
        $fieldseEmail = $montahtml->montaInput($htmlFieldsetEmail);

        $htmlFieldsetProfissao = array("label" => "Profissão", "classefg" => "col-md-4", "type" => "text", "name" => "vendedorProfissao", "value" => $vendedorProfissao, "placeholder" => null, "disabled" => false);
        $fieldseProfissao = $montahtml->montaInput($htmlFieldsetProfissao);

        $htmlFieldsetRenda = array("label" => "Renda", "classefg" => "col-md-4", "type" => "text", "name" => "vendedorRenda", "classecampo" => "moeda", "value" => $vendedorRenda, "placeholder" => null, "disabled" => false);
        $fieldseRenda = $montahtml->montaInput($htmlFieldsetRenda);

        $htmlFieldsetEmpresa = array("label" => "Empresa", "classefg" => "col-md-5", "type" => "text", "name" => "vendedorEmpresa", "value" => $vendedorEmpresa, "placeholder" => null, "disabled" => false);
        $fieldseEmpresa = $montahtml->montaInput($htmlFieldsetEmpresa);
        
        $dados .= $hiddenId
                . $fieldsetNome
                . $comboDeNacionalidade
                . $fieldsetDataNascimento
                . $fieldseCPF
                . $fieldseRG
                . $fieldseOE
                . $estadosBrasileirosHtml
                . $sexoHtml
                . $comboDeEstadoCivil
                . $comboDeEstadoRegimeComunhao
                . $labelFiliacao
                . $fieldseFiliacao2
                . $fieldseFiliacao
                . $fieldseTelefone
                . $fieldseTelefone2
                . $fieldseEndereco
                . $fieldseCidade
                . $estadosBrasileirosHtml2
                . $fieldseCEP
                . $fieldseEmail
                . $fieldseProfissao
                . $fieldseRenda
                . $fieldseEmpresa
                . "<div class='row'>";

        $dados .="</div></div><div class='col-md-12'>
                <button name='bt' type='submit' class='btn btn-info' value='nov'><i class='glyphicon glyphicon-asterisk'></i> Novo</button>
                <button name='bt' type='submit' class='btn btn-success' value='inc'><i class='glyphicon glyphicon-ok'></i> Incluir</button>
                <button name='bt' type='submit' class='btn btn-warning' value='alt'><i class='glyphicon glyphicon-refresh'></i> Alterar</button>
                <button name='bt' type='submit' class='btn btn-danger' value='exc'><i class='glyphicon glyphicon-trash'></i> Excluir</button></div></div>
                </form>";

        $this->setDados($dados);
    }

}
