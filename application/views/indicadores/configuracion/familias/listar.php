<h2 class="ui dividing header center aligned">
    Familias
</h2>

<div class="table_responsive">
    <table class="table table-striped table-hover" id="tbl_familias">
        <thead>
            <tr>
                <th class="text-center">Nro.</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Código</th>
                <th class="text-center">
                    <div class="ui checkbox">
                        <input type="checkbox" id="todos" onChange="javascript:seleccionar_todo('tbl_familias')">
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Contador
            $cont = 1;

            // Recorrido de las familias
            foreach ($this->configuracion_model->cargar("familias", NULL) as $familia) {
            ?>
                <tr>
                    <td class="text-right"><?php echo $cont++; ?></td>
                    <td><?php if ($familia->Estado == 1) { echo "Activo"; }else{ echo "Inactivo"; } ?></td>
                    <td><?php echo $familia->Nombre; ?></td>
                    <td><?php echo $familia->Codigo; ?></td>
                    <td class="text-center" width="50px">
                        <div class="ui checkbox">
                            <input type="checkbox" id="<?php echo $familia->Pk_Id; ?>" data-nombre="<?php echo $familia->Nombre; ?>" name="seleccionado" tabindex="0" class="hidden">
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
        $('#tbl_familias').DataTable({
	    	paging: true,
	    	"scrollX": true
		});

		// Se activan los botones
        botones({"crear": true, "volver": true, "editar": true, "eliminar": true});
        
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
        	"Familias", 
        	"Todas las familias de indicadores del proyecto.",
        	"block layout"
    	]);
	}); // document.ready
</script>