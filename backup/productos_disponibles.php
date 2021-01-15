<?
include 'php/class/Products.php';
include 'php/class/Almacen.php';

//Init session
session_start();
extract($_REQUEST);

//StatusBox
if(isset($_SESSION['statusBox'])) {
	$statusBox = $_SESSION['statusBox'];
	$message = $_SESSION['message'];
	$color = $_SESSION['color'];
}

//Verify login
if (!$_SESSION['auth']) {
	header('location: index.php');
}

$controller = new Almacen();
//Form
if (isset($action)) {
	$controller->AddConsume();
}

$dataProdA = Productos::getProductsList();
$dataMov = Almacen::getLastLogs('all');
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
		<span class="panelTitle">Productos disponibles</span>
   <div class="box">
      <span class="boxTitle">
        Suministros actuales
      </span>
      <div class="boxContent">
         <table class="striped centered">
					<thead>
						<tr>
							<th>Producto</th>
							<th>Disponibles</th>
						</tr>
					</thead>

					<tbody>
						<? 
						if (!empty($dataProdA)) {
							foreach ($dataProdA as $product) { ?>
							<tr>
								<td><? echo $product['prod_name'] ?></td>
								<td>
									<?
										if ($product['prod_stock'] > 20) {
											$colorText = 'blue-text';
										}else if ($product['prod_stock'] > 6) {
											$colorText = 'yellow-text text-darken-3';
										}else {
											$colorText = 'red-text';
										}
									?>
									<span class="<? echo $colorText ?>"><? echo $product['prod_stock'].$product['prod_medida']; ?></span>
								</td>
							</tr>
						<? } 
						} ?>
					</tbody>
				</table>
      </div>
    </div>
    <div class="box">
      <span class="boxTitle">
        Movimiento de suministros
      </span>
      <div class="boxContent">
         <table class="striped centered">
					<thead>
						<tr>
							<th>Producto</th>
							<th>Movimientos</th>
							<th>Fecha</th>
						</tr>
					</thead>

					<tbody>
						<? 
						if (!empty($dataMov)) {
							foreach ($dataMov as $movimientos) { ?>
								<tr>
									<td><? echo $movimientos['prod_name'] ?></td>
									<td>
										<?
											if ($movimientos['alm_action'] === 'added') {
												$colorText = 'green-text';
												$text = '+'.$movimientos['alm_stock'].$movimientos['prod_medida'];
											}else {
												$colorText = 'red-text';
												$text = '-'.$movimientos['alm_stock'].$movimientos['prod_medida'];
											}
										?>
										<span class="<? echo $colorText ?>"><? echo $text ?></span>
									</td>
									<td>
										<? echo $movimientos['alm_date'] ?>
									</td>
								</tr>
						<?	} 
							}
						?>
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
</body>
</html>