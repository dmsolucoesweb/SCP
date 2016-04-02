function calcula_parc() {
    var total = 0;
    $('.v_total').each(function () {
        var num = new NumberFormat();
        num.setInputDecimal(',');
        num.setNumber($(this).val());
        num.setPlaces('2', false);
        num.setCurrencyValue('');
        num.setCurrency(true);
        num.setCurrencyPosition(num.LEFT_OUTSIDE);
        num.setNegativeFormat(num.LEFT_DASH);
        num.setNegativeRed(false);
        num.setSeparators(false, '', '.');
        var valor = parseFloat(num.toFormatted());
        if (!isNaN(valor))
            total += valor;
        var num = new NumberFormat();
        num.setInputDecimal('.');
        num.setNumber(total);
        num.setPlaces('2', false);
        num.setCurrencyValue('');
        num.setCurrency(true);
        num.setCurrencyPosition(num.LEFT_OUTSIDE);
        num.setNegativeFormat(num.LEFT_DASH);
        num.setNegativeRed(false);
        num.setSeparators(true, '.', ',');
        total_f = num.toFormatted();
    });
    var num = new NumberFormat();
    num.setInputDecimal(',');
    num.setNumber($('.valor_apto').val());
    num.setPlaces('2', false);
    num.setCurrencyValue('');
    num.setCurrency(true);
    num.setCurrencyPosition(num.LEFT_OUTSIDE);
    num.setNegativeFormat(num.LEFT_DASH);
    num.setNegativeRed(false);
    num.setSeparators(false, '', '.');
    var valor_apto = parseFloat(num.toFormatted());
    if (total == valor_apto) {
        $('#alerta_parc').removeClass('alert-info alert-warning').addClass('alert-success');
        $('#alerta_parc').html('O total das parcelas adicionadas é igual ao valor do apartamento (R$ ' + total_f + ').');
        $('#inc').attr('disabled', false);
        $('#alt').attr('disabled', false);
    } else {
        var dif = total - valor_apto;
        var num = new NumberFormat();
        num.setInputDecimal('.');
        num.setNumber(dif);
        num.setPlaces('2', false);
        num.setCurrencyValue('');
        num.setCurrency(true);
        num.setCurrencyPosition(num.LEFT_OUTSIDE);
        num.setNegativeFormat(num.LEFT_DASH);
        num.setNegativeRed(false);
        num.setSeparators(true, '.', ',');
        dif = num.toFormatted();
        $('#alerta_parc').removeClass('alert-info alert-success').addClass('alert-warning');
        $('#alerta_parc').html('O total das parcelas adicionadas é de R$ ' + total_f + '. A diferença é de R$ ' + dif + '.');
        $('#inc').attr('disabled', true);
        $('#alt').attr('disabled', true);
    }
}
function calcula(id) {
    if ($('#n_parcela' + id + '').val() != '') {
        var v_uni = $('#v_unitario' + id + '').val();
        var n_parc = $('#n_parcela' + id + '').val();
        var num = new NumberFormat();
        num.setInputDecimal(',');
        num.setNumber(v_uni);
        num.setPlaces('2', false);
        num.setCurrencyValue('');
        num.setCurrency(true);
        num.setCurrencyPosition(num.LEFT_OUTSIDE);
        num.setNegativeFormat(num.LEFT_DASH);
        num.setNegativeRed(false);
        num.setSeparators(false, ',', ',');
        v_uni = num.toFormatted();
        var v_total = v_uni * n_parc;
        var num = new NumberFormat();
        num.setInputDecimal('.');
        num.setNumber(v_total);
        num.setPlaces('2', false);
        num.setCurrencyValue('');
        num.setCurrency(true);
        num.setCurrencyPosition(num.LEFT_OUTSIDE);
        num.setNegativeFormat(num.LEFT_DASH);
        num.setNegativeRed(false);
        num.setSeparators(true, '.', ',');
        v_total = num.toFormatted();
        $('#v_total' + id + '').val(v_total);
        $('#v_total' + id + '').change();
    }
}
var qtdeCampos = 1;

