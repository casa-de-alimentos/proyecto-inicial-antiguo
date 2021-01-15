<?php

class Almacen extends Controlador
{
	public function AddEntry()
	{
		extract($_REQUEST);
		session_start();

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$producto, $stock]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'Debe rellenar todos los campos';
			$_SESSION['color'] = 'error';
			header('location: suministros.php');
			return null;
		}

		if ($stock <= 0) {
			$_SESSION['statusBox'] = 'number';
			$_SESSION['message'] = 'La cantidad debe ser mayor a 0';
			$_SESSION['color'] = 'warning';
			header('location: suministros.php');
			return null;
		}

		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$owner = $_SESSION['user'];
		$date = (new DateTime())->format('Y-m-d');
		$sql="INSERT INTO Almacen (alm_owner, alm_product, alm_stock, alm_date) VALUES
		('$owner', '$producto', '$stock', '$date')";

		$res=mysqli_query($conection,$sql);

		if (!$res) {
    	$_SESSION['statusBox'] = 'sql';
			$_SESSION['message'] = 'No se pudo registrar la entrega';
			$_SESSION['color'] = 'error';
			header('location: suministros.php');
			return null;
    }

    //Update New Value
    $sql="UPDATE Productos SET prod_stock=prod_stock + $stock WHERE prod_id='$producto'";
    $res=mysqli_query($conection,$sql);

    if (!$res) {
    	$_SESSION['statusBox'] = 'sql';
			$_SESSION['message'] = 'No se pudo actualizar el stock';
			$_SESSION['color'] = 'error';
			header('location: suministros.php');
			return null;
    }

    $_SESSION['statusBox'] = 'ok';
		$_SESSION['message'] = 'Entrega registrada en el sistema';
		$_SESSION['color'] = 'success';

		$sql="SELECT prod_name FROM Productos WHERE prod_id='$producto'";
    $res=mysqli_query($conection,$sql);

    $data=mysqli_fetch_assoc($res);

    $nameP = $data['prod_name'];
		$this->addLog("Suministro añadido: +".$stock."Kg de $nameP");
		header('location: suministros.php');
	}

	public function AddConsume()
	{
		extract($_REQUEST);
		session_start();

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$producto, $stock]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'Debe rellenar todos los campos';
			$_SESSION['color'] = 'error';
			header('location: preparar_comida.php');
			return null;
		}

		if ($stock <= 0) {
			$_SESSION['statusBox'] = 'number';
			$_SESSION['message'] = 'La cantidad debe ser mayor a 0';
			$_SESSION['color'] = 'warning';
			header('location: preparar_comida.php');
			return null;
		}

		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		//Update New Value
    $sql="SELECT prod_stock FROM Productos WHERE prod_id='$producto'";
    $res=mysqli_query($conection,$sql);

    $data=mysqli_fetch_assoc($res);

    $resta = $data['prod_stock'] - $stock;
    if ($resta <= 0) {
    	$_SESSION['statusBox'] = 'max';
			$_SESSION['message'] = 'No dispone de esa cantidad almacenada';
			$_SESSION['color'] = 'warning';
			header('location: preparar_comida.php');
			return null;
    }

		//Registrar consumo
		$owner = $_SESSION['user'];
		$date = (new DateTime())->format('Y-m-d');
		$sql="INSERT INTO Almacen (alm_owner, alm_product, alm_stock, alm_date, alm_action) VALUES
		('$owner', '$producto', '$stock', '$date', 'removed')";

		$res=mysqli_query($conection,$sql);

		if (!$res) {
    	$_SESSION['statusBox'] = 'sql';
			$_SESSION['message'] = 'No se pudo registrar la entrega';
			$_SESSION['color'] = 'error';
			header('location: preparar_comida.php');
			return null;
    }

    //Update New Value
    $sql="UPDATE Productos SET prod_stock=prod_stock - $stock WHERE prod_id='$producto'";
    $res=mysqli_query($conection,$sql);

    if (!$res) {
    	$_SESSION['statusBox'] = 'sql';
			$_SESSION['message'] = 'No se pudo actualizar el stock';
			$_SESSION['color'] = 'error';
			header('location: preparar_comida.php');
			return null;
    }

    $_SESSION['statusBox'] = 'ok';
		$_SESSION['message'] = 'Gasto de suministro registrado';
		$_SESSION['color'] = 'success';

		$sql="SELECT prod_name FROM Productos WHERE prod_id='$producto'";
    $res=mysqli_query($conection,$sql);

    $data=mysqli_fetch_assoc($res);

    $nameP = $data['prod_name'];
		$this->addLog("Consumo de suministro: -".$stock."Kg de $nameP");
		header('location: preparar_comida.php');
	}

	static function getLastLogs($option = 'added')
	{
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql;
		if ($option === 'all') {
			$sql="SELECT Productos.prod_name, Almacen.alm_stock, Almacen.alm_action, Almacen.alm_date, Productos.prod_medida FROM Almacen 
			INNER JOIN Productos ON Productos.prod_id = Almacen.alm_product
			ORDER BY alm_id DESC LIMIT 7";
		}else {
			$sql="SELECT Productos.prod_name, Almacen.alm_stock, Almacen.alm_date, Productos.prod_medida FROM Almacen 
			INNER JOIN Productos ON Productos.prod_id = Almacen.alm_product
			WHERE alm_action = '$option' ORDER BY alm_id DESC LIMIT 7";
		}

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			return null;
		}

		//GetData
		$i=0;
		while ($data=mysqli_fetch_assoc($res)) {
			$logs[$i] = $data;
			$i++;
		}

    return $logs;
	}

	static function getConsumoMensual($positive = false)
	{
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		//Lista de todos los productos
		$productsList = Productos::getProductsList();
		$arrayListP = array();

		if ($productsList) {
			for ($j=0; $j < count($productsList); $j++) {
				$arrayListP[$j] = $productsList[$j]['prod_name'];
			}
			$productsList = $arrayListP;
		}

		//Consulta para obtener los meses consumindos
		if ($positive) {
			$sql = "SELECT SUM(alm_stock) as stock,
			MONTH(alm_date) as mes,
			Productos.prod_name as product
			FROM Almacen
			INNER JOIN Productos ON Productos.prod_id = alm_product
			WHERE alm_action = 'added'
			GROUP BY MONTH(alm_date), alm_product
			ORDER BY mes";
		}else {
			$sql = "SELECT SUM(alm_stock) as stock,
			MONTH(alm_date) as mes,
			Productos.prod_name as product
			FROM Almacen
			INNER JOIN Productos ON Productos.prod_id = alm_product
			WHERE alm_action = 'removed'
			GROUP BY MONTH(alm_date), alm_product
			ORDER BY mes";
		}

		$res=mysqli_query($conection,$sql);

		$mesList=array();
		$stocksArray = array();
		$mesI=0;
		$stockI=0;
		while($data=mysqli_fetch_assoc($res)){
			//Seleccionar Mes ESPAÑOL
			$mes = false;
			if ($data['mes'] == 1) {
				$mes = "Enero";
			} else if ($data['mes'] == 2) {
				$mes = "Febrero";
			} else if ($data['mes'] == 3) {
				$mes = "Marzo";
			} else if ($data['mes'] == 4) {
				$mes = "Abril";
			} else if ($data['mes'] == 5) {
				$mes = "Mayo";
			} else if ($data['mes'] == 6) {
				$mes = "Junio";
			} else if ($data['mes'] == 7) {
				$mes = "Julio";
			} else if ($data['mes'] == 8) {
				$mes = "Agosto";
			} else if ($data['mes'] == 9) {
				$mes = "Septiembre";
			} else if ($data['mes'] == 10) {
				$mes = "Octubre";
			} else if ($data['mes'] == 11) {
				$mes = "Noviembre";
			} else if ($data['mes'] == 12) {
				$mes = "Diciembre";
			}

			//Guardar mes sin repetir
			if ($mes) {
				$add = true;

				//Verificar existencia
				for ($p=0; $p < count($mesList); $p++) {
					if ($mesList[$p] === $mes) {
						$add = false;
					}
				}

				if ($add) {
					$mesList[$mesI] = $mes;

					//Cambiar mes
					$mesI++;
				}
			}

			//Guardar stocks
			if ($positive) {
				$value = $data['stock'];
			}else {
				$value = -1 * $data['stock'];
			}
			
			array_push($stocksArray, array('name' => $data['product'], 'mes' => $mesI - 1, 'stock' => $value));
		}

		//Corregir stocks
		$added=0;
		$stockList = array();

		//Poner todo en 0
		if ($stocksArray) {
			for ($i=0; $i < count($productsList); $i++) { 
				for ($w=0; $w < count($mesList); $w++) { 
					$stockList[$i][$w] = 0;
				}
			}

			//Colocar números
			for ($i=0; $i < count($productsList); $i++) { 
				for ($o=0; $o < count($stocksArray); $o++) { 
					if ($productsList[$i] === $stocksArray[$o]['name']) {
						$stockList[$i][$stocksArray[$o]['mes']] = $stocksArray[$o]['stock'];
					}
				}
			}
		}

		$MasterArray = array($mesList, $productsList, $stockList);
		return json_encode($MasterArray);
	}
}
?>