<?php

require_once 'HtmlGeralLogin.php';
require_once '../Classes/montahtml.php';

class RecuperaSenhaView extends HtmlGeralLogin {

    public function getDadosEntrada() {
        $usuarioLoginEmail = $this->getValorOuNull('usuarioLoginEmail');

        return $usuarioLoginEmail;
    }

    public function montaDados($usuarioLoginEmail = null) {
        $dados = null;
        $montahtml = new MontaHTML();
        $htmlFieldsetEmail = array("label" => "E-mail", "classelb" => "col-sm-3", "type" => "email", "classefg" => "col-sm-9", "name" => "usuarioLoginEmail", "value" => $usuarioLoginEmail, "placeholder" => null, "disabled" => false);
        $fieldseEmail = $montahtml->montaInput($htmlFieldsetEmail);
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
                    <span class='glyphicon glyphicon-lock'></span> Recuperação de Senha</div>
                <div class='panel-body'>
                    <form class='form-horizontal' action='RecuperaSenha.php' method='post' role='form'>" . $fieldseEmail . "
                    <div class='form-group last'>
                        <div class='col-sm-offset-3 col-sm-9'>
                            <button name='bt' type='submit' class='btn btn-primary btn-sm' value='Recuperar'> Recuperar</button>
                            <button type='reset' class='btn btn-default btn-sm'> Limpar</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class='panel-footer'>
                    <a href='../Modulos/Login.php'>Voltar ao Login</a></div>
            </div>
        </div>
         <div class='col-md-4 col-md-offset-9'>
        <img class='logo_dm' src='../IMG/logo_dm.png' />
    </div>
    </div>";

        $this->setDados($dados);
    }

}
