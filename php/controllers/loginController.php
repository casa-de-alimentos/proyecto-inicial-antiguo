<?php
date_default_timezone_set('America/Caracas');

//Extract request
extract($_REQUEST);

class LoginController
{
	public function login()
	{
		session_start();
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$username, $password]);
		

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Debe rellenar todos los campos';

			header('location: index.php');
			return null;
		}
		
		//Verificar user
		$db = new DB();
		$conection = $db->conectar();
		
		$sql="SELECT * FROM users WHERE username='$username'";

    $res=mysqli_query($conection,$sql);

    $cant=mysqli_num_rows($res);

    if ($cant === 0) {
    	$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'El usuario no existe';
    	header('location: index.php');
    	return null;
    }
		
		//GetData
    $data=mysqli_fetch_assoc($res);
		
		if ($password !== $data['password']) {
    	$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'Contraseña incorrecta';
    	header('location: index.php');
    	return null;
    }
		
		//Registrar login
    session_start();
    session_regenerate_id();

    //Variables
    $_SESSION['auth'] = true;
    $_SESSION['user_id'] = $data['id'];
		$_SESSION['username'] = $data['username'];
		$_SESSION['name'] = $data['name'];
		
		$this->addLog('Inicio de sesión '.$data['username']);

    header('location: panel.php');
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

	static function VerifyEmpty($array)
	{
		$void = false;
		foreach ($array as $key) {
			if (empty($key)) {
				$void = true;
			}
		}
		
		return $void;
	}
}
?>