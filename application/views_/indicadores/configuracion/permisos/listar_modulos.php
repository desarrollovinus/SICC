<?php
// Contador
$cont = 1;

// Id de tipo, que diferencia el guardado de módulos y de usuarios
echo '<input type="hidden" id="id_tipo" value ="modulos" />';

// Id de usuario oculto
echo '<input type="hidden" id="id_modulo" value ="'.$id_modulo.'" />';

// Recorrido de las acciones
foreach ($this->configuracion_model->cargar("acciones", $id_modulo) as $accion) {
	// Arreglo vacío
	$permisos = array();
	
	// Se recorre el resultado de la consulta que trae los usuarios con un permisos a una acción específica
	foreach ($this->configuracion_model->cargar("permisos_accion", $accion->Pk_Id) as $permiso) {
		// Se almacena el id del usuario en el arreglo nuevo
		array_push($permisos, $permiso->Fk_Id_Usuario);
	} // foreach
	?>
	
	<div class="col-lg-4">
		<!-- Nombre de la acción -->
		<h2 class="ui header">
			<i class="<?php echo $accion->Icono; ?> icon"></i>
			<div class="content">
				<?php echo $accion->Nombre; ?>
			</div>
		</h2>
		
		<div class="ui list">
			<!-- Recorrido de los usuarios con acceso a la aplicación -->
			<?php foreach ($this->configuracion_model->cargar("usuarios_aplicacion", NULL) as $usuario) { ?>
				<div class="item">
					<!-- <i class="users icon"></i> -->
					<div class="ui checkbox">
						<!-- Si el id del usuario está dentro del arreglo de permisos, lo chequea -->
                    	<?php if(in_array($usuario->Pk_Id, $permisos)) {$check = "checked";} else {$check = "";} ?>
						<input type="checkbox" name="permiso[]" data-accion="<?php echo $accion->Pk_Id; ?>" value="<?php echo $usuario->Pk_Id; ?>"  <?php echo $check; ?>>
						<label><?php echo $usuario->Nombres." ".$usuario->Apellidos; ?></label>
					</div>
				</div>
			<?php } // foreach usuarios ?>
		</div>
	</div>

	<?php
	// Si es el tercer contenedor
	if($cont % 3 == 0){
		// Se resetea para que quede bien ubicado
		echo "<div class='clear'></div>";

		// Divisor
		echo "<div class='ui divider'></div>";
	} // if

	// Aumento del contador
	$cont++;
} // foreach acciones 
?>

<script>
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// // Activación de los checkboxes
        $('.ui.checkbox').checkbox();

		// Se activan los botones
        botones({"guardar": true, "volver": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Configuración de permisos por módulos", 
    		"Active o desactive permisos para cada usuarios, clasificado por´las acciones de cada módulo.",
    		"cube"
		]);
	}); // document.ready
</script>