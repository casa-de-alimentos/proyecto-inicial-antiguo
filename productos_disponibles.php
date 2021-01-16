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

	//Datos de la pรกgina
	$data_productos = $controllerProductos->index();
	$data_storage = $controllerStorage->index('all');
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
				<h5>Productos disponibles</h5>
			</div>
			
			<div class='col s12 m6'>
				<div class="card">
					<div class="card-content">
						<span class='card-title'>Suministros actuales</span>
						<table class="centered">
							<thead>
								<tr>
									<th>Producto</th>
									<th>Disponibles</th>
								</tr>
							</thead>
							
							<tbody>
						<?php 
						if (!empty($data_productos)) {
							foreach ($data_productos as $product) { ?>
							<tr>
								<td><?php echo $product['name'] ?></td>
								<td>
									<?php
										if ($product['stock'] > 20) {
											$colorText = 'blue-text';
										}else if ($product['stock'] > 7) {
											$colorText = 'yellow-text text-darken-3';
										}else {
											$colorText = 'red-text';
										}
									?>
									<span class="<?php echo $colorText ?>"><?php echo $product['stock'].$product['medida']; ?></span>
								</td>
							</tr>
						<?php } 
						} ?>
					</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class='col s12 m6'>
				<div class="card">
					<div class="card-content">
						<span class='card-title'>Movimiento de suministros</span>
						<table class="centered" id='table_compact'>
							<thead>
								<tr>
									<th>Producto</th>
									<th>Movimientos</th>
									<th>Fecha</th>
								</tr>
							</thead>
							
							<tbody>
								<?php
								if (!empty($data_storage)) {
									foreach ($data_storage as $storage) { ?>
										<tr>
											<td><?php echo $storage['name'] ?></td>
											<td>
												<?php
													if ($storage['action'] === 'added') {
														$colorText = 'green-text';
														$text = '+'.$storage['stock'].$storage['medida'];
													}else {
														$colorText = 'red-text';
														$text = '-'.$storage['stock'].$storage['medida'];
													}
												?>
												<span class="<?php echo $colorText ?>"><?php echo $text ?></span>
											</td>
											<td>
												<?php echo $storage['date'] ?>
											</td>
										</tr>
								<?php	} 
									}
								?>
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