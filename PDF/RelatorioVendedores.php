<?php

define('MPDF_PATH', 'class/mpdf/');
require_once 'mpdf/mpdf.php';
require_once '../Ados/ProdutoAdo.php';

class RelatorioVendedor {

    function EmitirRelatorioDeVendedor() {
        $mpdf = new mPDF('pt', 'A4', 0, 'arial', 20, 20, 35, 20, 9, 9, 'P');
        $stylesheet = file_get_contents('../PDF/pdf_sistema.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->SetHTMLHeader('<table class="header"><tbody><tr><td rowspan="3" class="logo"><img src="../IMG/logo89x50.png" /></td><td class="nopad_top">PARK VILLE INCORPORAÇÃO SPE LTDA - 23.501.469/0001-00</td></tr><tr><td class="nopad_top">Rua Francisco Soyer, nº 714, Centro, Inhumas/GO</td></tr><tr><td class="nopad_top"></td></tr><tr><td class="titulo_relatorio center" colspan="2">Ficha do Cliente</td></tr></tbody></table>');

        $VendedorAdo = new VendedorAdo();
        $vendedor = $VendedorAdo->consultaProdutoPeloCliente($vendedorId);

        if (is_array($vendedor)) {
            foreach ($vendedor as $vendedores) {
                $produtoApartamento = $vendedores->getProdutoApartamento();
                $produtoBox = $vendedores->getProdutoBox();
                $produtoValor = $vendedores->getProdutoValor();

                $Html .= "<tr><td class='titulo'>APARTAMENTO</td><td colspan ='7'>$produtoApartamento</td></tr>"
                        . "<tr><td class='titulo'>BOX</td><td colspan ='7'>$produtoBox</td></tr>"
                        . "<tr><td class='titulo'>VALOR</td><td colspan ='7'>$produtoValor</td></tr>";
            }
        }
    }

    function EmitirRelatorioDeVendedores() {
        
    }

}