function addCampos() {
    var objPai = document.getElementById('campoPai');
    //Criando a DIV;
    var objFilho = document.createElement('div');
    //Definindo atributos ao objFilho:
    objFilho.setAttribute('id', 'filho' + qtdeCampos);
    objFilho.setAttribute('class', 'filho');

    //Inserindo o elemento no pai:
    objPai.appendChild(objFilho);
    //Escrevendo algo no filho recém-criado:
    document.getElementById('filho' + qtdeCampos).innerHTML = '<button class=\"btn btn-default btn-xs bt_excluipar\" onClick=\"removerCampo(' + qtdeCampos + ')\" type=\"button\"><i class=\"glyphicon text-danger glyphicon-minus-sign\"></i> <span class=\"hidden-lg hidden-md\">Excluir parcela</span></button><div class=\"row\" ><div class=\"form-group col-md-1\"> <label for=\"n_parcela\">Qtde</label> <input type=\"text\" onkeyup=\"calcula(' + qtdeCampos + ');\" class=\"form-control\" id=\"n_parcela' + qtdeCampos + '\" name=\"produtoParcelas[]\"> </div> <div class=\"form-group col-md-2\"> <label for=\"period\">Periodicidade</label> <select class=\"form-control\" id=\"period' + qtdeCampos + '\" name=\"produtoParcelasPeriodicidade[]\"><option value=\"-1\">Periodicidade</option><option value=\"1\">Única</option><option value=\"2\">Mensal</option></select> </div><div class=\"form-group col-md-3\"> <label for=\"venc_pri\" class=\"date\">Vencimento da 1ª série</label> <div class=\"input-group date linhaFieldset\"><input type=\"text\" class=\"form-control datePicker\" id=\"venc_pri' + qtdeCampos + '\" name=\"produtoParcelasDataVencimento[]\"> <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-th\"></i></span></div></div> <div class=\"form-group col-md-3\"> <label for=\"v_unitario\">Valor unitário</label> <input type=\"text\" onkeyup=\"calcula(' + qtdeCampos + ')\" class=\"form-control\" id=\"v_unitario' + qtdeCampos + '\" name=\"produtoParcelasValorUnitario[]\"> </div> <div class=\"form-group col-md-3\"> <label for=\"v_total\">Valor total</label> <input type=\"text\" class=\"form-control v_total\" id=\"v_total' + qtdeCampos + '\" onchange=\"calcula_parc()\" name=\"produtoParcelasValorTotal[]\"> </div></div><div class=\"row\"> <div class=\"form-group col-md-3\"> <label for=\"atul_mon\">Atualização Monetária</label> <select class=\"form-control\" id=\"atul_mon' + qtdeCampos + '\" name=\"produtoParcelasAtualizacaoMonetaria[]\"><option value=\"-1\">Atualização</option><option value=\"1\">Fixa e irreajustável</option><option value=\"2\">Reajustável</option></select></div> <div class=\"form-group col-md-3\"> <label for=\"form_pag\">Forma de pagamento</label> <select class=\"form-control\" id=\"form_pag' + qtdeCampos + '\" name=\"produtoParcelasFormaPagamento[]\"><option value=\"-1\">Forma de pagamento</option><option value=\"1\">À VISTA</option><option value=\"2\">BOLETO</option></select></div> <div class=\"form-group col-md-6\"> <label for=\"obs\">Observações</label> <input type=\"text\" class=\"form-control\" id=\"obs' + qtdeCampos + '\" name=\"produtoParcelasObservacoes[]\"> </div></div>';
    if (qtdeCampos == 1) {
        $('.bt_excluipar').addClass('hidden');
    }
    var nome_campo = '#v_total' + qtdeCampos;
    var nome_campo2 = '#v_unitario' + qtdeCampos;
    var nome_campo3 = '#venc_pri' + qtdeCampos;
    $(nome_campo).maskMoney({symbol: 'R$ ', decimal: ',', thousands: '.', showSymbol: false});
    $(nome_campo2).maskMoney({symbol: 'R$ ', decimal: ',', thousands: '.', showSymbol: false});
    $(nome_campo3).datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: 'linked',
        clearBtn: true,
        language: 'pt-BR',
        multidate: false
    });
    qtdeCampos++;

    $('select').select2({language: 'pt-BR'});
}

function removerCampo(id) {
    var objPai = document.getElementById('campoPai');
    var objFilho = document.getElementById('filho' + id);

    //Removendo o DIV com id específico do nó-pai:
    var removido = objPai.removeChild(objFilho);
}
$(document).ready(function () {
    $('.obrigatorio').hover().tooltip('show','top');
// funcao javascript que implementa datepicker
    $('.input-group.date').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: 'linked',
        clearBtn: true,
        language: 'pt-BR',
        multidate: false
    });
