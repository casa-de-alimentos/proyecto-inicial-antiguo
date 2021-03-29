<?php 
	require 'php/DB.php';
	require 'php/controllers/loginController.php';
	require 'php/controllers/BeneficiaryController.php';
	//Init session
	session_start();

	//Verify login
	if (!$_SESSION['auth']) {
		header('location: index.php');
	}

	//StatusBox
	if(isset($_SESSION['statusBox'])) {
		$dataStatus = array(
			'message' => $_SESSION['statusBox_message'],
			'status' => $_SESSION['statusBox'],
		);
		
		unset($_SESSION['statusBox']);
		unset($_SESSION['statusBox_message']);
	}

	//Form
	if (isset($action)) {
		$controller = new BeneficiaryController();
		
		$controller->create();
	}
?>
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
				<h5>Añadir beneficiario</h5>
			</div>
			
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<form class='formProducts' method="POST" action="#" autocomplete='off'>
							<div class='row' style='width: 100%'>
								<div class="input-field col s12 m6">
									<input id="cedula" 
										type="text" 
										name="cedula"
									/>
									<label for="cedula">Cédula</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="nombre" 
										type="text" 
										name="nombre"
									/>
									<label for="nombre">Nombres</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="apellido" 
										type="text" 
										name="apellido"
									/>
									<label for="apellido">Apellidos</label>
								</div>
								<div class="input-field col s12 m6">
									<select name='sexo'>
										<option value="" disabled selected >Seleccione un género</option>
										<option value="F">Femenino</option>
										<option value="M">Masculino</option>
									</select>
									<label>Género</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="fecha" type="text" name="fecha" class="datepicker">
									<label for="fecha">Fecha de nacimiento</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="peso" 
										type="number" 
										name="peso"
										step="0.01"
									/>
									<label for="peso">Peso actual</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="talla" 
										type="number" 
										name="talla"
										step="0.01"
									/>
									<label for="peso">Estatura actual (en metros)</label>
								</div>
								<div class="col s12">
									<div class="switch">
										<label class="tooltipped" data-position="bottom" data-tooltip="Al activar esta funcionalidad tendrá que registrar el peso y la estatura cada 90 días">
											<input type="checkbox" name="seguimiento">
											<span class="lever"></span>
											Activar seguimiento de nutrición
										</label>
									</div>
								</div>
								<div class='col s12 center-align'>
									<button 
										class="btn waves-effect red lighten-1" type="submit" name="action"
									>
										Añadir
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			
		</div>
		
		<input type='hidden' id='js_statusBox' value='<?php echo json_encode($dataStatus) ?>' />
	</main>
	
	<script src="js/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/statusBox.js"></script>
</body>
</html>