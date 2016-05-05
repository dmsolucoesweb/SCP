<?php

require_once 'viewabstract.php';
include '../Config/config.php';

if (!isset($_SESSION)) {
    session_start();
}
// Verifica se não há a variável da sessão que identifica o usuário
if ($_SESSION['usuarioLoginId'] == null) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header("Location: ../index.php");
    exit;
} elseif (isset($nivel_gerente) AND $_SESSION['usuarioLoginTipo'] != 1) {
    header("Location: ../Views/InicioView.php");
}

abstract class HtmlGeral extends ViewAbstract {

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
                        
                        <link rel='stylesheet' href='" . URL_SITE . "CSS/estilo.css'>
                        <link rel='stylesheet' href='" . URL_SITE . "CSS/select2.min.css'> 
                        <link rel='stylesheet' href='" . URL_SITE . "CSS/bootstrap.min.css'>
                        <link rel='stylesheet' href='" . URL_SITE . "CSS/bootstrap-theme.min.css'>  
                        <link rel='stylesheet' href='" . URL_SITE . "CSS/bootstrap-datepicker3.standalone.min.css'>
                        <link rel='stylesheet' href='" . URL_SITE . "CSS/sweet-alert.css'>
                        <script src='" . URL_SITE . "JS/sweet-alert.js'></script>
                        <script src='" . URL_SITE . "JS/jquery-1.11.0.js' ></script>
                        <script src='" . URL_SITE . "JS/jquery-migrate-1.2.1.js' ></script>    
                        <script src='" . URL_SITE . "JS/bootstrap.min.js' ></script>
                        <script src='" . URL_SITE . "JS/MontaMascaraCPF.js' ></script>
                        <script src='" . URL_SITE . "JS/select2.min.js'></script>
                        <script src='" . URL_SITE . "JS/select2_pt-BR.js'></script>
                        <script src='" . URL_SITE . "JS/bootstrap-datepicker.min.js'></script>
                        <script src='" . URL_SITE . "JS/jquery.maskedinput.min.js'></script>
                        <script src='" . URL_SITE . "JS/jquery.maskMoney.js'></script>
                        <script src='" . URL_SITE . "JS/NumberFormat.js'></script>
                        <script src='" . URL_SITE . "JS/funcoes_js.js'></script>
                        <script src='" . URL_SITE . "JS/bootstrap-datepicker.pt-BR.min.js'></script>
                    </head>
                    <body>
                <div class='container'>
                <header id='topo'>
                    <figure class='logo'>
                        <img src='" . URL_SITE . "/IMG/logo.png'>
                    </figure> 
<h1>Sistema de Controle de Pagamento</h1>
                             
                <div id='Menu'>
<nav class='navbar navbar-inverse'>
  <div class='container-fluid'>
    <div class='collapse navbar-collapse' id='menu-principal'>
      <ul class='nav navbar-nav'>
        <!-- Classe active... mostra qual página esta <li class='active'><a href='#'>Link <span class='sr-only'>(atual)</span></a></li> -->
<li> <a href='" . URL_SITE . "Views/InicioView.php'><i class='glyphicon glyphicon-home'></i> In&iacute;cio </a> </li> 
    <li class='dropdown'>
          <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><i class='glyphicon glyphicon-folder-open'></i> Cadastro <span class='caret'></span></a>
          <ul class='dropdown-menu'>
          <li> <a href='" . URL_SITE . "Modulos/Cliente.php'><i class='glyphicon glyphicon-user'></i> Clientes </a> </li>
          <li> <a href='" . URL_SITE . "Modulos/Vendedor.php'><i class='glyphicon glyphicon-user'></i> Vendedores </a> </li>";
        if ($_SESSION['usuarioLoginTipo'] == 1) {
            $this->html1 .= "
          <li role='separator' class='divider'></li>
          <li><a href='" . URL_SITE . "Modulos/UsuarioLogin.php'><i class='glyphicon glyphicon-user'></i> Usuários</a></li>";
        }
        $this->html1 .= "
          </ul>
        </li>
        <li> <a href='" . URL_SITE . "Modulos/Produto.php'><i class='glyphicon glyphicon-shopping-cart'></i> Vendas </a> </li>";
        if ($_SESSION['usuarioLoginTipo'] == 1) {
            $this->html1 .= "
            <li> <a href='" . URL_SITE . "Modulos/Indice.php'><i class='glyphicon glyphicon-check'></i> Atualizar &Iacute;ndices </a> </li>
            <li> <a href='" . URL_SITE . "Modulos/Pagamento.php'><i class='glyphicon glyphicon-piggy-bank'></i> Pagamento </a> </li>;
            <li> <a href='" . URL_SITE . "Modulos/Boleto.php'><i class='glyphicon glyphicon-piggy-bank'></i> Boleto </a> </li>";
        }
        $this->html1 .= "</ul>
    <ul class='nav navbar-nav navbar-right'>      
         <li class='dropdown txt_logado'>
          <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><i class='glyphicon glyphicon-lock'></i> Olá, " . $_SESSION['usuarioLoginNome'] . "! <span class='caret'></span></a>
          <ul class='dropdown-menu'>
            <li><a href='" . URL_SITE . "Modulos/TrocarSenha.php'><i class='glyphicon glyphicon-refresh'></i> Alterar Senha</a></li>
            <li role='separator' class='divider'></li>
            <li><a href='" . URL_SITE . "Login/logout.php'><i class='glyphicon glyphicon-off'></i> Sair</a></li>
            </ul>
        </li>
        </ul>
    </div>
  </div>
</nav>                

                </div>
                </header>";
    }

    //////////////// html ////////////////

    public function montaHtml2() {
        $this->html2 = "</div><footer class='rodape'>
      <div class='container'>
        <p class='text-muted'>&copy;" . date("Y") . " - Desenvolvido por DM Soluções Web.</p>
      </div>
    </footer>";
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

    function setHtml1($html1) {
        $this->html1 = $html1;
    }

    function setHtml2($html2) {
        $this->html2 = $html2;
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
