<?
include 'php/class/Products.php';
include 'php/class/Almacen.php';
include 'php/class/Empleados.php';
include 'php/class/Beneficiario.php';
include 'php/class/Asistencias.php';


//Init session
session_start();

$empCount = Empleados::EmpCount();
$benCount = Beneficiario::BenCount();
$consumoMen = Almacen::getConsumoMensual();
$entregaMen = Almacen::getConsumoMensual(true);

//Verify login
if (!$_SESSION['auth']) {
	header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Panel</title>
  <link rel="stylesheet" href="css/main.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
</head>
<body>
  <? require 'Header.php'; ?>
  
  <main class="panelMain">
    <div class="box">
      <span class="boxTitle">
        Personas registradas
      </span>
      <div class="boxContent">
        <canvas id="suministrosAc" height="250"></canvas>
      </div>
    </div>
    <div class="box">
      <span class="boxTitle">
        Consumo mensual
      </span>
      <div class="boxContent">
        <canvas id="consumoMen" height="250"></canvas>
      </div>
    </div>
    <div class="box">
      <span class="boxTitle">
        Entregas mensuales
      </span>
      <div class="boxContent">
        <canvas id="entregasMen" height="250"></canvas>
      </div>
    </div>
    <div class="box">
      <span class="boxTitle">
        Asistencias mensuales
      </span>
      <div class="boxContent">
        <canvas id="asistenciasMen" height="250"></canvas>
      </div>
    </div>

    <!-- Data Chars -->
    <input type="hidden" id="valuesRegisterPerson" value='<? echo $empCount ?>' />
    <input type="hidden" id="valuesRegisterPerson2" value='<? echo $benCount ?>' />
    <input type="hidden" id="valuesConsume" value='<? echo $consumoMen ?>' />
    <input type="hidden" id="valuesEntry" value='<? echo $entregaMen ?>' />
  </main>

  <? require 'Drawer.php'; ?>
  
	<div id="oscuroB">
		
	</div>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <script src="js/charts.js"></script>
</body>
</html>