var ctx = document.getElementById('seguiCanvas').getContext('2d');
var data = document.getElementById('seguimientoIMC').value;
data = JSON.parse(data);

let dataIMC = [];
let dataPeso = [];
let dataEstatura = [];
let dataFecha = [];
for (let i = 0; i < data[0].length; i++) {
	dataFecha[data[0].length - 1 - i] = data[0][i][0];
	dataPeso[data[1].length - 1 - i] = data[1][i][0];
	dataEstatura[data[1].length - 1 - i] = data[1][i][1];
	dataIMC[data[1].length - 1 - i] = data[1][i][0] / (data[1][i][1] ^ 2);
	console.log('hola');
}

var dataSets = [
	{
		data: dataPeso,
		label: 'Peso',
		borderColor: '#337AFF',
		fill: false,
		borderWidth: 5,
	},
	{
		data: dataIMC,
		label: 'IMC',
		borderColor: '#ff9f40',
		fill: false,
		borderWidth: 5,
	},
	{
		data: dataEstatura,
		label: 'Estatura',
		borderColor: '#0AAD14',
		fill: false,
		borderWidth: 5,
	},
];

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