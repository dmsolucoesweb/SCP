<?php

include '../Config/config.php';
require_once '../Views/LoginView.php';
require_once '../Models/LoginModel.php';
require_once '../BD/ConexaoBancoDeDados.php';

class LoginController {

    private $LoginView = null;
    private $LoginModel = null;

    public function __construct() {
        $this->LoginView = new LoginView();
        $this->LoginModel = new LoginModel();

        $acao = $this->LoginView->getAcao();

        switch ($acao) {
            case "entrar":
                $this->Loga();
                $this->LoginView->displayInterface($this->LoginModel);
                break;
            default :
                $this->LoginView->displayInterface($this->LoginModel);
                break;
        }
    }

    function Loga() {
        $LoginModel = $this->LoginView->getDadosEntrada();

        if (!isset($_SESSION)) {
            session_start();
        }

        // Verifica se não há a variável da sessão que identifica o usuário
        if (isset($_SESSION['usuarioLoginId'])) {
            // Destrói a sessão por segurança
            session_destroy();
            // Redireciona o visitante de volta pro login
            header("Location: ../index.php");
            exit;
        }

        //include('../Login/connect_pdo.php');
        $ConexaoBancoDeDados = new ConexaoBancoDeDados();
        $ConexaoBancoDeDados->connect_pdo();

        $usuario = $LoginModel->getLogin();
        $senha = $LoginModel->getSenha();

        $query = "select usuarioLoginSenha from UsuariosLogin where usuarioLoginLogin = '{$usuario}'";
        $ConexaoBancoDeDados->executaQuery($query);
        $senhasBd = $ConexaoBancoDeDados->leTabelaBD();

        $usuarios = null;
        $senhas = sha1($senha);

        if ($senhas === $senhasBd['usuarioLoginSenha']) {
            $query2 = "select usuarioLoginId, usuarioLoginLogin, usuarioLoginNome, usuarioLoginTipo from UsuariosLogin where usuarioLoginLogin = '{$usuario}' and usuarioLoginSenha = '{$senhas}'";
            $ConexaoBancoDeDados->executaQuery($query2);
            $usuarios = $ConexaoBancoDeDados->leTabelaBD();
        }

        if ($usuarios == null) {
            $this->LoginView->adicionaMensagemErro("Usuário e/ou a senha digitados não existem.");
        } else {
            // Se a sessão não existir, inicia uma
            if (!isset($_SESSION)) {
                session_start();
            }

            // Salva os dados encontrados na sessão
            $_SESSION['usuarioLoginId'] = $usuarios['usuarioLoginId'];
            $_SESSION['usuarioLoginNome'] = $usuarios['usuarioLoginNome'];
            $_SESSION['usuarioLoginTipo'] = $usuarios['usuarioLoginTipo'];

            // Redireciona o visitante
            echo "<div class='row'><div class='alert alert-success text-center' role='alert'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
            <span class='sr-only'>Sucesso!</span>Login realizado! Você será redirecionado em breve!</div><div/>";
            header("Location: ../Views/InicioView.php");
            exit;
        }
    }

}
