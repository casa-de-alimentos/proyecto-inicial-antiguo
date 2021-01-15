var ctx0 = document.getElementById('registred').getContext('2d');

let dataRe = JSON.parse(document.getElementById('valuesRegisterPerson').value);
let benCount = dataRe[0];
let empCount = dataRe[1];

//Data Personas
var data0 = {
	datasets: [
		{
			data: [benCount, empCount],
			backgroundColor: ['#36a2eb', '#4bc0c0'],
		},
	],

	// These labels appear in the legend and in the tooltips when hovering different arcs
	labels: ['Beneficiarios', 'Empleados'],
};
var chart0 = new Chart(ctx0, {
	// The type of chart we want to create
	type: 'doughnut',

	// The data for our dataset
	data: data0,

	// Configuration options go here
	options: {},
});

var ctx2 = document.getElementById('consumoMen').getContext('2d');
var dataConsume = document.getElementById('valuesConsume').value;
dataConsume = JSON.parse(dataConsume);

var colorList = ['#ff9f40', '#4bc0c0', '#ff6384'];

var dataSets = [];
if (dataConsume[0].length >= 1) {
	for (var i = 0; i < dataConsume[1].length; i++) {
		dataSets[i] = {
			data: dataConsume[2][i],
			label: dataConsume[1][i],
			borderColor: colorList[i],
			fill: false,
		};
	}
}

//Data Personas
var data2 = {
	labels: dataConsume[0],
	datasets: dataSets,
};
var chart2 = new Chart(ctx2, {
	// The type of chart we want to create
	type: 'line',

	// The data for our dataset
	data: data2,

	// Configuration options go here
	options: {},
});

var ctx3 = document.getElementById('entregasMen').getContext('2d');
var dataEntry = document.getElementById('valuesEntry').value;
var dataEntry = JSON.parse(dataEntry);

var dataSets2 = [];

if (dataEntry[0].length >= 1) {
	for (var i = 0; i < dataConsume[1].length; i++) {
		dataSets2[i] = {
			data: dataEntry[2][i],
			label: dataEntry[1][i],
			borderColor: colorList[i],
			fill: false,
		};
	}
}

//Data Personas
var data3 = {
	labels: dataEntry[0],
	datasets: dataSets2,
};
var chart3 = new Chart(ctx3, {
	// The type of chart we want to create
	type: 'line',

	// The data for our dataset
	data: data3,

	// Configuration options go here
	options: {},
});

var ctx4 = document.getElementById('assBen').getContext('2d');
var valuesAB = JSON.parse(document.getElementById('valuesAssBen').value);

let labelsAB = [];
let dataAB = [];
let ab = 0;
for (let object of valuesAB) {
	labelsAB[ab] = `${object.mes} ${object.year}`;
	dataAB[ab] = object.users;
	ab++;
}

//Data Personas
var data4 = {
	labels: labelsAB,
	datasets: [
		{
			data: dataAB,
			label: 'Asistencias',
			borderColor: '#36a2eb',
			fill: false,
		},
	],
};
var chart4 = new Chart(ctx4, {
	// The type of chart we want to create
	type: 'line',

	// The data for our dataset
	data: data4,

	// Configuration options go here
	options: {},
});

var ctx5 = document.getElementById('assEmp').getContext('2d');
var valuesAE = JSON.parse(document.getElementById('valuesAssEmp').value);

let labelsAE = [];
let dataAE = [];
let ae = 0;
for (let object of valuesAE) {
	labelsAE[ae] = `${object.mes} ${object.year}`;
	dataAE[ae] = object.users;
	ab++;
}

//Data Personas
var data5 = {
	labels: labelsAE,
	datasets: [
		{
			data: dataAE,
			label: 'Asistencias',
			borderColor: '#36a2eb',
			fill: false,
		},
	],
};
var chart5 = new Chart(ctx5, {
	// The type of chart we want to create
	type: 'line',

	// The data for our dataset
	data: data5,

	// Configuration options go here
	options: {},
});