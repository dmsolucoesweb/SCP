<?php

require_once 'Model.php';
require_once '../Classes/cpf.php';

class ClienteModel extends Model {

    private $clienteId = null;
    private $clienteNome = null;
    private $clienteNacionalidade = null;
    private $clienteDataNascimento = null;
    private $clienteCPF = null;
    private $clienteRG = null;
    private $clienteOrgaoEmissor = null;
    private $clienteEstadoOrgaoEmissor = null;
    private $clienteSexo = null;
    private $clienteEstadoCivil = null;
    private $clienteRegimeComunhao = null;
    private $clienteFiliacao = null;
    private $clienteFiliacao2 = null;
    private $clienteTelefone = null;
    private $clienteTelefone2 = null;
    private $clienteEndereco = null;
    private $clienteCidade = null;
    private $clienteEstado = null;
    private $clienteCEP = null;
    private $clienteEmail = null;
    private $clienteProfissao = null;
    private $clienteRenda = null;
    private $clienteEmpresa = null;
    private $clienteCargo = null;
    private $clienteCppStatus = null;
    private $clienteCppNome = null;
    private $clienteCppNacionalidade = null;
    private $clienteCppDataNascimento = null;
    private $clienteCppCPF = null;
    private $clienteCppRG = null;
    private $clienteCppOrgaoEmissor = null;
    private $clienteCppEstadoOrgaoEmissor = null;
    private $clienteCppSexo = null;
    private $clienteCppEstadoCivil = null;
    private $clienteCppRegimeComunhao = null;
    private $clienteCppFiliacao = null;
    private $clienteCppFiliacao2 = null;
    private $clienteCppTelefone = null;
    private $clienteCppTelefone2 = null;
    private $clienteCppEndereco = null;
    private $clienteCppCidade = null;
    private $clienteCppEstado = null;
    private $clienteCppCEP = null;
    private $clienteCppEmail = null;
    private $clienteCppProfissao = null;
    private $clienteCppRenda = null;
    private $clienteCppEmpresa = null;
    private $clienteCppCargo = null;

    function __construct($clienteId = null, $clienteNome = null, $clienteNacionalidade = null, $clienteDataNascimento = null, $clienteCPF = null, $clienteRG = null, $clienteOrgaoEmissor = null, $clienteEstadoOrgaoEmissor = null, $clienteSexo = null, $clienteEstadoCivil = null, $clienteRegimeComunhao = null, $clienteFiliacao = null, $clienteFiliacao2 = null, $clienteTelefone = null, $clienteTelefone2 = null, $clienteEndereco = null, $clienteCidade = null, $clienteEstado = null, $clienteCEP = null, $clienteEmail = null, $clienteProfissao = null, $clienteRenda = null, $clienteEmpresa = null, $clienteCargo = null, $clienteCppStatus = null, $clienteCppNome = null, $clienteCppNacionalidade = null, $clienteCppDataNascimento = null, $clienteCppCPF = null, $clienteCppRG = null, $clienteCppOrgaoEmissor = null, $clienteCppEstadoOrgaoEmissor = null, $clienteCppSexo = null, $clienteCppEstadoCivil = null, $clienteCppRegimeComunhao = null, $clienteCppFiliacao = null, $clienteCppFiliacao2 = null, $clienteCppTelefone = null, $clienteCppTelefone2 = null, $clienteCppEndereco = null, $clienteCppCidade = null, $clienteCppEstado = null, $clienteCppCEP = null, $clienteCppEmail = null, $clienteCppProfissao = null, $clienteCppRenda = null, $clienteCppEmpresa = null, $clienteCppCargo = null) {
        $this->clienteId = $clienteId;
        $this->clienteNome = $clienteNome;
        $this->clienteNacionalidade = $clienteNacionalidade;
        $this->clienteDataNascimento = $clienteDataNascimento;
        $this->clienteCPF = $clienteCPF;
        $this->clienteRG = $clienteRG;
        $this->clienteOrgaoEmissor = $clienteOrgaoEmissor;
        $this->clienteEstadoOrgaoEmissor = $clienteEstadoOrgaoEmissor;
        $this->clienteSexo = $clienteSexo;
        $this->clienteEstadoCivil = $clienteEstadoCivil;
        $this->clienteRegimeComunhao = $clienteRegimeComunhao;
        $this->clienteFiliacao = $clienteFiliacao;
        $this->clienteFiliacao2 = $clienteFiliacao2;
        $this->clienteTelefone = $clienteTelefone;
        $this->clienteTelefone2 = $clienteTelefone2;
        $this->clienteEndereco = $clienteEndereco;
        $this->clienteCidade = $clienteCidade;
        $this->clienteEstado = $clienteEstado;
        $this->clienteCEP = $clienteCEP;
        $this->clienteEmail = $clienteEmail;
        $this->clienteProfissao = $clienteProfissao;
        $this->clienteRenda = $clienteRenda;
        $this->clienteEmpresa = $clienteEmpresa;
        $this->clienteCargo = $clienteCargo;
        $this->clienteCppStatus = $clienteCppStatus;
        $this->clienteCppNome = $clienteCppNome;
        $this->clienteCppNacionalidade = $clienteCppNacionalidade;
        $this->clienteCppDataNascimento = $clienteCppDataNascimento;
        $this->clienteCppCPF = $clienteCppCPF;
        $this->clienteCppRG = $clienteCppRG;
        $this->clienteCppOrgaoEmissor = $clienteCppOrgaoEmissor;
        $this->clienteCppEstadoOrgaoEmissor = $clienteCppEstadoOrgaoEmissor;
        $this->clienteCppSexo = $clienteCppSexo;
        $this->clienteCppEstadoCivil = $clienteCppEstadoCivil;
        $this->clienteCppRegimeComunhao = $clienteCppRegimeComunhao;
        $this->clienteCppFiliacao = $clienteCppFiliacao;
        $this->clienteCppFiliacao2 = $clienteCppFiliacao2;
        $this->clienteCppTelefone = $clienteCppTelefone;
        $this->clienteCppTelefone2 = $clienteCppTelefone2;
        $this->clienteCppEndereco = $clienteCppEndereco;
        $this->clienteCppCidade = $clienteCppCidade;
        $this->clienteCppEstado = $clienteCppEstado;
        $this->clienteCppCEP = $clienteCppCEP;
        $this->clienteCppEmail = $clienteCppEmail;
        $this->clienteCppProfissao = $clienteCppProfissao;
        $this->clienteCppRenda = $clienteCppRenda;
        $this->clienteCppEmpresa = $clienteCppEmpresa;
        $this->clienteCppCargo = $clienteCppCargo;
    }

