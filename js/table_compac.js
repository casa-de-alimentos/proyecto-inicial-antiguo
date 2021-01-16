$.extend( true, $.fn.dataTable.defaults, {
	"searching": false,
	"ordering": false
});
$(document).ready(function() {
	$('#table_compact').DataTable({
		"pagingType": "full_numbers",
		"language": {
			"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
		},
	});
});