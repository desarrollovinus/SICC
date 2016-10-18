<?php
// Si es edición de unidad de medida
if ($id != 0) {
	// Se consultan los datos de la unidad de medida
	$unidad = $this->configuracion_model->cargar("unidad_medida", $id);

	// Input oculto
	echo '<input id="id_unidad" type="hidden" value="'.$id.'">';
} // if
?>

<h2 class="ui dividing header center aligned">
	Gestión de la unidad de medida
</h2>

<form class="ui form">
	<div class="two fields">
		<div class="field">
			<label for="input_nombre">Nombre</label>
			<input type="text" id="input_nombre" value="<?php if(isset($unidad->Nombre)){echo $unidad->Nombre;} ?>" placeholder="Obligatorio" autofocus>
		</div>
		<div class="field">
			<label for="input_codigo">Código</label>
			<input type="text" id="input_codigo" value="<?php if(isset($unidad->Codigo)){echo $unidad->Codigo;} ?>" placeholder="Obligatorio">
		</div>
	</div>

	<div class="ui toggle checkbox">
		<?php if(isset($unidad->Estado) && $unidad->Estado == 1) {$check = "checked";} else {$check = "";} ?>
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
    		"Gestión de la unidad de medida", 
    		"Cree y/o edite una unidad de medida",
    		"checkmark box"
		]);
	}); // document.ready
</script>