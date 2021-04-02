<?php
class StorageController
{
	public function index($option = 'added')
	{
		//Pedir productos
		$db = new DB();
		$conection = $db->conectar();
		
		if ($option === 'all') {
			$sql="SELECT products.name, storage.stock, storage.date, products.medida, storage.action FROM storage 
			INNER JOIN products ON products.id = storage.product_id ORDER BY storage.id DESC";	
		}else {
			$sql="SELECT products.name, storage.stock, storage.date, products.medida FROM storage 
			INNER JOIN products ON products.id = storage.product_id
			WHERE storage.action = '$option' ORDER BY storage.id DESC";
		}
		
		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			return null;
		}

		//GetData
		$i=0;
		while ($data=mysqli_fetch_assoc($res)) {
			$storages[$i] = $data;
			$i++;
		}

    return $storages;
	}
	
	public function create($option = 'added')
	{
		extract($_REQUEST);
		
		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$producto, $stock]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Debe rellenar todos los campos';

			if ($option !== 'added') {
				header('location: consumo.php');	
			}else {
				header('location: suministros.php');
			}
			return null;
		}
		
		if ($stock <= 0) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'La cantidad debe ser mayor a 0';
			
			if ($option !== 'added') {
				header('location: consumo.php');	
			}else {
				header('location: suministros.php');
			}
			return null;
		}
		
		//DB
		$db = new DB();
		$conection = $db->conectar();
		
		// Verificar Stock consumo
		$sql="SELECT stock FROM products WHERE id='$producto'";
		$res=mysqli_query($conection,$sql);
		$data=mysqli_fetch_assoc($res);
		
		if ($option !== 'added' && ($data['stock'] - $stock) < 0) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No dispone de esa cantidad actualmente';
			
			header('location: consumo.php');
			return null;
		}
		
		//Actualizar stock
    $sql='';
		if ($option !== 'added') {
			$sql="UPDATE products SET stock=stock - $stock WHERE id='$producto'";
		}else {
			$sql="UPDATE products SET stock=stock + $stock WHERE id='$producto'";
		}
    $res=mysqli_query($conection,$sql);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No se pudo actualizar el stock';
			
			if ($option !== 'added') {
				header('location: consumo.php');	
			}else {
				header('location: suministros.php');
			}
			return null;
    }
		
		//Añadir storage
		$date = (new DateTime())->format('Y-m-d H:i:s');
		$sql="INSERT INTO storage (product_id, action, stock, date) VALUES
		('$producto', '$option', '$stock', '$date')";
		
		$res=mysqli_query($conection,$sql);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			
			if ($option !== 'added') {
				$_SESSION['statusBox_message'] = 'No se pudo registrar el consumo';
				header('location: consumo.php');	
			}else {
				$_SESSION['statusBox_message'] = 'No se pudo registrar la entrega';
				header('location: suministros.php');
			}
			return null;
    }

		$sql="SELECT name, medida, stock FROM products WHERE id='$producto'";
    $res=mysqli_query($conection,$sql);

    $data=mysqli_fetch_assoc($res);

    $name_producto = $data['name'];
		
		$_SESSION['statusBox'] = 'success';
		
		if ($option !== 'added') {
			$this->addLog("Suministro consumido: -".$stock.$data['medida']." de $name_producto");
			$_SESSION['statusBox_message'] = 'Consumo registrado';
			header('location: consumo.php');	
		}else {
			$this->addLog("Suministro añadido: +".$stock.$data['medida']." de $name_producto");
			$_SESSION['statusBox_message'] = 'Entrega registrada';
			header('location: suministros.php');
		}
	}
	
	static public function consumo($positive = false)
	{
		//Consulta
		$db = new DB();
		$conection = $db->conectar();
		
		// Pedir todos los productos
		$sql = "SELECT name FROM products";
		$res=mysqli_query($conection,$sql);
		
		$i=0;
		$productsList = array();
		while($data=mysqli_fetch_assoc($res)){
			$productsList[$i] = $data['name'];
			$i++;
		}
		
		//Consulta para obtener los meses consumindos
		if ($positive) {
			$sql = "SELECT SUM(storage.stock) as stock,
			MONTHNAME(storage.date) as mes,
			DATE_FORMAT(storage.date,'%Y') as year,
			products.name as product
			FROM storage
			INNER JOIN products ON products.id = product_id
			WHERE storage.action = 'added'
			GROUP BY mes, product_id, year
			ORDER BY year, mes";
		}else {
			$sql = "SELECT SUM(storage.stock) as stock,
			MONTHNAME(storage.date) as mes,
			DATE_FORMAT(storage.date,'%Y') as year,
			products.name as product
			FROM storage
			INNER JOIN products ON products.id = product_id
			WHERE storage.action = 'removed'
			GROUP BY mes, product_id, year
			ORDER BY year, mes";
		}
		
		$res=mysqli_query($conection,$sql);
		
		$mesList=array();
		$stocksArray = array();
		$mesI=0;
		$stockI=0;
		while($data=mysqli_fetch_assoc($res)){
			$mes = ucfirst($data['mes'])." ".$data['year'];
			//Guardar mes sin repetir
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
	
	public function addLog($action)
	{
		session_start();
		
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$date = (new DateTime())->format('Y-m-d H:i:s');
		
		$user = $_SESSION['user_id'];
		$sql="INSERT INTO logs (user_id, action, date) VALUES ('$user', '$action', '$date')";
		
		$res=mysqli_query($conection,$sql);
	}
}
?>