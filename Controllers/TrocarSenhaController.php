<?php

require_once '../Views/TrocarSenhaView.php';
require_once '../Ados/UsuarioLoginAdo.php';

class TrocarSenhaController {

    private $trocarSenhaView = null;
    private $usuarioLoginSenhaAn = null;
    private $usuarioLoginSenhaAt = null;
    private $usuarioLoginSenhaCf = null;

    public function __construct() {

        $this->trocarSenhaView = new TrocarSenhaView();
        $acao = $this->trocarSenhaView->getAcao();

        switch ($acao) {
            case "Trocar" :
                $this->trocarSenha();
                break;
        }

        $this->trocarSenhaView->displayInterface($this->usuarioLoginSenhaAn, $this->usuarioLoginSenhaAt, $this->usuarioLoginSenhaCf);
    }

    function trocarSenha() {
        if (!isset($_SESSION)) {
            session_start();
        }

        // Verifica se não há a variável da sessão que identifica o usuário
        if (!isset($_SESSION['usuarioLoginId'])) {
            // Destrói a sessão por segurança
            session_destroy();
            // Redireciona o visitante de volta pro login
            header("Location: ../index.php");
            exit;
        }

        $this->usuarioLoginSenhaAn = sha1($_POST['usuarioLoginSenhaAntiga']);
        $this->usuarioLoginSenhaAt = sha1($_POST['usuarioLoginSenhaAtual']);
        $this->usuarioLoginSenhaCf = sha1($_POST['usuarioLoginSenhaConfirmacao']);

        if ($this->usuarioLoginSenhaAn != null && $this->usuarioLoginSenhaAt != null && $this->usuarioLoginSenhaCf != null) {
            $usuarioLoginAdo = new UsuarioLoginAdo();
            $ConexaoBancoDeDados = new ConexaoBancoDeDados();

            $id = $_SESSION['usuarioLoginId'];
            $Usuario = $usuarioLoginAdo->consultaObjetoPeloId($id);
            $senhaAntTeste = $Usuario->getUsuarioLoginSenha();

            if ($this->usuarioLoginSenhaAn == $senhaAntTeste && $this->usuarioLoginSenhaAt === $this->usuarioLoginSenhaCf) {
                $query = "update UsuariosLogin set usuarioLoginSenha = '{$this->usuarioLoginSenhaAt}' where usuarioLoginId = '{$id}'";
                $resultado = $ConexaoBancoDeDados->executaQuery($query);

                if ($resultado) {
                    //consulta Ok. Continua.
                } else {
                    parent::setMensagem("Erro no select de Usuarios-Login(senha): " . parent::getBdError());
                    return false;
                }

                $this->trocarSenhaView->adicionaMensagemSucesso("Senha alterada com sucesso!");
                $this->usuarioLoginSenhaAn = null;
                $this->usuarioLoginSenhaAt = null;
                $this->usuarioLoginSenhaACf = null;
            } else {
                $this->trocarSenhaView->adicionaMensagemErro("Erro ao tentar ao trocar a senha!");
                $this->usuarioLoginSenhaAn = null;
                $this->usuarioLoginSenhaAt = null;
                $this->usuarioLoginSenhaACf = null;
            }
        }
    }

}
