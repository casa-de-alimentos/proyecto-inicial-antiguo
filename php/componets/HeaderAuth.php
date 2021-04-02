<?php 
$url = $_SERVER['REQUEST_URI'];
$url = explode("/",$url);
$drawerActive = $url[count($url)-1];

//List of Inventario
switch ($drawerActive) {
	case 'edit_produc.php':
		$inventario='active';
		break;
		
	case 'edit_bienes.php':
		$inventario='active';
		break;

	case 'suministros.php':
		$inventario='active';
		break;

	case 'consumo.php':
		$inventario='active';
		break;

	case 'productos_disponibles.php':
		$inventario='active';
		break;
	
	default:
		$inventario = '';
		break;
}

//List of Asistencia
switch ($drawerActive) {
	case 'administrar_personas.php':
		$asistencia='active';
		break;
		
	case 'edit_personas.php':
		$asistencia='active';
		break;

	case 'registrar_asistencia.php':
		$asistencia='active';
		break;

	case 'buscar_asistencia.php':
		$asistencia='active';
		break;
	
	default:
		$asistencia = '';
		break;
}

//List of Administracion
switch ($drawerActive) {
	case 'editar_user.php':
		$administracion='active';
		break;

	case 'movimientos.php':
		$administracion='active';
		break;
		
	case 'respaldar_sistema.php':
		$administracion='active';
		break;
	
	default:
		$administracion = '';
		break;
}

//Items actives
$panel = ($drawerActive === 'panel.php') ? 'active' : '' ;

$editProducts = ($drawerActive==='edit_produc.php') ? 'active' : '' ;
$editBienes = ($drawerActive==='edit_bienes.php') ? 'active' : '' ;
$suministros = ($drawerActive==='suministros.php') ? 'active' : '' ;
$consumo = ($drawerActive==='consumo.php') ? 'active' : '' ;
$productosDisponibles = ($drawerActive==='productos_disponibles.php') ? 'active' : '' ;

$adminPeople = ($drawerActive==='administrar_personas.php' || $drawerActive==='edit_personas.php') ? 'active' : '' ;
$regAsis = ($drawerActive==='registrar_asistencia.php') ? 'active' : '' ;
$searchAsis = ($drawerActive==='buscar_asistencia.php') ? 'active' : '' ;

$editUser = ($drawerActive==='editar_user.php') ? 'active' : '' ;
$movim = ($drawerActive==='movimientos.php') ? 'active' : '' ;
$backup = ($drawerActive==='respaldar_sistema.php') ? 'active' : '' ;
?>
<header>
	<nav>
		<div class="nav-wrapper red darken-1">
			<a href="#" data-target="drawer" class="sidenav-trigger show-on-large"><i class="material-icons">menu</i></a>
			<ul class="right">
				<li><a href="logout.php">Salir</a></li>
			</ul>
		</div>
	</nav>
	
	<ul class="sidenav" id="drawer">
		<li>
			<div class="user-view">
				<div class="background" style="background: #e25a58 !important">
					
				</div>
				<a>
					<img src="img/logoWeb.png" alt="logo" width="80" height="80" style='background: #ffffffc9; border-radius: 20px;' />
				</a>
				<a>
					<span class="white-text name"><?php echo $_SESSION['name'] ?></span>
				</a>
			</div>
		</li>
		
		<li class='<?php echo $panel ?>'>
			<a href="panel.php"><i class="material-icons">home</i>Inicio</a>
		</li>
		
		<li class="no-padding">
			<ul class="collapsible collapsible-accordion">
				<li>
					<li class='<?php echo $inventario ?>'>
					<a class="collapsible-header">Inventario<i class="material-icons">arrow_drop_down</i></a>
					<div class="collapsible-body">
						<ul>
							<li class='<?php echo $editBienes ?>'>
								<a href="edit_bienes.php">
									<i class="material-icons">weekend</i>
									Bienes
								</a>
							</li>
							<li class='<?php echo $editProducts ?>'>
								<a href="edit_produc.php">
									<i class="material-icons">mode_edit</i>
									Administrar productos
								</a>
							</li>
							<li class='<?php echo $suministros ?>'>
								<a href="suministros.php">
									<i class="material-icons">content_paste</i>
									Entrada de suminsitros
								</a>
							</li>
							<li class='<?php echo $consumo ?>'>
								<a href="consumo.php">
									<i class="material-icons">local_dining</i>
									Consumo de suministros
								</a>
							</li>
							<li class='<?php echo $productosDisponibles ?>'>
								<a href="productos_disponibles.php">
									<i class="material-icons">done</i>
									Productos disponibles
								</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</li>
		
		<li class="no-padding">
			<ul class="collapsible collapsible-accordion">
				<li>
					<li class='<?php echo $asistencia ?>'>
					<a class="collapsible-header">Asistencia<i class="material-icons">arrow_drop_down</i></a>
					<div class="collapsible-body">
						<ul>
							<li class='<?php echo $adminPeople ?>'>
								<a href="administrar_personas.php">
									<i class="material-icons">mode_edit</i>
									Administrar Benef/Elab
								</a>
							</li>
							<li class='<?php echo $regAsis ?>'>
								<a href="registrar_asistencia.php">
									<i class="material-icons">playlist_add_check</i>
									Registrar asistencia
								</a>
							</li>
							<li class='<?php echo $searchAsis ?>'>
								<a href="buscar_asistencia.php">
									<i class="material-icons">search</i>
									Buscar asistencia
								</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</li>
		<?php if ($_SESSION['super_user'] == 1): ?>
		<li class="no-padding">
			<ul class="collapsible collapsible-accordion">
				<li>
					<li class='<?php echo $administracion ?>'>
					<a class="collapsible-header">Administrar<i class="material-icons">arrow_drop_down</i></a>
					<div class="collapsible-body">
						<ul>
							<?php if ($_SESSION['super_user'] == 1): ?>
							<li class='<?php echo $editUser ?>'>
								<a href="editar_user.php">
									<i class="material-icons">people</i>
									Administrar usuarios
								</a>
							</li>
							<?php endif ?>
							<?php if ($_SESSION['super_user'] == 1): ?>
							<li class='<?php echo $movim ?>'>
								<a href="movimientos.php">
									<i class="material-icons">computer</i>
									Movimientos
								</a>
							</li>
							<?php endif ?>
							<?php if ($_SESSION['super_user'] == 1): ?>
							<li class='<?php echo $backup ?>'>
								<a href="respaldar_sistema.php">
									<i class="material-icons">restore</i>
									Respaldar/Restaurar sistema
								</a>
							</li>
							<?php endif ?>
						</ul>
					</div>
				</li>
			</ul>
		</li>
		<?php endif ?>
	</ul>
</header>