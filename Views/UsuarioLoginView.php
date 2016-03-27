<?php

$nivel_gerente = true;
require_once 'HtmlGeral.php';
require_once '../Classes/montahtml.php';

class UsuarioLoginView extends HtmlGeral {

    public function montaTitulo() {
        $this->setTitulo("Dados do Usuário-Login");
    }

    public function getDadosEntrada() {
        $usuarioLoginId = $this->getValorOuNull('usuarioLoginId');
        $usuarioLoginNome = $this->getValorOuNull('usuarioLoginNome');
        $usuarioLoginEmail = $this->getValorOuNull('usuarioLoginEmail');
        $usuarioLoginTipo = $this->getValorOuNull('usuarioLoginTipo');
        $usuarioLoginLogin = $this->getValorOuNull('usuarioLoginLogin');
        $usuarioLoginSenha = $this->getValorOuNull('usuarioLoginSenha');

        return new UsuarioLoginModel($usuarioLoginId, $usuarioLoginNome, $usuarioLoginEmail, $usuarioLoginTipo, $usuarioLoginLogin, $usuarioLoginSenha);
    }

    public function montaOpcoesDeUsuarios($usuarioLoginSelected) {
        $opcoesDeUsuariosLogin = null;

        $usuarioLoginAdo = new UsuarioLoginAdo();
        $arrayDeUsuariosLogin = $usuarioLoginAdo->consultaArrayDeObjeto();

        if ($arrayDeUsuariosLogin == 0) {
            return null;
        }

        if (is_array($arrayDeUsuariosLogin)) {
            foreach ($arrayDeUsuariosLogin as $usuarioLoginModel) {
                $selected = null;

                $usuarioLoginId = $usuarioLoginModel->getUsuarioLoginId();
                $usuarioLoginNome = $usuarioLoginModel->getUsuarioLoginNome();
                $usuarioLoginLogin = $usuarioLoginModel->getUsuarioLoginLogin();

                $text = 'NOME: ' . $usuarioLoginNome . ' | LOGIN: ' . $usuarioLoginLogin;

                if ($usuarioLoginId == $usuarioLoginSelected) {
                    $selected = 1;
                }

                $opcoesDeUsuariosLogin[] = array("value" => $usuarioLoginId, "selected" => $selected, "text" => $text);
            }
        }
        return $opcoesDeUsuariosLogin;
    }

    public function montaDados($UsuarioLoginModel) {
        $dados = null;
        $montahtml = new MontaHTML();

        $usuarioLoginId = $UsuarioLoginModel->getUsuarioLoginId();
        $usuarioLoginNome = $UsuarioLoginModel->getUsuarioLoginNome();
        $usuarioLoginEmail = $UsuarioLoginModel->getUsuarioLoginEmail();
        $usuarioLoginTipo = $UsuarioLoginModel->getUsuarioLoginTipo();
        $usuarioLoginLogin = $UsuarioLoginModel->getUsuarioLoginLogin();
        $usuarioLoginSenha = $UsuarioLoginModel->getUsuarioLoginSenha();

        $dados .= "<form action='UsuarioLogin.php' method='post'>
                        <h1>Cadastro de Usuários</h1>
                        <div class='well'><legend>Consulta</legend>";

        $htmlComboUsuarios = array("label" => "Usuários", "name" => "idConsulta", "options" => $this->montaOpcoesDeUsuarios($usuarioLoginId));
        $comboDeUsuarios = $montahtml->montaCombobox($htmlComboUsuarios, $textoPadrao = 'Escolha um Usuário...');

        $dados .= $comboDeUsuarios;

        $dados .= "<button name='bt' type='submit' class='btn btn-info' value='con'><i class='glyphicon glyphicon-search'></i> Consultar</button></div>";

        $dadosfieldsetHidden = array("name" => "usuarioLoginId", "value" => $usuarioLoginId);
        $hiddenId = $montahtml->montaInputHidden($dadosfieldsetHidden);

        $htmlFieldsetNome = array("label" => "Nome", "type" => "text", "classefg" => "col-md-4", "name" => "usuarioLoginNome", "value" => $usuarioLoginNome, "placeholder" => null, "disabled" => false);
        $fieldsetNome = "<div class='row'>" . $montahtml->montaInput($htmlFieldsetNome);

        $htmlFieldsetEmail = array("label" => "E-mail", "type" => "email", "classefg" => "col-md-4", "name" => "usuarioLoginEmail", "value" => $usuarioLoginEmail, "placeholder" => null, "disabled" => false);
        $fieldseEmail = $montahtml->montaInput($htmlFieldsetEmail);
        $fieldseEmail .= "</div><div class='row'>";

        $selected = $selected1 = $selected2 = null;
        switch ($usuarioLoginTipo) {
            case '1':
                $selected = "selected='selected'";
                break;
            case '2':
                $selected1 = "selected='selected'";
                break;
            case '3':
                $selected2 = "selected='selected'";
                break;
        }

        $htmlComboTipo = array("label" => "Tipo", "classefg" => "col-md-3", "name" => "usuarioLoginTipo",
            "options" => array(array("value" => "1", "selected" => $selected, "text" => "Administrador"),
                array("value" => "2", "selected" => $selected1, "text" => "Gerente")));
        $comboDeTipo = $montahtml->montaCombobox($htmlComboTipo, $textoPadrao = 'Tipo de usuário');
        $comboDeTipo .= "</div><div class='row'>";

        $htmlFieldsetLogin = array("label" => "Login", "type" => "text", "classefg" => "col-md-2", "name" => "usuarioLoginLogin", "value" => $usuarioLoginLogin, "placeholder" => null, "disabled" => false);
        $fieldsetLogin = $montahtml->montaInput($htmlFieldsetLogin);
        $fieldsetLogin .= "</div><div class='row'>";

        $fieldsetSenha = null;
        if ($usuarioLoginId == 0 || $usuarioLoginId == '-1') {
            $htmlFieldsetSenha = array("label" => "Senha", "type" => "password", "classefg" => "col-md-2", "name" => "usuarioLoginSenha", "value" => $usuarioLoginSenha, "placeholder" => null, "disabled" => false);
            $fieldsetSenha = $montahtml->montaInput($htmlFieldsetSenha);
            $fieldsetSenha .= "</div><div class='row'>";
        }

        $dados .= $hiddenId
                . $fieldsetNome
                . $fieldseEmail
                . $comboDeTipo
                . $fieldsetLogin
                . $fieldsetSenha;

        $dados .= "<button name='bt' type='submit' class='btn btn-info' value='nov'><i class='glyphicon glyphicon-asterisk'></i> Novo</button>
                   <button name='bt' type='submit' class='btn btn-success' value='inc'><i class='glyphicon glyphicon-ok'></i> Incluir</button>";

        $this->setDados($dados);
    }

}
