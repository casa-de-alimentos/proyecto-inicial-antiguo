//Iniciar selects
$(document).ready(function(){
    $('select').formSelect();
});

//Iniciar datePicker
 document.addEventListener('DOMContentLoaded', function() {
	var elems = document.querySelectorAll('.datepicker');
	var instances = M.Datepicker.init(elems, 
		{
			format: 'dd-mm-yyyy',
			i18n: {
				cancel: 'Cancelar',
				months: [
					'Enero',
					'Febrero',
					'Marzo',
					'Abril',
					'Mayo',
					'Junio',
					'Julio',
					'Agosto',
					'Septiembre',
					'Octubre',
					'Noviembre',
					'Diciembre'
				],
				monthsShort: [
					'Ene',
					'Feb',
					'Mar',
					'Abr',
					'May',
					'Jun',
					'Jul',
					'Ago',
					'Sep',
					'Oct',
					'Nov',
					'Dic'
				],
				weekdays: [
					'Lunes',
					'Martes',
					'Miércoles',
					'Jueves',
					'Viernes',
					'Sábado',
					'Domingo'
				],
				weekdaysShort: [
					'Lun',
					'Mar',
					'Mier',
					'Jue',
					'Vie',
					'Sab',
					'Dom'
				],
				weekdaysAbbrev: [
					'L',
					'M',
					'Mi',
					'J',
					'V',
					'S',
					'D'
				]
			}
		}
	);
});

//Drawer
document.addEventListener('DOMContentLoaded', function() {
	var elems = document.querySelectorAll('.sidenav');
	var instances = M.Sidenav.init(elems, {});
});

//Collapsible
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems, {});
  });