    function getClienteId() {
        return $this->clienteId;
    }

    function getClienteNome() {
        return $this->clienteNome;
    }

    function getClienteNacionalidade() {
        return $this->clienteNacionalidade;
    }

    function getClienteDataNascimento() {
        return $this->clienteDataNascimento;
    }

    function getClienteCPF() {
        return $this->clienteCPF;
    }

    function getClienteRG() {
        return $this->clienteRG;
    }

    function getClienteOrgaoEmissor() {
        return $this->clienteOrgaoEmissor;
    }

    function getClienteEstadoOrgaoEmissor() {
        return $this->clienteEstadoOrgaoEmissor;
    }

    function getClienteSexo() {
        return $this->clienteSexo;
    }

    function getClienteEstadoCivil() {
        return $this->clienteEstadoCivil;
    }

    function getClienteRegimeComunhao() {
        return $this->clienteRegimeComunhao;
    }

    function getClienteFiliacao() {
        return $this->clienteFiliacao;
    }

    function getClienteFiliacao2() {
        return $this->clienteFiliacao2;
    }

    function getClienteTelefone() {
        return $this->clienteTelefone;
    }

    function getClienteTelefone2() {
        return $this->clienteTelefone2;
    }

    function getClienteEndereco() {
        return $this->clienteEndereco;
    }

    function getClienteCidade() {
        return $this->clienteCidade;
    }

    function getClienteEstado() {
        return $this->clienteEstado;
    }

    function getClienteCEP() {
        return $this->clienteCEP;
    }

    function getClienteEmail() {
        return $this->clienteEmail;
    }

    function getClienteProfissao() {
        return $this->clienteProfissao;
    }

    function getClienteRenda() {
        return $this->clienteRenda;
    }

    function getClienteEmpresa() {
        return $this->clienteEmpresa;
    }

    function getClienteCargo() {
        return $this->clienteCargo;
    }

    function getClienteCppStatus() {
        return $this->clienteCppStatus;
    }

    function getClienteCppNome() {
        return $this->clienteCppNome;
    }

    function getClienteCppNacionalidade() {
        return $this->clienteCppNacionalidade;
    }

    function getClienteCppDataNascimento() {
        return $this->clienteCppDataNascimento;
    }

    function getClienteCppCPF() {
        return $this->clienteCppCPF;
    }

    function getClienteCppRG() {
        return $this->clienteCppRG;
    }

    function getClienteCppOrgaoEmissor() {
        return $this->clienteCppOrgaoEmissor;
    }

