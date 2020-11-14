<?php
include 'php/controlador.php';

//Init session
session_start();

//StatusBox
if(isset($_SESSION['statusBox'])) {
	$statusBox = $_SESSION['statusBox'];
	$message = $_SESSION['message'];
	$color = $_SESSION['color'];
}

extract($_REQUEST);

if (isset($_SESSION['auth']) && $_SESSION['auth']) {
	header('location: panel.php');
}


if (isset($action)) {
	Controlador::options($operation);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="css/main.css">
  <title>Inicio</title>
</head>
<body>
  <header class="menu">
  </header>
  <main class="indexMain">
    <img src="img/logoWeb.png" alt="logo" width="150" height="150" />
    <form action="index.php?operation=login" method="POST" class="formIndex">
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
				<input type="text" name="user" id="user">
				<label for="user">Usuario</label>
			</div>
			<div class="input-field col s6">
				<input type="text" name="pass" id="pass">
				<label for="pass">Contraseña</label>
			</div>
			<p class="remember">
				<label>
					<input type="checkbox" class="red" name="remember" id="remember" />
					<span>Recordar usuario</span>
				</label>
			</p>
			<button 
				class="btn waves-effect red lighten-1" type="submit" name="action"
			>
				Acceder
			</button>
    </form>
  </main>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="js/statusBox.js"></script>
</body>
</html>