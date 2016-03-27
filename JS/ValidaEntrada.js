        function validaEntrada(form){
            with (form){
                if(senha1.value != senha2.value){
                    alert("A senha de confirmação não confere.");
                    senha1.focus();
                    return false;
                }
/*                if(nome.value == ""){
                    alert("É necessário informar o nome.");
                    nome.focus();
                    return false;
                }
                if(email.value == ""){
                    alert("É necessário informar o endereço eletrônico.");
                    nome.focus();
                    return false;
                }*/
            }
        }