<?php
	require 'php/DB.php';
	require 'php/controllers/loginController.php';
	require 'php/controllers/productController.php';
	require 'php/controllers/storageController.php';

	$controllerProductos = new ProductController();
	$controllerStorage = new StorageController();

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

	//Datos de la página
	$data_productos = $controllerProductos->index();
	$data_table = $controllerStorage->index();

	if (isset($action)) {
		$controllerStorage->create();
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
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	<?php require('php/componets/HeaderAuth.php') ?>
	
	<main class='container'>
		<div class="row">
			<div class='col s12'>
				<h5>Entrada de suministros</h5>
			</div>
			<div class='col s12 m6'>
				<div class="card">
					<div class="card-content">
						<form class='formProducts' method="POST" action="#" autocomplete='off'>
							<div class='row' style='width: 100%'>
								<div class="input-field col s12">
									<select name='producto'>
										<option value="" disabled selected>Seleccione un producto</option>
										<?php if (!empty($data_productos)) {
											foreach ($data_productos as $product) { ?>
											<option value="<?php echo $product['id'] ?>"><?php echo $product['name'] ?></option>
										<?php }
										} ?>
									</select>
									<label>Productos</label>
								</div>
								
								<div class="input-field col s12">
									<input id="number" 
										type="number" 
										name="stock"
										step=".01"
									/>
									<label for="number">Cantidad entregada</label>
								</div>
								
								<div class='col s12 center-align'>
									<button 
										class="btn waves-effect red lighten-1" type="submit" name="action"
									>
										Agregar
									</button>
								</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class='col s12 m6'>
				<div class="card">
					<div class="card-content">
						<span class='card-title'>Últimas entradas de suministros</span>
						<table class="centered" id='table_compact'>
							<thead>
								<tr>
									<th>Producto</th>
									<th>Entrega</th>
									<th>Fecha</th>
								</tr>
							</thead>
							
							<tbody>
								<?php
									if (isset($data_table)) {
										foreach ($data_table as $storage): 
									?>
									<tr>
										<td><?php echo $storage['name'] ?></td>
										<td>
											<span class="green-text">+<?php echo $storage['stock'].$storage['medida']; ?></span>
										</td>
										<td>
											<?php echo $storage['date'] ?>
										</td>
									</tr>
								<?php 
									endforeach;
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
	<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	<script src="js/main.js"></script>
	<script src='js/statusBox.js'></script>
	<script src='js/table_compac.js'></script>
</body>
</html>