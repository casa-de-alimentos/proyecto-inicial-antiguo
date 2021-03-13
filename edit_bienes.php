<?php
	require 'php/DB.php';
	require 'php/controllers/loginController.php';
	require 'php/controllers/BienesController.php';

	$controller = new BienesController();
	
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
		$idBienes = $edit;
		foreach ($data_table as $row) {
			if ($row['id'] === $idBienes) {
				$nameBienes = $row['name'];
				$stockBienes = $row['stock'];
			}
		}
	}else {
		$nameBienes = "";
		$stockBienes = "";
		$idBienes = "";
	}

	//Verify form
	if (isset($action)) {
		if ($idBienes === '') {
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
				<h5>Editar bienes</h5>
			</div>
			<div class='col s12'>
				<div class="card">
					<div class="card-content">
						<form class='formProducts' method="POST" action="#" autocomplete='off'>
							<div class='row' style='width: 100%'>
								<input type="hidden" name="id" value="<?php echo $idBienes ?>" />
								<div class="input-field col s12 m6">
									<input id="name" 
										type="text" 
										name="name"
										value="<?php echo $nameBienes ?>"
									/>
									<label for="name">Nombre</label>
								</div>
								
								<div class="input-field col s12 m6">
									<input id="number" 
										type="number" 
										name="stock"
										value="<?php echo $stockBienes ?>" 
									/>
									<label for="number">Cantidad disponible</label>
								</div>
								
								<div class='col s12 center-align'>
									<button 
										class="btn waves-effect red lighten-1" type="submit" name="action"
									>
										<?php echo $idBienes === '' ? 'Añadir' : 'Editar' ?>
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
						<span class="card-title">Bienes</span>
						<table class="centered" id='table_compact'>
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Disponible</th>
									<th colspan="2">Opciones</th>
								</tr>
							</thead>

							<tbody>
								<?php 
								if (!empty($data_table)) {
									foreach ($data_table as $row) { 
								?>
									<tr>
										<td><?php echo $row['name'] ?></td>
										<td><?php echo $row['stock'] ?></td>
										<td colspan="2">
											<a href="edit_bienes.php?edit=<?php echo $row['id'] ?>" class="waves-effect light-blue darken-3 btn-small">Modificar</a>		
											<a href="edit_bienes.php?delete=<?php echo $row['id'] ?>" class="waves-effect red darken-1 btn-small">Borrar</a>
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