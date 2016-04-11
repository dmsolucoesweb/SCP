<?php

require_once 'HtmlGeral.php';

class RemessaView extends HtmlGeral {

    public function getDadosEntrada() {
        
    }

    public function montaDados($objetoModel) {
        $dados = null;

        $dados .= "<form action='Remessa.php' method='post'>
                    <h1>Gerar Remessa</h1>";

        $dados .= "<div class='col-md-10'>
                   <button name='bt' type='submit' class='btn btn-success' value='grm'><i class='glyphicon glyphicon-asterisk'></i> Gerar Remessa(s)</button>
                   <button name='bt' type='submit' class='btn btn-info' value='grma'><i class='glyphicon glyphicon-ok'></i> Gerar Remessa(s) Anterior(es)</button>
                   </div></form>";

        $this->setDados($dados);
    }

}
