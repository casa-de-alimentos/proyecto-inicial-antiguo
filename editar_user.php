<?php
	require 'php/DB.php';
	require 'php/controllers/loginController.php';
	require 'php/controllers/UserController.php';

	$controller = new UserController();
	
	//Init session
	session_start();
	extract($_REQUEST);

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

	//Datos de la tabla
	$data_table = $controller->index();

	//Verify edit
	if (isset($edit)) {
		$idUser = $edit;
		foreach ($data_table as $user) {
			if ($user['id'] === $idUser) {
				$userUsername = $user['username'];
				$userName = $user['name'];
				$userSuper = $user['super_user'];
			}
		}
	}else {
		$idUser = "";
		$userUsername = "";
		$userName = "";
		$userSuper = "";
	}

	//Verify form
	if (isset($action)) {
		if ($idUser === '') {
			$controller->create();
		}else {
			$controller->edit();
		}
	}

	if (isset($delete)) {
		$controller->delete($delete);
	}
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
				<h5>Editar usuarios</h5>
			</div>
			<div class='col s12'>
				<div class="card">
					<div class="card-content">
						<form class='formProducts' method="POST" action="#" autocomplete='off'>
							<div class='row' style='width: 100%'>
								<input type="hidden" name="id" value="<?php echo $idUser ?>" />
								<div class="input-field col s12 m6">
									<input id="usernames" 
										type="text" 
										name="username"
										value="<?php echo $userUsername ?>"
										<?php echo $idUser ? 'disabled' : null ?>
									/>
									<label for="name">Usuario</label>
								</div>
								
								<div class="input-field col s12 m6">
									<input id="name" 
										type="text" 
										name="name"
										value="<?php echo $userName ?>" 
									/>
									<label for="name">Nombre de la cuenta</label>
								</div>
								
								<div class="input-field col s12 m6">
									<input id="password" 
										type="password" 
										name="password"
									/>
									<label for="password">Contraseña</label>
								</div>
								
								<div class="col s12">
									<div class="switch">
										<label>
											<input type="checkbox" <?php echo boolval($userSuper) ? 'checked' : '' ?> name="super_user">
											<span class="lever"></span>
											Cuenta modo Super Usuario
										</label>
									</div>
								</div>
								
								<div class='col s12 center-align'>
									<button 
										class="btn waves-effect red lighten-1" type="submit" name="action"
									>
										<?php echo $idUser === '' ? 'Añadir' : 'Editar' ?>
									</button>
								</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class='col s12'>
				<div class="card">
					<div class="card-content">
						<span class="card-title">Usuarios registrados</span>
						<table class="centered">
							<thead>
								<tr>
									<th>Usuario</th>
									<th colspan="2">Opciones</th>
								</tr>
							</thead>

							<tbody>
								<?php 
								if (!empty($data_table)) {
									foreach ($data_table as $user) { 
								?>
									<tr>
										<td><?php echo $user['username'] ?></td>
										<td colspan="2">
											<a href="editar_user.php?edit=<?php echo $user['id'] ?>" class="waves-effect light-blue darken-3 btn-small">Modificar</a>		
											<a href="editar_user.php?delete=<?php echo $user['id'] ?>" class="waves-effect red darken-1 btn-small">Borrar</a>
										</td>
									</tr>
								<?php }
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
		</div>
		
		<input type='hidden' id='js_statusBox' value='<?php echo json_encode($dataStatus) ?>' />
	</main>
	
	<script src="js/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="js/main.js"></script>
	<script src='js/statusBox.js'></script>
</body>
</html>