    function getClienteCppEstadoOrgaoEmissor() {
        return $this->clienteCppEstadoOrgaoEmissor;
    }

    function getClienteCppSexo() {
        return $this->clienteCppSexo;
    }

    function getClienteCppEstadoCivil() {
        return $this->clienteCppEstadoCivil;
    }

    function getClienteCppRegimeComunhao() {
        return $this->clienteCppRegimeComunhao;
    }

    function getClienteCppFiliacao() {
        return $this->clienteCppFiliacao;
    }

    function getClienteCppFiliacao2() {
        return $this->clienteCppFiliacao2;
    }

    function getClienteCppTelefone() {
        return $this->clienteCppTelefone;
    }

    function getClienteCppTelefone2() {
        return $this->clienteCppTelefone2;
    }

    function getClienteCppEndereco() {
        return $this->clienteCppEndereco;
    }

    function getClienteCppCidade() {
        return $this->clienteCppCidade;
    }

    function getClienteCppEstado() {
        return $this->clienteCppEstado;
    }

    function getClienteCppCEP() {
        return $this->clienteCppCEP;
    }

    function getClienteCppEmail() {
        return $this->clienteCppEmail;
    }

    function getClienteCppProfissao() {
        return $this->clienteCppProfissao;
    }

    function getClienteCppRenda() {
        return $this->clienteCppRenda;
    }

    function getClienteCppEmpresa() {
        return $this->clienteCppEmpresa;
    }

    function getClienteCppCargo() {
        return $this->clienteCppCargo;
    }

    function setClienteId($clienteId) {
        $this->clienteId = $clienteId;
    }

    function setClienteNome($clienteNome) {
        $this->clienteNome = $clienteNome;
    }

    function setClienteNacionalidade($clienteNacionalidade) {
        $this->clienteNacionalidade = $clienteNacionalidade;
    }

    function setClienteDataNascimento($clienteDataNascimento) {
        $this->clienteDataNascimento = $clienteDataNascimento;
    }

    function setClienteCPF($clienteCPF) {
        $this->clienteCPF = $clienteCPF;
    }

    function setClienteRG($clienteRG) {
        $this->clienteRG = $clienteRG;
    }

    function setClienteOrgaoEmissor($clienteOrgaoEmissor) {
        $this->clienteOrgaoEmissor = $clienteOrgaoEmissor;
    }

    function setClienteEstadoOrgaoEmissor($clienteEstadoOrgaoEmissor) {
        $this->clienteEstadoOrgaoEmissor = $clienteEstadoOrgaoEmissor;
    }

    function setClienteSexo($clienteSexo) {
        $this->clienteSexo = $clienteSexo;
    }

    function setClienteEstadoCivil($clienteEstadoCivil) {
        $this->clienteEstadoCivil = $clienteEstadoCivil;
    }

    function setClienteRegimeComunhao($clienteRegimeComunhao) {
        $this->clienteRegimeComunhao = $clienteRegimeComunhao;
    }

    function setClienteFiliacao($clienteFiliacao) {
        $this->clienteFiliacao = $clienteFiliacao;
    }

    function setClienteFiliacao2($clienteFiliacao2) {
        $this->clienteFiliacao2 = $clienteFiliacao2;
    }

    function setClienteTelefone($clienteTelefone) {
        $this->clienteTelefone = $clienteTelefone;
    }

    function setClienteTelefone2($clienteTelefone2) {
        $this->clienteTelefone2 = $clienteTelefone2;
    }

    function setClienteEndereco($clienteEndereco) {
        $this->clienteEndereco = $clienteEndereco;
    }

    function setClienteCidade($clienteCidade) {
        $this->clienteCidade = $clienteCidade;
    }

    function setClienteEstado($clienteEstado) {
        $this->clienteEstado = $clienteEstado;
    }

    function setClienteCEP($clienteCEP) {
        $this->clienteCEP = $clienteCEP;
    }

    function setClienteEmail($clienteEmail) {
        $this->clienteEmail = $clienteEmail;
    }

    function setClienteProfissao($clienteProfissao) {
        $this->clienteProfissao = $clienteProfissao;
    }

    function setClienteRenda($clienteRenda) {
        $this->clienteRenda = $clienteRenda;
    }

    function setClienteEmpresa($clienteEmpresa) {
        $this->clienteEmpresa = $clienteEmpresa;
    }

    function setClienteCargo($clienteCargo) {
        $this->clienteCargo = $clienteCargo;
    }

    function setClienteCppStatus($clienteCppStatus) {
        $this->clienteCppStatus = $clienteCppStatus;
    }

    function setClienteCppNome($clienteCppNome) {
        $this->clienteCppNome = $clienteCppNome;
    }

