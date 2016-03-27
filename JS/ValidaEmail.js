/* Data: 01/11/2012.
 * Desevolvedor: Flayson Potenciano.
 * E-mail: flayson.potenciano@gmail.com.
 * Descrição: Valida CPF.
 * Obs.: A validação é feita através da variável regra.
 */


//
////esta está certa, mas tem que receber o formulário com o this como parâmetro
//function validaEmail(form) {
//    with (form) {
//        var obj = eval("form.email");
//        var txt = obj.value;
//        if ((txt.length != 0) && ((txt.indexOf("@") < 1) || (txt.indexOf('.') < 1))) {
//            alert('Informe um e-mail válido.');
//            obj.focus();
//        }
//    }
//}
function validaEmail(url, mem) {
    //var url = document.getElementById(inpt).value;
    //var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    //var regra = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
    var regra = /^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/;
    if (!regra.test(url)) {
        alert("E-mail incorreto!\nInforme no formato: nome@provedor.com");
        showMenErroEmail(mem);
        return false;
    }
    hideMenErroEmail(mem);
    return true;
}

function hideMenErroEmail(mem){
    if((mem == '') || (mem == null)) {
        return;
    }
    document.getElementById(mem).style.display = "none";
}

function showMenErroEmail(mem){
    if((mem == '') || (mem == null)) {
        return;
    }
    document.getElementById(mem).style.display = "inline";
}
//testes
/*function validaEmail(form) {
    alert('form.value: ' + form.value);
    alert('tipo: ' + form.valueOf());
    var txt = form.value;
    alert('tipo txt: ' + txt.valueOf());
    var txt2 = txt.valueOf();
    alert('tipo txt2: ' + txt2.valueOf());
    
//   form.focus();     
    //with (form) {
      //  var obj = eval("form.email");
        //var txt = obj.value;
/*        if ((form.length != 0) && ((form.indexOf("@") < 1) || (form.indexOf('.') < 1))) {
            alert('Informe um e-mail válido.');
            form.focus();
        }
  */  //}
//}
