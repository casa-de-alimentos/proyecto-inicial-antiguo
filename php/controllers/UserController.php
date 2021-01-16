<?php
class UserController
{
	public function index()
	{
		//Pedir productos
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT id, username, name, super_user FROM users";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			return null;
		}

		//GetData
		$i=0;
		while ($data=mysqli_fetch_assoc($res)) {
			$users[$i] = $data;
			$i++;
		}

    return $users;
	}
	
	public function create()
	{
		extract($_REQUEST);
		
		if ($_SESSION['super_user'] != 1) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Solo los Super Usuarios pueden hacer esto';
			
			header('location: editar_user.php');
			return null;
		}
		
		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$username, $name, $password]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Debe rellenar todos los campos';

			header('location: editar_user.php');
			return null;
		}
		
		//Verificar que no exista el username
		$db = new DB();
		$conection = $db->conectar();
		
		$sql="SELECT * FROM users WHERE username='$username'";
		$res=mysqli_query($conection,$sql);
		$cant=mysqli_num_rows($res);
		
		if ($cant > 0) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'Ya existe una cuenta con ese usuario';
			
    	header('location: editar_user.php');
			return null;
    }
		
		if (!isset($super_user)) {
			$super_user = 0;
		}else {
			$super_user = boolval($super_user);
		}
		$sql="INSERT INTO users (username, name, password, super_user) VALUES ('$username','$name','".password_hash($password, PASSWORD_DEFAULT)."', ".$super_user.")";
		$res=mysqli_query($conection,$sql);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No se pudo crear el usuario';
			
    	header('location: editar_user.php');
			return null;
    }
		
		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Usuario creado';
		$this->addLog("Cuenta +".$username." creada");
			
    header('location: editar_user.php');
	}
	
	public function edit()
	{
		extract($_REQUEST);
		
		if ($_SESSION['super_user'] != 1) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Solo los Super Usuarios pueden hacer esto';
			
			header('location: editar_user.php');
			return null;
		}
		
		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$name, $password, $id]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Debe rellenar todos los campos';

			header('location: editar_user.php');
			return null;
		}
		
		$db = new DB();
		$conection = $db->conectar();
		
		$sql="SELECT * FROM users WHERE id='$id'";
		$res=mysqli_query($conection,$sql);
		$cant=mysqli_num_rows($res);
		
		if ($cant === 0) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'El usuario ya no existe';
			
    	header('location: editar_user.php');
			return null;
    }
		
		$sql="UPDATE users SET name='$name', password='".password_hash($password, PASSWORD_DEFAULT)."' WHERE id='$id'";
		$res=mysqli_query($conection,$sql);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No se pudo actualizar el usuario';
			
    	header('location: editar_user.php');
			return null;
    }
		
		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Usuario actualizado';
		$_SESSION['name'] = $name;
		$this->addLog("Cuenta +".$username." actualizada");
			
    header('location: editar_user.php');
	}
	
	public function delete($id)
	{
		if ($_SESSION['super_user'] != 1) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Solo los Super Usuarios pueden hacer esto';
			
			header('location: editar_user.php');
			return null;
		}
		
		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$id]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Id vacio';

			header('location: editar_user.php');
			return null;
		}
		
		//Verificar que no exista el username
		$db = new DB();
		$conection = $db->conectar();
		
		
		$sql="SELECT * FROM users WHERE id='$id'";
		$res=mysqli_query($conection,$sql);
		$data=mysqli_fetch_assoc($res);
		
		$sql="DELETE FROM users WHERE id='$id'";
		$res=mysqli_query($conection,$sql);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No se pudo eliminar el usuario';
			
			header('location: editar_user.php');
			return null;
		}
		
		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Usuario eliminado';
		$this->addLog("Cuenta +".$data['username']." eliminada");
		
		if ($_SESSION['user_id'] === $id) {
			header('location: logout.php');
		}else {
			header('location: editar_user.php');
		}
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