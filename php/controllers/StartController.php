<?php
class StartController
{
	public function start()
	{	
		//Pedir movimientos
		$db = new mysqli('localhost', 'root', '1234') or die 
    ('No conectado');
		
		$db->set_charset("utf8");
		$db->query("SET lc_time_names = 'es_ES'");
		
		$sql="CREATE DATABASE casa_alimentacion";

		$res=mysqli_query($db,$sql);
		if ($res) {
			$db = new mysqli('localhost', 'root', '1234', 'casa_alimentacion') or die 
			('No conectado');

			$db->set_charset("utf8");
			$db->query("SET lc_time_names = 'es_ES'");
			$result = $this->restoreMysqlDB('init_db.sql', $db);
			
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