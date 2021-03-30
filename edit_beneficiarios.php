<?php 
	require 'php/DB.php';
	require 'php/controllers/loginController.php';
	require 'php/controllers/BeneficiaryController.php';
	//Init session
	session_start();

	//Verify login
	if (!$_SESSION['auth']) {
		header('location: index.php');
	}

	//StatusBox
	if(isset($_SESSION['statusBox'])) {
		$dataStatus = array(
			'message' => $_SESSION['statusBox_message'],
			'status' => $_SESSION['statusBox'],
		);
		
		unset($_SESSION['statusBox']);
		unset($_SESSION['statusBox_message']);
	}

	//Form
	if (isset($action)) {
		$controller = new BeneficiaryController();
		
		$controller->create();
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Panel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
	<?php require('php/componets/HeaderAuth.php') ?>
	
	<main class='container'>
		<div class="row">
			<div class='col s12'>
				<h5>Añadir beneficiario</h5>
			</div>
			
			<div class="col s12">
				<form method="POST" action="#" autocomplete='off'>
					<div class="card">
						<div class="card-content">
							<div>
								<div class="input-field col s12 m6">
									<select name='nacionalidad'>
										<option value="" disabled selected >Seleccione una opción</option>
										<option value="V">Venezolano</option>
										<option value="E">Extranjero</option>
									</select>
									<label>* Nacionalidad</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="cedula" 
										type="text" 
										name="cedula"
										required
									/>
									<label for="cedula">* Cédula</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="nombre" 
										type="text" 
										name="nombre"
										required
									/>
									<label for="nombre">* Nombres</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="apellido" 
										type="text" 
										name="apellido"
										required
									/>
									<label for="apellido">* Apellidos</label>
								</div>
								<div class="input-field col s12 m6">
									<select name='sexo'>
										<option value="" disabled selected >Seleccione una opción</option>
										<option value="F">Femenino</option>
										<option value="M">Masculino</option>
									</select>
									<label>* Género</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="fecha" type="text" name="nacimiento" class="datepicker" required>
									<label for="fecha">* Fecha de nacimiento</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="peso" 
										type="number" 
										name="peso"
										step="0.01"
										required
									/>
									<label for="peso">* Peso actual</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="talla" 
										type="number" 
										name="talla"
										step="0.01"
										required
									/>
									<label for="talla">* Estatura actual (en metros)</label>
								</div>
								<div class="col s12">
									<div class="switch">
										<label class="tooltipped" data-position="bottom" data-tooltip="Al activar esta funcionalidad tendrá que registrar el peso y la estatura cada 90 días">
											<input type="checkbox" name="seguimiento">
											<span class="lever"></span>
											Activar seguimiento de nutrición
										</label>
									</div>
								</div>
								<div class='col s12 center-align' style='margin-bottom: 10px;'>
									<button 
										class="btn waves-effect red lighten-1" type="submit" name="action"
									>
										Añadir
									</button>
								</div>
							</div>
						</div>
						<div class="card-tabs">
							<ul class="tabs tabs-fixed-width">
								<li class="tab"><a class="active" href="#personales">Personales</a></li>
								<li class="tab"><a href="#estudios">Estudios</a></li>
								<li class="tab"><a href="#CNE">CNE</a></li>
								<li class="tab"><a href="#bonos">Bonos</a></li>
							</ul>
						</div>
						<div class="card-content grey lighten-4">
							<div id="personales" class='row'>
								<div class="input-field col s12 m6">
									<input id="serial" 
										type="number" 
										name="serial_patria"
										required
									/>
									<label for="serial">* Serial de patria</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="codigo_patria" 
										type="number" 
										name="codigo_patria"
										required
									/>
									<label for="codigo_patria">* Código de patria</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="direccion" 
										type="text" 
										name="direccion"
										required
									/>
									<label for="direccion">* Dirección</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="comunidad" 
										type="text" 
										name="comunidad"
										required
									/>
									<label for="comunidad">* Comunidad</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="parroquia" 
										type="text" 
										name="parroquia"
										required
									/>
									<label for="comunidad">* Parroquia</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="hijos" 
										type="number" 
										name="cantidad_de_hijos"
										required
									/>
									<label for="hijos">* Cantidad de hijos</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="telef_local" 
										type="tel" 
										name="telef_local"
									/>
									<label for="telef_local">Teléfono local</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="telef_celular" 
										type="tel" 
										name="telef_celular"
										required
									/>
									<label for="telef_celular">* Teléfono celular</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="enfermedad"
										type="text" 
										name="enfermedad"
									/>
									<label for="enfermedad">¿Si posee alguna enfermedad cuál seria?</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="discapacidad"
										type="text" 
										name="discapacidad"
									/>
									<label for="discapacidad">¿Si posee alguna discapacidad cuál seria?</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="codigo_carnet_discapacidad"
										type="number" 
										name="codigo_carnet_discapacidad"
									/>
									<label for="codigo_carnet_discapacidad">Código del carnet de discapacidad</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="orga_social_politica"
										type="text" 
										name="orga_social_politica"
									/>
									<label for="orga_social_politica">¿Organización social o politica a la que pertenece?</label>
								</div>
								<div class="col s12 m6">
									<span>* ¿Está embarazada?</span>
									<div style='display: flex;'>
										<p style='margin-right: 8px'>
											<label>
												<input class="with-gap" name="embarazada" type="radio" value='Si' />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="embarazada" type="radio" value='No' checked />
												<span>No</span>
											</label>
										</p>
									</div>
								</div>
								<div class="input-field col s12 m6">
									<input id="fecha_embarazo" type="text" name="fecha_embarazo" class="datepicker">
									<label for="fecha_embarazo">Fecha de embarazo</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="fecha_parto" type="text" name="fecha_parto" class="datepicker">
									<label for="fecha_parto">Fecha de parto</label>
								</div>
								<div class="col s12 m6" style='margin: 19px 0;'>
									<span>* ¿Está pencionado?</span>
									<div style='display: flex;'>
										<p style='margin-right: 8px'>
											<label>
												<input class="with-gap" name="pencionado" type="radio" value='Si' />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="pencionado" type="radio" value='No' checked />
												<span>No</span>
											</label>
										</p>
									</div>
								</div>
								<div class="input-field col s12 m6">
									<select name='pencionado_por'>
										<option value="" disabled selected >Seleccione una opción</option>
										<option value="Amor mayor">Amor mayor</option>
										<option value="Iviss">Iviss</option>
									</select>
									<label>¿Cobra por?</label>
								</div>
							</div>
							<div id="estudios" class='row'>
								<div class="col s12 m6">
									<span>* ¿Es estudiante?</span>
									<div style='display: flex;'>
										<p style='margin-right: 8px'>
											<label>
												<input class="with-gap" name="estudiante" type="radio" value='Si' />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="estudiante" type="radio" value='No' checked />
												<span>No</span>
											</label>
										</p>
									</div>
								</div>
								<div class="input-field col s12 m6">
									<input id="grado_instruccion" 
										type="text" 
										name="grado_instruccion"
									/>
									<label for="grado_instruccion">Grado de instrucción</label>
								</div>
								<div class="col s12 m6">
									<span>* ¿Desea estudiar?</span>
									<div style='display: flex;'>
										<p style='margin-right: 8px'>
											<label>
												<input class="with-gap" name="desea_estudiar" type="radio" value='Si' />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="desea_estudiar" type="radio" value='No' checked />
												<span>No</span>
											</label>
										</p>
									</div>
								</div>
								<div class="input-field col s12 m6">
									<input id="que_desea_estudiar" 
										type="text" 
										name="que_desea_estudiar"
									/>
									<label for="que_desea_estudiar">¿Qué desea estudiar?</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="habilidad_posee" 
										type="text" 
										name="habilidad_posee"
									/>
									<label for="habilidad_posee">¿Qué habilidad posee?</label>
								</div>
							</div>
							<div id="CNE" class='row'>
								<div class="col s12 m6">
									<span>* ¿Está inscrito en CNE?</span>
									<div style='display: flex;'>
										<p style='margin-right: 8px'>
											<label>
												<input class="with-gap" name="inscrito_CNE" type="radio" value='Si' />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="inscrito_CNE" type="radio" value='No' checked />
												<span>No</span>
											</label>
										</p>
									</div>
								</div>
								<div class="col s12 m6">
									<span>* ¿Ejerce el voto?</span>
									<div style='display: flex;'>
										<p style='margin-right: 8px'>
											<label>
												<input class="with-gap" name="ejerce_voto" type="radio" value='Si' />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="ejerce_voto" type="radio" value='No' checked />
												<span>No</span>
											</label>
										</p>
									</div>
								</div>
								<div class="input-field col s12 m6">
									<input id="centro_electoral" 
										type="text" 
										name="centro_electoral"
									/>
									<label for="centro_electoral">Centro electoral</label>
								</div>
							</div>
							<div id="bonos" class='row'>
								<div id="CNE" class='row'>
								<div class="col s12">
									<span>¿Recibe bonos eventuales?</span>
									<div>
										<p class='col s12 m6 l4'>
											<label>
												<input type="checkbox" name='bono_eventuales' />
												<span>Eventuales</span>
											</label>
										</p>
										<p class='col s12 m6 l4'>
											<label>
												<input type="checkbox" name='bono_lactancia' />
												<span>Lactancia materna</span>
											</label>
										</p>
										<p class='col s12 m6 l4'>
											<label>
												<input type="checkbox" name='bono_parto' />
												<span>Parto humanizado</span>
											</label>
										</p>
										<p class='col s12 m6 l4'>
											<label>
												<input type="checkbox" name='bono_jose_gregoreo' />
												<span>José Gregoreo</span>
											</label>
										</p>
										<p class='col s12 m6 l4'>
											<label>
												<input type="checkbox" name='bono_hogares' />
												<span>Hogares de la patria</span>
											</label>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			
		</div>
		
		<input type='hidden' id='js_statusBox' value='<?php echo json_encode($dataStatus) ?>' />
	</main>
	
	<script src="js/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/statusBox.js"></script>
</body>
</html>