<?php

require_once 'HtmlGeral.php';
require_once '../Models/VendedorModel.php';
require_once '../Ados/VendedorAdo.php';
require_once '../Classes/montahtml.php';
require_once '../Ados/UsuarioLoginAdo.php';
include('../Classes/functions.php');

class IndiceView extends HtmlGeral {

    public function getDadosEntrada() {
        $DatasEHoras = new DatasEHoras();
        $CPF = new CPF();

        $indiceId = $this->getValorOuNull('indiceId');
        $indiceInccValor = $CPF->retiraMascaraRenda($this->getValorOuNull('indiceInccValor'));
        $indiceIgpmValor = $CPF->retiraMascaraRenda($this->getValorOuNull('indiceIgpmValor'));
        $indiceData = $DatasEHoras->getDataEHorasInvertidaComTracos($this->getValorOuNull('indiceData'));
        $usuarioId = $this->getValorOuNull('usuarioId');

        return new IndiceModel($indiceId, $indiceInccValor, $indiceIgpmValor, $indiceData, $usuarioId);
    }

    public function montaOpcoesDeIndices($indiceSelected) {
        $opcoesDeIndices = null;

        $indiceAdo = new IndiceAdo();
        $arrayDeindices = $indiceAdo->consultaArrayDeObjeto();

        if ($arrayDeindices === 0) {
            return null;
        }

        if (is_array($arrayDeindices)) {
            foreach ($arrayDeindices as $indiceModel) {
                $selected = null;

                $indiceId = $indiceModel->getIndiceId();
                $indiceInccValor = $indiceModel->getIndiceInccValor();
                $indiceIgpmValor = $indiceModel->getIndiceIgpmValor();
                $indiceData = $indiceModel->getIndiceData();

                $text = 'Data: ' . $indiceData . '| INCC:' . $indiceInccValor . ' | IGPM:' . $indiceIgpmValor;

                if ($indiceId == $indiceSelected) {
                    $selected = 1;
                }

                $opcoesDeIndices[] = array("value" => $indiceId, "selected" => $selected, "text" => $text);
            }
        }

        return $opcoesDeIndices;
    }

