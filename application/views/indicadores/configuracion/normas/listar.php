<h2 class="ui dividing header center aligned">
	Normatividad del proyecto
</h2>

<div class="table_responsive">
	<table class="table table-striped table-hover" id="tbl_normas">
		<thead>
			<tr>
				<th class="text-center">Nro.</th>
				<th class="text-center">Estado</th>
				<th class="text-center">Nombre</th>
				<th class="text-center">Descripción</th>
				<th class="text-center">
					<div class="ui checkbox">
                        <input type="checkbox" id="todos" onChange="javascript:seleccionar_todo('tbl_normas')">
                    </div>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Contador
			$cont = 1;

			// Recorrido de las normas
			foreach ($this->configuracion_model->cargar("normas", NULL) as $norma) {
			?>
				<tr>
					<td class="text-right"><?php echo $cont++; ?></td>
					<td><?php if ($norma->Estado == 1) { echo "Activo"; }else{ echo "Inactivo"; } ?></td>
					<td><?php echo $norma->Nombre; ?></td>
					<td><?php echo $norma->Descripcion; ?></td>
					<td class="text-center" width="50px">
						<div class="ui checkbox">
							<input type="checkbox" id="<?php echo $norma->Pk_Id; ?>" data-nombre="<?php echo $norma->Nombre; ?>" name="seleccionado" tabindex="0" class="hidden">
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
        $('#tbl_normas').DataTable({
	    	paging: true,
	    	"scrollX": true
		});

		// Se activan los botones
        botones({"crear": true, "volver": true, "editar": true, "eliminar": true});
        
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
        	"Normatividad", 
        	"Todas las normas aplicables al proyecto",
        	"book"
    	]);
	}); // document.ready
</script>