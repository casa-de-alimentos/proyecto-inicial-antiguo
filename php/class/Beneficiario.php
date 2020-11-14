<?
/**
 * 
 */
class Beneficiario extends Controlador
{
	public function AddBen()
	{
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$cedula, $name, $ape, $sexo, $fecha]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'Debe rellenar todos los campos';
			$_SESSION['color'] = 'error';
			header('location: edit_beneficiarios.php');
			return null;
		}

		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM Beneficiarios WHERE ben_cedula='$cedula'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant > 0) {
			$_SESSION['statusBox'] = 'found';
			$_SESSION['message'] = 'La cedula ya está registrada en el sistema';
			$_SESSION['color'] = 'warning';
			header('location: edit_beneficiarios.php');
			return null;
		}

		//Verificar seguimiento
		$user=$_SESSION['user'];
		$date = (new DateTime($fecha))->format('Y-m-d');
		if (isset($seguimiento) && $seguimiento) {
			if (isset($peso) && $peso <= 0) {
				$_SESSION['statusBox'] = 'notSet';
				$_SESSION['message'] = 'Debe colocar un peso para poder realizar el seguimiento';
				$_SESSION['color'] = 'warning';
				header('location: edit_beneficiarios.php');
				return null;
			}

			$sql="INSERT INTO Beneficiarios (ben_cedula, ben_nombres, ben_apellidos, ben_sexo, ben_nacimiento, ben_peso, ben_seguimiento,ben_created_by) VALUES ('$cedula', '$name', '$ape', '$sexo', '$date', '$peso', '1', '$user')";
		}else {
			if (isset($peso) && empty($peso)) {
				$sql="INSERT INTO Beneficiarios (ben_cedula, ben_nombres, ben_apellidos, ben_sexo, ben_nacimiento, ben_created_by) VALUES ('$cedula', '$name', '$ape', '$sexo', '$date', '$user')";
			}else {
				$sql="INSERT INTO Beneficiarios (ben_cedula, ben_nombres, ben_apellidos, ben_sexo, ben_nacimiento, ben_peso, ben_created_by) VALUES ('$cedula', '$name', '$ape', '$sexo', '$date', '$peso', '$user')";
			}
		}

		$res=mysqli_query($conection,$sql);

		if (!$res) {
			$_SESSION['statusBox'] = 'sql';
			$_SESSION['message'] = 'No se pudo añadir al beneficiario';
			$_SESSION['color'] = 'error';
			header('location: edit_beneficiarios.php');
			return null;
		}


		$_SESSION['statusBox'] = 'ok';
		$_SESSION['message'] = 'Beneficiario añadido';
		$_SESSION['color'] = 'success';
		header('location: edit_beneficiarios.php');
	}

	public function SearchBen()
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

		$sql="SELECT * FROM Beneficiarios WHERE ben_cedula='$search'";

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

	static function BenCount()
	{
		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM Beneficiarios";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		return $cant;
	}
}
?>