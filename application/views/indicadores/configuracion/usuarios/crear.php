<?php
// Si es edición de usuario
if ($id != 0) {
	// Se consultan los datos del usuario
	$usuario = $this->configuracion_model->cargar("usuario", $id);

	// Input oculto
	echo '<input id="id_usuario" type="hidden" value="'.$id.'">';
} // if
?>

<form class="ui form">
	<h4 class="ui horizontal divider header">
		<i class="user icon"></i>
		Datos básicos
	</h4>

	<div class="three fields">
		<div class="field">
			<label for="input_nombre">Nombres</label>
			<input type="text" id="input_nombres" value="<?php if(isset($usuario->Nombres)){echo $usuario->Nombres;} ?>" placeholder="Obligatorio" autofocus>
		</div>
		<div class="field">
			<label for="input_apellidos">Apellidos</label>
			<input type="text" id="input_apellidos" value="<?php if(isset($usuario->Apellidos)){echo $usuario->Apellidos;} ?>" placeholder="Obligatorio">
		</div>
		<div class="field">
			<label for="input_documento">Número de documento</label>
			<input type="text" id="input_documento" value="<?php if(isset($usuario->Documento)){echo $usuario->Documento;} ?>" placeholder="Obligatorio">
		</div>
	</div>

	<div class="three fields">
		<div class="field">
			<label for="input_email">Correo electrónico</label>
			<input type="text" id="input_email" value="<?php if(isset($usuario->Email)){echo $usuario->Email;} ?>">
		</div>
		<div class="field">
			<label for="input_telefono">Teléfono</label>
			<input type="text" id="input_telefono" value="<?php if(isset($usuario->Telefono)){echo $usuario->Telefono;} ?>">
		</div>
		<div class="field">
			<label for="check_activo">Activo / Inactivo</label>
			<div class="ui toggle checkbox">
				<?php if(isset($usuario->Estado) && $usuario->Estado == 1) {$check = "checked";} else {$check = "";} ?>
				<input type="checkbox" id="check_activo" class="hidden" <?php echo $check; ?>>
				<label></label>
			</div>
		</div>
	</div>

	<h4 class="ui horizontal divider header">
		<i class="lock icon"></i>
		Datos de seguridad
	</h4>

	<div class="three fields">
		<div class="field">
			<label for="input_login">Nombre de usuario</label>
			<input type="text" id="input_login" value="<?php if(isset($usuario->Login)){echo $usuario->Login;} ?>" placeholder="Obligatorio">
			<input type="hidden" id="input_login_anterior" value="<?php if(isset($usuario->Login)){echo $usuario->Login;} ?>">
		</div>
		<div class="field">
			<label for="input_clave">Contraseña</label>
			<input type="password" id="input_clave" placeholder="Escríbala solo si va a cambiarla">
		</div>
		<div class="field">
			<label for="input_clave2">Repetir contraseña</label>
			<input type="password" id="input_clave2" placeholder="Repita la contraseña anterior">
		</div>
	</div>
</form>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los checkboxes
        $('.ui.checkbox').checkbox();

        // Campos a bloquear para que sea sólo numérico
        $("#input_documento").numericInput({
            allowFloat: true, 
            allowNegative: false
        }); // numeric input

        // Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Gestión del usuario",
    		"Cree y/o edite una usuario, digitando la información requerida.",
    		"checkmark box"
		]);
	}); // document.ready
</script>