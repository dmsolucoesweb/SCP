<?php

require_once 'HtmlGeral.php';
require_once '../Classes/montahtml.php';

class TrocarSenhaView extends HtmlGeral {

    public function getDadosEntrada() {
        $usuarioLoginSenhaAntiga = $this->getValorOuNull('usuarioLoginSenhaAntiga');
        $usuarioLoginSenhaAtual = $this->getValorOuNull('usuarioLoginSenhaAtual');
        $usuarioLoginSenhaConfirmacao = $this->getValorOuNull('usuarioLoginSenhaConfirmacao');

        return $usuarioLoginSenhaAntiga && $usuarioLoginSenhaAtual && $usuarioLoginSenhaConfirmacao;
    }

    public function montaDados($senha = null) {
        $dados = null;
        $montahtml = new MontaHTML();

        $dados .= "<form action='TrocarSenha.php' method='post'>
                   <h1>Redefinir Senha</h1>
                   <div class='row'>";

        $htmlFieldsetSenha = array("label" => "Senha Antiga", "type" => "password", "classefg" => "col-md-4", "name" => "usuarioLoginSenhaAntiga", "value" => $senha, "placeholder" => null, "disabled" => 0);
        $fieldsetSenha = $montahtml->montaInput($htmlFieldsetSenha);
        $fieldsetSenha .= "</div><div class='row'>";

        $htmlFieldsetSenha2 = array("label" => "Nova Senha", "type" => "password", "classefg" => "col-md-4", "name" => "usuarioLoginSenhaAtual", "value" => $senha, "placeholder" => null, "disabled" => 0);
        $fieldsetSenha2 = $montahtml->montaInput($htmlFieldsetSenha2);
        $fieldsetSenha2 .= "</div><div class='row'>";

        $htmlFieldsetSenha3 = array("label" => "Confirmação da Senha", "type" => "password", "classefg" => "col-md-4", "name" => "usuarioLoginSenhaConfirmacao", "value" => $senha, "placeholder" => null, "disabled" => 0);
        $fieldsetSenha3 = $montahtml->montaInput($htmlFieldsetSenha3);
        $fieldsetSenha3 .= "</div><div class='col-md-12'>";

        $dados .= $fieldsetSenha
                . $fieldsetSenha2
                . $fieldsetSenha3;

        $dados .= "<button name='bt' type='submit' class='btn btn-info' value='Trocar'><i class='glyphicon glyphicon-asterisk'></i> Redefinir Senha</button></div>";

        $this->setDados($dados);
    }

}
