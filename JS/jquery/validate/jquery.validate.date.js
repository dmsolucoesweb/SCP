/* Data: 25/10/2012.
 * Desevolvedor: Flayson Potenciano.
 * E-mail: flayson.potenciano@gmail.com.
 * Descrição: valida data.
 *
 */

$(document).ready(function(){
    $("#myform").validate({
        rules: {
            myfield: {
                required: true,
                date: true
            }
        }
    });
});
