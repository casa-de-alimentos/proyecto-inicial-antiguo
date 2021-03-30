//Iniciar selects
$(document).ready(function(){
    $('select').formSelect();
});

// Iniciar Tooltips
document.addEventListener('DOMContentLoaded', function() {
	var elems = document.querySelectorAll('.tooltipped');
	var instances = M.Tooltip.init(elems, {});
});

// Init TABS
document.addEventListener('DOMContentLoaded', function() {
	let elem = document.querySelector('.tabs');
	let instance = M.Tabs.init(elem, {});
});

//Iniciar datePicker
 document.addEventListener('DOMContentLoaded', function() {
	var elems = document.querySelectorAll('.datepicker');
	var instances = M.Datepicker.init(elems, 
		{
			format: 'dd-mm-yyyy',
			yearRange: 80,
			maxDate: new Date(),
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
