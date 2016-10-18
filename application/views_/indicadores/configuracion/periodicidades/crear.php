<?php
// Si es edición de periodicidad
if ($id != 0) {
	// Se consultan los datos de la periodicidad
	$periodicidad = $this->configuracion_model->cargar("periodicidad", $id);

	// Input oculto
	echo '<input id="id_periodicidad" type="hidden" value="'.$id.'">';
} // if
?>

<h2 class="ui dividing header center aligned">
	Gestión de la periodicidad
</h2>

<form class="ui form">
	<div class="three fields">
		<div class="field">
			<label for="input_nombre">Nombre</label>
			<input type="text" id="input_nombre" value="<?php if(isset($periodicidad->Nombre)){echo $periodicidad->Nombre;} ?>" placeholder="Obligatorio" autofocus>
		</div>
		<div class="field">
			<label for="input_codigo">Código</label>
			<input type="text" id="input_codigo" value="<?php if(isset($periodicidad->Codigo)){echo $periodicidad->Codigo;} ?>" placeholder="Obligatorio">
		</div>
		<div class="field">
			<label for="input_dias">Días</label>
			<input type="number" id="input_dias" value="<?php if(isset($periodicidad->Dias)){echo $periodicidad->Dias;} ?>" placeholder="Obligatorio">
		</div>
	</div>

	<div class="ui toggle checkbox">
		<?php if(isset($periodicidad->Estado) && $periodicidad->Estado == 1) {$check = "checked";} else {$check = "";} ?>
		<input type="checkbox" id="check_activo" class="hidden" <?php echo $check; ?>>
		<label>Activo / Inactivo</label>
	</div>
</form>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        $('.ui.checkbox').checkbox();

        // Campos a bloquear para que sea sólo numérico
        $("#input_dias").numericInput({
            allowFloat: false, 
            allowNegative: false
        });

        // Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Gestión de la periodicidad", 
    		"Cree y/o edite una periodicidad",
    		"checkmark box"
		]);
	}); // document.ready
</script>