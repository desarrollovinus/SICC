<?php
// Si es edición de una familia
if ($id != 0) {
	// Se consultan los datos de la familia
	$familia = $this->configuracion_model->cargar("familia", $id);

	// Input oculto
	echo '<input id="id_familia" type="hidden" value="'.$id.'">';
} // if
?>

<h2 class="ui dividing header center aligned">
	Gestión de familias de indicadores
</h2>

<form class="ui form">
	<div class="two fields">
		<div class="field">
			<label for="input_nombre">Nombre</label>
			<input type="text" id="input_nombre" value="<?php if(isset($familia->Nombre)){echo $familia->Nombre;} ?>" placeholder="Obligatorio" autofocus>
		</div>
		<div class="field">
			<label for="input_codigo">Código</label>
			<input type="text" id="input_codigo" value="<?php if(isset($familia->Codigo)){echo $familia->Codigo;} ?>" placeholder="Obligatorio">
		</div>
	</div>

	<div class="ui toggle checkbox">
		<?php if(isset($familia->Estado) && $familia->Estado == 1) {$check = "checked";} else {$check = "";} ?>
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
    		"Gestión familias", 
    		"Cree y/o edite una familia de indicadores",
    		"checkmark box"
		]);
	}); // document.ready
</script>