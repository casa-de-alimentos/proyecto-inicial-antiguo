$(document).ready(function(){
    $('select').formSelect();
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

//Open Submenu
var openSub = document.querySelectorAll(".openSubmenu");

openSub.forEach(function(item) {
  item.addEventListener('click', function(){
		var open = $(item).data('open');
		
		$('#'+open).slideToggle();
	})
});