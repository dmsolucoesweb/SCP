<?php

abstract class viewabstract {

    private $html1 = null;
    private $html2 = null;
    private $corpo = null;
    private $dados = null;
    private $acao = null;
    private $mensagem = null;

    public function __construct() {
        $this->montaHtml1();
        $this->montaHtml2();
    }

    function montaHtmlSexo(array $dados, $checked = "M", $disabled = NULL) {
        if (is_null($checked)) {
            $checked = "M";
        }


        $sexo = "\t\t\t\t<div class=\"form-group linhaFieldset\">\n";
        $sexo .= "\t\t\t\t\t<label>{$dados[0]['label']} </label>\n";
        $sexo .= "\t\t\t\t\t<label class='radio-inline'><input type=\"radio\" class='form-control' name=\"{$dados[0]['nome']}\" value=\"{$dados[0]['valor']}\"";
        $checked == "M" ? $sexo .= " checked=\"checked\"" : "";
        $sexo .=" {$disabled}> Masculino</label>\n";
        $sexo .="<label class='radio-inline'><input type=\"radio\" class='form-control' name=\"{$dados[1]['nome']}\" value=\"{$dados[1]['valor']}\"";
        $checked == "F" ? $sexo .= "checked=\"checked\"" : "";
        $sexo .=" {$disabled}> Feminino</label>\n";
        $sexo .= "\t\t\t\t</div>\n";

        return $sexo;
    }

    function montaHtmlSenha(array $dados) {
        $senha = NULL;
        foreach ($dados as $dado) {
            $senha .= "\t\t\t\t<div class=\"linhaFieldset\">\n";
            $senha .= "\t\t\t\t\t<label>{$dado['label']}</label>\n";
            $senha .= "\t\t\t\t\t<input type=\"password\" id=\"senha1\" name=\"{$dado['nome']}\" dado=\"{$dado['valor']}\" />\n";
            $senha .= "\t\t\t\t</div>\n";
        }

        return $senha;
    }

    function montaHtmlEmail(array $dados, $disabled = NULL) {
        $email = "\t\t\t\t<div class=\"linhaFieldset\">\n";
        $email .= "\t\t\t\t\t<label>{$dados[0]['label']}</label>\n";
        $email .= "\t\t\t\t\t<input id=\"email\" type=\"text\" name=\"{$dados[0]['nome']}\" size=\"60\" value=\"{$dados[0]['valor']}\" onblur=\"validaEmail(this.value, 'mensagemErroEmail');\" {$disabled} />\n";
        $email .= "\t\t\t\t\t<span class=\"alertaLinha\" id=\"mensagemErroEmail\"> &lt;&#45; E-mail incorreto! </span>\n";
        $email .= "\t\t\t\t</div>\n";

        if (isset($dados[1]['label'])) {
            $email .= "\t\t\t\t<div class=\"linhaFieldset\">\n";
            $email .= "\t\t\t\t\t<label>{$dados[1]['label']}</label>\n";
            $email .= "\t\t\t\t\t<input id=\"email\" type=\"text\" name=\"{$dados[1]['nome']}\" size=\"60\" value=\"{$dados[1]['valor']}\" onblur=\"validaEmail(this.value, 'mensagemErroEmail');\" {$disabled} />\n";
            $email .= "\t\t\t\t\t<span class=\"alertaLinha\" id=\"mensagemErroEmail\"> &lt;&#45; E-mail n&atilde;o confere! </span>\n";
            $email .= "\t\t\t\t</div>\n";
        }

        return $email;
    }

    function montaHtmlCpf(array $dados, $disabled = NULL) {
        $cpf = "\t\t\t\t<div class=\"linhaFieldset\"><label>{$dados[0]['label']}</label><input id=\"cpf2\" type=\"text\" name=\"{$dados[0]['nome']}\" size=\"20\" value=\"{$dados[0]['valor']}\" onkeypress=\"valCPF(this);\" onblur=\"consistenciaCPF(this.value,'mensagemErroCPF' );\" class=\"mascaraCPF\" maxlength=\"14\" {$disabled} />";
        $cpf .= "<span class=\"alertaLinha\" id=\"mensagemErroCPF\"> &lt;&#45; CPF inválido! </span> </div>\n";

        return $cpf;
    }

    function montaHtmlData($label, $name, $value, $disabled = NULL) {
        $data = "\t\t\t\t<div class=\"linhaFieldset\">\n";
        $data .= "\t\t\t\t\t<label>$label</label>\n";
        $data .= "\t\t\t\t\t<input type=\"text\" name=\"$name\" class=\"datePicker mascaraData\" size=\"16\" value=\"$value\" $disabled />\n";
        $data .= "\t\t\t\t</div>\n";
        return $data;
    }

