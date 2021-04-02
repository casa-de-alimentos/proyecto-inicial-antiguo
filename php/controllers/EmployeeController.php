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
	
	public function index() {
		//Pedir productos
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT employees.id as people_id, employees.cedula, users.name as username, employees.nombre, employees.apellido
		FROM employees
		LEFT JOIN users ON users.id = employees.created_by";
		
		$res=mysqli_query($conection,$sql);
		
		$employees = [];
		while($data=mysqli_fetch_assoc($res)) {
			$employees[] = $data;
		}
		
		return $employees;
	}
	
	public function find($id) {
		$verifyEmpty = LoginController::VerifyEmpty([$id]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'ID vacio';
			return null;
		}
		
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT *
		FROM employees
		WHERE id='$id'";
		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);
		
		if ($cant <= 0) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'El empleado ya no existe';
			return null;
		}
		
		$data=mysqli_fetch_assoc($res);
		
		return $data;
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
		
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM employees WHERE cedula='$cedula'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant > 0) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'La cedula ya está registrada en el sistema';
			header('location: edit_personas.php?mode=elab');
			return null;
		}
		
		// Parse inputs to string SQL
		$userId = $_SESSION['user_id'];
		$sql_inputs = '';
		$sql_values = '';
		foreach($_POST as $key => $value) {
			if (strlen($value) > 0) {
				$sql_inputs= $sql_inputs."$key,";
				if ($value === 'on') {
					$sql_values= $sql_values."'1',";
				} else if ($key === 'nacimiento' || $key === 'fecha_embarazo' || $key === 'fecha_parto') {
					$date = (new DateTime($value))->format('Y-m-d');
					$sql_values= $sql_values."'$date',";
				}else {
					$sql_values= $sql_values."'$value',";
				}
			}
		}
		
		$sql="INSERT INTO employees ($sql_inputs created_by) VALUES ($sql_values '$userId')";

		$res=mysqli_query($conection,$sql);

		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No se pudo añadir al empleado';
			header('location: edit_personas.php?mode=elab');
			return null;
		}


		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Elaborador añadido';
		$this->addLog('Elaborador '.$cedula.' añadido');
		header('location: administrar_personas.php?mode=elab');
	}
	
	public function edit($id) {
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM employees WHERE id='$id'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'El elaborador ya no existe';
			header('location: administrar_personas.php?mode=elab');
			return null;
		}
		
		// Parse inputs to string SQL
		$userId = $_SESSION['user_id'];
		$sql_inputs_update = '';
		foreach($_POST as $key => $value) {
			if (strlen($value) > 0) {
				if ($value === 'on') {
					// skip
				}else if ($key === 'id') {
					// skip
				} else if ($key === 'nacimiento' || $key === 'fecha_embarazo' || $key === 'fecha_parto') {
					$date = (new DateTime($value))->format('Y-m-d');
					$sql_inputs_update= $sql_inputs_update."$key='$date',";
				}else {
					$sql_inputs_update= $sql_inputs_update."$key='$value',";
				}
			}else if ($key === 'action') {
				// skip
			}else {
				$sql_inputs_update = $sql_inputs_update."$key=NULL,";
			}
		}
		
		// Verify checkboxes
		$list = ['bono_eventuales', 'bono_lactancia', 'bono_parto', 'bono_jose_gregoreo', 'bono_hogares'];
		foreach($list as $value) {
			if ($_POST[$value] === 'on') {
				$sql_inputs_update = $sql_inputs_update."$value='1',";
			}else {
				$sql_inputs_update = $sql_inputs_update."$value='0',";
			}
		}
		
		$sql_inputs_update = substr($sql_inputs_update, 0, -1);
		$sql = "UPDATE employees SET $sql_inputs_update WHERE id='$id'";
		
		$res=mysqli_query($conection,$sql);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'No se pudieron modificar los datos';
			header('location: edit_personas.php?mode=edit&formMode=elab&idEdit='.$id);
			return null;
		}
		
		
		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Datos modificados';
		$this->addLog('Elaborador '.$_POST['cedula'].' actualizados');
		header('location: edit_personas.php?mode=edit&formMode=elab&idEdit='.$id);
		return null;
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
			$_SESSION['statusBox_message'] = 'El elaborador ya no existe';
			header('location: delete_personas.php');
			return null;
		}

		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Elaborador borrado';
		
		$this->addLog('Elaborador '.$data['cedula'].' eliminado');
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