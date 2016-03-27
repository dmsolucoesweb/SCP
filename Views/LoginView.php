<?php

require_once 'HtmlGeralLogin.php';
require_once '../Classes/montahtml.php';

class LoginView extends HtmlGeralLogin {

    public function getDadosEntrada() {
        $login = $this->getValorOuNull('login');
        $senha = $this->getValorOuNull('senha');

        return new LoginModel($login, $senha);
    }

    public function montaDados($LoginModel) {
        $dados = null;
        $montahtml = new MontaHTML();

        $login = $LoginModel->getLogin();
        $senha = $LoginModel->getSenha();

        $htmlFieldsetLogin = array("label" => "Login", "classelb" => "col-sm-3", "type" => "text", "classefg" => "col-sm-9", "name" => "login", "value" => $login, "placeholder" => null, "disabled" => 0);
        $fieldsetLogin = $montahtml->montaInput($htmlFieldsetLogin);

        $htmlFieldsetSenha = array("label" => "Senha", "classelb" => "col-sm-3", "type" => "password", "classefg" => "col-sm-9", "name" => "senha", "value" => $senha, "placeholder" => null, "disabled" => 0);
        $fieldsetSenha = $montahtml->montaInput($htmlFieldsetSenha);


        $dados .= "<div class='container'>

    <div class='row'>
        <div class='col-md-4 titulo'>
            <h1>Residencial Park Ville</h1>
            <img src='../IMG/logo.png' class='logo_park' />
        </div>
    </div>

    <div class='row'>
        <div class='col-md-4 col-md-offset-7'>
            <div class='panel panel-default' id='login'>
                <div class='panel-heading'>
                    <span class='glyphicon glyphicon-lock'></span> Login</div>
                <div class='panel-body'>
                <h3>Seja Bem-Vindo ao SCP</h3>
                    <form class='form-horizontal' action='Login.php' method='post' role='form'>" . $fieldsetLogin . $fieldsetSenha . "
                    <div class='form-group last'>
                        <div class='col-sm-offset-3 col-sm-9'>
                            <button name='bt' type='submit' class='btn btn-success btn-sm' value='entrar'> Entrar</button>
                            <button type='reset' class='btn btn-default btn-sm'> Limpar</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class='panel-footer'>
                    <a href='RecuperaSenha.php'>Esqueceu sua senha?</a></div>
            </div>
        </div>
    </div>
    <div class='col-md-4 col-md-offset-9'>
        <img class='logo_dm' src='../IMG/logo_dm.png' />
    </div>
</div>";


        $this->setDados($dados);
    }

}
