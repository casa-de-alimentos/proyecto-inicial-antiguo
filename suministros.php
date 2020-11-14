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
	$controller->AddEntry();
}

$dataP = Productos::getProductsList();
$dataL = Almacen::getLastLogs();
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
		<span class="panelTitle">Entrada de suministros</span>
    <div class="boxWidthAll">
      <div class="boxContent">
        <form id="editProducForm" action="#" method="POST">
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
					<div class="input-field col s12">
						<select name='producto'>
							<option value="" disabled selected>Seleccione un producto</option>
							<? if (!empty($dataP)) {
								foreach ($dataP as $product) { ?>
								<option value="<? echo $product['prod_id'] ?>"><? echo $product['prod_name'] ?></option>
							<? }
							} ?>
						</select>
						<label>Productos</label>
					</div>
					<div class="input-field col s6">
						<input id="number" 
							type="number" 
							name="stock"
							step=".01"
						/>
						<label for="number">Cantidad entregada</label>
					</div>
					<button 
						class="btn waves-effect red lighten-1" 
						type="submit" 
						name="action"
					>
						Agregar
					</button>
				</form>
      </div>
    </div>
    <div class="box">
      <span class="boxTitle">
        Últimas entradas de suministros
      </span>
      <div class="boxContent">
        <table class="striped centered">
					<thead>
						<tr>
							<th>Producto</th>
							<th>Entrega</th>
							<th>Fecha</th>
						</tr>
					</thead>

					<tbody>
						<?php
							if (isset($dataL)) {								
								foreach ($dataL as $log): 
							?>
							<tr>
								<td><? echo $log['prod_name'] ?></td>
								<td>
									<span class="green-text">+<? echo $log['alm_stock'].$log['prod_medida']; ?></span>
								</td>
								<td>
									<? echo $log['alm_date'] ?>
								</td>
							</tr>
						<?php 
							endforeach;
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