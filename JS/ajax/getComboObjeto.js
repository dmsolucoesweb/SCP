/**
 * Este é um Código da Fábrica de Software
 * 
 * Coordenador: Elymar Pereira Cabral
 * 
 * Descrição: esse JS permique que vc escolha um select que deseje pegar um valor 
 * para setar outro select par isso vc deve passar os seguintes parametros:
 * 
 * 
 * Data: 15/10/2013
 * 
 * 
 * @autor Giovane Citnra Alencar
 */

var selecSetado;

function setSelect(idSelectOrigem, idSelectDestino, arquivoPhp) {
    var formulario = document.getElementById(idSelectOrigem);
    var index = formulario.selectedIndex;
    var option = formulario.options[index].value;
    selecSetado=idSelectDestino;
    if (option == -1) {
        limpaSelect();
       
        var select = document.getElementById(idSelectDestino);  
 
        var option = document.createElement("option");
        option.value = "-1";
        option.text= " Selecione opção anterior ";
        select.options.add(option);
    }else{
        mostraObjeto(option,arquivoPhp);
    }
}

function mostraObjeto(objeto,arquivoPhp) {
    if (objeto == null) {
        return;
    }
    var url = "../AJAX/" + arquivoPhp + ".php?valorId=" + encodeURIComponent(objeto);
    requisicaoHTTP("GET", url, true);
}

function trataDados() {
    var info = ajax.responseText; // responseText é um método do JS
    var arrayOpcoes = info.split("|");
    limpaSelect();
    adicionarOpcoesSelect(arrayOpcoes);
}
function adicionarOpcoesSelect(arrayOpcoes){
    var select = document.getElementById(selecSetado);  
 
    if(select != null){
        for(var i = 0 ; i < arrayOpcoes.length-1 ; i += 2){
            var option = document.createElement("option");
            option.value = arrayOpcoes[i];
            option.text = arrayOpcoes[i + 1];
            select.options.add(option);
        }
    }
    else{
      window.alert("O elemento " + selecSetado +" não foi encontrado.");
    }
  }
function limpaSelect(){
    var select = document.getElementById(selecSetado);    

    // Limpa o combo destino para adicionar novos dados
    if(select.options.length > 0){
        select.options.length = 0;    

    }
    
}

