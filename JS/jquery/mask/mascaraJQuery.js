/* Data: 22/10/2012.
 * Desevolvedor: Flayson Potenciano.
 * E-mail: flayson.potenciano@gmail.com.
 * Descrição: Mascaras para controle em textboxs
 * Obs.: O uso é importante.
 *
 */

(function($) {
    $(function() {
        $('.mascaraDateTimePicker').mask('99/99/9999 99:99'); //data dateTimePicker
        $('.mascaraData').mask('99/99/9999'); //data dateTimePicker
        $('.mascaraHora').mask('99:99'); //horas
        $('.mascaraFone').mask('(99) 9999-9999'); //telefone
        $('.mascaraRG').mask('99.999.999-9'); //RG
        $('.mascaraCPF').mask('999.999.999-99'); //CPF
        $('.mascaraCodigoArea').mask('9.99.99.99-9'); //Código de Grandes Áreas/Áreas/Sub-Áreas
        $('.mascaraAno').mask('9999'); //máscara para ano. ex: 2013
        $('.mascaraCEP').mask('99999-999');
        $('.mascaraMatricula').mask('99999999999999');
        $('.mascaraPeriodo').mask('99');//máscara para períodos de discentes. Apenas números.
        $('.mascaraNotaAvaliacao').mask('99,99');//máscara para a nota de avaliação de projetos. No programa aprovareprovaprojetos.php
        $('.mascaraIsbn').mask('999-99-9999-999-9');//máscara para a nota de avaliação de projetos. No programa aprovareprovaprojetos.php
    });
})(jQuery);