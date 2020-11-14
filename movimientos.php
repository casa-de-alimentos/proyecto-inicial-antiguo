<?
include 'php/controlador.php';
$controller = new Controlador();

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

$logs = $controller->getLogs();
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
		<span class="panelTitle">Movimientos</span>
    <div class="boxWidthAll">
      <div class="boxContent">
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
				<table class="striped centered">
					<thead>
						<th>Fecha</th>
						<th>Acción</th>
						<th>Usuario</th>
					</thead>
					<tbody>
						<? if($logs) {
							foreach ($logs as $log) {
								?>
								<tr>
									<td><? echo $log['mov_date'] ?></td>
									<td><? echo $log['mov_action'] ?></td>
									<td><? echo $log['mov_user'] ?></td>
								</tr>
								<?
							}
						} ?>
					</tbody>
				</table>
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