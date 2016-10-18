<h2 class="ui dividing header center aligned">
	Unidades de medida
</h2>

<div class="table_responsive">
	<table class="table table-striped table-hover" id="tbl_unidades_medida">
		<thead>
			<tr>
				<th class="text-center">Nro.</th>
				<th class="text-center">Estado</th>
				<th class="text-center">Nombre</th>
				<th class="text-center">Código</th>
				<th class="text-center">
					<div class="ui checkbox">
                        <input type="checkbox" id="todos" onChange="javascript:seleccionar_todo('tbl_unidades_medida')">
                    </div>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Contador
			$cont = 1;

			// Recorrido de las unidades funcionales
			foreach ($this->configuracion_model->cargar("unidades_medida", NULL) as $unidad) {
			?>
				<tr>
					<td class="text-right"><?php echo $cont++; ?></td>
					<td><?php if ($unidad->Estado == 1) { echo "Activo"; }else{ echo "Inactivo"; } ?></td>
					<td><?php echo $unidad->Nombre; ?></td>
					<td><?php echo $unidad->Codigo; ?></td>
					<td class="text-center" width="50px">
						<div class="ui checkbox">
							<input type="checkbox" id="<?php echo $unidad->Pk_Id; ?>" data-nombre="<?php echo $unidad->Nombre; ?>" name="seleccionado" tabindex="0" class="hidden">
						</div>
					</td>
				</tr>
			<?php } // foreach ?>
		</tbody>
	</table>
</div>


<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        $('.ui.checkbox').checkbox();
        
        // Activación de la tabla
        $('#tbl_unidades_medida').DataTable({
	    	paging: true,
	    	"scrollX": true
		});

		// Se activan los botones
        botones({"crear": true, "volver": true, "editar": true, "eliminar": true});
        
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
        	"Unidades de medida", 
        	"Todas las unidades de medida aplicables a los indicadores",
        	"dashboard"
    	]);
	}); // document.ready
</script>