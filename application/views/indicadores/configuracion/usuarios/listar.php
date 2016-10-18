<h2 class="ui dividing header center aligned">
	Usuarios
</h2>

<div class="table_responsive">
	<table class="table table-striped table-hover" id="tbl_usuarios">
		<thead>
			<tr>
				<th class="text-center">Nro.</th>
				<th class="text-center">Nombres</th>
				<th class="text-center">Apellidos</th>
				<th class="text-center">Estado</th>
				<th class="text-center">Login</th>
				<th class="text-center">Acceso a la aplicación</th>
				<th class="text-center">
					<div class="ui checkbox">
                        <input type="checkbox" id="todos" onChange="javascript:seleccionar_todo('tbl_usuarios')">
                    </div>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Contador
			$cont = 1;

			// Recorrido de las usuarioes funcionales
			foreach ($this->configuracion_model->cargar("usuarios", NULL) as $usuario) {
			?>
				<tr>
					<td class="text-right"><?php echo $cont++; ?></td>
					<td><?php echo $usuario->Nombres; ?></td>
					<td><?php echo $usuario->Apellidos; ?></td>
					<td><?php if ($usuario->Estado == 1) { echo "Activo"; }else{ echo "Inactivo"; } ?></td>
					<td><?php echo $usuario->Login; ?></td>
					<td class="text-center">
						<?php if($usuario->Acceso == 1) {$check = "checked"; $acceso = "Si";} else {$check = ""; $acceso = "No";} ?>
						<div class="ui slider checkbox" onClick="javascrip:accesar('<?php echo $usuario->Pk_Id; ?>', '<?php echo $usuario->Nombres." ".$usuario->Apellidos; ?>');">
							<input type="checkbox" id="check<?php echo $usuario->Pk_Id; ?>" name="acceso" <?php echo $check; ?> >
							<label id="label<?php echo $usuario->Pk_Id; ?>"><?php echo $acceso; ?></label>
						</div>
					</td>
					<td class="text-center" width="50px">
						<div class="ui checkbox">
							<input type="checkbox" id="<?php echo $usuario->Pk_Id; ?>" data-nombre="<?php echo $usuario->Nombres.' '.$usuario->Apellidos; ?>" name="seleccionado" tabindex="0" class="hidden">
						</div>
					</td>
				</tr>
			<?php } // foreach ?>
		</tbody>
	</table>
</div>

<script>
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        $('.ui.checkbox').checkbox();

        // Activación de la tabla
        $('#tbl_usuarios').DataTable({
	    	paging: true,
	    	"scrollX": true
		});

		// Se activan los botones
        botones({"crear": true, "volver": true, "editar": true, "eliminar": true, "historial": true});

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Usuarios", 
    		"Listado de todos los usuarios del sistema Hatoapps.",
    		"users"
		]);
	}); // document.ready
</script>