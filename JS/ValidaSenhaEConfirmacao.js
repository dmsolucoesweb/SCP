function validaSenha(inpt1, inpt2, mem){
    var senha1 = document.getElementById(inpt1);
 
    var senha2 = document.getElementById(inpt2);

    if (senha1.value != senha2.value) {
        showMenErroSenha(mem);
        alert("Opss... Senhas não são iguais.");
    } else {
        hideMenErroSenha(mem);
    }
}

function hideMenErroSenha(mem){
    document.getElementById(mem).style.display = "none";
}

function showMenErroSenha(mem){
    document.getElementById(mem).style.display = "inline";
}