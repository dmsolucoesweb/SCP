<?php

class MontaHTML {

    /**
     * Cria uma linha de classe "linhaFileldset" para um input do tipo hidden.
     * @param array $dadosFieldset Array de dados contendo: nome e valor do input.
     * @return string String com o código HTML da linha do hidden.
     * @example $dadosfieldset = array("name" => "fieldset", "value" => "");
     */
    function montaInputHidden(array $dadosFieldset) {
        $fieldset = NULL;

        $fieldset .= "\n\t<div class=\"form-group hidden linhaFieldset\">\n";
        $fieldset .= "\t\t<input class='form-control' type=\"hidden\" "
                . "name=\"{$dadosFieldset['name']}\" value=\"{$dadosFieldset['value']}\" />\n";
        $fieldset .= "\t</div>\n";

        return $fieldset;
    }

    function montaInputParte1(Array $dadosFieldset) {
        $fieldset = NULL;
        if (empty($dadosFieldset['classefg'])) {
            $dadosFieldset['classefg'] = null;
        } else { }

        if (empty($dadosFieldset['classelb'])) {
            $dadosFieldset['classelb'] = null;
        } else {}

        if (!$dadosFieldset['obg']) {
            $obg = null;
        } else {
            $obg = "<small><i class='glyphicon glyphicon-asterisk text-danger obrigatorio'></i></small>";
        }
        if (empty($dadosFieldset['classecampo'])) {
            $dadosFieldset['classecampo'] = null;
        } else {
        }

        $disabled = null;

        if ($dadosFieldset['disabled']) {
            $disabled = "disabled=\"disabled\"";
        }

        $fieldset .= "\n\t<div class=\"form-group {$dadosFieldset['classefg']} linhaFieldset\">\n";
        $fieldset .= "\t\t<label for=\"{$dadosFieldset['name']}\" class=\"{$dadosFieldset['classelb']}\">{$dadosFieldset['label']} $obg</label>\n";
        $fieldset .= "\t\t<input class='form-control {$dadosFieldset['classecampo']}' type=\"{$dadosFieldset['type']}\" "
                . "name=\"{$dadosFieldset['name']}\" value=\"{$dadosFieldset['value']}\" "
                . "placeholder=\"{$dadosFieldset['placeholder']}\" {$disabled} />\n";

        return $fieldset;
    }

    /**
     * Cria uma linha de classe "linhaFileldset" com label e input do tipo texto.
     * @param array $dadosFieldset Array de dados contendo: texto do label, 
     * tipo, nome, valor do input, placeholder e valor lógico para desabilitar ou não.
     * @return string String com o código HTML da linha de entrada de dados.
     * @example $dadosfieldset = array("type" => "text", "name" => "fieldset", "value" => "", "placeholder" => "", "disabled" => true/false);
     */
    function montaInput(array $dadosFieldset) {
        $fieldset = $this->montaInputParte1($dadosFieldset);
        $fieldset .= "\t</div>\n";

        return $fieldset;
    }

    function montaInputComCodigoExtra($codigoExtra, array $dadosFieldset) {
        $fieldset = $this->montaInputParte1($dadosFieldset);
        $fieldset .= $codigoExtra;
        $fieldset .= "\t</div>\n";

        return $fieldset;
    }

    /**
     * Cria uma linha de classe "linhaFileldset" com label e input para dado do 
     * tipo data.
     * @param array $dadosFieldset Array de dados contendo: texto do label, 
     * nome, valor do input e valor lógico para desabilitar ou não.
     * @return string String com o código HTML da linha de entrada de dados.
     * @example $dadosfieldset = array("label" => "Fieldset Teste", "name" => "fieldset", "value" => "", "disabled" => true/false);
     */
    function montaInputDeData(array $dadosFieldset) {
        $fieldset = NULL;
        if (empty($dadosFieldset['classefg'])) {
            $dadosFieldset['classefg'] = null;
        } else {
            
        }
        if (!$dadosFieldset['obg']) {
            $obg = null;
        } else {
            $obg = "<small><i class='glyphicon glyphicon-asterisk text-danger obrigatorio'></i></small>";
        }
        $disabled = null;
        if ($dadosFieldset['disabled']) {
            $disabled = "disabled=\"disabled\"";
        }
        $fieldset .= "\n\t<div class='form-group {$dadosFieldset['classefg']}'><label for=\"{$dadosFieldset['name']}\">{$dadosFieldset['label']} $obg</label>\n";
        $fieldset .= "\t\t<div class=\"input-group date linhaFieldset\">\n";
        $fieldset .= "\t\t<input type=\"text\" class=\"form-control datePicker mascaraData\""
                . "name=\"{$dadosFieldset['name']}\" value=\"{$dadosFieldset['value']}\" "
                . " size=\"16\" "
                . "{$disabled} /><span class='input-group-addon'><i class='glyphicon glyphicon-th'></i></span></div>\n";
        $fieldset .= "\t</div>\n";

        return $fieldset;
    }

