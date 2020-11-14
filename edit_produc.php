<?php
include 'php/class/Products.php';

$controller = new Productos();

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

//Verify form
if (isset($action)) {
	if ($option === 'add') {
		$controller->registerProduct();
	}else if ($option === 'modify') {
		$controller->editProduct();
	}
}

$dataP = Productos::getProductsList();

//Verify edit
if (isset($edit)) {
	$radioAdd = "";
	$radioModify = "checked";
	$idI = $edit;
	foreach ($dataP as $product) {
		if ($product['prod_id'] === $idI) {
			$nameI = $product['prod_name'];
			$stockI = $product['prod_stock'];
		}
	}
}else {
	$radioAdd = "checked";
	$radioModify = "";
	$nameI = "";
	$stockI = "";
	$idI = "";
}

if (isset($delete)) {
	$controller->deleteProduct($delete);
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
		<span class="panelTitle">Editar Productos</span>
    <div class="boxWidthAll">
      <div class="boxContent">
        <form id="editProducForm" method="POST" action="#">
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
					<div class="option">
						<p>
							<label>
								<input name="option" class="with-gap" <? echo $radioAdd ?> type="radio" value="add" />
								<span>Añadir</span>
							</label>
						</p>
						<p>
							<label>
								<input name="option" class="with-gap" <? echo $radioModify ?> type="radio" value="modify" />
								<span>Modificar</span>
							</label>
						</p>
					</div>
					<div class="inputs">
						<input type="hidden" name="id" value="<? echo $idI ?>" />
						<div class="input-field col s6">
							<input id="name" 
								type="text" 
								name="name"
								value="<? echo $nameI ?>" 
							/>
							<label for="name">Nombre del producto</label>
						</div>
						<div class="input-field col s6">
							<input id="number" 
								type="number" 
								name="stock"
								value="<? echo $stockI ?>"
							/>
							<label for="number">Cantidad inicial</label>
						</div>
					</div>
					<div class="input-field col s12">
							<select name='medida'>
								<option value="" disabled selected>Seleccione una medida</option>
								<option value="Kg">Kg</option>
								<option value="Lts">Lts</option>
							</select>
							<label>Medida</label>
						</div>
					<button 
						class="btn waves-effect red lighten-1" type="submit" name="action"
					>
						Editar
					</button>
				</form>
      </div>
    </div>
    <div class="box">
      <span class="boxTitle">
        Productos registrados
      </span>
      <div class="boxContent">
				<table class="striped centered">
					<thead>
						<tr>
							<th>Producto</th>
							<th colspan="2">Opciones</th>
						</tr>
					</thead>

					<tbody>
						<? 
						if (!empty($dataP)) {
							foreach ($dataP as $product) { 
						?>
							<tr>
								<td><? echo $product['prod_name'] ?></td>
								<td colspan="2">
									<a href="edit_produc.php?edit=<? echo $product['prod_id'] ?>" class="waves-effect light-blue darken-3 btn-small">Modificar</a>		
									<a href="edit_produc.php?delete=<? echo $product['prod_id'] ?>" class="waves-effect red darken-1 btn-small">Borrar</a>
								</td>
							</tr>
						<? }
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