<?php

if (!isset($_SESSION)) {
    session_start();
}

include('../Config/config.php');

echo " <!DOCTYPE html>
                <html lang='pt-br'>
                    <head>
                        <meta charset='UTF-8'>
                        <title>Sistema de Controle de Pagamento</title>
                        <link rel='stylesheet' href='../CSS/estilo.css'>
                        <link rel='stylesheet' href='../CSS/bootstrap.min.css'>
                        <link rel='stylesheet' href='../CSS/bootstrap-theme.min.css'>
                        <link rel='stylesheet' href='../CSS/sweet-alert.css'>
                        <script src='" . URL_SITE . "JS/sweet-alert.js'></script>
                        <script src='" . URL_SITE . "JS/jquery-1.11.0.js' ></script>
                        <script src='" . URL_SITE . "JS/bootstrap.min.js' ></script>
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
    echo "
          <li role='separator' class='divider'></li>
          <li><a href='" . URL_SITE . "Modulos/UsuarioLogin.php'><i class='glyphicon glyphicon-user'></i> Usuários</a></li>";
}
echo "
          </ul>
        </li>
        <li> <a href='" . URL_SITE . "Modulos/Produto.php'><i class='glyphicon glyphicon-shopping-cart'></i> Vendas </a> </li>";
if ($_SESSION['usuarioLoginTipo'] == 1) {
    echo "
            <li> <a href='" . URL_SITE . "Modulos/Indice.php'><i class='glyphicon glyphicon-check'></i> Atualizar &Iacute;ndices </a> </li>
            <li> <a href='" . URL_SITE . "Modulos/Pagamento.php'><i class='glyphicon glyphicon-piggy-bank'></i> Pagamento </a> </li>;
            <li> <a href='" . URL_SITE . "Modulos/Boleto.php'><i class='glyphicon glyphicon-piggy-bank'></i> Boleto </a> </li>";
}
echo "</ul>
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

echo "<section id='Corpo'>
                <div class='branco_index'></div>
                </section>
</div><footer class='rodape'>
      <div class='container'>
        <p class='text-muted'>&copy;" . date("Y") . " - Desenvolvido por DM Soluções Web.</p>
      </div>
    </footer>";
if (isset($_GET['np'])) {
    echo "<script>$(document).ready(function () { 
swal({ title: \"Erro\", text: \"Usuário sem privilégios para acessar método!\", type: \"error\", showCancelButton: false, allowEscapeKey: true, allowOutsideClick: true, confirmButtonClass: \"btn-danger\", confirmButtonText: \"Ok\" }); });
</script>";
}
echo "</body></html>";
