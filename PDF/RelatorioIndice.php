<?php

define('MPDF_PATH', 'class/mpdf/');
require_once 'mpdf/mpdf.php';
require_once '../Ados/IndiceAdo.php';
include('../Config/config.php');

class RelatorioIndice {

    function EmitirRelatorioDeIndices() {

        $mpdf = new mPDF('pt', 'A4', 0, 'arial', 20, 20, 35, 20, 9, 9, 'P');
        $stylesheet = file_get_contents('../PDF/pdf_sistema.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->SetHTMLHeader('<table class="header"><tbody><tr><td rowspan="3" class="logo"><img src="../IMG/logo89x50.png" /></td><td class="nopad_top">PARK VILLE INCORPORAÇÃO SPE LTDA - 23.501.469/0001-00</td></tr><tr><td class="nopad_top">Rua Francisco Soyer, nº 714, Centro, Inhumas/GO</td></tr><tr><td class="nopad_top"></td></tr><tr><td class="titulo_relatorio center" colspan="2">Índices aplicados</td></tr></tbody></table>');
        $arrayDeIndices = $IndiceAdo->consultaArrayDeObjeto();
        $Html1 = "<table class='proposta center'><thead><tr><td class='secao'>Data de aplicação</td><td class='secao'>INCC (%)</td><td class='secao'>IGP-M +1 (%)</td><td class='secao'>Usuário responsável pelo processamento</td></tr></thead><tbody>";
        $mpdf->WriteHTML($Html1);

        $IndiceAdo = new IndiceAdo();
        $UsuarioAdo = new UsuarioLoginAdo;

        if (is_array($arrayDeIndices)) {
            foreach ($arrayDeIndices as $IndiceModel) {
                $Html = null;

                $indiceInccValor = $IndiceModel->getIndiceInccValor() * 100;
                $indiceIgpmValor = $IndiceModel->getIndiceIgpmValor() * 100;
                $indiceData = $IndiceModel->getIndiceData();
                $usuarioId = $IndiceModel->getUsuarioId();
                $Usuario = $UsuarioAdo->consultaObjetoPeloId($usuarioId);
                $usuarioLoginNome = $Usuario->getUsuarioLoginNome();
                $Html .= "<tr><td>$indiceData</td><td>$indiceInccValor</td><td>$indiceIgpmValor</td><td>$usuarioLoginNome</td></tr>";

                $mpdf->WriteHTML($Html);
            } //fecha foreach
        } //fecha condicional 'if'
        $Html2 = "</tbody></table>";
        $mpdf->WriteHTML($Html2);
        $arquivo = date("d-m-Y") . "-indices_aplicados.pdf";
        $mpdf->Output($arquivo, "I");
        exit();
    }

//fecha função emitirrelatorioindices

    function EmitirRelatorioIndice($indiceModel) {
        $mpdf = new mPDF('pt', 'A4', 0, 'arial', 20, 20, 35, 20, 9, 9, 'P');
        $stylesheet = file_get_contents('../PDF/pdf_sistema.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->SetHTMLHeader('<table class="header"><tbody><tr><td rowspan="3" class="logo"><img src="../IMG/logo89x50.png" /></td><td class="nopad_top">PARK VILLE INCORPORAÇÃO SPE LTDA - 23.501.469/0001-00</td></tr><tr><td class="nopad_top">Rua Francisco Soyer, nº 714, Centro, Inhumas/GO</td></tr><tr><td class="nopad_top"></td></tr><tr><td class="titulo_relatorio center" colspan="2">Índices aplicados</td></tr></tbody></table>');
        $IndiceAdo = new IndiceAdo();
        $arrayDeIndices = $IndiceAdo->consultaArrayDeObjeto();
        $Html1 = "<table class='proposta center'><thead><tr><td class='secao'>Data de aplicação</td><td class='secao'>INCC (%)</td><td class='secao'>IGP-M +1 (%)</td><td class='secao'>Usuário responsável pelo processamento</td></tr></thead><tbody>";
        $mpdf->WriteHTML($Html1);

        if (is_array($arrayDeIndices)) {
            foreach ($arrayDeIndices as $indiceModel) {
                $Html = null;

                $indiceId = $indiceModel->getIndiceId();
                $Html .= "<tr><td>$indiceData</td><td>$indiceInccValor</td><td>$indiceIgpmValor</td><td>$nome_u</td></tr>";

                $mpdf->WriteHTML($Html);
            } //fecha foreach
        } //fecha condicional 'if'
        $Html2 = "</tbody></table>";
        $mpdf->WriteHTML($Html2);
        $arquivo = date("d-m-Y") . "-indices_aplicados.pdf";
        $mpdf->Output($arquivo, "I");
        exit();
    }

//fecha função emitirrelatorioindiceperiodo
}

//fecha classe