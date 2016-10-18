<?php
// Si es edición de indicador
if ($id != 0) {
	// Se consultan los datos del indicador
	$indicador = $this->indicadores_model->cargar("indicador", $id);

	// Input oculto
	echo '<input id="id_indicador" type="hidden" value="'.$id.'">';
} // if
?>

<h2 class="ui dividing header center aligned">
	Gestión de indicadores
</h2>

<form class="ui form">
	<!-- Nombre -->
	<div class="col-lg-4">
		<div class="field">
			<label for="input_nombre">Nombre</label>
			<input type="text" id="input_nombre" value="<?php if(isset($indicador->Nombre)){echo $indicador->Nombre;} ?>" placeholder="Obligatorio" autofocus>
		</div>
	</div><!-- Nombre -->
	
	<!-- Identificador -->
	<div class="col-lg-2">
		<div class="field">
			<label for="input_identificador">Identificador</label>
			<input type="text" id="input_identificador" value="<?php if(isset($indicador->Identificador)){echo $indicador->Identificador;} ?>" placeholder="Obligatorio">
		</div>
	</div><!-- Identificador -->
	
	<!-- Familia -->
	<div class="col-lg-3">
		<div class="field">
			<label for="select_familia">Familia</label>
			<select id="select_familia" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de las familias activas -->
				<?php foreach ($this->configuracion_model->cargar("familias_activas", NULL) as $familia) { ?>
					<option value="<?php echo $familia->Pk_Id; ?>"><?php echo $familia->Nombre; ?></option>
				<?php } // foreach ?>
			</select>
		</div>
	</div><!-- Familia -->
	
	<!-- Concepto de medición -->
	<div class="col-lg-3">
		<div class="field">
			<label for="select_concepto_medicion">Concepto de medición</label>
			<select id="select_concepto_medicion" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de los conceptos de medición -->
				<?php foreach ($this->configuracion_model->cargar("conceptos_medicion_activos", NULL) as $medicion) { ?>
					<option value="<?php echo $medicion->Pk_Id; ?>"><?php echo $medicion->Nombre; ?></option>
				<?php } // foreach ?>
			</select>
		</div>
	</div><!-- Concepto de medición -->
	
	<!-- Norma -->
	<div class="col-lg-3">
		<div class="field">
			<label for="select_norma">Norma</label>
			<select id="select_norma" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de las normas activas -->
				<?php foreach ($this->configuracion_model->cargar("normas_activas", NULL) as $norma) { ?>
					<option value="<?php echo $norma->Pk_Id; ?>"><?php echo $norma->Nombre; ?></option>
				<?php } // foreach ?>
			</select>
		</div>
	</div><!-- Norma -->
	
	<!-- Periodicidad -->
	<div class="col-lg-3">
		<div class="field">
			<label for="select_periodicidad">Periodicidad</label>
			<select id="select_periodicidad" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de las periodicidades -->
				<?php foreach ($this->configuracion_model->cargar("periodicidades", NULL) as $periodicidad) { ?>
					<option value="<?php echo $periodicidad->Pk_Id; ?>"><?php echo $periodicidad->Nombre; ?></option>
				<?php } // foreach ?>
			</select>
		</div>
	</div><!-- Periodicidad -->
	
	<!-- Unidad de medida -->
	<div class="col-lg-3">
		<div class="field">
			<label for="select_unidad_medida">Unidad de medida</label>
			<select id="select_unidad_medida" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de las unidades de medida -->
				<?php foreach ($this->configuracion_model->cargar("unidades_medida", NULL) as $unidad_medida) { ?>
					<option value="<?php echo $unidad_medida->Pk_Id; ?>"><?php echo $unidad_medida->Nombre; ?></option>
				<?php } // foreach ?>
			</select>
		</div>
	</div><!-- Unidad de medida -->
	
	<!-- Fecha de inicio del indicador -->
	<div class="col-lg-3">
		<div class="field">
			<label for="fecha_inicio">Fecha de inicio del indicador</label>
			<input type="text" id="fecha_inicio" class="datepicker" value="<?php if(isset($indicador->Fecha_Inicio)){echo date("d-m-Y", strtotime($indicador->Fecha_Inicio));} ?>" placeholder="Obligatorio">
		</div>
	</div><!-- Fecha de inicio del indicador -->
	
	<!-- Método de medida -->
	<div class="col-lg-12">
		<div class="field">
			<label for="input_metodo_medida">Método de medida</label>
			<textarea rows="1" id="input_metodo_medida"><?php if(isset($indicador->Metodo_Medida)){echo $indicador->Metodo_Medida;} ?></textarea>
		</div>
	</div><!-- Método de medida -->
	
	<!-- Valor de aceptación -->
	<div class="col-lg-12">
		<div class="field">
			<label for="input_valor_aceptacion">Valor de aceptación</label>
			<textarea rows="1" id="input_valor_aceptacion"><?php if(isset($indicador->Valor_Aceptacion)){echo $indicador->Valor_Aceptacion;} ?></textarea>
		</div>
	</div><!-- Valor de aceptación -->
	
	<!-- Valor mínimo -->
	<div class="col-lg-6">
		<div class="field">
			<label for="input_minimo">Valor mínimo</label>
			<input type="text" id="input_minimo" value="<?php if(isset($indicador->Valor_Minimo)){echo $indicador->Valor_Minimo;} ?>" placeholder="Obligatorio">
		</div>
	</div><!-- Valor mínimo -->
	
	<!-- Valor máximo -->
	<div class="col-lg-6">
		<div class="field">
			<label for="input_maximo">Valor máximo</label>
			<input type="text" id="input_maximo" value="<?php if(isset($indicador->Valor_Maximo)){echo $indicador->Valor_Maximo;} ?>" placeholder="Obligatorio">
		</div>
	</div><!-- Valor máximo -->
	
	<!-- Estado -->
	<div class="col-lg-12">
		<div class="ui toggle checkbox">
			<?php if(isset($concepto->Estado) && $concepto->Estado == 1) {$check = "checked";} else {$check = "";} ?>
			<input type="checkbox" id="check_activo" class="hidden" <?php echo $check; ?>>
			<label>Activo / Inactivo</label>
		</div>
	</div><!-- Estado -->
