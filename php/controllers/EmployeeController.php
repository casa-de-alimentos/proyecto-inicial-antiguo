<?php
class EmployeeController
{
	static public function counts()
	{
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT COUNT(nombre) as users FROM employees WHERE 1";

		$res=mysqli_query($conection,$sql);
		$data=mysqli_fetch_assoc($res);
		
		return $data['users'];
	}
	
	public function show()
	{
		extract($_REQUEST);
		
		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$search]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Debe rellenar todos los campos';
			return null;
		}
		
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT employees.cedula, employees.nombre, employees.apellido, employees.nacimiento, users.name, employees.id as people_id, employees.sexo, employees.telefono FROM employees 
		LEFT JOIN users ON users.id = employees.created_by
		WHERE cedula='$search'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);
		
		if ($cant <= 0) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No hay nadie registrado con esa cédula';
			return null;
		}
		
		$data=mysqli_fetch_assoc($res);
		
		unset($_SESSION['statusBox']);
		unset($_SESSION['statusBox_message']);
		return $data;
	}
	
	public function create()
	{
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$cedula, $nombre, $apellido, $sexo, $fecha]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Debe rellenar todos los campos';

			header('location: edit_elaborador.php');
			return null;
		}
		
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM employees WHERE cedula='$cedula'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant > 0) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'La cedula ya está registrada en el sistema';
			header('location: edit_elaborador.php');
			return null;
		}
		
		//Añadir empleado
		$date = (new DateTime($fecha))->format('Y-m-d');
		$user = $_SESSION['user_id'];
		$sql="INSERT INTO employees (cedula, nombre, apellido, sexo, nacimiento, telefono, created_by) VALUES ('$cedula', '$nombre', '$apellido', '$sexo', '$date', '$telefono', '$user')";
		
		$res=mysqli_query($conection,$sql);

		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No se pudo añadir al empleado';
			header('location: edit_elaborador.php');
			return null;
		}


		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Empleado añadido';
		$this->addLog('Elaborador '.$nombre.' añadido');
		header('location: edit_elaborador.php');
	}
	
	public function delete($id)
	{	
		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$id]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Id vacio';
			header('location: delete_personas.php');
			return null;
		}
		
		//restore data
		$db = new DB();
		$conection = $db->conectar();
		$sql="SELECT * FROM employees
		WHERE id='$id'";

		$res=mysqli_query($conection,$sql);
		$data=mysqli_fetch_assoc($res);
		
		
		//Consulta
		$sql="DELETE FROM employees
		WHERE id='$id'";

		$res=mysqli_query($conection,$sql);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'El empleado ya no existe';
			header('location: delete_personas.php');
			return null;
		}

		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Empleado borrado';
		
		$this->addLog('Elaborador '.$data['nombre'].' eliminado');
		header('location: delete_personas.php');
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