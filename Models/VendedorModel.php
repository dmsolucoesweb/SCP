<?php

require_once 'Model.php';
require_once '../Classes/cpf.php';

class VendedorModel extends Model {

    private $vendedorId = null;
    private $vendedorNome = null;
    private $vendedorNacionalidade = null;
    private $vendedorDataNascimento = null;
    private $vendedorCPF = null;
    private $vendedorRG = null;
    private $vendedorOrgaoEmissor = null;
    private $vendedorEstadoOrgaoEmissor = null;
    private $vendedorSexo = null;
    private $vendedorEstadoCivil = null;
    private $vendedorRegimeComunhao = null;
    private $vendedorFiliacao = null;
    private $vendedorFiliacao2 = null;
    private $vendedorTelefone = null;
    private $vendedorTelefone2 = null;
    private $vendedorEndereco = null;
    private $vendedorCidade = null;
    private $vendedorEstado = null;
    private $vendedorCEP = null;
    private $vendedorEmail = null;
    private $vendedorProfissao = null;
    private $vendedorRenda = null;
    private $vendedorEmpresa = null;

    function __construct($vendedorId = null, $vendedorNome = null, $vendedorNacionalidade = null, $vendedorDataNascimento = null, $vendedorCPF = null, $vendedorRG = null, $vendedorOrgaoEmissor = null, $vendedorEstadoOrgaoEmissor = null, $vendedorSexo = null, $vendedorEstadoCivil = null, $vendedorRegimeComunhao = null, $vendedorFiliacao = null, $vendedorFiliacao2 = null, $vendedorTelefone = null, $vendedorTelefone2 = null, $vendedorEndereco = null, $vendedorCidade = null, $vendedorEstado = null, $vendedorCEP = null, $vendedorEmail = null, $vendedorProfissao = null, $vendedorRenda = null, $vendedorEmpresa = null) {
        $this->vendedorId = $vendedorId;
        $this->vendedorNome = $vendedorNome;
        $this->vendedorNacionalidade = $vendedorNacionalidade;
        $this->vendedorDataNascimento = $vendedorDataNascimento;
        $this->vendedorCPF = $vendedorCPF;
        $this->vendedorRG = $vendedorRG;
        $this->vendedorOrgaoEmissor = $vendedorOrgaoEmissor;
        $this->vendedorEstadoOrgaoEmissor = $vendedorEstadoOrgaoEmissor;
        $this->vendedorSexo = $vendedorSexo;
        $this->vendedorEstadoCivil = $vendedorEstadoCivil;
        $this->vendedorRegimeComunhao = $vendedorRegimeComunhao;
        $this->vendedorFiliacao = $vendedorFiliacao;
        $this->vendedorFiliacao2 = $vendedorFiliacao2;
        $this->vendedorTelefone = $vendedorTelefone;
        $this->vendedorTelefone2 = $vendedorTelefone2;
        $this->vendedorEndereco = $vendedorEndereco;
        $this->vendedorCidade = $vendedorCidade;
        $this->vendedorEstado = $vendedorEstado;
        $this->vendedorCEP = $vendedorCEP;
        $this->vendedorEmail = $vendedorEmail;
        $this->vendedorProfissao = $vendedorProfissao;
        $this->vendedorRenda = $vendedorRenda;
        $this->vendedorEmpresa = $vendedorEmpresa;
    }

    function getVendedorId() {
        return $this->vendedorId;
    }

    function getVendedorNome() {
        return $this->vendedorNome;
    }

    function getVendedorNacionalidade() {
        return $this->vendedorNacionalidade;
    }

    function getVendedorDataNascimento() {
        return $this->vendedorDataNascimento;
    }

    function getVendedorCPF() {
        return $this->vendedorCPF;
    }

    function getVendedorRG() {
        return $this->vendedorRG;
    }

    function getVendedorOrgaoEmissor() {
        return $this->vendedorOrgaoEmissor;
    }

    function getVendedorEstadoOrgaoEmissor() {
        return $this->vendedorEstadoOrgaoEmissor;
    }

    function getVendedorSexo() {
        return $this->vendedorSexo;
    }

    function getVendedorEstadoCivil() {
        return $this->vendedorEstadoCivil;
    }

    function getVendedorRegimeComunhao() {
        return $this->vendedorRegimeComunhao;
    }

    function getVendedorFiliacao() {
        return $this->vendedorFiliacao;
    }

    function getVendedorFiliacao2() {
        return $this->vendedorFiliacao2;
    }

    function getVendedorTelefone() {
        return $this->vendedorTelefone;
    }

    function getVendedorTelefone2() {
        return $this->vendedorTelefone2;
    }

    function getVendedorEndereco() {
        return $this->vendedorEndereco;
    }

    function getVendedorCidade() {
        return $this->vendedorCidade;
    }

    function getVendedorEstado() {
        return $this->vendedorEstado;
    }

    function getVendedorCEP() {
        return $this->vendedorCEP;
    }

    function getVendedorEmail() {
        return $this->vendedorEmail;
    }

    function getVendedorProfissao() {
        return $this->vendedorProfissao;
    }

    function getVendedorRenda() {
        return $this->vendedorRenda;
    }

    function getVendedorEmpresa() {
        return $this->vendedorEmpresa;
    }

    function setVendedorId($vendedorId) {
        $this->vendedorId = $vendedorId;
    }

