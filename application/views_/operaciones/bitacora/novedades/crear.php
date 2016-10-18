<?php
// Fecha y hora
$fecha = date("Y-m-d");
$hora = date("h:i s");

// Se declara un arreglo de actores activos en esta novedad
$actores_activos = array();

// Si es edición
if ($id != 0) {
	// Se consultan los datos de la novedad
	$novedad = $this->operaciones_bitacora_model->cargar("novedad", $id);

    // Se recorren los actores seleccionados en la novedad
	foreach ($this->operaciones_bitacora_model->cargar("actores_novedad", $id) as $actor_activo) {
		// Se agrega cada id en el arreglo nuevo
		array_push($actores_activos, $actor_activo->Pk_Id);
	} // foreach

	// Input oculto
	echo '<input id="id_novedad" type="hidden" value="'.$id.'">';
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
	
	<div class="col-lg-5">
		<!-- Asunto -->
		<div class="col-lg-12">
			<div class="field">
				<label for="select_novedad_tipo">Asunto</label>
				<select id="select_novedad_tipo" class="ui fluid search dropdown">
					<!-- Option vacío -->
					<option value="">Seleccione un asunto</option>

					<!-- Recorrido de los tipos de novedades -->
					<?php foreach ($this->operaciones_configuracion_model->cargar("novedades_tipos_activos", NULL) as $novedad_tipo) { ?>
						<option value="<?php echo $novedad_tipo->Pk_Id; ?>" data-evento="<?php echo $novedad_tipo->Evento; ?>"><?php echo $novedad_tipo->Nombre; ?></option>
					<?php } // foreach ?>
				</select>
			</div>
		</div><!-- Asunto -->

		<!-- Actores -->
		<div class="col-lg-12">
			<!-- Recorrido de los actores -->
			<?php foreach ($this->operaciones_configuracion_model->cargar("actores_activos", NULL) as $actor) { ?>
				<div class="col-lg-6">
					<div class="ui toggle checkbox">
						<label for="check_activo"><?php echo $actor->Nombre; ?></label>

                    	<!-- Si el id del actor está dentro del arreglo de actores activos, lo chequea y desactiva -->
                    	<?php if(in_array($actor->Pk_Id, $actores_activos)) {$existe = "1";  $check = "checked disabled";} else {$existe = "0"; $check = "";} ?>
						<input type="checkbox" id="<?php echo $actor->Pk_Id; ?>" name="actores" class="hidden" data-existe="<?php echo $existe; ?>" <?php echo $check; ?>>
					</div> 
				</div> 
			<?php } // foreach actores ?>
		</div><!-- Actores -->
	</div>

	<!-- Descripción -->
	<div class="col-lg-7">
		<div class="field">
			<label for="input_anotacion">Anotación</label>
			<textarea rows="2" id="input_anotacion" placeholder="Obligatorio" autofocus><?php if(isset($novedad->Anotacion)){echo $novedad->Anotacion;} ?></textarea>
		</div>
	</div><!-- Descripción -->
</form>

<!-- Si tiene id (es edición) -->
<?php if($id != 0){ ?>
	<script type="text/javascript">
		// Se consultan los valores por defecto de los selects, enviando nombre del elemento y valor
		select_por_defecto("select_novedad_tipo", "<?php echo $novedad->Fk_Id_Novedad_Tipo; ?>");
	</script>
<?php } // if ?>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        $('.ui.checkbox').checkbox();

        // Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});

        // Activación de los selects
		$('#select_novedad_tipo').dropdown({
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
    	mostrar_mensaje_pie([
    		"estado", 
    		"Gestión de la novedad", 
    		"Configure los parámetros básicos de la novedad.",
    		"checkmark box"
		]);
	}); // document.ready
</script>