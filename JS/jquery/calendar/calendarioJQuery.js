/* Data: 22/10/2012.
 * Desevolvedor: Flayson Potenciano.
 * E-mail: flayson.potenciano@gmail.com.
 * Descrição: Calendário com horas e minutos.
 * Obs.: esta função executa os demais scripts!
 *
 */
            
$(function(){
    $('.timeDatePicker').datetimepicker({ // onde tiver a class calendario em CSS
        //timeFormat: 'hh:mm',          // formato das horas e minutos
        addSliderAccess: true,        // abilita a barra de rolagem
        sliderAccessArgs: {
            touchonly: true // somente a barra? se falso, aparecera + e -.
        } 
    });
    $( ".datePicker" ).datepicker();
});
