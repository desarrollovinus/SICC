<h2 class="ui dividing header center aligned">
	Periodicidades
</h2>

<div class="table_responsive">
	<table class="table table-striped table-hover" id="tbl_periodicidades">
		<thead>
			<tr>
				<th class="text-center">Nro.</th>
				<th class="text-center">Estado</th>
				<th class="text-center">Nombre</th>
				<th class="text-center">Código</th>
				<th class="text-center">Días</th>
				<th class="text-center">
					<div class="ui checkbox">
                        <input type="checkbox" id="todos" onChange="javascript:seleccionar_todo('tbl_periodicidades')">
                    </div>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Contador
			$cont = 1;

			// Recorrido de las periodicidades
			foreach ($this->configuracion_model->cargar("periodicidades", NULL) as $periodicidad) {
			?>
				<tr>
					<td class="text-right"><?php echo $cont++; ?></td>
					<td><?php if ($periodicidad->Estado == 1) { echo "Activo"; }else{ echo "Inactivo"; } ?></td>
					<td><?php echo $periodicidad->Nombre; ?></td>
					<td><?php echo $periodicidad->Codigo; ?></td>
					<td class="text-right"><?php echo $periodicidad->Dias; ?></td>
					<td class="text-center" width="50px">
						<div class="ui checkbox">
							<input type="checkbox" id="<?php echo $periodicidad->Pk_Id; ?>" data-nombre="<?php echo $periodicidad->Nombre; ?>" name="seleccionado" tabindex="0" class="hidden">
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
        $('#tbl_periodicidades').DataTable({
	    	paging: true,
	    	"scrollX": true
		});

		// Se activan los botones
        botones({"crear": true, "volver": true, "editar": true, "eliminar": true});
        
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
        	"Periodicidades", 
        	"Todas los lapsos de tiempo aplicables al proyecto",
        	"wait"
    	]);
	}); // document.ready
</script>