<div class="table_responsive">
	<table class="table table-striped table-hover" id="tbl_registros">
		<thead>
			<tr>
				<th class="text-center">Nro.</th>
				<th class="text-center">Anotación</th>
				<th class="text-center"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Contador
			$cont = 1;

			// Recorrido de la bitácora
			foreach ($this->operaciones_bitacora_model->cargar("registros", NULL) as $registro) {
			?>
				<tr>
					<td class="text-right"><?php echo $cont++; ?></td>
					<td><?php echo $registro->Anotacion; ?></td>
					<td class="text-center" width="50px">
						<div class="ui checkbox">
							<input type="checkbox" id="<?php echo $registro->Pk_Id; ?>" name="seleccionado" tabindex="0" class="hidden">
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
        $('#tbl_registros').DataTable({
	    	paging: true,
	    	"scrollX": true
		});

		// Se activan los botones
        // botones({"crear": true, "volver": true, "editar": true, "eliminar": true});
        
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
       /* mostrar_mensaje_pie([
        	"estado", 
        	"Normatividad", 
        	"Todas las normas aplicables al proyecto",
        	"book"
    	]);*/
	}); // document.ready
</script>