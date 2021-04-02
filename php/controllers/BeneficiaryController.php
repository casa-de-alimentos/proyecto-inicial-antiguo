<?php
class BeneficiaryController
{
	static public function counts()
	{
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT COUNT(nombre) as users FROM beneficiarys WHERE 1";

		$res=mysqli_query($conection,$sql);
		$data=mysqli_fetch_assoc($res);
		
		return $data['users'];
	}
	
	public function index() {
		//Pedir productos
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT beneficiarys.id as people_id, beneficiarys.cedula, users.name as username, beneficiarys.nombre, beneficiarys.apellido
		FROM beneficiarys 
		LEFT JOIN users ON users.id = beneficiarys.created_by";
		
		$res=mysqli_query($conection,$sql);
		
		$beneficiarys = [];
		while($data=mysqli_fetch_assoc($res)) {
			$beneficiarys[] = $data;
		}
		
		return $beneficiarys;
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
		FROM beneficiarys
		WHERE id='$id'";
		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);
		
		if ($cant <= 0) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'El beneficiario ya no existe';
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

		$sql="SELECT beneficiarys.seguimiento, beneficiarys.cedula, beneficiarys.nombre, beneficiarys.apellido, beneficiarys.nacimiento, beneficiarys.peso, beneficiarys.talla, users.name, beneficiarys.id as people_id, beneficiarys.sexo FROM beneficiarys 
		LEFT JOIN users ON users.id = beneficiarys.created_by
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

		$sql="SELECT * FROM beneficiarys WHERE cedula='$cedula'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant > 0) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'La cedula ya está registrada en el sistema';
			header('location: edit_personas.php');
			return null;
		}
		
		//Verificar seguimiento
		$userId = $_SESSION['user_id'];
		if ($peso <= 0) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'El peso debe ser un número positivo';
			header('location: edit_personas.php');
			return null;
		}
		
		if ($talla <= 0) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'La estatura debe ser un número positivo';
			header('location: edit_personas.php');
			return null;
		}
		$seguimiento = boolval($seguimiento) ? 1 : 0;
		
		// Parse inputs to string SQL
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
		
		$sql="INSERT INTO beneficiarys ($sql_inputs created_by) VALUES ($sql_values '$userId')";
		
		$res=mysqli_query($conection,$sql);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No se pudo añadir al beneficiario';
			header('location: edit_personas.php');
			return null;
		}


		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Beneficiario añadido';
		$this->addLog('Beneficiario '.$nombre.' añadido');
		header('location: administrar_personas.php?mode=ben');
	}
	
	public function edit($id) {
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM beneficiarys WHERE id='$id'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'El beneficiario ya no existe';
			header('location: administrar_personas.php?mode=ben');
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
		$list = ['bono_eventuales', 'bono_lactancia', 'bono_parto', 'bono_jose_gregoreo', 'bono_hogares', 'seguimiento'];
		foreach($list as $value) {
			if ($_POST[$value] === 'on') {
				$sql_inputs_update = $sql_inputs_update."$value='1',";
			}else {
				$sql_inputs_update = $sql_inputs_update."$value='0',";
			}
		}
		
		$sql_inputs_update = substr($sql_inputs_update, 0, -1);
		$sql = "UPDATE beneficiarys SET $sql_inputs_update WHERE id='$id'";
		
		$res=mysqli_query($conection,$sql);
		
		if (!$res) {
			$_SESSION['statusBox'] = 'warning';
			$_SESSION['statusBox_message'] = 'No se pudieron modificar los datos';
			header('location: edit_personas.php?mode=edit&formMode=ben&idEdit='.$id);
			return null;
		}
		
		
		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Datos modificados';
		header('location: edit_personas.php?mode=edit&formMode=ben&idEdit='.$id);
		return null;
	}
	
	public function delete($id)
	{	
		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$id]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Id vacio';
			header('location: administrar_personas.php?mode='.$mode);
			return null;
		}
		
		//restore data
		$db = new DB();
		$conection = $db->conectar();
		$sql="SELECT * FROM beneficiarys
		WHERE id='$id'";

		$res=mysqli_query($conection,$sql);
		$data=mysqli_fetch_assoc($res);
		
		//Consulta
		$sql="DELETE FROM beneficiarys
		WHERE id='$id'";

		$res=mysqli_query($conection,$sql);

		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Beneficiario borrado';
		$this->addLog('Beneficiario '.$data['nombre'].' eliminado');
		header('location: administrar_personas.php?mode=ben');
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
	
	public function clasificationIMC($IMC)
	{
		if (!is_float($IMC)) {
			return array('type' => 'Sin datos que analizar', 'color' => 'grey-text darken-2', 'warning' => 'none');
		}
		
		if ($IMC < 16) {
			return array('type' => 'C', 'color' => 'red-text darken-2', 'warning' => 'grave');
		}else if ($IMC <= 18.49) {
			return array('type' => 'B', 'color' => 'orange-text darken-2', 'warning' => 'leve y moderado');
		}else if ($IMC <=18.9) {
			return array('type' => 'A', 'color' => 'teal-text darken-2', 'warning' => 'moderado');
		}else if ($IMC > 18.9) {
			return array('type' => 'N', 'color' => 'grey-text darken-2', 'warning' => 'normal');
		}
	}
}
?>