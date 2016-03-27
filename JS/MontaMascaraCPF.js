/*permite somente valores numericos*/
function valCPF (e, campo){
    var tecla=(window.event)?event.keyCode:e.which;
    
    if ((tecla > 47 && tecla < 58 )) {
        mascara (campo, '###.###.###-##');
        return true;
    } else {
        if ( tecla != 8 && tecla != 9 && tecla != 10 && tecla != 13 && tecla != 127 ) {
            return false;
        } else {
            return true;
        }
    }
}
 
/*cria a mascara*/
function mascara (src, mask){
    var i = src.value.length;
    var saida = mask.substring(1,2);
    var texto = mask.substring(i);

    if (texto.substring(0,1) != saida) {
        src.value += texto.substring(0,1);
    }
}
