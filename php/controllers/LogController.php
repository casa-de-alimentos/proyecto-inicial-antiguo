<?php
class LogController
{
	public function index()
	{
		//Pedir movimientos
		$db = new DB();
		$conection = $db->conectar();

		$sql="SELECT logs.date, logs.action, users.name FROM logs
		LEFT JOIN users ON users.id = logs.user_id
		ORDER BY date DESC";

		$res=mysqli_query($conection,$sql);

		$cant=mysqli_num_rows($res);

		if ($cant === 0) {
			return null;
		}

		//GetData
		$i=0;
		while ($data=mysqli_fetch_assoc($res)) {
			$logs[$i] = $data;
			$i++;
		}

    return $logs;
	}
}
?>