<?
include 'php/controlador.php';
include 'php/class/Beneficiario.php';
include 'php/class/Empleados.php';
include 'php/class/Asistencias.php';
//Init session
session_start();

$controller1 = new Beneficiario();
$controller2 = new Empleados();
$asistencias = new Asistencias();

extract($_REQUEST);

//StatusBox
if(isset($_SESSION['statusBox']) && !empty($_SESSION['statusBox'])) {
	$statusBox = $_SESSION['statusBox'];
	$message = $_SESSION['message'];
	$color = $_SESSION['color'];
}

//Verify login
if (!$_SESSION['auth']) {
	header('location: index.php');
}

//Search User
if (isset($search)) {
	$userFoundBen = $controller1->SearchBen();

	if (!$userFoundBen) {
		$userFoundEmp = $controller2->SearchEmp();
	}

	//StatusBox
	if(isset($_SESSION['statusBox']) && !empty($_SESSION['statusBox'])) {
		$statusBox = $_SESSION['statusBox'];
		$message = $_SESSION['message'];
		$color = $_SESSION['color'];
	}
}

if (isset($reg)){
	if ($regIn === 'ben') {
		$asistencias->RegisterAsisB();
	}else if ($regIn === 'emp') {
		$asistencias->RegisterAsisP();
	}
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
</head>
<body>
  
  <? require 'Header.php'; ?>

  <main class="panelMain">
		<span class="panelTitle">Registrar asistencia</span>
    <div class="boxWidthAll">
      <div class="boxContent">
        <form id="editProducForm" action="">
        	<? if (isset($statusBox)) { ?>
			    	<div class="col s12 statusBox">
							<div class="statusBox__message <? echo $color ?>">
								<span><? echo $message ?></span>
								 <i class="material-icons statusBox__close">close</i>
							</div>
						</div>
					<? 
					unset($_SESSION['statusBox']);
					unset($_SESSION['status']);
					unset($_SESSION['color']);
					} ?>
					<div class="input-field col s6">
						<i class="prefix material-icons">search</i>
						<input id="search" 
							type="text" 
							name="search"
						/>
						<label for="search">Buscar cédula</label>
					</div>
					<button 
						class="btn waves-effect red lighten-1" 
						type="submit"
					>
						Buscar
					</button>
				</form>
      </div>
    </div>
    <div class="boxWidthAll">
      <span class="boxTitle">
      	Datos de la persona
      </span>
      <div class="boxContent">
        <table class="striped centered">
					<thead>
						<tr>
							<?php if (isset($userFoundBen) && $userFoundBen): ?>
							<th>Cédula</th>
							<th>Nombres</th>
							<th>Apellidos</th>
							<th>Sexo</th>
							<th>Nacimiento</th>
							<th>Peso</th>
							<th>Registrado por</th>
							<th>Seguimiento de peso</th>	
							<?php elseif (isset($userFoundEmp) && $userFoundEmp): ?>
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
						<? 
						if (!empty($userFoundBen)) {
						?>
							<tr>
								<td><? echo $userFoundBen['ben_cedula'] ?></td>
								<td><? echo $userFoundBen['ben_nombres'] ?></td>
								<td><? echo $userFoundBen['ben_apellidos'] ?></td>
								<td><? 
									if ($userFoundBen['ben_sexo']==='M') {
										echo 'Masculino';
									}else {
										echo 'Femenino';
									}
								?></td>
								<td><? echo $userFoundBen['ben_nacimiento'] ?></td>
								<td><? 
									if (empty($userFoundBen['ben_peso'])) {
										echo 'No registrado';
									}else {
										echo $userFoundBen['ben_peso'].'Kg';
									}
								?></td>
								<td><? echo $userFoundBen['ben_created_by'] ?></td>
								<td><? 
									if ($userFoundBen['ben_seguimiento']) {
										echo 'activo';
									}else {
										echo 'desactivado';
									}
								?></td>
							</tr>
							<tr>
							<td colspan="8">
								<?php if ($userFoundBen['ben_seguimiento']): ?>
								<div class="input-field col s1">
									<i class="prefix">Kg</i>
									<input id="search" 
										type="number" 
										name="newPeso"
										step="0.1" 
									/>
									<label for="search">Nuevo peso</label>
								</div>
								<?php endif ?>
								<a 
									href="registrar_asistencia.php?reg=<? echo $userFoundBen['ben_cedula'] ?>&regIn=ben" 
									class="btn waves-effect red lighten-1" 
								>
									Registrar asistencia
								</a>
							</td>
						<? 
						} else if (!empty($userFoundEmp)) {
						?>
						<tr>
							<td><? echo $userFoundEmp['emp_cedula'] ?></td>
							<td><? echo $userFoundEmp['emp_nombres'] ?></td>
							<td><? echo $userFoundEmp['emp_apellidos'] ?></td>
							<td><? echo $userFoundEmp['emp_sexo'] ?></td>
							<td><? echo $userFoundEmp['emp_nacimiento'] ?></td>
							<td><? echo $userFoundEmp['emp_telef'] ?></td>
							<td><? echo $userFoundEmp['emp_created_by'] ?></td>
						</tr>
						<tr>
							<td colspan="8">
								<a 
									href="registrar_asistencia.php?reg=<? echo $userFoundEmp['emp_cedula'] ?>&regIn=emp" 
									class="btn waves-effect red lighten-1" 
								>
									Registrar asistencia
								</a>
							</td>
						</tr>
						<?
						}
						?>
					</tbody>
				</table>
      </div>
    </div>
  </main>

  <? require 'Drawer.php'; ?>

	<div id="oscuroB">
		
	</div>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/statusBox.js"></script>
</body>
</html>