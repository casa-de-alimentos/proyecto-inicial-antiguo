<?php
class StartController
{
	public function start()
	{	
		$db = new DB();
		$conection = $db->connectWithoutDB();
		
		$sql="CREATE DATABASE casa_alimentacion";

		$res=mysqli_query($conection,$sql);
		if ($res) {
			$db = new DB();
			$conection = $db->conectar();
			
			$result = $this->restoreMysqlDB('init_db.sql', $conection);
			
			$_SESSION['statusBox'] = $result['type'];
			$_SESSION['statusBox_message'] = $result['message'];
		}
	}
	
	public function restoreMysqlDB($filePath, $conn)
	{
		$sql = '';
		$error = '';

		if (file_exists($filePath)) {
			$lines = file($filePath);

			foreach ($lines as $line) {
				// Ignoring comments from the SQL script
				if (substr($line, 0, 2) == '--' || $line == '') {
					continue;
				}

				$sql .= $line;

				if (substr(trim($line), - 1, 1) == ';') {
					$result = mysqli_query($conn, $sql);
					if (! $result) {
						$error .= mysqli_error($conn) . "\n";
					}
					$sql = '';
				}
			} // end foreach

			if ($error) {
				$response = array(
						"type" => "error",
						"message" => $error
				);
			} else {
				$response = array(
						"type" => "info",
						"message" => "Sistema instalado correctamente"
				);
			}
		} // end if file exists
		return $response;
	}
}

$class = new StartController();
$class->start();
?>