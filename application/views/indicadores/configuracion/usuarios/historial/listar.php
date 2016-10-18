<div class="ui form ">
	<!-- Módulo -->
	<div class="col-lg-6">
		<div class="ui sub header">Módulo</div>
		<select id="select_modulo" class="ui fluid search dropdown">
			<!-- Option vacío -->
			<option value="">Todos</option>

			<!-- Recorrido de los módulos -->
			<?php foreach ($this->configuracion_model->cargar("modulos", NULL) as $modulo) { ?>
				<option value="<?php echo $modulo->Pk_Id; ?>"><?php echo $modulo->Nombre; ?></option>
			<?php } // foreach módulos ?>
		</select>
	</div><!-- Módulo -->

	<!-- Acción -->
	<div class="col-lg-6">
		<div class="ui sub header">Acción</div>
		<select id="select_accion" class="ui fluid search dropdown">
			<!-- Option vacío -->
			<option value="">Todas las acciones</option>

			<!-- Recorrido de los usuarios -->
			<?php foreach ($this->configuracion_model->cargar("acciones_logs", NULL) as $accion) { ?>
				<option value="<?php echo $accion->Pk_Id; ?>"><?php echo $accion->Nombre; ?></option>
			<?php } // foreach usuarios ?>
		</select>
	</div><!-- Acción -->
</div>

<div class="clear"></div>

<div class="ui divider"></div>

<!-- Interfaz de las acciones -->
<div id="cont_logs"></div>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se carga la tabla con los datos en cero para que los cargue todos
		cargar("logs", ["<?php echo $id_usuario; ?>", "", ""]);

		// Activación de los selects
		$('#select_modulo, #select_accion').dropdown({
			allowAdditions: true,
			onChange: function(){
				// Se Vuelve a cargar los logs con los nuevos valores de los selects
				cargar("logs", ["<?php echo $id_usuario; ?>", $("#select_modulo").val(), $("#select_accion").val()]);
			} // on change
		}); // dropdown


  //       // Activación de la tabla
  //       $('#tbl_usuarios').DataTable({
	 //    	paging: true,
	 //    	"scrollX": true
		// });

		// Se activan los botones
        botones({"volver": true});

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Historial", 
    		"Información histórica del usuario en la aplicación.",
    		"unhide"
		]);
	}); // document.ready
</script>