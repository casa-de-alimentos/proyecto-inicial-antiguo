var ctx = document.getElementById('suministrosAc').getContext('2d');

var empCount = document.getElementById('valuesRegisterPerson').value;
var benCount = document.getElementById('valuesRegisterPerson2').value;

//Data Personas
var data = {
    datasets: [{
        data: [benCount, empCount],
        backgroundColor: [
            '#36a2eb',
            '#4bc0c0',
        ],
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'Misioneros',
        'Empleados',
    ]
}
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: data,

    // Configuration options go here
    options: {}
});


var ctx2 = document.getElementById('consumoMen').getContext('2d');
var dataConsume = document.getElementById('valuesConsume').value;
var dataConsume = JSON.parse(dataConsume);

var colorList = ['#ff9f40','#4bc0c0','#ff6384']

var dataSets = []
if (dataConsume[0].length >= 1) {
    for (var i = 0; i < dataConsume[1].length; i++) {
        dataSets[i] = {
            data: dataConsume[2][i],
            label: dataConsume[1][i],
            borderColor: colorList[i],
            fill: false
        }
    }
}

//Data Personas
var data2 = {
    labels: dataConsume[0],
    datasets: dataSets
}
var chart2 = new Chart(ctx2, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: data2,

    // Configuration options go here
    options: {}
});



var ctx3 = document.getElementById('entregasMen').getContext('2d');
var dataEntry = document.getElementById('valuesEntry').value;
var dataEntry = JSON.parse(dataEntry);

var dataSets2 = []

if (dataEntry[0].length >= 1) {
    for (var i = 0; i < dataConsume[1].length; i++) {
        dataSets2[i] = {
            data: dataEntry[2][i],
            label: dataEntry[1][i],
            borderColor: colorList[i],
            fill: false
        }
    }
}

//Data Personas
var data3 = {
    labels: dataEntry[0],
    datasets: dataSets2
}
var chart3 = new Chart(ctx3, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: data3,

    // Configuration options go here
    options: {}
});




var ctx4 = document.getElementById('asistenciasMen').getContext('2d');

//Data Personas
var data4 = {
    labels: ['Enero', 'Febrero', 'Marzo'],
    datasets: [{
        data: [30, 10, 10],
        label: 'Personas',
        borderColor: '#36a2eb',
        fill: false
    },
    {
        data: [100, 130, 240],
        label: 'Misioneros',
        borderColor: '#4bc0c0',
        fill: false
    }]
}
var chart4 = new Chart(ctx4, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: data4,

    // Configuration options go here
    options: {}
});