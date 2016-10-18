<?php
// Si es edición de un concepto de medición
if ($id != 0) {
	// Se consultan los datos del concepto de medición
	$concepto = $this->configuracion_model->cargar("concepto_medicion", $id);

	// Input oculto
	echo '<input id="id_concepto_medicion" type="hidden" value="'.$id.'">';
} // if
?>

<h2 class="ui dividing header center aligned">
	Gestión del concepto de medición
</h2>

<form class="ui form">
	<div class="field">
		<label for="input_descripcion">Descripción</label>
		<textarea rows="2" id="input_descripcion" placeholder="Obligatorio" autofocus><?php if(isset($concepto->Descripcion)){echo $concepto->Descripcion;} ?></textarea>
	</div>

	<div class="field">
		<label for="input_nombre">Nombre</label>
		<input type="text" id="input_nombre" value="<?php if(isset($concepto->Nombre)){echo $concepto->Nombre;} ?>">
	</div>

	<div class="ui toggle checkbox">
		<?php if(isset($concepto->Estado) && $concepto->Estado == 1) {$check = "checked";} else {$check = "";} ?>
		<input type="checkbox" id="check_activo" class="hidden" <?php echo $check; ?>>
		<label>Activo / Inactivo</label>
	</div>
</form>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        $('.ui.checkbox').checkbox();

        // Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Gestión del concepto de medición", 
    		"Cree y/o edite un concepto de medición",
    		"checkmark box"
		]);
	}); // document.ready
</script>