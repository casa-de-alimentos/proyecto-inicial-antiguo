<?
include 'php/controlador.php';
include 'php/class/Empleados.php';
$controller = new Empleados();

//Init session
session_start();

//StatusBox
if(isset($_SESSION['statusBox'])) {
	$statusBox = $_SESSION['statusBox'];
	$message = $_SESSION['message'];
	$color = $_SESSION['color'];
}

extract($_REQUEST);

//Verify login
if (!$_SESSION['auth']) {
	header('location: index.php');
}

//Form
if (isset($action)) {
	$controller->AddEmp();
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
		<span class="panelTitle">Añadir Empleado</span>
    <div class="boxWidthAll">
      <div class="boxContent">
        <form id="editProducForm" action="#" method="POST">
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
					<div class="inputs">
						<div class="input-field col s6">
							<span class="prefix">V-</span>
							<input id="cedula" type="text" name="cedula" />
							<label for="cedula">Cédula</label>
						</div>
						<div class="input-field col s6">
							<input id="name" 
								type="text" 
								name="name"
							/>
							<label for="name">Nombres</label>
						</div>
						<div class="input-field col s6">
							<input id="ape" 
								type="text" 
								name="ape"
							/>
							<label for="ape">Apellidos</label>
						</div>
					</div>
					<div class="option">
						<p>
							<label>
								<input name="sexo" class="with-gap" type="radio" value="M" />
								<span>Hombre</span>
							</label>
						</p>
						<p>
							<label>
								<input name="sexo" class="with-gap" type="radio" value="F" />
								<span>Mujer</span>
							</label>
						</p>
					</div>
					<div class="input-field col s6">
						<input id="fecha" type="text" name="fecha" class="datepicker">
						<label for="fecha">Fecha de nacimiento</label>
					</div>
					<div class="inputs">
						<div class="input-field col s6">
							<input id="telef" 
								type="number" 
								name="telef"
							/>
							<label for="telef">Teléfono</label>
						</div>
					</div>
					<button 
						class="btn waves-effect red lighten-1" type="submit" name="action"
					>
						Añadir
					</button>
				</form>
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