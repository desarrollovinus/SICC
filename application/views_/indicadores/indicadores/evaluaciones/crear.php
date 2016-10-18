<?php
// Si es edición de evaluación
if ($id != 0) {
	// Se consultan los datos de la evaluación
	$evaluacion = $this->configuracion_model->cargar("evaluacion", $id);

	// Input oculto
	echo '<input id="id_evaluacion" type="hidden" value="'.$id.'">';
} // if
?>

<!-- <h2 class="ui dividing header center aligned">
	Evaluación
</h2> -->

<form class="ui form">
	<h4 class="ui horizontal divider header">
		<i class="tag icon"></i>
		Selección de la política
	</h4>

	<!-- Unidad funcional -->
	<div class="col-lg-4">
		<div class="field">
			<label for="select_unidad_funcional">Unidad funcional</label>
			<select id="select_unidad_funcional" class="ui fluid search dropdown" autofocus>
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de las unidades funcionales activas -->
				<?php foreach ($this->configuracion_model->cargar("unidades_funcionales_activas", NULL) as $unidad_funcional) { ?>
					<option value="<?php echo $unidad_funcional->Pk_Id; ?>"><?php echo $unidad_funcional->Nombre; ?></option>
				<?php } // foreach ?>
			</select>
		</div>
	</div><!-- Unidad funcional -->

	<!-- Indicador -->
	<div class="col-lg-8">
		<div class="field">
			<label for="select_indicadores">Indicador</label>
			<select id="select_indicadores" class="ui fluid search dropdown" >
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de las unidades funcionales activas -->
				<?php foreach ($this->indicadores_model->cargar("indicadores_activos", NULL) as $indicador) { ?>
					<option value="<?php echo $indicador->Pk_Id; ?>"><?php echo "$indicador->Identificador - $indicador->Nombre"; ?></option>
				<?php } // foreach ?>
			</select>
		</div>
	</div><!-- Indicador -->
	<div class="clear"></div>

	<h4 class="ui horizontal divider header">
		<i class="resize horizontal icon"></i>
		Segmentos
	</h4>

	<!-- Contenedor de los segmentos -->
	<div id="cont_segmentos"></div>
</form>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        // $('.ui.checkbox').checkbox();

        // Campos a bloquear para que sea sólo numérico
        // $("#input_minimo, #input_maximo").numericInput({
            // allowFloat: true, 
            // allowNegative: true
        // });
        
        // Activación de los selects
		$("#select_unidad_funcional, #select_indicadores").dropdown({
			allowAdditions: true
		}); // dropdown

		// Cuando se seleccione el indicador y la unidad funcional
		$("#select_unidad_funcional, #select_indicadores").on("change", function(){
			// Variables
			id_unidad_funcional = $("#select_unidad_funcional");
			id_indicador = $("#select_indicadores");

			// Cuando todos los selects tengan un valor seleccionado
			if (id_unidad_funcional.val() != "" && id_indicador.val() != "") {
				// Se carga la interfaz
				cargar_interfaz("cont_segmentos", "<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": "evaluaciones_segmentos", "id_unidad_funcional": id_unidad_funcional.val(), "id_indicador": id_indicador.val()});
			} // if
		}); // change

		// Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Gestión de la evaluación", 
    		"Cree y/o edite una evaluación o autoevaluación",
    		"checkmark box"
		]);
	}); // document.ready
</script>
