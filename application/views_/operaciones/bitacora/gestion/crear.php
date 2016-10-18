<?php
// Fecha y hora
$fecha = date("Y-m-d");
$hora = date("h:i s");

// Si es edición
if ($id != 0) {
	// Se consultan los datos de la familia
	// $familia = $this->configuracion_model->cargar("familia", $id);

	// Input oculto
	// echo '<input id="id_familia" type="hidden" value="'.$id.'">';
} // if
?>

<form class="ui form">
	<!-- Fecha y hora -->
	<div class="col-lg-12">
		<h2 class="ui header">
			<i class="wait icon"></i>
			<div class="content">
				<!-- Fecha -->
				<?php echo $this->configuracion_model->formato_fecha($fecha); ?>
				
				<!-- Hora -->
				<div class="sub header"><?php echo date("g:i a"); ?></div>
			</div>
		</h2>
	</div><!-- Fecha y hora -->

	<div class="ui divider"></div>
	
	<div class="col-lg-4">
		<!-- Unidad de medida -->
		<div class="col-lg-12">
			<div class="field">
				<label for="select_asunto">Asunto</label>
				<select id="select_asunto" class="ui fluid search dropdown">
					<!-- Option vacío -->
					<option value="">Obligatorio</option>

					<!-- Recorrido de los asuntos -->
					<?php foreach ($this->operaciones_configuracion_model->cargar("asuntos", NULL) as $asunto) { ?>
						<option value="<?php echo $asunto->Pk_Id; ?>"><?php echo $asunto->Nombre; ?></option>
					<?php } // foreach ?>
				</select>
			</div>
		</div><!-- Unidad de medida -->
	</div>

	<!-- Descripción -->
	<div class="col-lg-8">
		<div class="field">
			<label for="input_anotacion">Anotación</label>
			<textarea rows="1" id="input_anotacion" autofocus><?php if(isset($indicador->Anotacion)){echo $indicador->Anotacion;} ?></textarea>
		</div>
	</div><!-- Descripción -->


</form>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        // $('.ui.checkbox').checkbox();

        // Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});

        // Activación de los selects
		$('#select_asunto').dropdown({
			allowAdditions: true,
			onChange: function(){
				// // Si es un valor válido
				// if ($(this).val() != "") {
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
				// } // if
			} // on change
		}); // dropdown

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
  //   	mostrar_mensaje_pie([
  //   		"estado", 
  //   		"Gestión familias", 
  //   		"Cree y/o edite una familia de indicadores",
  //   		"checkmark box"
		// ]);
	}); // document.ready
</script>