    function setClienteCppNacionalidade($clienteCppNacionalidade) {
        $this->clienteCppNacionalidade = $clienteCppNacionalidade;
    }

    function setClienteCppDataNascimento($clienteCppDataNascimento) {
        $this->clienteCppDataNascimento = $clienteCppDataNascimento;
    }

    function setClienteCppCPF($clienteCppCPF) {
        $this->clienteCppCPF = $clienteCppCPF;
    }

    function setClienteCppRG($clienteCppRG) {
        $this->clienteCppRG = $clienteCppRG;
    }

    function setClienteCppOrgaoEmissor($clienteCppOrgaoEmissor) {
        $this->clienteCppOrgaoEmissor = $clienteCppOrgaoEmissor;
    }

    function setClienteCppEstadoOrgaoEmissor($clienteCppEstadoOrgaoEmissor) {
        $this->clienteCppEstadoOrgaoEmissor = $clienteCppEstadoOrgaoEmissor;
    }

    function setClienteCppSexo($clienteCppSexo) {
        $this->clienteCppSexo = $clienteCppSexo;
    }

    function setClienteCppEstadoCivil($clienteCppEstadoCivil) {
        $this->clienteCppEstadoCivil = $clienteCppEstadoCivil;
    }

    function setClienteCppRegimeComunhao($clienteCppRegimeComunhao) {
        $this->clienteCppRegimeComunhao = $clienteCppRegimeComunhao;
    }

    function setClienteCppFiliacao($clienteCppFiliacao) {
        $this->clienteCppFiliacao = $clienteCppFiliacao;
    }

    function setClienteCppFiliacao2($clienteCppFiliacao2) {
        $this->clienteCppFiliacao2 = $clienteCppFiliacao2;
    }

    function setClienteCppTelefone($clienteCppTelefone) {
        $this->clienteCppTelefone = $clienteCppTelefone;
    }

    function setClienteCppTelefone2($clienteCppTelefone2) {
        $this->clienteCppTelefone2 = $clienteCppTelefone2;
    }

    function setClienteCppEndereco($clienteCppEndereco) {
        $this->clienteCppEndereco = $clienteCppEndereco;
    }

    function setClienteCppCidade($clienteCppCidade) {
        $this->clienteCppCidade = $clienteCppCidade;
    }

    function setClienteCppEstado($clienteCppEstado) {
        $this->clienteCppEstado = $clienteCppEstado;
    }

    function setClienteCppCEP($clienteCppCEP) {
        $this->clienteCppCEP = $clienteCppCEP;
    }

    function setClienteCppEmail($clienteCppEmail) {
        $this->clienteCppEmail = $clienteCppEmail;
    }

    function setClienteCppProfissao($clienteCppProfissao) {
        $this->clienteCppProfissao = $clienteCppProfissao;
    }

    function setClienteCppRenda($clienteCppRenda) {
        $this->clienteCppRenda = $clienteCppRenda;
    }

    function setClienteCppEmpresa($clienteCppEmpresa) {
        $this->clienteCppEmpresa = $clienteCppEmpresa;
    }

    function setClienteCppCargo($clienteCppCargo) {
        $this->clienteCppCargo = $clienteCppCargo;
    }

