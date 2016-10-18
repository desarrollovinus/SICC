<div class="table_responsive">
	<table class="table table-striped table-hover" id="tbl_logs">
		<thead>
			<tr>
				<th class="text-center">Nro.</th>

				<!-- Si no se eligió un módulo -->
				<?php if ($id_modulo == "") { ?>
					<!-- Se muestra -->
					<th class="text-center">Módulo</th>
				<?php } // if ?>

				<!-- Si no se eligió un módulo -->
				<?php if ($id_accion == "") { ?>
					<!-- Se muestra -->
					<th class="text-center">Acción</th>
				<?php } // if ?>

				<th class="text-center">Fecha</th>
				<th class="text-center">Hora</th>
				<th class="text-center">Antigüedad</th>
				<th class="text-center">Descripción</th>
				<th class="text-center">Observación</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Contador
			$cont = 1;

			// Recorrido de las unidades funcionales
			foreach ($this->configuracion_model->cargar("logs_usuario", array("Fk_Id_Usuario" => $id_usuario, "Fk_Id_Modulo" => $id_modulo, "Fk_Id_Accion" => $id_accion)) as $log) {
			?>
				<tr>
					<td class="text-right"><?php echo $cont++; ?></td>

					<!-- Si no se eligió un módulo -->
					<?php if ($id_modulo == "") { ?>
						<!-- Se muestra -->
						<td><?php echo $log->Modulo; ?></td>
					<?php } // if ?>

					<!-- Si no se eligió un módulo -->
					<?php if ($id_accion == "") { ?>
						<!-- Se muestra -->
						<td><?php echo $log->Accion; ?></td>
					<?php } // if ?>

					<td><?php echo $log->Fecha_Creacion; ?></td>
					<td><?php echo $log->Fecha_Creacion; ?></td>
					<td><?php echo $log->Fecha_Creacion; ?></td>
					<td><?php echo $log->Descripcion; ?></td>
					<td><?php echo $log->Observacion; ?></td>
				</tr>
			<?php } // foreach ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
        // Activación de la tabla
        $('#tbl_logs').DataTable({
	    	paging: true,
	    	"scrollX": true
		});

		// Se activan los botones
        botones({"volver": true});
        
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
        	"Historial", 
        	"Seleccione un módulo y/o una acción para filtrar resultados.",
        	"list layout"
    	]);
	}); // document.ready
</script>