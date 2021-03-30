<?php
	require 'php/DB.php';
	require 'php/controllers/loginController.php';
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

	//Form
	if (isset($action)) {
		$controller = new AssistanceBenController();
		$controller2 = new AssistanceEmpController();
		
		$dataSearch = $controller->search();
		
		if ($dataSearch === null) {
			$dataSearch = $controller2->search();
		}
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

	if (isset($delete)) {
		$controller = new AssistanceBenController();
		$controller2 = new AssistanceEmpController();
		
		if ($people === 'ben') {
			$controller->delete($delete, $delete_user);
		}else if ($people === 'emp') {
			$controller2->delete($delete, $delete_user);
		}
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
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	<?php require('php/componets/HeaderAuth.php') ?>
	
	<main class='container'>
		<div class="row">
			<div class='col s12'>
				<h5>Buscar asistencia</h5>
			</div>
			
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<form class='formProducts' method="POST" action="#" autocomplete='off'>
							<div class='row' style='width: 100%'>
								<div class="input-field col s12">
									<i class="prefix material-icons">search</i>
									<input id="search" 
										type="text" 
										name="search"
									/>
									<label for="search">Buscar cédula de empleado/beneficiario</label>
								</div>
								<div class='col s12 center-align'>
									<button 
										class="btn waves-effect red lighten-1" type="submit" name="action"
									>
										Buscar
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<span class="card-title">Datos de la persona</span>
						<?php if (!empty($dataSearch)): ?>
						<div style='overflow: auto'>
							<table class="striped centered">
								<thead>
									<tr>
										<?php if (isset($dataSearch[0]['peso'])): ?>
										<th>Cédula</th>
										<th>Nombres</th>
										<th>Apellidos</th>
										<th>Sexo</th>
										<th>Nacimiento</th>
										<th>Peso</th>
										<th>Estatura</th>
										<th>Registrado por</th>
										<th>Seguimiento de nutrición</th>	
										<?php elseif (isset($dataSearch[0]['telefono'])): ?>
										<th>Cédula</th>
										<th>Nombres</th>
										<th>Apellidos</th>
										<th>Sexo</th>
										<th>Nacimiento</th>
										<th>teléfono</th>
										<th>Registrado por</th>
										<?php endif ?>
									</tr>
								</thead>
								<tbody>
									<?php if (isset($dataSearch[0]['seguimiento'])): ?>
									<tr>
										<td><?php echo $dataSearch[0]['cedula'] ?></td>
										<td><?php echo $dataSearch[0]['nombre'] ?></td>
										<td><?php echo $dataSearch[0]['apellido'] ?></td>
										<td><?php
											if ($dataSearch[0]['sexo']==='M') {
												echo 'Masculino';
											}else {
												echo 'Femenino';
											}
										?></td>
										<td><?php echo $dataSearch[0]['nacimiento'] ?></td>
										<td><?php echo $dataSearch[0]['peso'].'Kg';?></td>
										<td><?php echo $dataSearch[0]['talla'].'m';?></td>
										<td><?php 
											if ($dataSearch[0]['name']) {
												echo $dataSearch[0]['name'];
											}else {
												echo 'Cuenta eliminada';
											}
										?></td>
										<td><?php
											if ($dataSearch[0]['seguimiento']) {
												echo 'activo';
											}else {
												echo 'desactivado';
											}
										?></td>
									</tr>
									<?php elseif (isset($dataSearch[0]['telefono'])): ?>
									<tr>
										<td><?php echo $dataSearch[0]['cedula'] ?></td>
										<td><?php echo $dataSearch[0]['nombre'] ?></td>
										<td><?php echo $dataSearch[0]['apellido'] ?></td>
										<td><?php
											if ($dataSearch[0]['sexo']==='M') {
												echo 'Masculino';
											}else {
												echo 'Femenino';
											}
										?></td>
										<td><?php echo $dataSearch[0]['nacimiento'] ?></td>
										<td><?php 
											if (!empty($dataSearch[0]['telefono'])) {
												echo $dataSearch[0]['telefono'];
											}else {
												echo 'No registrado';
											}
										?></td>
										<td><?php echo $dataSearch[0]['name'] ?></td>
									</tr>
									<?php endif ?>
								</tbody>
							</table>
						</div>
						<?php endif ?>
						<br/>
						<?php if (!empty($dataSearch)): ?>
						<span class="card-title">Otros datos</span>
						<?php endif ?>
					</div>
					<?php if (!empty($dataSearch)): ?>
					<div class="card-tabs">
						<ul class="tabs tabs-fixed-width">
							<li class="tab"><a class="active" href="#personales">Personales</a></li>
							<li class="tab"><a href="#estudios">Estudios</a></li>
							<li class="tab"><a href="#CNE">CNE</a></li>
							<li class="tab"><a href="#bonos">Bonos</a></li>
						</ul>
					</div>
					<div class="card-content grey lighten-4">
						<div id="personales" class='row'>
							<span class='col s12 m6 l4 textSpacing'><strong>Edad:</strong> <?php 
							$cumpleanos = new DateTime($dataSearch[0]['nacimiento']);
							$hoy = new DateTime();
							$edad = $hoy->diff($cumpleanos);
							echo $edad->y;
							?> años</span>
							<span class='col s12 m6 l4 textSpacing'><strong>Nacionalidad:</strong> <?php echo $dataSearch[0]['nacionalidad']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Serial de patria:</strong> <?php echo $dataSearch[0]['serial_patria']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Código de patria:</strong> <?php echo $dataSearch[0]['codigo_patria']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Dirección:</strong> <?php echo $dataSearch[0]['direccion']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Comunidad:</strong> <?php echo $dataSearch[0]['comunidad']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Parroquia:</strong> <?php echo $dataSearch[0]['parroquia']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Cantidad de hijos:</strong> <?php echo $dataSearch[0]['cantidad_de_hijos']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Teléfono local:</strong> <?php echo isset($dataSearch[0]['telef_local']) ? $dataSearch[0]['telef_local'] : 'No tiene'; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Teléfono celular:</strong> <?php echo $dataSearch[0]['telef_celular']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Posee alguna enfermedad?:</strong> <?php echo isset($dataSearch[0]['enfermedad']) ? $dataSearch[0]['enfermedad'] : 'No'; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Posee alguna discapacidad?:</strong> <?php echo isset($dataSearch[0]['discapacidad']) ? $dataSearch[0]['discapacidad'] : 'No'; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Está embarazada?:</strong> <?php echo isset($dataSearch[0]['embarazada']) ? $dataSearch[0]['embarazada'] : 'No'; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Fecha de embarazo:</strong> <?php echo isset($dataSearch[0]['fecha_embarazo']) ? $dataSearch[0]['fecha_embarazo'] : 'No registrada'; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Fecha de parto:</strong> <?php echo isset($dataSearch[0]['fecha_parto']) ? $dataSearch[0]['fecha_parto'] : 'No registrada'; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Está pencionado?:</strong> <?php echo $dataSearch[0]['pencionado']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Por donde cobra?:</strong> <?php echo isset($dataSearch[0]['pencionado_por']) ? $dataSearch[0]['pencionado_por'] : 'No registrado'; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Pertenece a una organización social o política?:</strong> <?php echo isset($dataSearch[0]['orga_social_politica']) ? $dataSearch[0]['orga_social_politica'] : 'No'; ?></span>
						</div>
						<div id="estudios" class='row'>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Es estudiante?:</strong> <?php echo $dataSearch[0]['estudiante']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Grado de instrucción:</strong> <?php echo isset($dataSearch[0]['grado_instruccion']) ? $dataSearch[0]['grado_instruccion'] : 'No registrado'; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Desea estudiar?:</strong> <?php echo $dataSearch[0]['desea_estudiar']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Qué desea estudiar?:</strong> <?php echo isset($dataSearch[0]['que_desea_estudiar']) ? $dataSearch[0]['que_desea_estudiar'] : 'No registrado'; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Habilidad que posee:</strong> <?php echo isset($dataSearch[0]['habilidad_posee']) ? $dataSearch[0]['habilidad_posee'] : 'No registrado'; ?></span>
						</div>
						<div id="CNE" class='row'>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Inscrito en CNE?:</strong> <?php echo $dataSearch[0]['inscrito_CNE']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Ejerce el voto?:</strong> <?php echo $dataSearch[0]['ejerce_voto']; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>Centro electoral:</strong> <?php echo isset($dataSearch[0]['centro_electoral']) ? $dataSearch[0]['centro_electoral'] : 'No registrado'; ?></span>
						</div>
						<div id="bonos" class='row'>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Recibe bonos eventuales?:</strong> <?php echo $dataSearch[0]['bono_eventuales'] ? 'Si' : 'No' ; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Recibe bono de Lactancia Materna?:</strong> <?php echo $dataSearch[0]['bono_lactancia'] ? 'Si' : 'No' ; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Recibe bono Parto Humanizado?:</strong> <?php echo $dataSearch[0]['bono_parto'] ? 'Si' : 'No' ; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Recibe bono José Gregoreo?:</strong> <?php echo $dataSearch[0]['bono_jose_gregoreo'] ? 'Si' : 'No' ; ?></span>
							<span class='col s12 m6 l4 textSpacing'><strong>¿Recibe bono Hogares de la Patria?:</strong> <?php echo $dataSearch[0]['bono_hogares'] ? 'Si' : 'No' ; ?></span>
						</div>
					</div>
					<?php endif ?>
				</div>
			</div>
			
			<?php if (isset($dataSearch[2]) && $dataSearch[0]['seguimiento']): ?>
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<span class="card-title">Seguimiento de nutrición</span>
						<canvas id="seguiCanvas" height="250"></canvas>
						<input type='hidden' id='seguimientoIMC' value='<?php echo json_encode(array($dataSearch[1], $dataSearch[2])) ?>' />
						<div>Nutición inicial: <?php 
							$IMC = $dataSearch[0]['peso'] / ($dataSearch[0]['talla']**2);
							echo round($IMC, 2);
							?> IMC</div>
						<div>Peso inicial: <?php echo $dataSearch[0]['peso'] ?>Kg</div>
						<div>Estatura inicial: <?php echo $dataSearch[0]['talla'] ?>m</div>
						<span class="card-title">Última revisión</span>
						<div>
							<?php 
							$pesoActual = $dataSearch[2][0][0];
							$IMCActual = $dataSearch[2][0][1];
							$tallaActual = $dataSearch[2][0][2];
							$controllerBen = new BeneficiaryController();
							$statusIMC = $controllerBen->clasificationIMC($IMCActual);
							?>
							Nutrición actual: <?php echo $IMCActual ?>
						</div>
						<div>
							Clasificación: 
							<span class='<?php echo $statusIMC['color'] ?>'><?php echo $statusIMC['type'] ?> (<?php echo $statusIMC['warning'] ?>)</span>
						</div>
					</div>
				</div>
			</div>
			<?php endif ?>
			
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<span class="card-title">Asistencia</span>
						<?php if (isset($dataSearch[1])): ?>
						<table class='centered' id='table_compac'>
							<thead>
								<tr>
									<th>Día</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$data=[];
								if (isset($dataSearch[0])) {
									$controller = new AssistanceBenController();
									$data = $controller->getAssis($dataSearch[0]['people_id']);
								}
								?>
								<?php foreach($data as $assis): ?>
								<tr>
									<td>
										<?php echo $assis['date'] ?>
										<?php
										echo $assis['peso'] ? '(seguimiento)' : ''
										?>
									</td>
									<td><a href="buscar_asistencia.php?delete=<?php echo $assis[2] ?>&people=<?php echo isset($dataSearch[0]['seguimiento']) ? 'ben' : 'emp' ?>&delete_user=<?php echo $dataSearch[0]['cedula'] ?>" class="waves-effect red darken-1 btn-small">Borrar</a></td>
								</tr>
								<?php endforeach ?>
							</tbody>
						</table>
						<?php endif ?>
					</div>
				</div>
			</div>
			
		</div>
		
		<input type='hidden' id='js_statusBox' value='<?php echo json_encode($dataStatus) ?>' />
	</main>
	
	<script src="js/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/statusBox.js"></script>
	<script src="js/seguimiento.js"></script>
	<script>
		$.extend( true, $.fn.dataTable.defaults, {
			"searching": false,
			"ordering": false
		});
		$(document).ready(function() {
			$('#table_compac').DataTable({
				"pagingType": "full_numbers",
				"language": {
					"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
				},
				
			});
		});
	</script>
</body>
</html>