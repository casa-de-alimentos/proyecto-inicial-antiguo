<?php
/**
 * 
 */
class Asistencias extends Controlador
{
	public function RegisterAsisB()
	{
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$reg]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'No se pudo encontrar una cedula para registrar';
			$_SESSION['color'] = 'error';
			return null;
		}

		//Verificar existencia
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM Beneficiarios WHERE ben_cedula='$reg'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'notFound';
			$_SESSION['message'] = 'La cedula no está registrada en el sistema';
			$_SESSION['color'] = 'error';
			header('location: registrar_asistencia.php?search='.$reg);
			return null;
		}

		//Verificar que no se haya registrado HOY
		$sql="SELECT * FROM AsistenciaBen WHERE asb_beneficiario='$reg' ORDER BY asb_date DESC LIMIT 1";

		$res=mysqli_query($conection,$sql);
		$dataAsis=mysqli_fetch_assoc($res);

		$date = (new DateTime())->format('Y-m-d');
		if ($dataAsis['asb_date'] === $date) {
			$_SESSION['statusBox'] = 'register';
			$_SESSION['message'] = 'La cedula ya fue registrada en la asistencia de hoy';
			$_SESSION['color'] = 'error';
			header('location: registrar_asistencia.php');
			return null;
		}

		//Insertar asistencia
		$dataUser=mysqli_fetch_assoc($res);

		if (!$dataUser['ben_peso'] && $dataUser['ben_seguimiento']) {
			$peso = 'NULL';
		}else {
			$peso = $dataUser['ben_peso'];
		}

		$sql="INSERT INTO AsistenciaBen (asb_date, asb_peso, asb_beneficiario) VALUES ('$date',NULL,'$reg')";

		$res=mysqli_query($conection,$sql);

		if (!$res) {
			$_SESSION['statusBox'] = 'sql';
			$_SESSION['message'] = $sql;
			$_SESSION['color'] = 'error';
			header('location: registrar_asistencia.php?search='.$reg);
			return null;
		}

		//Ok
		$_SESSION['statusBox'] = 'ok';
		$_SESSION['message'] = 'Asistencia añadida';
		$_SESSION['color'] = 'success';
		header('location: registrar_asistencia.php');
	}

	public function RegisterAsisP()
	{
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$reg]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'No se pudo encontrar una cedula para registrar';
			$_SESSION['color'] = 'error';
			return null;
		}

		//Verificar existencia
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM Empleados WHERE emp_cedula='$reg'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'notFound';
			$_SESSION['message'] = 'La cedula no está registrada en el sistema';
			$_SESSION['color'] = 'error';
			header('location: registrar_asistencia.php?search='.$reg);
			return null;
		}

		//Verificar que no se haya registrado HOY
		$sql="SELECT * FROM AsistenciaEmp WHERE asp_empleado='$reg' ORDER BY asp_date DESC LIMIT 1";

		$res=mysqli_query($conection,$sql);
		$dataAsis=mysqli_fetch_assoc($res);

		$date = (new DateTime())->format('Y-m-d');
		if ($dataAsis['asp_date'] === $date) {
			$_SESSION['statusBox'] = 'register';
			$_SESSION['message'] = 'La cedula ya fue registrada en la asistencia de hoy';
			$_SESSION['color'] = 'error';
			header('location: registrar_asistencia.php');
			return null;
		}

		//Insertar asistencia
		$sql="INSERT INTO AsistenciaEmp (asp_date, asp_empleado) VALUES ('$date','$reg')";

		$res=mysqli_query($conection,$sql);

		if (!$res) {
			$_SESSION['statusBox'] = 'sql';
			$_SESSION['message'] = $sql;
			$_SESSION['color'] = 'error';
			header('location: registrar_asistencia.php?search='.$reg);
			return null;
		}

		//Ok
		$_SESSION['statusBox'] = 'ok';
		$_SESSION['message'] = 'Asistencia añadida';
		$_SESSION['color'] = 'success';
		header('location: registrar_asistencia.php');
	}

	public function SearchAsisBen()
	{
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$person]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'Debe rellenar todos los campos';
			$_SESSION['color'] = 'error';
			return null;
		}

		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM AsistenciaBen WHERE asb_beneficiario='$person' ORDER BY asb_date DESC LIMIT 10";

		$res=mysqli_query($conection,$sql);

		$i=0;
		while($data=mysqli_fetch_assoc($res)) {
			$fechas[$i] = $data;
			$i++;
		}

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'notFound';
			$_SESSION['message'] = 'No hay asistencias registradas en el sistema';
			$_SESSION['color'] = 'error';
			return null;
		}

		$_SESSION['statusBox'] = '';
		$_SESSION['message'] = '';
		$_SESSION['color'] = '';
		return $fechas;
	}

	public function SearchAsisEmp()
	{
		extract($_REQUEST);

		//Verify data
		$verifyEmpty = Controlador::VerifyEmpty([$person]);

		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'empty';
			$_SESSION['message'] = 'Debe rellenar todos los campos';
			$_SESSION['color'] = 'error';
			return null;
		}

		//Consulta
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM AsistenciaEmp WHERE asp_empleado='$person' ORDER BY asp_date DESC LIMIT 10";

		$res=mysqli_query($conection,$sql);

		$i=0;
		while($data=mysqli_fetch_assoc($res)) {
			$fechas[$i] = $data;
			$i++;
		}

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'notFound';
			$_SESSION['message'] = 'No hay asistencias registradas en el sistema';
			$_SESSION['color'] = 'error';
			return null;
		}

		$_SESSION['statusBox'] = '';
		$_SESSION['message'] = '';
		$_SESSION['color'] = '';
		return $fechas;
	}
}
?>