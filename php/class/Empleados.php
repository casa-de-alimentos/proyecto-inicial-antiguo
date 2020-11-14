<?
/**
 * 
 */
class Empleados extends Controlador
{
	public function AddEmp()
	{
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$cedula, $name, $ape, $sexo, $fecha, $telef]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'Debe rellenar todos los campos';
			$_SESSION['color'] = 'error';
			header('location: edit_empleado.php');
			return null;
		}

		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM Empleados WHERE emp_cedula='$cedula'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant > 0) {
			$_SESSION['statusBox'] = 'found';
			$_SESSION['message'] = 'La cedula ya está registrada en el sistema';
			$_SESSION['color'] = 'warning';
			header('location: edit_empleado.php');
			return null;
		}

		//Añadir empleado
		$date = (new DateTime($fecha))->format('Y-m-d');
		$user=$_SESSION['user'];
		$sql="INSERT INTO Empleados (emp_cedula, emp_nombres, emp_apellidos, emp_sexo, emp_nacimiento, emp_telef, emp_created_by) VALUES ('$cedula', '$name', '$ape', '$sexo', '$date', '$telef', '$user')";

		$res=mysqli_query($conection,$sql);

		if (!$res) {
			$_SESSION['statusBox'] = 'sql';
			$_SESSION['message'] = 'No se pudo añadir al empleado';
			$_SESSION['color'] = 'error';
			header('location: edit_empleado.php');
			return null;
		}


		$_SESSION['statusBox'] = 'ok';
		$_SESSION['message'] = 'Empleado añadido';
		$_SESSION['color'] = 'success';
		header('location: edit_empleado.php');
	}

	public function SearchEmp()
	{
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$search]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'Debe rellenar todos los campos';
			$_SESSION['color'] = 'error';
			return null;
		}

		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM Empleados WHERE emp_cedula='$search'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'notFound';
			$_SESSION['message'] = 'La cedula no está registrada en el sistema';
			$_SESSION['color'] = 'error';
			return null;
		}

		$data=mysqli_fetch_assoc($res);

		$_SESSION['statusBox'] = '';
		$_SESSION['message'] = '';
		$_SESSION['color'] = '';
		return $data;
	}

	static function EmpCount()
	{
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM Empleados";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		return $cant;
	}
}
?>