//Abrir drawer
var drawerOpen = document.getElementById('openDrawer');

drawerOpen.addEventListener('click', function(e) {
  var drawerBox = document.getElementById('drawer');

  $(drawerBox).animate({left: "0px"});
});

//Cerrar drawer
var drawerClose = document.getElementById('closeDrawer');

drawerClose.addEventListener('click', function(e) {
  var drawerBox = document.getElementById('drawer');

  $(drawerBox).animate({left: "-300px"});
});