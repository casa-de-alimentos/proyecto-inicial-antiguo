<?php
	require 'php/DB.php';
	require 'php/controllers/loginController.php';
	require 'php/controllers/BeneficiaryController.php';
	require 'php/controllers/EmployeeController.php';

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

	// Form mode
	if (isset($_GET['mode']) && $_GET['mode'] === 'elab') {
		$formMode = 'elab';
	}else {
		$formMode = 'ben';
	}

	// Delete
	if (isset($idDel)) {
		if ($formMode === 'elab') {
			
		}else {
			$controller = new BeneficiaryController();
			$controller->delete($idDel);
		}
	}
?>
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
				<h5>Administrar Benef/Elab</h5>
			</div>
			
			<div class='col s12 center-align'>
				<a class="btn waves-effect red lighten-1 <?php echo $formMode === 'ben' ? 'disabled' : '' ?>" href='?mode=ben'>Beneficiario</a>
				<a class="btn waves-effect red lighten-1 <?php echo $formMode === 'elab' ? 'disabled' : '' ?>" href='?mode=elab'>Elaborador</a>
			</div>
			
			<div class='col s12 right-align'>
				<a href='edit_personas.php?mode=add&formMode=<?php echo $formMode ?>' class="btn waves-effect red lighten-1" href='?mode=ben'>Añadir <?php echo $formMode === 'elab' ? 'elaborador' : 'beneficiario' ?></a>
			</div>
			
			<div class='col s12'>
				<div class="card">
					<div class="card-content">
						<span class="card-title"><?php echo $formMode === 'elab' ? 'Elaboradores' : 'Beneficiario' ?> registrados</span>
						<?php
						if ($formMode === 'elab') {
							$controller = new EmployeeController();
							$dataTable = $controller->index();
						}else {
							$controller = new BeneficiaryController();
							$dataTable = $controller->index();
						}
						?>
						<?php if (count($dataTable) > 0): ?>
						<table class='centered' id='table_compac'>
							<thead>
								<tr>
									<th>Cédula</th>
									<th>Nombre y apellido</th>
									<th>Registrado por</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($dataTable as $people): ?>
								<tr>
									<td><?php echo $people['cedula'] ?></td>
									<td><?php echo $people['nombre'].' '.$people['apellido'] ?></td>
									<td><?php echo $people['username'] ?></td>
									<td>
										<a href="edit_personas.php?mode=edit&formMode=<?php echo $formMode ?>&idEdit=<?php echo $people['people_id'] ?>" class="btn-floating waves-effect light-blue darken-3 btn-small"><i class="material-icons">edit</i></a>
										
										<a href="#confirm<?php echo $people['people_id'] ?>" class="btn-floating waves-effect red darken-1 btn-small modal-trigger"><i class="material-icons">delete</i></a>
										
										<div id="confirm<?php echo $people['people_id'] ?>" class="modal">
											<div class="modal-content">
												<h4>¿Seguro?</h4>
												<p>Está apunto de eliminar a <strong><?php echo $people['nombre'].' '.$people['apellido'] ?></strong> (<?php echo $people['cedula']; ?>), los datos borrados tras esta acción no se podrán recuperar</p>
											</div>
											<div class="modal-footer">
												<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
												<a href="?mode=<?php echo $formMode ?>&idDel=<?php echo $people['people_id'] ?>" class="waves-effect waves-red btn-flat">Eliminar</a>
											</div>
										</div>
									</td>
								</tr>
								<?php endforeach ?>
							</tbody>
						</table>
						<?php endif ?>
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
	<script src="js/statusBox.js"></script>
	<script>
		$.extend( true, $.fn.dataTable.defaults, {
			"searching": true,
			"ordering": false
		});
		$(document).ready(function() {
			$('#table_compac').DataTable({
				"pagingType": "full_numbers",
				"language": {
					"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
				},
				
			});
		});
	</script>
</body>
</html>