<?php
// Si es edición de unidad funcional
if ($id != 0) {
	// Se consultan los datos de la unidad funcional
	$unidad = $this->configuracion_model->cargar("unidad_funcional", $id);

	// Input oculto
	echo '<input id="id_unidad" type="hidden" value="'.$id.'">';
} // if
?>

<h2 class="ui dividing header center aligned">
	Gestión de la unidad funcional
</h2>

<form class="ui form">
	<div class="three fields">
		<div class="field">
			<label for="input_nombre">Nombre</label>
			<input type="text" id="input_nombre" value="<?php if(isset($unidad->Nombre)){echo $unidad->Nombre;} ?>" placeholder="Obligatorio" autofocus>
		</div>
		<div class="field">
			<label for="input_codigo">Código</label>
			<input type="text" id="input_codigo" value="<?php if(isset($unidad->Codigo)){echo $unidad->Codigo;} ?>" placeholder="Obligatorio">
		</div>
		<div class="field">
			<label for="input_abscisado">Abscisado inicial</label>
			<input type="text" id="input_abscisado" value="<?php if(isset($unidad->Abscisado_Inicial)){echo $unidad->Abscisado_Inicial;} ?>" placeholder="Obligatorio">
		</div>
	</div>

	<div class="four fields">
		<div class="field">
			<label for="input_longitud">Longitud (metros)</label>
			<input type="text" id="input_longitud" value="<?php if(isset($unidad->Longitud)){echo number_format($unidad->Longitud, 0);} ?>" placeholder="Obligatorio" <?php if(isset($unidad->Longitud)){echo "disabled";} ?>>
		</div>

		<div class="field">
			<label for="input_segmento">Tamaño del segmento (metros)</label>
			<input type="text" id="input_segmento" value="<?php if(isset($unidad->Tamanio_Segmento)){echo number_format($unidad->Tamanio_Segmento);} ?>" placeholder="Obligatorio" <?php if(isset($unidad->Tamanio_Segmento)){echo "disabled";} ?>>
		</div>
		
		<div class="field">
			<label for="input_monto">Monto</label>
			<div class="ui left icon input field">
				<input type="text" id="input_monto" value="<?php if(isset($unidad->Monto)){echo $unidad->Monto;} ?>">
				<i class="dollar icon"></i>
			</div>
		</div>

		<div class="field">
			<label for="input_peso">Peso</label>
			<input type="text" id="input_peso" value="<?php if(isset($unidad->Peso)){echo $unidad->Peso;} ?>">
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

        // Campos a bloquear para que sea sólo numérico
        $("#input_longitud, #input_segmento, #input_monto, #input_peso, #input_abscisado").numericInput({
            allowFloat: true, 
            allowNegative: false
        });

        // Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Gestión de la unidad funcional", 
    		"Cree y/o edite una unidad funcional",
    		"checkmark box"
		]);
	}); // document.ready
</script>