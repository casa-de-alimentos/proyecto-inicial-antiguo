<?php
class BienesController
{
	public function index() {
		//Pedir productos
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM bienes";

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

			header('location: edit_bienes.php');
			return null;
		}
		
		if ($stock <= 0) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'La cantidad debe ser mayor a 0';
			
			header('location: edit_bienes.php');
			return null;
		}
		
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="INSERT INTO bienes (name, stock) VALUES ('$name', '$stock')";
		
		$res=mysqli_query($conection,$sql);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No se pudo añadir';
			
    	header('location: edit_bienes.php');
			return null;
    }

		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Añadido';
		
		$this->addLog("Bien añadido: ".$name);

    header('location: edit_bienes.php');
	}
	
	public function edit()
	{
		extract($_REQUEST);
		
		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$name, $stock]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Debe rellenar todos los campos';

			header("location: edit_bienes.php?edit=$id");
			return null;
		}
		
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="UPDATE bienes SET name='$name', stock='$stock' WHERE id='$id'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Este bien no existe';
			header("location: edit_bienes.php?edit=$id");
			return null;
		}
		
		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Bien actualizado';
		
		$this->addLog("Bien actualizado: ".$name);
		
		header('location: edit_bienes.php');
	}
	
	public function delete($id)
	{	
		//Consulta
		$db = new DB();
		$conection = $db->conectar();
		
		$sql="SELECT * FROM bienes WHERE id='$id'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);
		
		//GetData
    $data_producto=mysqli_fetch_assoc($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'El bien no existe';
			header('location: edit_bienes.php');
			return null;
		}
		
		$sql="DELETE FROM bienes WHERE id='$id'";

    $res=mysqli_query($conection,$sql);
		
		 if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No se pudo eliminar el bien';
			header('location: edit_bienes.php');
			return null;
    }
		
		$this->addLog("Bien eliminado: ".$data_producto['name']);

    header('location: edit_bienes.php');
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