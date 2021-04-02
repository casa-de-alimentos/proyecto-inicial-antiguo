<?php
	require 'php/DB.php';
	require 'php/controllers/LogController.php';

	$controller = new LogController();
	
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

	//Datos de la tabla
	$data_table = $controller->index();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Panel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="css/roboto.css" />
	<link rel="stylesheet" href="css/materialize.min.css">
	<link href="css/materialize-icons.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery.dataTables.min.css">
</head>
<body>
	<?php require('php/componets/HeaderAuth.php') ?>
	
	<main class='container'>
		<div class="row">
			<div class='col s12'>
				<h5>Movimientos del sistema</h5>
			</div>
			<div class='col s12'>
				<div class="card">
					<div class="card-content">
						<table id='table_compact'>
							<thead>
								<tr>
									<th>Fecha</th>
									<th>Acciรณn</th>
									<th>Cuenta</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($data_table)): ?>
								<?php foreach($data_table as $log): ?>
								<tr>
									<td><?php echo $log['date'] ?></td>
									<td><?php echo $log['action'] ?></td>
									<td><?php echo isset($log['name']) ? $log['name'] : 'Cuenta eliminada' ?></td>
								</tr>
								<?php endforeach ?>
								<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
		</div>
		
		<input type='hidden' id='js_statusBox' value='<?php echo json_encode($dataStatus) ?>' />
	</main>
	
	<script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/materialize.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/main.js"></script>
	<script src='js/statusBox.js'></script>
	<script src='js/table_compac.js'></script>
</body>
</html>