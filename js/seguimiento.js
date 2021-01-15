var ctx = document.getElementById('seguiCanvas').getContext('2d');
var data = document.getElementById('seguimientoPeso').value;
data = JSON.parse(data);

let dataPeso = [];
let dataFecha = [];
for (let i = 0; i < data[0].length; i++) {
	dataFecha[(data[0].length - 1) - i] = data[0][i]; 
	dataPeso[(data[1].length - 1) - i] = data[1][i];
}

var dataSets = [{
	data: dataPeso,
	label: 'Peso',
	borderColor: '#ff9f40',
	fill: false,
}];

//Data Personas
var datos = {
	labels: dataFecha,
	datasets: dataSets,
};
var chart = new Chart(ctx, {
	// The type of chart we want to create
	type: 'line',

	// The data for our dataset
	data: datos,

	// Configuration options go here
	options: {},
});
