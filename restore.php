<?php
session_start();
//Verify login
if (!$_SESSION['auth']) {
	header('location: index.php');
}

if ($_SESSION['super_user'] != 1) {
	$_SESSION['statusBox'] = 'error';
	$_SESSION['statusBox_message'] = 'Solo los Super Usuarios pueden hacer esto';

	header('location: respaldar_sistema.php');
	return null;
}

require 'php/DB.php';
$db = new DB();
$conn = $db->conectar();

// CLEAR DB
$sql="DROP TABLE assistance_ben, assistance_emp, beneficiarys, employees, logs, products, storage, users";
$result = mysqli_query($conn, $sql);


if (! empty($_FILES)) {
	// Validating SQL file type by extensions
	if (! in_array(strtolower(pathinfo($_FILES["backup_file"]["name"], PATHINFO_EXTENSION)), array(
			"sql"
	))) {
		$response = array(
			"type" => "warning",
			"message" => "Solo se admiten archivos .sql"
		);
	} else {
		if (is_uploaded_file($_FILES["backup_file"]["tmp_name"])) {
			move_uploaded_file($_FILES["backup_file"]["tmp_name"], $_FILES["backup_file"]["name"]);
			$response = restoreMysqlDB($_FILES["backup_file"]["name"], $conn);
		}
	}
}

$_SESSION['statusBox_message'] = $response['message'];
$_SESSION['statusBox'] = $response['type'];
header('location: respaldar_sistema.php');

function restoreMysqlDB($filePath, $conn)
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
					"type" => "success",
					"message" => "Sistema restaurado correctamente."
			);
		}
	} // end if file exists
	return $response;
}
?>