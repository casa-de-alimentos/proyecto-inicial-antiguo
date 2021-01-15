<?php
$url = $_SERVER['REQUEST_URI'];
$url = explode("/",$url);
$drawerActive = $url[count($url)-1];

//List of Inventario
switch ($drawerActive) {
	case 'edit_produc.php':
		$Inventario='active';
		break;

	case 'suministros.php':
		$Inventario='active';
		break;

	case 'preparar_comida.php':
		$Inventario='active';
		break;

	case 'productos_disponibles.php':
		$Inventario='active';
		break;
	
	default:
		$Inventario = '';
		break;
}

//List of Asistencia
switch ($drawerActive) {
	case 'edit_beneficiarios.php':
		$Asistencia='active';
		break;

	case 'edit_empleado.php':
		$Asistencia='active';
		break;

	case 'registrar_asistencia.php':
		$Asistencia='active';
		break;

	case 'buscar_asistencia.php':
		$Asistencia='active';
		break;
	
	default:
		$Asistencia = '';
		break;
}

//List of Administracion
switch ($drawerActive) {
	case 'editar_user.php':
		$Administracion='active';
		break;

	case 'movimientos.php':
		$Administracion='active';
		break;
	
	default:
		$Administracion = '';
		break;
}
?>

<div id="drawer">
  <header class="drawerMenu">
    <i id="closeDrawer" class="material-icons" title="menu">close</i>
  </header>
	<div class="contenedor">
		<div class="userInfo">
			<img src="" alt="" width="70" height="70" />
			<span><? echo $_SESSION['user'] ?></span>
		</div>
		<hr/>
		<div class="menu">
			<? $panel = ($drawerActive==='panel.php') ? 'active' : '' ; ?>
			<a href="panel.php" class="agrupItem <? echo $panel ?>">
				<i class="material-icons" title="menu">home</i>
				Inicio
			</a>
			<span class="agrupItem openSubmenu <? echo $Inventario ?>" data-open="inv">
				<i class="material-icons" title="menu">chrome_reader_mode</i>
				Inventario
			</span>
			<div id="inv" class="subMenu">
				<? $editPrducts = ($drawerActive==='edit_produc.php') ? 'active' : '' ; ?>
				<a href="edit_produc.php" class="agrupItem <? echo $editPrducts ?>">
					<i class="material-icons" title="menu">mode_edit</i>
					Editar produtos
				</a>
				<? $suministros = ($drawerActive==='suministros.php') ? 'active' : '' ; ?>
				<a href="suministros.php" class="agrupItem <? echo $suministros ?>">
					<i class="material-icons" title="menu">content_paste</i>
					Entrada de suminsitros
				</a>
				<? $consumo = ($drawerActive==='preparar_comida.php') ? 'active' : '' ; ?>
				<a href="preparar_comida.php" class="agrupItem <? echo $consumo ?>">
					<i class="material-icons" title="menu">local_dining</i>
					Preparar comida
				</a>
				<? $productosDisponibles = ($drawerActive==='productos_disponibles.php') ? 'active' : '' ; ?>
				<a href="productos_disponibles.php" class="agrupItem <? echo $productosDisponibles ?>">
					<i class="material-icons" title="menu">done</i>
					Productos disponibles
				</a>
			</div>
			<span class="agrupItem openSubmenu <? echo $Asistencia ?>" data-open="assis">
				<i class="material-icons" title="menu">list</i>
				Asistencia
			</span>
			<div id="assis" class="subMenu">
				<? $addBenef = ($drawerActive==='edit_beneficiarios.php') ? 'active' : '' ; ?>
				<a href="edit_beneficiarios.php" class="agrupItem <? echo $addBenef ?>">
					<i class="material-icons" title="menu">mode_edit</i>
					Añadir Beneficiario
				</a>
				<? $addEmp = ($drawerActive==='edit_empleado.php') ? 'active' : '' ; ?>
				<a href="edit_empleado.php" class="agrupItem <? echo $addEmp ?>">
					<i class="material-icons" title="menu">mode_edit</i>
					Añadir Empleado
				</a>
				<? $regAsis = ($drawerActive==='registrar_asistencia.php') ? 'active' : '' ; ?>
				<a href="registrar_asistencia.php" class="agrupItem <? echo $regAsis ?>">
					<i class="material-icons" title="menu">playlist_add_check</i>
					Registrar asistencia
				</a>
				<? $searchAsis = ($drawerActive==='buscar_asistencia.php') ? 'active' : '' ; ?>
				<a href="buscar_asistencia.php" class="agrupItem <? echo $searchAsis ?>">
					<i class="material-icons" title="menu">search</i>
					Buscar persona
				</a>
			</div>
			<span class="agrupItem openSubmenu <? echo $Administracion ?>" data-open="admin">
				<i class="material-icons" title="menu">update</i>
				Administracion
			</span>
			<div id="admin" class="subMenu">
				<? $editUser = ($drawerActive==='editar_user.php') ? 'active' : '' ; ?>
				<a href="editar_user.php" class="agrupItem <? echo $editUser ?>">
					<i class="material-icons" title="menu">mode_edit</i>
					Editar usuarios
				</a>
				<? $movim = ($drawerActive==='movimientos.php') ? 'active' : '' ; ?>
				<a href="movimientos.php" class="agrupItem <? echo $movim ?>">
					<i class="material-icons" title="menu">computer</i>
					Movimientos
				</a>
			</div>
			<span class="agrupItem openSubmenu">
				<i class="material-icons" title="menu">update</i>
				Ayuda
			</span>
		</div>
	</div>
</div>