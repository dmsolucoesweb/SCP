/* Data: 01/11/2012.
 * Desevolvedor: Flayson Potenciano.
 * E-mail: flayson.potenciano@gmail.com.
 * Descrição: Valida CPF.
 * Obs.: Validaçao de nome, não deixa informar números 
 * e determina o tamanho mínimo. 
 */
function fvalNomePesquisa(campo){
    var regra =/[A-z]/;
    
    if (!regra.test(campo)) {
        alert("Opss... O nove deve iniciar com uma letra.");
        return false;
    }
    return true;
}

function fvalNome(campo, idMensagem){
    //var campo = document.getElementById(idNome).value;
    //var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    //var regra = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
    //var regra = /^[A-Za-z]{10,}/;
    //alert(campo);
    var valLength = campo.length;
    if (valLength<10){
        alert("O nome deve ter tamanho mínimo de: 10 caracteres.");
        showMenErroNome(idMensagem);
        return false;
    }
    
    var regra =/[A-z][ ][A-z]/;
    
    if (!regra.test(campo)) {
        alert("Nome inválido!\nNão deve conter: número.\nDeve ter tamanho mínimo de: 10 caracteres.");
        showMenErroNome(idMensagem);
        return false;
    }
    hideMenErroNome(idMensagem);
    return true;   
}

function hideMenErroNome(idMensagem){
    if((idMensagem == '') || (idMensagem == null)) {
        return;
    }
    document.getElementById(idMensagem).style.display = "none";
}

function showMenErroNome(idMensagem){
    if((idMensagem == '') || (idMensagem == null)) {
        return;
    }
    document.getElementById(idMensagem).style.display = "inline";
}