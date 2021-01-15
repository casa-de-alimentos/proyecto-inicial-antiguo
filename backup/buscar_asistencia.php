<?
include 'php/controlador.php';
include 'php/class/Asistencias.php';
//Init session
session_start();
$asistencias = new Asistencias();

extract($_REQUEST);

//StatusBox
if(isset($_SESSION['statusBox']) && !empty($_SESSION['statusBox'])) {
	$statusBox = $_SESSION['statusBox'];
	$message = $_SESSION['message'];
	$color = $_SESSION['color'];
}

//Verify login
if (!$_SESSION['auth']) {
	header('location: index.php');
}

//Search User
if (isset($search)) {
	$asisBen = $asistencias->SearchAsisBen();

	if (!$asisBen) {
		$asisEmp = $asistencias->SearchAsisEmp();
	}

	//StatusBox
	if(isset($_SESSION['statusBox']) && !empty($_SESSION['statusBox'])) {
		$statusBox = $_SESSION['statusBox'];
		$message = $_SESSION['message'];
		$color = $_SESSION['color'];
	}
}
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
		<span class="panelTitle">Buscar asistencia</span>
    <div class="boxWidthAll">
      <div class="boxContent">
        <form id="editProducForm" action="#">
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
						<i class="prefix material-icons">search</i>
						<input id="number" 
							type="text" 
							name="person"
						/>
						<label for="number">Buscar persona</label>
					</div>
					<button 
						class="btn waves-effect red lighten-1" 
						type="submit" 
						name="search"
					>
						Buscar
					</button>
				</form>
      </div>
    </div>
    <div class="box">
      <span class="boxTitle">
      	Días asistidos (Últimos 10 días)
      </span>
      <div class="boxContent">
				<? if (isset($asisBen) || isset($asisEmp)) {
				?>
				<table class="striped centered">
					<thead>
						<th>Fecha</th>
						<th>Asistencia</th>
					</thead>
					<tbody>
						<?
						if ($asisBen) {
							$dateInit = (new DateTime())->format('Y-m-d');

							//Obtener todas las asistencias
							$w=0;
							foreach ($asisBen as $asistencia) {
								$dataAsis[$w] = $asistencia;
								$w++;
							}

							for ($i=0; $i < 10; $i++) { 
								$asisFor = false;
								for ($o=0; $o < count($dataAsis); $o++) { 
									if ($dateInit === $dataAsis[$o]['asb_date']) {
										$asisFor = true;
									}
								}

								if ($asisFor) {
									?>
									<tr>
										<td><? echo $dateInit ?></td>
										<td class="green-text">Asistido</td>
									</tr>
									<?
								}else {
									?>
									<tr>
										<td><? echo $dateInit ?></td>
										<td class="red-text">No asistido</td>
									</tr>
									<?
								}
								$dateInit = (new DateTime($dateInit))->modify('-1 day')->format('Y-m-d');
							}
						}else if ($asisEmp) {
							$dateInit = (new DateTime())->format('Y-m-d');

							//Obtener todas las asistencias
							$w=0;
							foreach ($asisEmp as $asistencia) {
								$dataAsis[$w] = $asistencia;
								$w++;
							}

							for ($i=0; $i < 10; $i++) { 
								$asisFor = false;
								for ($o=0; $o < count($dataAsis); $o++) { 
									if ($dateInit === $dataAsis[$o]['asp_date']) {
										$asisFor = true;
									}
								}

								if ($asisFor) {
									?>
									<tr>
										<td><? echo $dateInit ?></td>
										<td class="green-text">Asistido</td>
									</tr>
									<?
								}else {
									?>
									<tr>
										<td><? echo $dateInit ?></td>
										<td class="red-text">No asistido</td>
									</tr>
									<?
								}
								$dateInit = (new DateTime($dateInit))->modify('-1 day')->format('Y-m-d');
							}
						}
						?>
					</tbody>
				</table>
				<?
				}
				?>
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