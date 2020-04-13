//Iniciar selects
$(document).ready(function(){
    $('select').formSelect();
});

//Iniciar datePicker
 document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems, {i18n: 
			{
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
		});
  });


//Abrir drawer
var drawerOpen = document.getElementById('openDrawer');
var oscuroB = document.getElementById('oscuroB');

drawerOpen.addEventListener('click', function(e) {
  var drawerBox = document.getElementById('drawer');

  $(drawerBox).animate({left: "0px"});
	$(oscuroB).css({display: 'block'});
});

//Cerrar drawer
var drawerClose = document.getElementById('closeDrawer');

drawerClose.addEventListener('click', function(e) {
  var drawerBox = document.getElementById('drawer');

  $(drawerBox).animate({left: "-300px"});
	$(oscuroB).css({display: 'none'});
});

oscuroB.addEventListener('click', function(e) {
  var drawerBox = document.getElementById('drawer');

  $(drawerBox).animate({left: "-300px"});
	$(oscuroB).css({display: 'none'});
});

//Open Submenu
var openSub = document.querySelectorAll(".openSubmenu");

openSub.forEach(function(item) {
  item.addEventListener('click', function(){
		var open = $(item).data('open');
		
		$('#'+open).slideToggle();
	})
});