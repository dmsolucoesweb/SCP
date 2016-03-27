<?php

require_once 'viewabstract.php';
include '../Config/config.php';

abstract class HtmlGeralLogin extends ViewAbstract {

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

    //////////////// html ////////////////

    public function montaHtml1() {

        $this->html1 = "            
                <!DOCTYPE html>
                <html lang='pt-br'>
                    <head>
                        <meta charset='UTF-8'>
                        <title>Sistema de Controle de Pagamento</title>
                        <style>body { 
  background: url('" . URL_SITE . "/IMG/bg.jpg') no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}


.panel-default {
background: rgba(255,255,255,.7);
margin-top:30px;
}</style>
                        <link rel='stylesheet' href='" . URL_SITE . "CSS/estilo.css'>
                        <link rel='stylesheet' href='" . URL_SITE . "CSS/bootstrap.min.css'>
                        <link rel='stylesheet' href='" . URL_SITE . "CSS/bootstrap-theme.min.css'>  
                        <link rel='stylesheet' href='" . URL_SITE . "CSS/sweet-alert.css'>
                        <script src='" . URL_SITE . "JS/sweet-alert.js'></script>
                        <script src='" . URL_SITE . "JS/jquery-1.11.0.js' ></script>
                        <script src='" . URL_SITE . "JS/jquery-migrate-1.2.1.js' ></script>    
                        <script src='" . URL_SITE . "JS/bootstrap.min.js' ></script>
                    </head>
                <body>";
    }

    //////////////// html ////////////////

    public function montaHtml2() {
        $this->html2 = "</body></html>";
    }

    //////////////// monta a parte principal da pagina, campos, botões etc ////////////////

    public function montaCorpo($objetoModel) {
        $this->montaDados($objetoModel);

        $this->corpo .= "<section id='Corpo'>";

        $this->corpo .= $this->mensagem;

        $this->corpo .= $this->getDados();

        $this->corpo .= "</section>";
    }

    //////////////// pega todas as funções de html e corpo e mostra para o usuário ////////////////

    public function displayInterface($objetoModel) {
        $this->montaCorpo($objetoModel);
        echo $this->getHtml1() . $this->getCorpo() . $this->getHtml2();
    }

    //////////////// ações do sistema ////////////////   


    abstract public function getDadosEntrada();

    abstract public function montaDados($objetoModel);

    function setAcao($acao) {
        $this->acao = $acao;
    }

    function getHtml1() {
        return $this->html1;
    }

    function getHtml2() {
        return $this->html2;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function setHtml1($html1) {
        $this->html1 = $html1;
    }

    function setHtml2($html2) {
        $this->html2 = $html2;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function getCorpo() {
        return $this->corpo;
    }

    function setCorpo($corpo) {
        $this->corpo = $corpo;
    }

    function getDados() {
        return $this->dados;
    }

    function setDados($dados) {
        $this->dados = $dados;
    }

    function getMensagem() {
        return $this->mensagem;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    function adicionaMensagemErro($mensagem) {
        if (is_array($mensagem)) {
            $i = 0;
            $this->mensagem .= "<script>$(document).ready(function () { 
swal({ title: \"Erro\", text: \"";

            foreach ($mensagem as $umaMensagem) {
                $this->mensagem .= "$umaMensagem \\n";
                $i++;
                if ($i > 6) {
                    break;
                }
            }
            $this->mensagem .= "\", type: \"error\", showCancelButton: false, allowEscapeKey: true, allowOutsideClick: true, confirmButtonClass: \"btn-danger\", confirmButtonText: \"Ok\" }); });
</script>";
        } else {
            $this->mensagem .= "<script>$(document).ready(function () { 
swal({ title: \"Erro\", text: \"$mensagem\", type: \"error\", showCancelButton: false, allowEscapeKey: true, allowOutsideClick: true, confirmButtonClass: \"btn-danger\", confirmButtonText: \"Ok\" }); });
</script>";
        }
    }

    function adicionaMensagemAlerta($mensagem) {
        if (is_array($mensagem)) {
            $i = 0;
            $this->mensagem .= "<script>$(document).ready(function () { 
swal({ title: \"Atenção\", text: \"";
            foreach ($mensagem as $umaMensagem) {
                $this->mensagem .= "$umaMensagem \\n";
                $i++;
                if ($i > 6) {
                    break;
                }
            }
            $this->mensagem .= "\", type: \"warning\", showCancelButton: false, allowEscapeKey: true, allowOutsideClick: true, confirmButtonClass: \"btn-warning\", confirmButtonText: \"Ok\" }); });
</script>";
        } else {
            $this->mensagem .= "<script>$(document).ready(function () { 
swal({ title: \"Atenção\", text: \"$mensagem\", type: \"warning\", showCancelButton: false, allowEscapeKey: true, allowOutsideClick: true, confirmButtonClass: \"btn-warning\", confirmButtonText: \"Ok\" }); });
</script>";
        }
    }

    function adicionaMensagemSucesso($mensagem) {
        if (is_array($mensagem)) {
            $i = 0;
            $this->mensagem .= "<script>$(document).ready(function () { 
swal({ title: \"Sucesso\", text: \"";
            foreach ($mensagem as $umaMensagem) {
                $this->mensagem .= "$umaMensagem \\n";
                $i++;
                if ($i > 6) {
                    break;
                }
            }
            $this->mensagem .= "\", type: \"success\", showCancelButton: false, allowEscapeKey: true, allowOutsideClick: true, confirmButtonClass: \"btn-success\", confirmButtonText: \"Ok\" }); });
</script>";
        } else {
            $this->mensagem .= "<script>$(document).ready(function () { 
swal({ title: \"Sucesso\", text: \"$mensagem\", type: \"success\", showCancelButton: false, allowEscapeKey: true, allowOutsideClick: true, confirmButtonClass: \"btn-success\", confirmButtonText: \"Ok\" }); });
</script>";
        }
    }

}
