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
				<h5>Respaldar sistema</h5>
			</div>
			<div class='col s12'>
				<div class="card">
					<div class="card-content">
						<span class="card-title">Realizar backup</span>
						<div class='row'>
							<div class='col s12 center-align'>
								<a 
									href='backup.php' class="btn waves-effect red lighten-1"
								>
									Realizar y descargar backup
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class='col s12'>
				<div class="card">
					<div class="card-content">
						<span class="card-title">Restaurar sistema</span>
						<form method="post" action="restore.php" enctype="multipart/form-data">
							<div class='row'>
								<div class="file-field input-field col s12">
									<div class="btn red lighten-1">
										<span>File</span>
										<input type="file" name='backup_file'>
									</div>
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text">
									</div>
								</div>
								<div class='col s12 center-align'>
									<button
										type='submit' class="btn waves-effect red lighten-1"
									>
										Restaurar sistema
									</button>
								</div>
						</form>
						</div>
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
	<script>
		$.extend( true, $.fn.dataTable.defaults, {
			"searching": false,
			"ordering": false
		});
		$(document).ready(function() {
			$('#table_compact').DataTable({
				"pagingType": "full_numbers",
				"language": {
					"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
				},
				
			});
		});
	</script>
</body>
</html>