    public function montaDados($IndiceModel) {
        $dados = null;
        $MontaHtml = new MontaHTML();
        $UsuarioLoginAdo = new UsuarioLoginAdo();

        $indiceId = $IndiceModel->getIndiceId();
        $indiceInccValor = ($IndiceModel->getIndiceInccValor() * 100);
        $indiceIgpmValor = ($IndiceModel->getIndiceIgpmValor() * 100);

        if ($indiceInccValor != 0 && $indiceIgpmValor != 0) {
            $indiceInccValor = number_format($indiceInccValor, 2, ",", ".");
            $indiceIgpmValor = number_format($indiceIgpmValor, 2, ",", ".");
        }

        $indiceData = $IndiceModel->getIndiceData();
        $usuarioId = $IndiceModel->getUsuarioId();
        $Usuario = $UsuarioLoginAdo->consultaObjetoPeloId($usuarioId);

        if ($indiceId != null && $indiceId != '-1') {
            $usuarioLoginNome = $Usuario->getUsuarioLoginNome();
        } else {
            $usuarioLoginNome = $_SESSION['usuarioLoginNome'];
            $usuarioId = $_SESSION['usuarioLoginId'];
        }

        $htmlComboIndices = array("label" => "&Iacute;ndice:", "name" => "idConsulta", "options" => $this->montaOpcoesDeIndices($indiceId));
        $comboDeIndices = $MontaHtml->montaCombobox($htmlComboIndices, $textoPadrao = 'Escolha um &Iacute;ndice', $onChange = null, $disabled = false);

        $dados .= "<form action='Indice.php' id='form_indice' method='post'>
                    <h1>Cadastro de Índices</h1>
                    <div class='well'><legend>Consulta</legend>";

        $dados .= $comboDeIndices;

        $dados .= "<button id='consulta' type='button' class='btn btn-info'><i class='glyphicon glyphicon-search'></i> Consultar</button>
                   <button id='relatorio' type='button' class='btn btn-info'><i class='glyphicon glyphicon-print'></i> Emitir Relatório</button></div>";

        $dadosfieldsetHidden = array("name" => "indiceId", "value" => $indiceId);
        $hiddenId = $MontaHtml->montaInputHidden($dadosfieldsetHidden);
        $hiddenId .= "<div class='row'>";

        $htmlFieldsetInccValor = array("label" => "Valor INCC (%)", "classefg" => "col-md-4", "type" => "text", "name" => "indiceInccValor", "classecampo" => "moeda", "value" => $indiceInccValor, "placeholder" => null, "disabled" => false);
        $fieldsetInccValor = $MontaHtml->montaInput($htmlFieldsetInccValor);

        $htmlFieldsetIgpmValor = array("label" => "Valor IGP-M (%)", "classefg" => "col-md-4", "type" => "text", "name" => "indiceIgpmValor", "classecampo" => "moeda", "value" => $indiceIgpmValor, "placeholder" => null, "disabled" => false);
        $fieldsetIgpmValor = $MontaHtml->montaInput($htmlFieldsetIgpmValor);
        $fieldsetIgpmValor .= "</div><div class='row'>";

        $htmlFieldsetData = array("label" => "Data da atualização", "classefg" => "col-md-4", "name" => "indiceData", "value" => $indiceData, "disabled" => false);
        $fieldsetData = $MontaHtml->montaInputDeData($htmlFieldsetData);
        $fieldsetData .= "</div><div class='row'>";

        $dadosfieldsetHidden2 = array("name" => "usuarioId", "value" => $usuarioId);
        $hiddenId2 = $MontaHtml->montaInputHidden($dadosfieldsetHidden2);

        $htmlFieldsetUsuario = array("label" => "Usuário responsável pelo processamento", "classefg" => "col-md-4", "type" => "text", "name" => "usuarioLoginNome", "classecampo" => "moeda", "value" => $usuarioLoginNome, "placeholder" => null, "disabled" => true);
        $fieldsetUsuario = $MontaHtml->montaInput($htmlFieldsetUsuario);

        $dados .= $hiddenId
                . $fieldsetInccValor
                . $fieldsetIgpmValor
                . $fieldsetData
                . $hiddenId2
                . $fieldsetUsuario
                . "<div class='row'>";

        $dados .= "</div></div><div class='col-md-10'>
                <input class='hidden' name='bt' id='cod_enviar' type='text' value='' />
                <button type='button' id='novo' class='btn btn-info'><i class='glyphicon glyphicon-asterisk'></i> Novo</button>
                <button id='incluir' type='button' class='btn btn-success'><i class='glyphicon glyphicon-ok'></i> Incluir</button>
                </div></div>                
                </form>
<script>
$(document).ready(function() {
$('#novo').click(function() { $('#cod_enviar').val('nov'); $('#form_indice').submit(); });
$('#relatorio').click(function() { $('#cod_enviar').val('erl'); $('#form_indice').submit(); });
$('#consulta').click(function() { $('#cod_enviar').val('con'); $('#form_indice').submit(); });
$('#incluir').click(function(){    swal({
  title: 'Atenção!',
  text: 'Você tem certeza sobre os valores inseridos para os índices? Uma vez inseridos, eles irão atualizar todos os saldos devedores.',
  type: 'warning',
  showCancelButton: true,
  confirmButtonClass: 'btn-success',
  cancelButtonText: 'Cancelar',
  allowEscapeKey: true, 
  allowOutsideClick: true,
  confirmButtonText: 'Confirmo!',
  closeOnConfirm: false
},
function(){
  $('#cod_enviar').val('inc');
  $('#form_indice').submit();
}); }); 
});</script>       
";

        $this->setDados($dados);
    }

}
