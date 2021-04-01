<?php
class AssistanceEmpController
{
	public function search()
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

		$sql="SELECT employees.cedula, employees.nombre, employees.apellido, employees.nacimiento, users.name, employees.id as people_id, employees.sexo, employees.nacionalidad, employees.serial_patria, employees.codigo_patria, employees.direccion, employees.comunidad, employees.parroquia, employees.cantidad_de_hijos, employees.telef_local, employees.telef_celular, employees.estudiante, employees.grado_instruccion, employees.desea_estudiar, employees.que_desea_estudiar, employees.habilidad_posee, employees.inscrito_CNE, employees.ejerce_voto, employees.centro_electoral, employees.enfermedad, employees.discapacidad, employees.codigo_carnet_discapacidad, employees.embarazada, employees.fecha_embarazo, employees.fecha_parto, employees.bono_eventuales, employees.bono_lactancia, employees.bono_parto, employees.bono_jose_gregoreo, employees.bono_hogares, employees.pencionado, employees.pencionado_por, employees.orga_social_politica
		FROM employees 
		LEFT JOIN users ON users.id = employees.created_by
		WHERE cedula='$search'";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);
		
		if ($cant <= 0) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'No hay nadie registrado con esa cédula';
			return null;
		}
		
		$dataPeople=mysqli_fetch_assoc($res);
		
		// Asistencias
		$sql = "SELECT * FROM assistance_emp WHERE employee_id = ".$dataPeople['people_id']." ORDER BY date DESC";
		
		$res=mysqli_query($conection,$sql);
		
		$dataAsis = array();
		while($data=mysqli_fetch_assoc($res)) {
			array_push($dataAsis, array($data['date'], $data['id']));
		}
		
		$MasterArray = array($dataPeople, $dataAsis);
		
		unset($_SESSION['statusBox']);
		unset($_SESSION['statusBox_message']);
		return $MasterArray;
	}
	
	public function create($id)
	{
		//Verify data
		$verifyEmpty = LoginController::VerifyEmpty([$id]);
		
		if ($verifyEmpty) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'Id vacio';
			
			header('location: registrar_asistencia.php');
			return null;
		}
		
		//Verificar existencia
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT * FROM employees WHERE id='$id'";

		$res=mysqli_query($conection,$sql);
		$dataUsed=mysqli_fetch_assoc($res);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'La cedula no está registrada en el sistema';
			
			header('location: registrar_asistencia.php');
			return null;
		}
		
		//Verificar que no se haya registrado HOY
		$sql="SELECT * FROM assistance_emp WHERE employee_id='$id' ORDER BY date DESC LIMIT 1";

		$res=mysqli_query($conection,$sql);
		$dataAsis=mysqli_fetch_assoc($res);

		$date = (new DateTime())->format('Y-m-d');
		if ($dataAsis['date'] === $date) {
			$_SESSION['statusBox'] = 'error';
			$_SESSION['statusBox_message'] = 'La cedula ya fue registrada en la asistencia de hoy';
			
			header('location: registrar_asistencia.php');
			return null;
		}
		
		//Insertar asistencia
		$sql="INSERT INTO assistance_emp (date, employee_id) VALUES ('$date','$id')";

		$res=mysqli_query($conection,$sql);

		if (!$res) {
			$_SESSION['statusBox'] = 'error';
		$_SESSION['statusBox_message'] = 'No se pudo registrar la asistencia';
			header('location: registrar_asistencia.php');
			return null;
		}

		//Ok
		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Asistencia añadida';
		$this->addLog('Asistencia del empleado '.$dataUsed['nombre']);
		header('location: registrar_asistencia.php');
	}
	
	public function delete($id, $cedula)
	{
		///Consulta
		$db = new DB();
		$conection = $db->conectar();
		
		$sql="DELETE FROM assistance_emp WHERE id='$id'";
		$res=mysqli_query($conection,$sql);
		
		$_SESSION['statusBox'] = 'success';
		$_SESSION['statusBox_message'] = 'Asistencia eliminada';
		header('location: buscar_asistencia.php?action&search='.$cedula);
	}
	
	static public function counts()
	{
		///Consulta
		$db = new DB();
		$conection = $db->conectar();
		
		$sql="SELECT COUNT(assistance_emp.id) as users,
			MONTHNAME(assistance_emp.date) as mes,
			DATE_FORMAT(assistance_emp.date,'%Y') as year
			FROM assistance_emp
			GROUP BY mes, year
			ORDER BY year, mes";
		
		$res=mysqli_query($conection,$sql);
		$request=[];
		while($data=mysqli_fetch_assoc($res)){
			$data['mes'] = ucfirst($data['mes']);
			$request[] = $data;
		}
		
		return json_encode($request);
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