<?php 
	
	//Includes
	require('php/DB.php');
	require('php/controllers/loginController.php');

	//Init session
	session_start();
	require('php/controllers/StartController.php');

	if (isset($_SESSION['auth']) && $_SESSION['auth']) {
		header('location: panel.php');
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

	if (isset($action)) {
		$controller = new loginController();
		
		$controller->login();
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Inicio</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="css/roboto.css" />
	<link rel="stylesheet" href="css/materialize.min.css">
</head>
<body>
	<header>
		<nav>
			<div class="nav-wrapper red darken-1">
			</div>
		</nav>
	</header>
	
	<main>
		<form action='index.php'>
			<div class="container">
				<div class="row">
					<div class="col s12 center-align">
						<img src="img/logoWeb.png" alt="logo" width="150" height="150" />
					</div>
					<div class="input-field col s12 m8 offset-m2 l6 offset-l3">
						<input type="text" name="username" id="username">
						<label for="username">Usuario</label>
					</div>
					<div class="input-field col s12 m8 offset-m2 l6 offset-l3">
						<input type="password" name="password" id="pass">
						<label for="pass">Contraseña</label>
					</div>
					<div class="col s12 center-align form__login">
						<button 
							class="btn waves-effect red lighten-1" type="submit" name="action"
						>
							Acceder
						</button>
					</div>
				</div>
			</div>
		</form>
		
		<input type='hidden' id='js_statusBox' value='<?php echo json_encode($dataStatus) ?>' />
	</main>
	<script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/materialize.min.js"></script>
	<script src='js/statusBox.js'></script>
</body>
</html>