</form>

<!-- Si tiene id (es edición) -->
<?php if($id != 0){ ?>
	<script type="text/javascript">
		// Se consultan los valores por defecto de los selects, enviando nombre del elemento y valor
		select_por_defecto("select_concepto_medicion", "<?php echo $indicador->Fk_Id_Concepto_Medicion; ?>");
		select_por_defecto("select_familia", "<?php echo $indicador->Fk_Id_Indicador_Familia; ?>");
		select_por_defecto("select_periodicidad", "<?php echo $indicador->Fk_Id_Periodicidad; ?>");
		select_por_defecto("select_unidad_medida", "<?php echo $indicador->Fk_Id_Unidad_Medida; ?>");
		select_por_defecto("select_norma", "<?php echo $indicador->Fk_Id_Norma; ?>");
	</script>
<?php } // if ?>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        $('.ui.checkbox').checkbox();

        // Campos a bloquear para que sea sólo numérico
        $("#input_minimo, #input_maximo").numericInput({
            allowFloat: true, 
            allowNegative: true
        });
        
        // Activación de los selects
		$("#select_concepto_medicion, #select_familia, #select_norma, #select_periodicidad, #select_unidad_medida").dropdown({
			allowAdditions: true
		}); // dropdown

		// Declaración de las fechas
		$(".datepicker").pickadate({
			// format: 'dddd, dd mmmm, yyyy',
			format: 'dd-mm-yyyy',
			formatSubmit: 'yyyy-mm-dd'
		}); // datepicker

        // Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Gestión de indicadores", 
    		"Cree y/o edite un indicador",
    		"checkmark box"
		]);
	}); // document.ready
</script>