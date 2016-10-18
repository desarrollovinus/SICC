<div class="ui form ">
	<!-- Período de tiempo -->
	<div class="col-lg-6">
		<label for="select_periodo">Período</label>
		<select id="select_periodo" class="ui fluid search dropdown">
			<!-- Option vacío -->
			<option value="">Seleccione el período de tiempo</option>
			<option value="<?php echo date("Y-m-d"); ?>">Hoy</option>
			<option value="<?php echo date("Y-m-d"); ?>">OK</option>
		</select>
	</div><!-- Período de tiempo -->
	
	<!-- Fecha inicial -->
	<div class="col-lg-3">
		<div class="field">
			<label for="fecha_inicio">Registros de bitácora desde</label>
			<input type="text" id="fecha_inicio" class="datepicker" value="<?php if(isset($indicador->Fecha_Inicio)){echo date("d-m-Y", strtotime($indicador->Fecha_Inicio));} ?>" >
		</div>
	</div><!-- Fecha inicial -->

	<!-- Fecha final -->
	<div class="col-lg-3">
		<div class="field">
			<label for="fecha_final">Hasta</label>
			<input type="text" id="fecha_final" class="datepicker" value="<?php if(isset($indicador->Fecha_Final)){echo date("d-m-Y", strtotime($indicador->Fecha_Final));} ?>" >
		</div>
	</div><!-- Fecha final -->
</div>

<!-- Contenedor de registros -->
<div id="cont_registros"></div>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        // $('.ui.checkbox').checkbox();
        
        listar_registros();
        
        // Activación de la tabla
  //       $('#tbl_indicadores').DataTable({
	 //    	paging: true,
	 //    	"scrollX": true
		// });

		// Se activan los botones
        botones({"volver": true});
        
        // Declaración de las fechas
		$(".datepicker").pickadate({
			// format: 'dddd, dd mmmm, yyyy',
			format: 'dd-mm-yyyy',
			formatSubmit: 'yyyy-mm-dd'
		}); // datepicker
		
        // Activación de los selects
		$('#select_asunto').dropdown({
			allowAdditions: true,
			onChange: function(){
				// Si es un valor válido
				if ($(this).val() != "") {
				// 	// Si es por módulos
				// 	if ($(this).attr("id") == "select_modulos") {
				// 		// Se almacena el tipo
				// 		var tipo = "permisos_tipo_modulo"
				// 	} // if

				// 	// Si es por usuarios
				// 	if ($(this).attr("id") == "select_usuarios") {
				// 		// Se almacena el tipo
				// 		var tipo = "permisos_tipo_usuario"
				// 	} // if

				// 	// Se carga la Interfaz
				// 	cargar_tipo(tipo, $(this).val());
				} // if
			} // on change
		}); // dropdown
        
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
        	"Bitácora", 
        	"Registros en bitácora de hoy. Para ver más, por favor elija una de las opciones",
        	"flag"
    	]);
	}); // document.ready
</script>