    function setVendedorNome($vendedorNome) {
        $this->vendedorNome = $vendedorNome;
    }

    function setVendedorNacionalidade($vendedorNacionalidade) {
        $this->vendedorNacionalidade = $vendedorNacionalidade;
    }

    function setVendedorDataNascimento($vendedorDataNascimento) {
        $this->vendedorDataNascimento = $vendedorDataNascimento;
    }

    function setVendedorCPF($vendedorCPF) {
        $this->vendedorCPF = $vendedorCPF;
    }

    function setVendedorRG($vendedorRG) {
        $this->vendedorRG = $vendedorRG;
    }

    function setVendedorOrgaoEmissor($vendedorOrgaoEmissor) {
        $this->vendedorOrgaoEmissor = $vendedorOrgaoEmissor;
    }

    function setVendedorEstadoOrgaoEmissor($vendedorEstadoOrgaoEmissor) {
        $this->vendedorEstadoOrgaoEmissor = $vendedorEstadoOrgaoEmissor;
    }

    function setVendedorSexo($vendedorSexo) {
        $this->vendedorSexo = $vendedorSexo;
    }

    function setVendedorEstadoCivil($vendedorEstadoCivil) {
        $this->vendedorEstadoCivil = $vendedorEstadoCivil;
    }

    function setVendedorRegimeComunhao($vendedorRegimeComunhao) {
        $this->vendedorRegimeComunhao = $vendedorRegimeComunhao;
    }

    function setVendedorFiliacao($vendedorFiliacao) {
        $this->vendedorFiliacao = $vendedorFiliacao;
    }

    function setVendedorFiliacao2($vendedorFiliacao2) {
        $this->vendedorFiliacao2 = $vendedorFiliacao2;
    }

    function setVendedorTelefone($vendedorTelefone) {
        $this->vendedorTelefone = $vendedorTelefone;
    }

    function setVendedorTelefone2($vendedorTelefone2) {
        $this->vendedorTelefone2 = $vendedorTelefone2;
    }

    function setVendedorEndereco($vendedorEndereco) {
        $this->vendedorEndereco = $vendedorEndereco;
    }

    function setVendedorCidade($vendedorCidade) {
        $this->vendedorCidade = $vendedorCidade;
    }

    function setVendedorEstado($vendedorEstado) {
        $this->vendedorEstado = $vendedorEstado;
    }

    function setVendedorCEP($vendedorCEP) {
        $this->vendedorCEP = $vendedorCEP;
    }

    function setVendedorEmail($vendedorEmail) {
        $this->vendedorEmail = $vendedorEmail;
    }

    function setVendedorProfissao($vendedorProfissao) {
        $this->vendedorProfissao = $vendedorProfissao;
    }

    function setVendedorRenda($vendedorRenda) {
        $this->vendedorRenda = $vendedorRenda;
    }

    function setVendedorEmpresa($vendedorEmpresa) {
        $this->vendedorEmpresa = $vendedorEmpresa;
    }

    public function checaAtributos() {
        $atributosValidos = TRUE;

        if (is_null($this->vendedorNome)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o nome completo do Vendedor.");
        }

        if (is_null($this->vendedorNacionalidade)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione a Nacionalidade do Vendedor.");
        }

        if (is_null($this->vendedorDataNascimento)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite a Data de Nascimento do Vendedor.");
        }

        if (!CPF::validaCPF($this->vendedorCPF)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o CPF corretamente.");
        }

        if (is_null($this->vendedorRG)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o RG corretamente.");
        }

        if (is_null($this->vendedorOrgaoEmissor)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o Org&aatilde;o Emissor corretamente.");
        }

        if (is_null($this->vendedorEstadoOrgaoEmissor)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Estado do Org&aatilde;o Emissor.");
        }

        if (is_null($this->vendedorSexo)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Sexo do Vendedor.");
        }

        if (is_null($this->vendedorEstadoCivil)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Estado Civil do Vendedor.");
        }

        if ($this->clienteEstadoCivil == '2') {
            if (is_null($this->vendedorRegimeComunhao)) {
                $atributosValidos = FALSE;
                $this->adicionaMensagem("Selecione o Regime de Comunhão do Vendedor.");
            }
        }

        if (is_null($this->vendedorFiliacao2)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite a Filia&ccedil;&aatilde;o do Vendedor.");
        }

        if (is_null($this->vendedorTelefone)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite corretamente o Telefone do Vendedor.");
        }

        if (is_null($this->vendedorEndereco)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite corretamente o Endere&ccedil;o do Vendedor.");
        }

        if (is_null($this->vendedorCidade)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite o nome da Cidade corretamente do Vendedor.");
        }

        if (is_null($this->vendedorEstado)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Selecione o Estado do Vendedor.");
        }

        if (is_null($this->vendedorCEP)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite corretamente o CEP do Vendedor.");
        }

        if (is_null($this->vendedorProfissao)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite a Profiss&aatilde;o corretamente do Vendedor.");
        }

        if (is_null($this->vendedorRenda)) {
            $atributosValidos = FALSE;
            $this->adicionaMensagem("Digite a Renda do Vendedor.");
        }

        if ($this->vendedorEstadoCivil == '1' || $this->vendedorEstadoCivil == '3' || $this->vendedorEstadoCivil == '4' || $this->vendedorEstadoCivil == '5') {
            $this->vendedorRegimeComunhao = null;
        }

        return $atributosValidos;
    }

}
