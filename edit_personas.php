<?php 
	require 'php/DB.php';
	require 'php/controllers/loginController.php';
	require 'php/controllers/BeneficiaryController.php';
	require 'php/controllers/EmployeeController.php';

	//Init session
	session_start();

	//Verify login
	if (!$_SESSION['auth']) {
		header('location: index.php');
	}

	// Form mode
	if (isset($_GET['formMode']) && $_GET['formMode'] === 'elab') {
		$formMode = 'elab';
	}else {
		$formMode = 'ben';
	}

	// Search in edit mode
	if (isset($mode) && $mode === 'edit' && $formMode === 'ben') {
		$controller = new BeneficiaryController();
		$people = $controller->find($idEdit);
	}else if (isset($mode) && $mode === 'edit' && $formMode === 'elab') {
		$controller = new EmployeeController();
		$people = $controller->find($idEdit);
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

	// Form add
	if (isset($action) && $mode === 'add' && $formMode === 'ben') {
		$controller = new BeneficiaryController();
		
		$controller->create();
	}else if (isset($action) && $mode === 'add' && $formMode === 'elab') {
		$controller = new EmployeeController();
		
		$controller->create();
	}

	// Form edit
	if (isset($action) && $mode === 'edit' && $formMode === 'ben') {
		$controller = new BeneficiaryController();
		
		$controller->edit($idEdit);
	}else if (isset($action) && $mode === 'edit' && $formMode === 'elab') {
		$controller = new EmployeeController();
		
		$controller->edit($idEdit);
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Panel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="css/roboto.css" />
	<link rel="stylesheet" href="css/materialize.min.css">
	<link href="css/materialize-icons.css" rel="stylesheet">
</head>
<body>
	<?php require('php/componets/HeaderAuth.php') ?>
	
	<main class='container'>
		<div class="row">
			<div class='col s12'>
				<h5><?php echo $mode === 'add' ? 'Añadir' : 'Modificar' ?> <?php echo $formMode === 'elab' ? 'Elaborador' : 'Beneficiario' ?></h5>
			</div>
			
			<div class='col s12'>
				<a class="btn waves-effect red lighten-1" href='administrar_personas.php?mode=<?php echo $formMode ?>'>Regresar</a>
			</div>
			
			<div class="col s12">
				<form method="POST" action="#" autocomplete='off'>
					<div class="card">
						<div class="card-content">
							<div>
								<?php if ($mode === 'edit'): ?>
								<input type='hidden' name='id' value='<?php echo $people['id'] ?>' />
								<?php endif ?>
								<div class="input-field col s12 m6">
									<select name='nacionalidad'>
										<option value="" disabled <?php echo isset($people['nacionalidad']) ? '' : 'selected' ?>>Seleccione una opción</option>
										<option value="V" <?php echo $people['nacionalidad'] === 'V' ? 'selected' : '' ?>>Venezolano</option>
										<option value="E" <?php echo $people['nacionalidad'] === 'E' ? 'selected' : '' ?>>Extranjero</option>
									</select>
									<label>* Nacionalidad</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="cedula" 
										type="number" 
										name="cedula"
										min="1000000"
										value='<?php echo $people['cedula'] ?>'
										required
									/>
									<label for="cedula">* Cédula</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="nombre" 
										type="text" 
										name="nombre"
										minlength="3"
										value='<?php echo $people['nombre'] ?>'
										required
									/>
									<label for="nombre">* Nombres</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="apellido" 
										type="text" 
										name="apellido"
										minlength="3"
										value='<?php echo $people['apellido'] ?>'
										required
									/>
									<label for="apellido">* Apellidos</label>
								</div>
								<div class="input-field col s12 m6">
									<select name='sexo'>
										<option value="" disabled <?php echo isset($people['nacionalidad']) ? '' : 'selected' ?>>Seleccione una opción</option>
										<option value="F" <?php echo $people['sexo'] === 'F' ? 'selected' : '' ?>>Femenino</option>
										<option value="M" <?php echo $people['sexo'] === 'M' ? 'selected' : '' ?>>Masculino</option>
									</select>
									<label>* Género</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="fecha" type="text" name="nacimiento" class="datepicker" required value='<?php echo $people['nacimiento'] ?>'>
									<label for="fecha">* Fecha de nacimiento</label>
								</div>
								<?php if ($formMode === 'ben') : ?>
								<div class="input-field col s12 m6">
									<input id="peso" 
										type="number" 
										name="peso"
										step="0.01"
										value='<?php echo $people['peso'] ?>'
										required
									/>
									<label for="peso">* Peso actual (Ejem: 50.30)</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="talla" 
										type="number" 
										name="talla"
										step="0.01"
										value='<?php echo $people['talla'] ?>'
										required
									/>
									<label for="talla">* Estatura actual (Ejem: 1.75)</label>
								</div>
								<div class="col s12">
									<div class="switch">
										<label class="tooltipped" data-position="bottom" data-tooltip="Al activar esta funcionalidad tendrá que registrar el peso y la estatura cada 90 días">
											<input type="checkbox" name="seguimiento" <?php echo $people['seguimiento'] ? 'checked' : '' ?>>
											<span class="lever"></span>
											Activar seguimiento de nutrición
										</label>
									</div>
								</div>
								<?php endif ?>
								<div class='col s12 center-align' style='margin-bottom: 10px;'>
									<button 
										class="btn waves-effect red lighten-1" type="submit" name="action"
									>
										<?php echo $mode === 'add' ? 'Añadir' : 'Modificar' ?>
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
										min="1000000"
										value='<?php echo $people['serial_patria'] ?>'
										required
									/>
									<label for="serial">* Serial de patria</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="codigo_patria" 
										type="number" 
										name="codigo_patria"
										value='<?php echo $people['codigo_patria'] ?>'
										min="1000000"
										required
									/>
									<label for="codigo_patria">* Código de patria</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="direccion" 
										type="text" 
										name="direccion"
										value='<?php echo $people['direccion'] ?>'
										required
									/>
									<label for="direccion">* Dirección</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="comunidad" 
										type="text" 
										name="comunidad"
										value='<?php echo $people['comunidad'] ?>'
										required
									/>
									<label for="comunidad">* Comunidad</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="parroquia" 
										type="text" 
										name="parroquia"
										value='<?php echo $people['parroquia'] ?>'
										required
									/>
									<label for="comunidad">* Parroquia</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="hijos" 
										type="number" 
										name="cantidad_de_hijos"
										value='<?php echo $people['cantidad_de_hijos'] ?>'
										required
									/>
									<label for="hijos">* Cantidad de hijos</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="telef_local" 
										type="tel" 
										name="telef_local"
										minlength="10"
										value='<?php echo $people['telef_local'] ?>'
										maxlength="11"
									/>
									<label for="telef_local">Teléfono local</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="telef_celular" 
										type="tel" 
										name="telef_celular"
										minlength="10"
										maxlength="11"
										value='<?php echo $people['telef_celular'] ?>'
										required
									/>
									<label for="telef_celular">* Teléfono celular</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="enfermedad"
										type="text" 
										name="enfermedad"
										value='<?php echo $people['enfermedad'] ?>'
									/>
									<label for="enfermedad">¿Posee alguna enfermedad? Indique</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="discapacidad"
										type="text" 
										name="discapacidad"
										value='<?php echo $people['discapacidad'] ?>'
									/>
									<label for="discapacidad">¿Posee alguna discapacidad? Indique</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="codigo_carnet_discapacidad"
										type="text" 
										name="codigo_carnet_discapacidad"
										minlength='6'
										value='<?php echo $people['codigo_carnet_discapacidad'] ?>'
									/>
									<label for="codigo_carnet_discapacidad">¿Posee carnet de discapacidad? Indique</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="orga_social_politica"
										type="text" 
										name="orga_social_politica"
										value='<?php echo $people['orga_social_politica'] ?>'
									/>
									<label for="orga_social_politica">¿Organización social o politica a la que pertenece?</label>
								</div>
								<div class="col s12 m6">
									<span>* ¿Está embarazada?</span>
									<div style='display: flex;'>
										<p style='margin-right: 8px'>
											<label>
												<input class="with-gap" name="embarazada" type="radio" value='Si' <?php echo $people['embarazada'] === 'Si' ? 'checked' : '' ?> />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="embarazada" type="radio" value='No' <?php echo ($people['embarazada'] === 'No' || $mode === 'add') ? 'checked' : '' ?> />
												<span>No</span>
											</label>
										</p>
									</div>
								</div>
								<div class="input-field col s12 m6">
									<input id="fecha_embarazo" type="text" name="fecha_embarazo" class="datepicker" value='<?php echo $people['fecha_embarazo'] ?>'>
									<label for="fecha_embarazo">Fecha de embarazo</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="fecha_parto" type="text" name="fecha_parto" class="datepicker" value='<?php echo $people['fecha_parto'] ?>'>
									<label for="fecha_parto">Fecha de parto</label>
								</div>
								<div class="col s12 m6" style='margin: 19px 0;'>
									<span>* ¿Está pencionado?</span>
									<div style='display: flex;'>
										<p style='margin-right: 8px'>
											<label>
												<input class="with-gap" name="pencionado" type="radio" value='Si' <?php echo $people['pencionado'] === 'Si' ? 'checked' : '' ?> />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="pencionado" type="radio" value='No' <?php echo ($people['pencionado'] === 'No' || $mode === 'add') ? 'checked' : '' ?> />
												<span>No</span>
											</label>
										</p>
									</div>
								</div>
								<div class="input-field col s12 m6">
									<select name='pencionado_por'>
										<option value="" disabled <?php echo isset($people['pencionado_por']) ? '' : 'selected' ?>>Seleccione una opción</option>
										<option value="Amor mayor" <?php echo $people['pencionado_por'] === 'Amor mayor' ? 'selected' : '' ?>>Amor mayor</option>
										<option value="Iviss" <?php echo $people['pencionado_por'] === 'E' ? 'Iviss' : '' ?>>Iviss</option>
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
												<input class="with-gap" name="estudiante" type="radio" value='Si' <?php echo $people['estudiante'] === 'Si' ? 'checked' : '' ?> />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="estudiante" type="radio" value='No' <?php echo ($people['estudiante'] === 'No' || $mode === 'add') ? 'checked' : '' ?> />
												<span>No</span>
											</label>
										</p>
									</div>
								</div>
								<div class="input-field col s12 m6">
									<input id="grado_instruccion" 
										type="text" 
										name="grado_instruccion"
										value='<?php echo $people['grado_instruccion'] ?>'
									/>
									<label for="grado_instruccion">Grado de instrucción</label>
								</div>
								<div class="col s12 m6">
									<span>* ¿Desea estudiar?</span>
									<div style='display: flex;'>
										<p style='margin-right: 8px'>
											<label>
												<input class="with-gap" name="desea_estudiar" type="radio" value='Si' <?php echo $people['desea_estudiar'] === 'Si' ? 'checked' : '' ?> />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="desea_estudiar" type="radio" value='No' <?php echo ($people['desea_estudiar'] === 'No' || $mode === 'add') ? 'checked' : '' ?> />
												<span>No</span>
											</label>
										</p>
									</div>
								</div>
								<div class="input-field col s12 m6">
									<input id="que_desea_estudiar" 
										type="text" 
										name="que_desea_estudiar"
										value='<?php echo $people['que_desea_estudiar'] ?>'
									/>
									<label for="que_desea_estudiar">¿Qué desea estudiar?</label>
								</div>
								<div class="input-field col s12 m6">
									<input id="habilidad_posee" 
										type="text" 
										name="habilidad_posee"
										value='<?php echo $people['habilidad_posee'] ?>'
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
												<input class="with-gap" name="inscrito_CNE" type="radio" value='Si' <?php echo $people['inscrito_CNE'] === 'Si' ? 'checked' : '' ?> />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="inscrito_CNE" type="radio" value='No' <?php echo ($people['inscrito_CNE'] === 'No' || $mode === 'add') ? 'checked' : '' ?> />
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
												<input class="with-gap" name="ejerce_voto" type="radio" value='Si' <?php echo $people['ejerce_voto'] === 'Si' ? 'checked' : '' ?> />
												<span>Si</span>
											</label>
										</p>
										<p>
											<label>
												<input class="with-gap" name="ejerce_voto" type="radio" value='No' <?php echo ($people['ejerce_voto'] === 'No' || $mode === 'add') ? 'checked' : '' ?> />
												<span>No</span>
											</label>
										</p>
									</div>
								</div>
								<div class="input-field col s12 m6">
									<input id="centro_electoral" 
										type="text" 
										name="centro_electoral"
										value='<?php echo $people['centro_electoral'] ?>'
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
												<input type="checkbox" name='bono_eventuales' <?php echo $people['bono_eventuales'] ? 'checked' : '' ?> />
												<span>Eventuales</span>
											</label>
										</p>
										<p class='col s12 m6 l4'>
											<label>
												<input type="checkbox" name='bono_lactancia' <?php echo $people['bono_lactancia'] ? 'checked' : '' ?> />
												<span>Lactancia materna</span>
											</label>
										</p>
										<p class='col s12 m6 l4'>
											<label>
												<input type="checkbox" name='bono_parto' <?php echo $people['bono_parto'] ? 'checked' : '' ?> />
												<span>Parto humanizado</span>
											</label>
										</p>
										<p class='col s12 m6 l4'>
											<label>
												<input type="checkbox" name='bono_jose_gregoreo' <?php echo $people['bono_jose_gregoreo'] ? 'checked' : '' ?> />
												<span>José Gregoreo</span>
											</label>
										</p>
										<p class='col s12 m6 l4'>
											<label>
												<input type="checkbox" name='bono_hogares' <?php echo $people['bono_hogares'] ? 'checked' : '' ?> />
												<span>Hogares de la patria</span>
											</label>
										</p>
									</div>
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
  <script src="js/materialize.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/statusBox.js"></script>
</body>
</html>