    /**
     * Este método tem como objetivo padronizar a criação de Textarea.
     * @param array $dadosTextArea
     * Recebe como parâmetro um array de dados contendo: Label, Nome e o Texto
     * @return string
     * retorna uma string contendo todos os dados do Teextarea.
     * @example $dadosTextArea = array("label" => "TextArea Teste", "name" => "TextArea Teste", "texto" => "");
     */
    function montaTextArea(array $dadosTextArea) {
        $textArea = NULL;
if (!$dadosTextArea['obg']) {
            $obg = null;
        } else {
            $obg = "<small><i class='glyphicon glyphicon-asterisk text-danger obrigatorio'></i></small>";
        }
        $textArea = "\n\t\t\t<div class=\"form-group linhaFieldset\">";
        $textArea .= "<label for=\"{$dadosTextArea['name']}\">{$dadosTextArea['label']} $obg</label>";
        $textArea .= "<textarea class='form-control' name=\"{$dadosTextArea['name']}\">{$dadosTextArea['texto']}";
        $textArea .= "</textarea></div>";

        return $textArea;
    }

    private function montaComboboxParte1(array $dadosCombo, $textoOpcaoPadrao, $onChange = null, $disabled = false) {
        $combobox = NULL;
        if (!$dadosCombo['obg']) {
            $obg = null;
        } else {
            $obg = "<small><i class='glyphicon glyphicon-asterisk text-danger obrigatorio'></i></small>";
        }
        if (empty($dadosCombo['classefg'])) {
            $dadosCombo['classefg'] = null;
        }

        if (empty($dadosCombo['classecampo'])) {
            $dadosCombo['classecampo'] = null;
        }

        if ($disabled) {
            $disabled = "disabled=\"disabled\"";
        }

        $combobox .= "\n\t<div class=\"form-group {$dadosCombo['classefg']} linhaSelect\">\n";
        $combobox .= "\t\t<label for=\"{$dadosCombo['name']}\">{$dadosCombo['label']} $obg</label>\n";
        $combobox .= "\t\t<select class=\"form-control {$dadosCombo['classecampo']} selectpicker\" name=\"{$dadosCombo['name']}\" id=\"{$dadosCombo['name']}\" $onChange $disabled>\n";
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

    /**
     * Este método tem como objetivo facilitar e padronizar a codificação de 
     * ComboBoxes.
     * @param array $dadosCombo
     * Recebe como parâmetro um array de dados contendo: Label, Nome, e um array 
     * interno para montagem das options contendo: Valor e Texto e se a opção 
     * deve vir selecionada ou não.
      @example $dadoscombo =
     * array("label" => "Combo Teste", "name" => "combo",
     *       "options" => array (array ("value" => "1", "selected" => 0, "text" => "Teste1"),
     *                           array ("value" => "2", "selected" => 0, "text" => "Teste2"),
     *                           array ("value" => "3", "selected" => 0, "text" => "Teste3")
     *                          )
     *      );
     * @return string retorna uma string com o código HTML do ComboBox desejado.
     */
    function montaCombobox(array $dadosCombo, $textoOpcaoPadrao = 'Escolha uma op&ccedil&atilde;o abaixo...', $onChange = null, $disabled = false) {
        $combobox = $this->montaComboboxParte1($dadosCombo, $textoOpcaoPadrao, $onChange, $disabled);
        $combobox .= "\t</div>\n";

        return $combobox;
    }

    function montaComboboxComCodigoExtra($codigoExtra, array $dadosCombo, $textoOpcaoPadrao = 'Escolha uma op&ccedil&atilde;o abaixo...', $onChange = null, $disabled = false) {
        $combobox = $this->montaComboboxParte1($dadosCombo, $textoOpcaoPadrao, $onChange, $disabled);
        $combobox .= $codigoExtra;
        $combobox .= "\t</div>\n";

        return $combobox;
    }

    /**
     * Este método tem como objetivo facilitar e padronizar a codificação de 
     * Radio Buttons em posição de linha.
     * @param array $dadosRadio
     * Recebe como parâmetro um array de dados contendo: Label e um array 
     * interno para montagem das buttons contendo: Nome, Valor, Checked e Texto.
     * @example 
     * $dadosradio = array("label" => "*Sexo", "buttons" => array
     *     (array("name" => "sex", "value" => "masculino", "checked" => 1, "text" => "Masculino"), 
     *     array("name" => "sex", "value" => "feminino", "checked" => 0, "text" => "Feminino")));
     * @return string retorna uma string com o código HTML do Radio Button desejado.
     */
    function montaRadioEmLinha(array $dadosRadio) {
        $radio = NULL;
       if (!$dadosRadio['obg']) {   
            $obg = null;
        } else {
            $obg = "<small><i class='glyphicon glyphicon-asterisk text-danger obrigatorio'></i></small>";
        }
        if (empty($dadosRadio['classefg'])) {
            $dadosRadio['classefg'] = null;
        }

        $radio .= "<div class=\"form-group {$dadosRadio['classefg']} linhaFieldset\">";
        $radio .= "<label class='rotulo_inline'>{$dadosRadio['label']} $obg</label>";

        foreach ($dadosRadio['buttons'] as $dadosR) {
            $checked = null;
            if ($dadosR['checked'] == 1) {
                $checked = " checked='checked' ";
            }
            $radio .= "<label class='radio-inline'><input type='radio' name=\"{$dadosR['name']}\" value=\"{$dadosR['value']}\" {$checked}\">{$dadosR['text']}</input></label>";
        }

        $radio .= "</div>\n";
        return $radio;
    }

    /**
     * Este método tem como objetivo facilitar e padronizar a codificação de 
     * Radio Buttons em posição de coluna.
     * @param array $dadosRadio
     * Recebe como parâmetro um array de dados contendo: Label e um array 
     * interno para montagem das buttons contendo: Nome, Valor, Checked e Texto.
     * @exemple
     * $dadosradio = array("label" => "*Sexo", "buttons" => array
     *     (array("name" => "sex", "value" => "masculino", "checked" => 1, "text" => "Masculino"), 
     *     array("name" => "sex", "value" => "feminino", "checked" => 0, "text" => "Feminino")));
     * @return string retorna uma string com o código HTML do Radio Button desejado.
     */
    function montaRadioEmColuna(array $dadosRadio) {
        $radio = NULL;
if (!$dadosRadio['obg']) {
            $obg = null;
        } else {
            $obg = "<small><i class='glyphicon glyphicon-asterisk text-danger obrigatorio'></i></small>";
        }
        if (empty($dadosRadio['classefg'])) {
            $dadosRadio['classefg'] = null;
        }

        $radio .= "<div class=\"form-group {$dadosRadio['classefg']} linhaFieldset\">";
        $radio .= "<label>{$dadosRadio['label']} $obg</label>";

        $primeiroRadio = TRUE;

        foreach ($dadosRadio['buttons'] as $dadosR) {
            $checked = null;
            if ($dadosR['checked']) {
                $checked = " checked='checked' ";
            }

            $radio .= "<div class='radio'><label><input type='radio' name='{$dadosR['name']}' value='{$dadosR['value']}' {$checked}>{$dadosR['text']}</label></div>";
        }
        $radio .= "</div>\n";
        return $radio;
    }

    /**
     * Este método tem como objetivo facilitar e padronizar a codificação de 
     * CheckBox em posição de linha.
     * @param array $dadosCheckbox
     * Recebe como parâmetro um array de dados contendo: Label e um array 
     * interno para montagem das options contendo: Nome e Valor.
     * @example 
     *  $dadoscheckbox = array(array("label" => "CheckBox Teste", "name" => "teste1", "value" => "teste1"));
     * @return string retorna uma string com o código HTML do CheckBox desejado.
     */
    function montaCheckboxEmLinha(array $dadosCheckbox) {
        $checkbox = NULL;
        $checkbox .= "<div class=\"linhaFieldset\">";
if (!$dadosCheckbox['obg']) {
            $obg = null;
        } else {
            $obg = "<small><i class='glyphicon glyphicon-asterisk text-danger obrigatorio'></i></small>";
        }
        if ($dadosCheckbox['label'] == null) {
            $dadosCheckbox['label'] = '&nbsp';
        }

        $checkbox .= "<label>{$dadosCheckbox['label']} $obg</label>";

        foreach ($dadosCheckbox['options'] as $dadosCheck) {
            $checked = null;
            if ($dadosCheck['checked']) {
                $checked = "checked";
            }
            $checkbox .= "<input type='checkbox' name='{$dadosCheck['name']}' value='{$dadosCheck['value']}' {$dadosCheck['checked']}'>{$dadosCheck['text']}";
        }

        $checkbox .= "</div>\n";
        return $checkbox;
    }

    /**
     * Este método tem como objetivo facilitar e padronizar a codificação de 
     * CheckBox em posição de coluna.
     * @param array $dadosCheckbox
     * Recebe como parâmetro um array de dados contendo: Label e um array 
     * interno para montagem das options contendo: Nome e Valor.
     * @example 
     * $dadoscheckbox = array("label" => "Opções", 
     *                        "options" => array(array("name" => "teste1", 
     *                                                 "value" => "teste1", 
     *                                                 "checked" => 1, 
     *                                                 "text" => "CheckBox Teste1"));
     * @return string retorna uma string com o código HTML do CheckBox desejado.
     */
    function montaCheckboxEmColuna(array $dadosCheckbox) {
        if (!$dadosCheckbox['obg']) {
            $obg = null;
        } else {
            $obg = "<small><i class='glyphicon glyphicon-asterisk text-danger obrigatorio'></i></small>";
        }
        $checkbox = NULL;
        $checkbox .= "<div class=\"linhaFieldset\">";
        $checkbox .= "<label>{$dadosCheckbox['label']} $obg</label>";

        $primeiroCheck = TRUE;

        foreach ($dadosCheckbox['options'] as $dadosCheck) {
            $checked = null;
            if ($dadosCheck['checked']) {
                $checked = 'checked';
            }
            if ($primeiroCheck) {
                $primeiroCheck = false;
                $checkbox .= "<input type='checkbox' name='{$dadosCheck['name']}' value='{$dadosCheck['value']}' $checked>{$dadosCheck['text']}</input></div>";
            } else {
                $checkbox .= "<div class=\" campoCheckBoxColuna\"><input type='checkbox' name='{$dadosCheck['name']}' value='{$dadosCheck['value']}' $checked>{$dadosCheck['text']}</input></div>";
            }
        }

        return $checkbox;
    }

    /**
     * Este método monta a parte do login em html
     * 
     * @param type $montaHtmlDoLogin
     * Recebe o usuário caso exista
     * @example $htmlLogin = $htmlDoLogin->montaHtmlDoLogin($usuario);
     * @return $htmlLogin
     */
    function montaHtmlDoLogin($usuario = null) {
        $diretorios = new Diretorios();
        $img = $diretorios->getCaminhoDoArtefatoFsw("ARTE");

        $senha = NULL;

        $htmlLogin = NULL;
        $htmlLogin .= "\t\t<div id=\"telaLogin\"><!--inicio id telaLogin -->\n";
        $htmlLogin .= "\t\t\t<div class=\"login\"><!--inicio class login -->\n";
        $htmlLogin .= "\t\t\t\t<div id=\"menBemVindo\">Bem Vindo!\n";
        $htmlLogin .= "\t\t\t\t</div>\n";
        $htmlLogin .= "\t\t\t\t<form action=\"\" method=\"post\" onsubmit=\"return verificarFormulario(this)\" name=\"formLogin\">\n";
        $htmlLogin .= "\t\t\t\t\t<div class=\"campoLogin\"><!--inicio class campoLogin -->\n";

        $htmlLogin .= "\t\t\t\t\t\t<div class=\"linhaLogin\"> <label>Login</label>\n";
        $htmlLogin .= "\t\t\t\t\t\t\t<input name=\"usuario\" type=\"text\" value=\"$usuario\" autofocus=\"true\" placeholder='Login ou e-mail' />\n";
        $htmlLogin .= "\t\t\t\t\t\t</div>\n";

        $htmlLogin .= "\t\t\t\t\t\t<div class=\"linhaLogin\"><label>Senha</label>\n";
        $htmlLogin .= "\t\t\t\t\t\t\t<input name=\"senha\" type=\"password\" />\n";
        $htmlLogin .= "\t\t\t\t\t\t</div>\n";
        $htmlLogin .= "\t\t\t\t\t</div><!--fim class campoLogin -->\n";

        $htmlLogin .= "\t\t\t\t\t<div class=\"campoBotao\">\t\n";
        $htmlLogin .= "\t\t\t\t\t\t<input name=\"acao\" value=\"Entrar\" class=\"botao\" type=\"submit\">\n";
        $htmlLogin .= "\t\t\t\t\t\t<input name=\"acao\" value=\"Cadastrar\" class=\"botao\" type=\"submit\" title=\"Cadastre-se na F&aacute;brica\">\n";
        $htmlLogin .= "\t\t\t\t\t</div>\n";

        $htmlLogin .= "\t\t\t\t\t<div class=\"recuperarSenha\"><a href=\"redefinesenha.php\" title=\"Redefina sua Senha\">Redefinir Senha</a>\n";

        $htmlLogin .= "\t\t\t\t\t</div>\n";
        $htmlLogin .= "\t\t\t\t</form>\n";
        $htmlLogin .= "\t\t\t\t<div class=\"imagemLogin\">\n";
        $htmlLogin .= "\t\t\t\t\t<img src=\"{$img}/Img/login.png\" alt=\"Login\" />\n";
        $htmlLogin .= "\t\t\t\t</div>\n";
        $htmlLogin .= "\t\t\t</div><!--fim class login -->\n";
        $htmlLogin .= "\t\t</div><!--fim id telaLogin -->\n";

        return $htmlLogin;
    }

    /**
     * Este método monta uma tabela de acordo com os dados recebidos, isto é, ela é adaptável
     * @param array $cabecalho
     * @param array $linhasEColunas
     * @return string
     * @example
     * $cabecalho      = array("Nome da coluna 1", "Nome da coluna 2");
      $linhasEColunas = array(
      array('Linha 1 / Coluna 1', 'Linha 1 / Coluna 2'),
      array('Linha 2 / Coluna 1', 'Linha 2 / Coluna 2')
      );
     */
    function montaTabela($label = null, array $cabecalho, array $tamanhoDasColunas, array $linhasEColunasArray, $classesCss = 'tabela') {
        $tabela = null;

        if (is_null($label)) {
            // Não faz nada
            // Caso um label tenha sido enviado, coloca a tabela dentro de um fieldset
        } else {
            $tabela .= '<div class="linhaFieldset">';
            $tabela .= '<label>' . $label . '</label>';
        }

        // Classes CSS
        if (is_array($classesCss)) {
            $stringClassesCss = implode(' ', $classesCss);
        } else {
            $stringClassesCss = $classesCss;
        }

        // Inicia tabela
        $tabela .= '<div class="tabela-area">'
                . '<table class="' . $stringClassesCss . '">';

        // Monta o cabeçalho
        if (is_array($cabecalho)) {
            $tabela .= '<thead>';
            $tabela .= '<tr>';
            foreach ($cabecalho as $nome) {
                $tabela .= '<th>' . $nome . '</th>';
            }
            $tabela .= '</tr>';
            $tabela .= '</thead>';
        }

        // Monta o corpo
        if (is_array($linhasEColunasArray)) {
            $tabela .= '<tbody>';
            foreach ($linhasEColunasArray as $linhasEColunas) {
                if (is_array($linhasEColunas)) {
                    $tabela .= '<tr>';

                    $i = 0;
                    foreach ($linhasEColunas as $linhaEColuna) {
                        $tabela .= '<td width="' . $tamanhoDasColunas[$i] . '">' . $linhaEColuna . '</td>';
                        $i++;
                    }
                    $tabela .= '</tr>';
                }
            }
            $tabela .= '</tbody>';
        }

        $tabela .= '</table>';
        $tabela .= '</div>';

        if (is_null($label)) {
            // Não faz nada
        } else {
            $tabela .= '</div>';
        }

        $tabela .= '<div class="clearfix"></div>';

        return $tabela;
    }

}
