<?php 
	require 'php/DB.php';
	require 'php/controllers/storageController.php';
	require 'php/controllers/BeneficiaryController.php';
	require 'php/controllers/EmployeeController.php';
	require 'php/controllers/AssistanceBenController.php';
	require 'php/controllers/AssistanceEmpController.php';

	//Init session
	session_start();

	//Verify login
	if (!$_SESSION['auth']) {
		header('location: index.php');
	}
	
	$count_ben = BeneficiaryController::counts();
	$count_emp = EmployeeController::counts();
	$consumoMen = StorageController::consumo();
	$entregaMen = StorageController::consumo(true);
	$assBen = AssistanceBenController::counts();
	$assEmp = AssistanceEmpController::counts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Panel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	<?php require('php/componets/HeaderAuth.php') ?>
	
	<main class='container'>
		<div class="row">
			<div class='col s12'>
				<h5>Bienvenido <?php echo $_SESSION['name'] ?></h5>
			</div>
			
			<div class="col s12 m6">
				<div class="card">
					<div class="card-content">
						<span class="card-title">Personas registradas</span>
						<canvas id="registred" height="250"></canvas>
						<!-- Data Char -->
						<input type="hidden" id="valuesRegisterPerson" value='<?php echo json_encode(array($count_ben, $count_emp)) ?>' />
					</div>
				</div>
			</div>
			
			<div class="col s12 m6">
				<div class="card">
					<div class="card-content">
						<span class="card-title">Consumo mensual</span>
						<canvas id="consumoMen" height="250"></canvas>
						<!-- Data Char -->
						<input type="hidden" id="valuesConsume" value='<?php echo $consumoMen ?>' />
					</div>
				</div>
			</div>
			
			<div class="col s12 m6">
				<div class="card">
					<div class="card-content">
						<span class="card-title">Entregas mensuales</span>
						<canvas id="entregasMen" height="250"></canvas>
						<!-- Data Char -->
						<input type="hidden" id="valuesEntry" value='<?php echo $entregaMen ?>' />
					</div>
				</div>
			</div>
			
			<div class="col s12 m6">
				<div class="card">
					<div class="card-content">
						<span class="card-title">Asistencias mensuales (Beneficiarios)</span>
						<canvas id="assBen" height="250"></canvas>
						<!-- Data Char -->
						<input type="hidden" id="valuesAssBen" value='<?php echo $assBen ?>' />
					</div>
				</div>
			</div>
			
			<div class="col s12 m6">
				<div class="card">
					<div class="card-content">
						<span class="card-title">Asistencias mensuales (Empleados)</span>
						<canvas id="assEmp" height="250"></canvas>
						<!-- Data Char -->
						<input type="hidden" id="valuesAssEmp" value='<?php echo $assEmp ?>' />
					</div>
				</div>
			</div>
			
		</div>
	</main>
	
	<script src="js/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/charts.js"></script>
</body>
</html>