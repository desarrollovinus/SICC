<h2 class="ui dividing header center aligned">
    Conceptos de medición
</h2>

<div class="table_responsive">
    <table class="table table-striped table-hover" id="tbl_conceptos_medicion">
        <thead>
            <tr>
                <th class="text-center">Nro.</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Descripción</th>
                <th class="text-center" width="5%">
                    <div class="ui checkbox">
                        <input type="checkbox" id="todos" onChange="javascript:seleccionar_todo('tbl_conceptos_medicion')">
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
        	<?php
            // Contador
            $cont = 1;

            // Recorrido de los conceptos de medición
            foreach ($this->configuracion_model->cargar("conceptos_medicion", NULL) as $concepto) {
            ?>
	        	<tr>
                    <td class="text-right"><?php echo $cont++; ?></td>
                    <td><?php if ($concepto->Estado == 1) { echo "Activo"; }else{ echo "Inactivo"; } ?></td>
                    <td><?php echo $concepto->Nombre; ?></td>
	        		<td width="50%"><?php echo $concepto->Descripcion; ?></td>
	        		<td class="text-center" width="50px">
                        <div class="ui checkbox">
                            <input type="checkbox" id="<?php echo $concepto->Pk_Id; ?>" data-nombre="<?php echo $concepto->Nombre; ?>" name="seleccionado" tabindex="0" class="hidden">
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
        $('#tbl_conceptos_medicion').DataTable({
	    	paging: true,
	    	"scrollX": true
		});

		// Se activan los botones
        botones({"crear": true, "volver": true, "editar": true, "eliminar": true});

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
        	"Conceptos de medición", 
        	"Todos los conceptos de medición de las políticas de indicadores.",
        	"resize horizontal"
    	]);
	}); // document.ready
</script>