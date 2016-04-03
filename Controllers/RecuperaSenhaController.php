<?php

require_once '../Views/RecuperaSenhaView.php';
require_once '../Models/UsuarioLoginModel.php';
require_once '../Ados/UsuarioLoginAdo.php';
require_once '../Classes/emails.php';
require_once '../BD/ConexaoBancoDeDados.php';

class RecuperaSenhaController {

    private $RecuperaSenhaView = null;
    private $usuarioLoginEmail = null;
    private $usuarioLoginLogin = null;
    private $novaSenha = null;

    public function __construct() {
        $this->RecuperaSenhaView = new RecuperaSenhaView();
        $acao = $this->RecuperaSenhaView->getAcao();

        switch ($acao) {

            case "Recuperar" :
                $this->geraNovaSenha();

                if (isset($this->novaSenha)) {
                    // Cria um objeto para utilizar os métodos da ADO (de forma transparente)
                    $usuarioLoginAdo = new UsuarioLoginAdo();
                    $ConexaoBancoDeDados = new ConexaoBancoDeDados();

                    $this->usuarioLoginEmail = $this->RecuperaSenhaView->getDadosEntrada();

                    $usuarioLoginEmail = $this->usuarioLoginEmail;
                    $usuarioLoginId = $usuarioLoginAdo->consultaIdPeloEmail($usuarioLoginEmail);
                    $Usuario = $usuarioLoginAdo->consultaObjetoPeloId($usuarioLoginId);
                    $this->usuarioLoginLogin = $Usuario->getUsuarioLoginLogin();

                    if ($usuarioLoginId == null) {
                        $this->RecuperaSenhaView->adicionaMensagemErro("Erro ao enviar a nova senha para o e-mail informado.");
                    } else {
                        if ($this->enviaEmail()) {
                            $novaSenha = sha1($this->novaSenha);
                            $query = "update Usuarios_Login set usuarioLoginSenha = '{$novaSenha}' where usuarioLoginId = '{$usuarioLoginId}'";
                            $resultado = $ConexaoBancoDeDados->executaQuery($query);

                            if ($resultado) {
                                //consulta Ok. Continua.
                                // ERRO 101: Erro ao realizar o select de usuario_login (senha)
                            } else {
                                parent::setMensagem("Erro 101 " . parent::getBdError());
                                return false;
                            }

                            $this->RecuperaSenhaView->adicionaMensagemSucesso("Senha redefinida com sucesso! Acesse o e-mail informado para verificar sua nova senha.", "Informacao");
                            $this->usuarioLoginEmail = null;
                        } else {
                            $this->RecuperaSenhaView->adicionaMensagemErro("Erro ao enviar a nova senha para o e-mail informado.");
                        }
                    }
                }
                break;
        }

        $this->RecuperaSenhaView->displayInterface($this->usuarioLoginEmail);
    }

    function geraNovaSenha() {
        $maiusculas = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
        $minusculas = "abcdefghijklmnopqrstuwxyz";
        $numeros = "0123456789";
        $codigos = null;

        $base = $maiusculas . $minusculas . $numeros . $codigos;

        srand((float) microtime() * 10000000); // Semeia o processo randômico
        $senha = '';
        for ($i = 0; $i < 8; $i++) {
            $senha .= substr($base, rand(0, strlen($base) - 1), 1);
        }

        $this->novaSenha = $senha;
    }

    function enviaEmail() {
        $email = new Emails();

        $endereco['email'] = $this->usuarioLoginEmail;
        $endereco['nome'] = "";
        $enderecos[] = $endereco;

        $assunto = "SCP - Redefinição de Senha";
        $corpo = "Foi solicitado através de nosso sistema (SCP) a redefinição da sua senha: \n\n "
                . "Login da Conta: " . $this->usuarioLoginLogin
                . "\n Nova Senha:  " . $this->novaSenha
                . "\n\n Caso não seja você, informe ao administrador do sistema sobre este aviso."
                . "\n\n 2016 - DM Soluções Web. Todos os direitos reservados.";

        return $email->enviaEmails($enderecos, $assunto, $corpo);
    }

}
