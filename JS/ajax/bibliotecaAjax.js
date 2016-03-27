/* 
 * Este javascript trara as principais funções que 
 * vc ira presisar para trabalhar com o Ajax
 *  Data: 15/10/2013.
 * Desevolvedor: Giovane Cintra
 * Descrição: biblioteca de ajax
 * Este codigo se encontra no livro Web Interativa com Ajax e PHP / Juliano Niederauer / 2007 
 * O livro pode ser encontrado na FSW e na Biblioteca Atenas - Campus Inhumas  
 */

var ajax;
var dadosUsuario;

// ---------- cria Objeto e faz requisição -------------------
function requisicaoHTTP(tipo, url, assinc) {
    if (window.XMLHttpRequest) { // Mozila, safari e outros
        ajax = new XMLHttpRequest();
    }
    else if (window.ActiveXOject) { // IE
        ajax = new ActiveXOject("Msxml2.XMLHTTP");
        if (!ajax) {
            ajax = new ActiveXOject("Microsoft.XMLHTTP");
        }
    }
    if (ajax)
        iniciaRequisicao(tipo, url, assinc);
    else
        alert("Seu navegador não possui suporte a essa aplicação! Utilize Mozilla, IE, Chrome, Safari ou contate o analista responsável.");

}

// ------------------ Inicializa o objeto criado e envia os dados (se existirem)-----------
function iniciaRequisicao(tipo, url, bool) {
    ajax.onreadystatechange = trataResposta;// É um método, mas não se deve colocar ()   
    ajax.open(tipo, url, bool);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
    if (identifyBrowser() == 4 ) {
        ajax.overrideMimeType("text/XML");
    }
    ajax.send(dadosUsuario);
}

//---------------- Detequita se o navegador e o Mozilla----------------
function identifyBrowser() {

    var ua = navigator.userAgent.toLowerCase();
    if (ua.indexOf("mozilla") != -1) {
        if (ua.indexOf("firefox") != -1) {
            browserName = "firefox";
            return 4;
        } 
    }
}

// ------------ Inicia requisitos com envio de dados---------
function enviaDados(url) {
    criaQueryString();
    requisicaoHTTP("POST", url, true);

}

// ----------------- Cria a String a ser enviada, Formato campo1=valor&camp2=valor-------
function criaQueryString() {
    dadosUsuario = "";
    var frm = document.forms[1];
    var numElementos = frm.elements.length;
    for (var i = 0; i < numElementos; i++) {
        if (i < numElementos - 1) {
            dadosUsuario += frm.elements[i].name + "=" + encodeURIComponent(frm.elements[i].value) + "&";
        }else{
            dadosUsuario += frm.elements[i].name+"="+encodeURIComponent(frm.elements[i].value);
        }

    }
}
// ------------ Trata a resposta do servidor -----------
function trataResposta(){
    
    if(ajax.readyState == 4 ){
        if(ajax.status == 200){
           trataDados(); // Cria essa função no seu programa 
        }else{
            alert("Problema na comunicação com o objeto XMLHttpRequest. Contate o analista responsável.");
        }
    }
}