    function montaHtmlEstadosBrasileiros($label, $name, $obg, $classefg, $uf = -1, $disabled = NULL) {
if (empty($obg)) {
            $obg = null;
        } else {
            $obg = "<small><i class='glyphicon glyphicon-asterisk text-danger obrigatorio' data-toggle='tooltip' data-placement='top' title='Campo Obrigatório'></i></small>";
        }
        if (empty($classefg)) {
            $classefg = null;
        } else {
            $classefg = $classefg;
        }
        $estados = "\t\t\t\t<div class=\"form-group $classefg linhaFieldset\"><label>$label $obg</label> ";
        $estados .= "\t<select class=\"form-control\" name=\"$name\" $disabled>\n";
        $estados .= "\t\t<option value=\"-1\">UF</option>\n";
        $estados .= "\t\t<option ";
        $uf == "AC" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"AC\">AC</option>\n";
        $estados .= "\t\t<option ";
        $uf == "AL" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"AL\">AL</option>\n";
        $estados .= "\t\t<option ";
        $uf == "AM" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"AM\">AM</option>\n";
        $estados .= "\t\t<option ";
        $uf == "AP" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"AP\">AP</option>\n";
        $estados .= "\t\t<option ";
        $uf == "BA" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"BA\">BA</option>\n";
        $estados .= "\t\t<option ";
        $uf == "CE" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"CE\">CE</option>\n";
        $estados .= "\t\t<option ";
        $uf == "DF" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"DF\">DF</option>\n";
        $estados .= "\t\t<option ";
        $uf == "ES" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"ES\">ES</option>\n";
        $estados .= "\t\t<option ";
        $uf == "GO" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"GO\">GO</option>\n";
        $estados .= "\t\t<option ";
        $uf == "MA" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"MA\">MA</option>\n";
        $estados .= "\t\t<option ";
        $uf == "MG" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"MG\">MG</option>\n";
        $estados .= "\t\t<option ";
        $uf == "MS" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"MS\">MS</option>\n";
        $estados .= "\t\t<option ";
        $uf == "MT" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"MT\">MT</option>\n";
        $estados .= "\t\t<option ";
        $uf == "PA" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"PA\">PA</option>\n";
        $estados .= "\t\t<option ";
        $uf == "PB" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"PB\">PB</option>\n";
        $estados .= "\t\t<option ";
        $uf == "PE" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"PE\">PE</option>\n";
        $estados .= "\t\t<option ";
        $uf == "PI" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"PI\">PI</option>\n";
        $estados .= "\t\t<option ";
        $uf == "PR" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"PR\">PR</option>\n";
        $estados .= "\t\t<option ";
        $uf == "RJ" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"RJ\">RJ</option>\n";
        $estados .= "\t\t<option ";
        $uf == "RN" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"RN\">RN</option>\n";
        $estados .= "\t\t<option ";
        $uf == "RO" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"RO\">RO</option>\n";
        $estados .= "\t\t<option ";
        $uf == "RR" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"RR\">RR</option>\n";
        $estados .= "\t\t<option ";
        $uf == "RS" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"RS\">RS</option>\n";
        $estados .= "\t\t<option ";
        $uf == "SC" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"SC\">SC</option>\n";
        $estados .= "\t\t<option ";
        $uf == "SE" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"SE\">SE</option>\n";
        $estados .= "\t\t<option ";
        $uf == "SP" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"SP\">SP</option>\n";
        $estados .= "\t\t<option ";
        $uf == "TO" ? $estados .= "selected = \"selected\"" : "";
        $estados .= " value=\"TO\">TO</option>\n";
        $estados .= "\t</select></div>\n";

        return $estados;
    }

    function montaComboboxParte1(array $dadosCombo, $textoOpcaoPadrao, $onChange = null, $disabled = false) {
        $combobox = NULL;
        if (empty($dadosCombo['classefg'])) {
            $dadosCombo['classefg'] = null;
        } else {
            $dadosCombo['classefg'] = $dadosCombo['classefg'];
        }
        if (empty($dadosCombo['classecampo'])) {
            $dadosCombo['classecampo'] = null;
        } else {
            $dadosCombo['classecampo'] = $dadosCombo['classecampo'];
        }
        if ($disabled) {
            $disabled = "disabled=\"disabled\"";
        }

        $combobox .= "\n\t<div class=\"form-group {$dadosCombo['classefg']} linhaSelect\">\n";
        $combobox .= "\t\t<label for=\"{$dadosCombo['name']}\">{$dadosCombo['label']}</label>\n";
        $combobox .= "\t\t<select class=\"form-control {$dadosCombo['classecampo']}\"name=\"{$dadosCombo['name']}\" id=\"{$dadosCombo['name']}\" $onChange $disabled>\n";
        $combobox .= "\t\t\t<option value='-1'>" . $textoOpcaoPadrao . "</option>\n";

        if (is_array($dadosCombo['options'])) {
            foreach ($dadosCombo['options'] as $option) {
                $selected = null;
                if ($option['selected']) {
                    $selected = " selected='selected' ";
                }

                $combobox .= "\t\t\t<option value='{$option['value']}'{$selected}>{$option['text']}</option>\n";
            }
        }

        $combobox .= "\t\t</select>\n";
        return $combobox;
    }

    function getValorOuNull($post) {
        if (strlen($valor = $this->getAtributoDoPostOuNull($post)) == 0) {
            return NULL;
        } else {
            return $valor;
        }
    }

    function getAtributoDoPostOuNull($post) {

        if (isset($_POST[$post])) {
            return addslashes(strip_tags(trim($_POST[$post])));
        } else {
            return NULL;
        }
    }

    function getAcao() {
        if (isset($_POST['bt'])) {
            return $_POST['bt'];
        } else {
            return null;
        }
    }

    function getIdConsulta() {
        return $_POST['idConsulta'];
    }

}
