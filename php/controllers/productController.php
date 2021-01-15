<?php
class ProductController
{
	public function index() {
		//Pedir productos
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM products";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			return null;
		}

		//GetData
		$i=0;
		while ($data=mysqli_fetch_assoc($res)) {
			$productos[$i] = $data;
			$i++;
		}

    return $productos;
	}
	
	public function create()
	{
		extract($_REQUEST);
		
		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$name, $stock]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Debe rellenar todos los campos';

			header('location: edit_produc.php');
			return null;
		}
		
		if ($stock <= 0) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'La cantidad debe ser mayor a 0';
			
			header('location: edit_produc.php');
			return null;
		}
		
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="INSERT INTO products (name, stock, medida) VALUES ('$name', '$stock', '$medida')";
		
		$res=mysqli_query($conection,$sql);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No se pudo añadir el producto';
			
    	header('location: edit_produc.php');
			return null;
    }

		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Producto añadido';
		
		$this->addLog("Producto ".$name." añadido");

    header('location: edit_produc.php');
	}
	
	public function edit()
	{
		extract($_REQUEST);
		
		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$name, $stock]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Debe rellenar todos los campos';

			header("location: edit_produc.php?edit=$id");
			return null;
		}
		
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="UPDATE products SET name='$name', stock='$stock', medida='$medida' WHERE id='$id'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'El producto no existe';
			header("location: edit_produc.php?edit=$id");
			return null;
		}
		
		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Producto actualizado';
		
		$this->addLog("Producto ".$name." actualizado");
		
		header('location: edit_produc.php');
	}
	
	public function delete($id)
	{	
		//Consulta
		$db = new DB();
		$conection = $db->conectar();
		
		$sql="SELECT * FROM products WHERE id='$id'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);
		
		//GetData
    $data_producto=mysqli_fetch_assoc($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'El producto no existe';
			header('location: edit_produc.php');
			return null;
		}
		
		$sql="DELETE FROM products WHERE id='$id'";

    $res=mysqli_query($conection,$sql);
		
		 if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No se pudo eliminar el producto';
			header('location: edit_produc.php');
			return null;
    }
		
		//Limpiar storage
		$sql="DELETE FROM storage WHERE product_id='$id'";

    $res=mysqli_query($conection,$sql);

		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Producto eliminado';
		
		$this->addLog("Producto ".$data_producto['name']." eliminado");

    header('location: edit_produc.php');
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