/*permite somente valores numericos*/

/*consistencia se o valor do CPF e um valor valido
seguindo os criterios da Receita Federal do territorio nacional*/

/* Data: 01/11/2012.
 * Desevolvedor: Flayson Potenciano.
 * E-mail: flayson.potenciano@gmail.com.
 * Descrição: Valida CPF.
 * Obs.: Fiz modificações na validação do CPF, para possibilitar uso 
 * dinâmico nos formulários. 
 */
function consistenciaCPF(inpt, mem) {

    cpf = inpt.replace(/\./g, '').replace(/\-/g, '');
    erro = new String;
    
    if (cpf.length < 11) {
        erro += "Sao necessarios 11 digitos para verificacao do CPF! \n\n";
        showMenErroCPF(mem);
        alert(erro);
    } else {
        var nonNumbers = /\D/;      
            
        if (cpf == "00000000000" || cpf == "11111111111"
            || cpf == "22222222222" || cpf == "33333333333"
            || cpf == "44444444444" || cpf == "55555555555"
            || cpf == "66666666666" || cpf == "77777777777"
            || cpf == "88888888888" || cpf == "99999999999") {
            erro += "Número de CPF inválido!";
            showMenErroCPF(mem);
            alert(erro);
            return;
        } else {
            hideMenErroCPF(mem);
        }
            
        var a = [];
        var b = new Number;
        var c = 11;
            
        for (i=0; i<11; i++) {
            a[i] = cpf.charAt(i);
            if (i < 9) {
                b += (a[i] * --c);
            }
        }
            
        if ((x = b % 11) < 2) {
            a[9] = 0;
        } else { 
            a[9] = 11 - x;
        }
            
        b = 0;
        c = 11;
        for (y=0; y<10; y++) {
            b += (a[y] * c--);
        }
            
        if ((x = b % 11) < 2) {
            a[10] = 0; 
        } else {
            a[10] = 11 - x;
        }
        if ( (cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) ) {
            erro += "Digito verificador inválido!";
            showMenErroCPF(mem);
            alert(erro);
        } else {
            hideMenErroCPF(mem);
        }
    }
}
    
function hideMenErroCPF(mem){
    if((mem == '') || (mem == null)) {
        return;
    }
    document.getElementById(mem).style.display = "none";
}

function showMenErroCPF(mem){
    if((mem == '') || (mem == null)) {
        return;
    }
    document.getElementById(mem).style.display = "inline";
}