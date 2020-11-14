<?php
date_default_timezone_set('America/Caracas');
//Includes
include('DB.php');

//Extract request
extract($_REQUEST);

class Controlador
{
	//options
	static function options($option)
	{
		$controller = new Controlador();

		switch ($option) {
			case 'login':
				$controller->login();
				break;

			case 'registerProduct':
				$controller->registerProduct();
				break;

			case 'editProduct':
				$controller->editProduct();
				break;
			
			default:
				?>
        <script type="text/javascript">
          alert("Error al intentar realizar esa acción.");
          windows.location = "PersonasControlador.php?operacion=index";
        </script>
        <?php
				break;
		}
	}

	public function login()
	{
		session_start();
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$user, $pass]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'Debe rellenar todos los campos';
			$_SESSION['color'] = 'error';

			header('location: index.php');
			return null;
		}

		//Verificar user
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM Usuarios WHERE user_id='$user'";

    $res=mysqli_query($conection,$sql);

    $cant=mysqli_num_rows($res);

    if ($cant === 0) {
    	$_SESSION['statusBox'] = 'notExist';
			$_SESSION['message'] = 'El usuario no existe';
			$_SESSION['color'] = 'warning';
    	header('location: index.php');
    	return null;
    }

    //GetData
    $data=mysqli_fetch_assoc($res);

    if ($pass !== $data['user_pass']) {
    	$_SESSION['statusBox'] = 'credentials';
			$_SESSION['message'] = 'Contraseña incorrecta';
			$_SESSION['color'] = 'error';
    	header('location: index.php');
    	return null;
    }

    //Registrar login
    session_start();
    session_regenerate_id();

    //Variables
    $_SESSION['auth'] = true;
    $_SESSION['user'] = $data['user_id'];

    header('location: panel.php');
	}

	public function addLog($action)
	{
		session_start();
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$date = (new DateTime())->format('Y-m-d');
		$user = $_SESSION['user'];
		$sql="INSERT INTO Movimientos (mov_user, mov_action, mov_date) VALUES ('$user', '$action', '$date')";
		$res=mysqli_query($conection,$sql);
	}

	public function getLogs()
	{
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$date = (new DateTime())->format('Y-m-d');
		$user = $_SESSION['user'];
		$sql="SELECT * FROM Movimientos ORDER BY mov_id DESC";
		$res=mysqli_query($conection,$sql);

		$i=0;
		while($data=mysqli_fetch_assoc($res)) {
			$logs[$i] = $data;
			$i++;
		}

		return $logs;
	}

	static function VerifyEmpty($array)
	{
		foreach ($array as $key) {
			if (empty($key)) {
				return true;
			}
		}
		return false;
	}
}
?>