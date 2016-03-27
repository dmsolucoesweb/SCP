<?php

require_once 'phpmailer.php';

class Emails extends PHPMailer {

    function __construct() {
        $this->SMTPSecure = 'ssl';
        $this->CharSet = "utf8"; // Define a Codificação
        $this->IsSMTP(); // Define que será enviado por SMTP
        $this->Host = "smtp.gmail.com"; // Servidor SMTP
        $this->Port = 465;
        $this->SMTPAuth = true; // Caso o servidor SMTP precise de autenticação
        $this->Username = "dmsolucoesweb2@gmail.com"; // Usuário ou E-mail para autenticação no SMTP
        $this->Password = "Cadu$9719!sn"; // Senha do E-mail
        $this->IsHTML(false); // Enviar como HTML
        $this->FromName = "DM Solucoes"; // Nome do Remetente
    }

    function enviaEmails(Array $enderecos, $assunto, $corpo) {

        foreach ($enderecos as $endereco) {
            parent::AddAddress($endereco['email'], $endereco['nome']);
        }

        $this->Subject = $assunto; // Define o Assunto
        $this->Body = $corpo;

        return parent::Send();
    }

}