    public function checaAtributos() {
        $atributosValidos = TRUE;

        if (is_null($this->clienteNome)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o nome completo do Cliente.");
        }

        if (is_null($this->clienteNacionalidade)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione a Nacionalidade do Cliente.");
        }

        if (is_null($this->clienteDataNascimento)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite a Data de Nascimento do Cliente.");
        }

        if (!CPF::validaCPF($this->clienteCPF)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o CPF corretamente.");
        }

        if (is_null($this->clienteRG)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o RG corretamente.");
        }

        if (is_null($this->clienteOrgaoEmissor)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o Org&aatilde;o Emissor corretamente.");
        }

        if (is_null($this->clienteEstadoOrgaoEmissor)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Estado do Org&aatilde;o Emissor.");
        }

        if (is_null($this->clienteSexo)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Sexo do Cliente.");
        }

        if (is_null($this->clienteEstadoCivil)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Estado Civil do Cliente.");
        }

        if ($this->clienteEstadoCivil == '2') {
            if (is_null($this->clienteRegimeComunhao)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Selecione o Regime de Comunhão do Cliente.");
            }
        }

        if (is_null($this->clienteFiliacao2)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite a Filia&ccedil;&aatilde;o do Cliente.");
        }

        if (is_null($this->clienteTelefone)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite corretamente o Telefone do Cliente.");
        }

        if (is_null($this->clienteEndereco)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite corretamente o Endere&ccedil;o do Cliente.");
        }

        if (is_null($this->clienteCidade)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o nome da Cidade corretamente do Cliente.");
        }

        if (is_null($this->clienteEstado)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Estado do Cliente.");
        }

        if (is_null($this->clienteCEP)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite corretamente o CEP do Cliente.");
        }

        if (is_null($this->clienteProfissao)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite a Profissão corretamente do Cliente.");
        }

        if (is_null($this->clienteRenda)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite a Renda do Cliente.");
        }

        if (is_null($this->clienteCppStatus)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Escolha o Status do ClienteCpp.");
        }

        if ($this->clienteCppStatus == 'C' || $this->clienteCppStatus == 'SP' || $this->clienteCppStatus == 'P') {
            if (is_null($this->clienteCppNome)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite o nome completo do ClienteCpp.");
            }

            if (is_null($this->clienteCppNacionalidade)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Selecione a Nacionalidade do ClienteCpp.");
            }

            if (is_null($this->clienteCppDataNascimento)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite a Data de Nascimento do ClienteCpp.");
            }

            if (!CPF::validaCPF($this->clienteCppCPF)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite o CPF corretamente do ClienteCpp.");
            }

            if (is_null($this->clienteCppRG)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite o RG corretamente do ClienteCpp.");
            }

            if (is_null($this->clienteCppOrgaoEmissor)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite o Org&aatilde;o Emissor corretamente do ClienteCpp.");
            }

            if (is_null($this->clienteCppEstadoOrgaoEmissor)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Selecione o Estado do Org&aatilde;o Emissor do ClienteCpp.");
            }

            if (is_null($this->clienteCppSexo)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Selecione o Sexo do Cliente do ClienteCpp.");
            }

            if (is_null($this->clienteCppEstadoCivil)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Selecione o Estado Civil do Cliente do ClienteCpp.");
            }

            if (is_null($this->clienteCppRegimeComunhao)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Selecione o Regime de Comunhão do ClienteCpp.");
            }

            if (is_null($this->clienteCppFiliacao2)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite a Filia&ccedil;&aatilde;o do ClienteCpp.");
            }

            if (is_null($this->clienteCppTelefone)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite corretamente o Telefone do ClienteCpp.");
            }

            if (is_null($this->clienteCppEndereco)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite corretamente o Endere&ccedil;o do ClienteCpp.");
            }

            if (is_null($this->clienteCppCidade)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite o nome da Cidade corretamente do ClienteCpp.");
            }

            if (is_null($this->clienteCppEstado)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Selecione o Estado do ClienteCpp.");
            }

            if (is_null($this->clienteCppCEP)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite corretamente o CEP do ClienteCpp.");
            }

            if (is_null($this->clienteCppProfissao)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite a Profiss&aatilde;o corretamente do ClienteCpp.");
            }

            if (is_null($this->clienteCppRenda)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Digite a Renda do ClienteCpp.");
            }
        }

        if ($this->clienteEstadoCivil == '1' || $this->clienteEstadoCivil == '3' || $this->clienteEstadoCivil == '4' || $this->clienteEstadoCivil == '5') {
            $this->clienteRegimeComunhao = null;
        }

        if ($this->clienteCppEstadoCivil == '1' || $this->clienteCppEstadoCivil == '3' || $this->clienteCppEstadoCivil == '4' || $this->clienteCppEstadoCivil == '5') {
            $this->clienteCppRegimeComunhao = null;
        }

        if ($this->clienteCppStatus == NULL || $this->clienteCppStatus == 'N') {
            $this->clienteCppNome = null;
            $this->clienteCppNacionalidade = null;
            $this->clienteCppDataNascimento = null;
            $this->clienteCppCPF = null;
            $this->clienteCppRG = null;
            $this->clienteCppOrgaoEmissor = null;
            $this->clienteCppEstadoOrgaoEmissor = null;
            $this->clienteCppSexo = null;
            $this->clienteCppEstadoCivil = null;
            $this->clienteCppRegimeComunhao = null;
            $this->clienteCppFiliacao = null;
            $this->clienteCppFiliacao2 = null;
            $this->clienteCppTelefone = null;
            $this->clienteCppTelefone2 = null;
            $this->clienteCppEndereco = null;
            $this->clienteCppCidade = null;
            $this->clienteCppEstado = null;
            $this->clienteCppCEP = null;
            $this->clienteCppEmail = null;
            $this->clienteCppProfissao = null;
            $this->clienteCppRenda = null;
            $this->clienteCppEmpresa;
        }

        return $atributosValidos;
    }

}