// função javascript que implementa select2 bootstrap 
$('select').select2({ language: 'pt-BR' });
// função javascript que mostra opções do vendedor na página de vendas
    $('.vendedor_produto').change(function () { 
        if ($('.vendedor_produto').val() == 1) {
            $('.dados_int').hide( 'fast', 'linear' );
        } else { $('.dados_int').show( 'fast', 'linear' );}
    });
// função javascript que mostra opções do Cpp na página de cadastro de clientes
$('input[name=\"clienteCppStatus\"]').change(function () {
    var status = $('input[name=\"clienteCppStatus\"]:checked').val();
    if (status == 'N') { 
    $('.spp').hide(); 
    $('.linha').addClass('hidden');     
    $('.cliente').removeClass('col-md-6').addClass('col-md-12');
    } else { 
    $('.cliente').removeClass('col-md-12').addClass('col-md-6');
    $('.linha').removeClass('hidden');    
    $('.spp').show( 'fast', 'linear' ); 
    } });
 
        $('select[name=\"clienteEstadoCivil\"]').change(function () {
        var status_estado = $('select[name=\"clienteEstadoCivil\"]').val();
        if ( status_estado == '1' ) {
        $('select[name=\"clienteRegimeComunhao\"]').prop('disabled', 'disabled'); 
        $('select[name=\"clienteRegimeComunhao\"]').val() = -1;
} 
        else if ( status_estado == '3' ) {
        $('select[name=\"clienteRegimeComunhao\"]').prop('disabled', 'disabled'); 
        $('select[name=\"clienteRegimeComunhao\"]').val() = -1;
} 
        else if ( status_estado == '4' ) {
        $('select[name=\"clienteRegimeComunhao\"]').prop('disabled', 'disabled'); 
        $('select[name=\"clienteRegimeComunhao\"]').val() = -1;
}
        else { $('select[name=\"clienteRegimeComunhao\"]').prop('disabled', ''); }
    });
    
        $('select[name=\"vendedorEstadoCivil\"]').change(function () {
        var status_estado = $('select[name=\"vendedorEstadoCivil\"]').val();
        if ( status_estado == '1' ) {
        $('select[name=\"vendedorRegimeComunhao\"]').prop('disabled', 'disabled'); 
        $('select[name=\"vendedorRegimeComunhao\"]').val() = -1;
} 
        else if ( status_estado == '3' ) {
        $('select[name=\"vendedorRegimeComunhao\"]').prop('disabled', 'disabled'); 
        $('select[name=\"vendedorRegimeComunhao\"]').val() = -1;
} 
        else if ( status_estado == '4' ) {
        $('select[name=\"vendedorRegimeComunhao\"]').prop('disabled', 'disabled'); 
        $('select[name=\"vendedorRegimeComunhao\"]').val() = -1;
}
        else { $('select[name=\"vendedorRegimeComunhao\"]').prop('disabled', ''); }
    });
    
    $('select[name=\"clienteCppEstadoCivil\"]').change(function () {
        var status_estado = $('select[name=\"clienteCppEstadoCivil\"]').val();
        if ( status_estado == '1' ) {
        $('select[name=\"clienteCppRegimeComunhao\"]').prop('disabled', 'disabled'); 
        $('select[name=\"clienteCppRegimeComunhao\"]').val() = -1;
} 
        else if ( status_estado == '3' ) {
        $('select[name=\"clienteCppRegimeComunhao\"]').prop('disabled', 'disabled'); 
        $('select[name=\"clienteCppRegimeComunhao\"]').val() = -1;        
} 
        else if ( status_estado == '4' ) {
        $('select[name=\"clienteCppRegimeComunhao\"]').prop('disabled', 'disabled'); 
        $('select[name=\"clienteCppRegimeComunhao\"]').val() = -1;
}
        else { $('select[name=\"clienteCppRegimeComunhao\"]').prop('disabled', ''); }
    });
    });
    
jQuery(function($){
    $('.obrigatorio').tooltip('hide');
    $('.moeda').maskMoney({symbol:'R$ ',decimal:',',thousands:'.',showSymbol : false});
    $('.fone').mask('(99) 9999-9999');
    $('.cpf').mask('999.999.999-99');
    $('.cep').mask('99.999-999');
    $('.indice').mask('0.0000');
});