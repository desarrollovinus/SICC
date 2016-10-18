<h2 class="ui dividing header center aligned">
	Indicadores
</h2>

<div class="table_responsive">
	<table class="table table-striped table-hover" id="tbl_indicadores">
		<thead>
			<tr>
				<th class="text-center">Nro.</th>
				<th class="text-center">Estado</th>
				<th class="text-center">Nombre</th>
				<th class="text-center">Identificador</th>
				<th class="text-center">Norma</th>
				<th class="text-center">Frecuencia máxima</th>
				<th class="text-center">Unidad de medida</th>
				<th class="text-center">
					<div class="ui checkbox">
                        <input type="checkbox" id="todos" onChange="javascript:seleccionar_todo('tbl_indicadores')">
                    </div>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Contador
			$cont = 1;

			// Recorrido de los indicadores
			foreach ($this->indicadores_model->cargar("indicadores", NULL) as $indicador) {
			?>
				<tr>
					<td class="text-right"><?php echo $cont++; ?></td>
					<td><?php if ($indicador->Estado == 1) { echo "Activo"; }else{ echo "Inactivo"; } ?></td>
					<td><?php echo $indicador->Nombre; ?></td>
					<td><?php echo $indicador->Identificador; ?></td>
					<td><?php echo $indicador->Norma; ?></td>
					<td><?php echo $indicador->Periodicidad; ?></td>
					<td><?php echo $indicador->Unidad_Medida; ?></td>
					<td class="text-center" width="50px">
						<div class="ui checkbox">
							<input type="checkbox" id="<?php echo $indicador->Pk_Id; ?>" data-nombre="<?php echo $indicador->Nombre; ?>" name="seleccionado" tabindex="0" class="hidden">
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
        $('#tbl_indicadores').DataTable({
	    	paging: true,
	    	"scrollX": true
		});

		// Se activan los botones
        botones({"crear": true, "volver": true, "editar": true, "eliminar": true, "pdf": true});
        
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
        	"Gestión de indicadores", 
        	"Todos los indicadores del proyecto",
        	"flag"
    	]);
	}); // document.ready
</script>