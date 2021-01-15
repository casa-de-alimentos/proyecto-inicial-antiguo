<?php
//Includes
include('php/controlador.php');

class Productos extends Controlador
{
	public function registerProduct()
	{
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$name, $stock]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'Debe rellenar todos los campos';
			$_SESSION['color'] = 'error';
			header('location: edit_produc.php');
			return null;
		}

		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="INSERT INTO Productos (prod_name, prod_stock, prod_medida) VALUES ('$name', '$stock', '$medida')";

    $res=mysqli_query($conection,$sql);

    if (!$res) {
    	$_SESSION['statusBox'] = 'sql';
			$_SESSION['message'] = 'No se pudo añadir el producto';
			$_SESSION['color'] = 'error';
    	header('location: edit_produc.php');
			return null;
    }

    $_SESSION['statusBox'] = 'ok';
		$_SESSION['message'] = 'Producto añadido';
		$_SESSION['color'] = 'success';
		$this->addLog("producto $name registrado");

    header('location: edit_produc.php');
	}

	public function editProduct()
	{
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$name, $stock, $medida]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'Debe rellenar todos los campos';
			$_SESSION['color'] = 'error';
			header('location: edit_produc.php');
			return null;
		}

		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM Productos WHERE prod_id='$id'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		$dataResp=mysqli_fetch_assoc($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'notExist';
			$_SESSION['message'] = 'El producto no existe';
			$_SESSION['color'] = 'error';
			header('location: edit_produc.php');
			return null;
		}

		$sql="UPDATE Productos SET prod_name='$name', prod_stock='$stock', prod_medida='$medida' WHERE prod_id='$id'";

    $res=mysqli_query($conection,$sql);

    if (!$res) {
    	$_SESSION['statusBox'] = 'sql';
			$_SESSION['message'] = 'No se pudo actualizar el producto';
			$_SESSION['color'] = 'error';
			header('location: edit_produc.php');
			return null;
    }

    $_SESSION['statusBox'] = 'ok';
		$_SESSION['message'] = 'Producto actualizado';
		$_SESSION['color'] = 'success';

		$product = $dataResp['prod_name'];
		$this->addLog("producto $product actualizado");

    header('location: edit_produc.php');
	}

	public function deleteProduct($id)
	{
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM Productos WHERE prod_id='$id'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'notExist';
			$_SESSION['message'] = 'El producto no existe';
			$_SESSION['color'] = 'error';
			header('location: edit_produc.php');
			return null;
		}

		$sql="DELETE FROM Productos WHERE prod_id='$id'";

    $res=mysqli_query($conection,$sql);

    if (!$res) {
    	$_SESSION['statusBox'] = 'sql';
			$_SESSION['message'] = 'No se pudo eliminar el producto';
			$_SESSION['color'] = 'error';
			header('location: edit_produc.php');
			return null;
    }

    $_SESSION['statusBox'] = 'ok';
		$_SESSION['message'] = 'Producto eliminado';
		$_SESSION['color'] = 'success';

		$product = $dataResp['prod_name'];
		$this->addLog("producto $product eliminado");

    header('location: edit_produc.php');
	}

	static function getProductsList()
	{
		//Pedir productos
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM Productos";

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
}
?>