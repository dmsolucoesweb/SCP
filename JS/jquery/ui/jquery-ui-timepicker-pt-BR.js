/* Data: 22/10/2012.
 * Desevolvedor: Flayson Potenciano.
 * E-mail: flayson.potenciano@gmail.com.
 * Descrição: Tradução jquery;
 * Obs.: esta função não é obrigatória para os demais scripts!
 *
 */

(function ($) {
	$.timepicker.regional['pt-BR'] = {
		timeOnlyTitle: 'Escolha a horario',
		timeText: 'Horario',
		hourText: 'Hora',
		minuteText: 'Minutos',
		secondText: 'Segundos',
		millisecText: 'Milissegundos',
		timezoneText: 'Fuso horario',
		currentText: 'Agora',
		closeText: 'Fechar',
		timeFormat: 'hh:mm',
		amNames: ['a.m.', 'AM', 'A'],
		pmNames: ['p.m.', 'PM', 'P'],
		ampm: false,
		isRTL: false
	};
	$.timepicker.setDefaults($.timepicker.regional['pt-BR']);
})(jQuery);
