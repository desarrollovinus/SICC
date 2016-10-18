<?php
// Arreglo vacío
$permisos = array();

// Id de tipo, que diferencia el guardado de módulos y de usuarios
echo '<input type="hidden" id="id_tipo" value ="usuarios" />';

// Id de usuario oculto
echo '<input type="hidden" id="id_usuario" value ="'.$id_usuario.'" />';

// Se recorre el resultado de la consulta que trae los permisos
foreach ($this->configuracion_model->cargar("permisos_usuario", $id_usuario) as $permiso) {
	// Se almacena el id de la acción en el arreglo nuevo
	array_push($permisos, $permiso->Fk_Id_Accion);
} // foreach
?>

<!-- Recorrido de las acciones -->
<?php foreach ($this->configuracion_model->cargar("modulos", NULL) as $modulo) { ?>
	<div class="col-lg-4">
		<!-- Nombre del módulo -->
		<h2 class="ui header">
			<i class="<?php echo $modulo->Icono; ?> icon"></i>
			<div class="content">
				<?php echo $modulo->Nombre; ?>
			</div>
		</h2>

		<div class="ui list">
			<!-- Recorrido de las acciones -->
			<?php foreach ($this->configuracion_model->cargar("acciones", $modulo->Pk_Id) as $accion) { ?>
				<div class="item">
					<div class="ui checkbox">
						<!-- Si el id de la acción está dentro del arreglo de permisos, lo chequea -->
                    	<?php if(in_array($accion->Pk_Id, $permisos)) {$check = "checked";} else {$check = "";} ?>
						<input type="checkbox" name="permiso[]" value="<?php echo $accion->Pk_Id; ?>" <?php echo $check; ?>>

						<label>
							<i class="<?php echo $accion->Icono; ?> icon"></i>
							<?php echo $accion->Nombre; ?>
						</label>
					</div>
				</div>
			<?php } // foreach acciones ?>
		</div>
	</div>
<?php } // foreach módulos ?>

<script>
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        $('.ui.checkbox').checkbox();

		// Se activan los botones
        botones({"guardar": true, "volver": true});
        
        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Configuración de permisos por usuario", 
    		"Active o desactive permisos para un usuario específico.",
    		"user"
		]);
	}); // document.ready
</script>