<div class="row">
	<div class="col-md-4">
		<div class="ui horizontal segment">
			<p>
				<h2 class="ui header">
					<i class="settings icon"></i>
					<div class="content">
						Account Settings
						<div class="sub header">Manage your preferences</div>
					</div>
				</h2>
			</p>
		</div>
	</div>
	<div class="col-md-4">
		<div class="ui horizontal segment">
			<p>
				<h2 class="ui header">
					<i class="settings icon"></i>
					<div class="content">
						Account Settings
						<div class="sub header">Manage your preferences</div>
					</div>
				</h2>
			</p>
		</div>
	</div>
	<div class="col-md-4">
		<div class="ui horizontal segment">
			<p>
				<h2 class="ui header">
					<i class="settings icon"></i>
					<div class="content">
						Account Settings
						<div class="sub header">Manage your preferences</div>
					</div>
				</h2>
			</p>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">.col-md-4</div>
	<div class="col-md-6">
		<div class="ui horizontal segment">
			<p>
				<form class="ui form segment">
					<div class="field">
						<label>Usuario</label>
						<div class="ui left icon input">
							<input id="input_usuario" type="text" autofocus>
							<i class="user icon"></i>
						</div>
					</div>
					<div class="field">
						<label>Contraseña</label>
						<div class="ui left icon input">
							<input id="input_password" type="password">
							<i class="lock icon"></i>
						</div>
					</div>

					<!-- Ingresar -->
					<input type="submit" id="btn_login" class="ui blue submit button" value="Ingresar">
				</form>
			</p>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">.col-md-4</div>
	<div class="col-md-4">.col-md-4</div>
	<div class="col-md-4">.col-md-4</div>
</div>
<div class="row">
	<div class="col-md-6">.col-md-6</div>
	<div class="col-md-6">.col-md-6</div>
</div>

<script type="text/javascript">
	/**
	 * Función que permite hacer el inicio de sesión
	 * @return {[type]} [description]
	 */
	function iniciar_sesion()
	{
		// Se toman los valores
		var login = $("#input_usuario");
		var password = $("#input_password");

		// Arreglo con los datos a validar
        datos_obligatorios = new Array(
            login.val(),
			password.val()
        );
		// imprimir(datos_obligatorios);

		// Se ejecuta la validación de los datos obligatorios
        validacion = validar_campos_obligatorios(datos_obligatorios);

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
			"carga", 
        	"Iniciando sesión...", 
        	"Validando que se hayan ingresado el usuario y la contraseña."
    	]);

        //Si no supera la validacíón
        if (!validacion) {
        	// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"Faltan campos por diligenciar. Por favor asegúrese de ingresar usuario y contraseña.", 
				"warning sign"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        	mostrar_mensaje_pie([
        		"estado", 
        		"No se puede iniciar sesión...", 
        		"Esperando que se ingresen usuario y contraseña.",
        		"announcement"
    		]);

			return false;
        } // if

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Iniciando sesión...", 
        	"Validando que la información coincida con la base de datos."
    	]);

        // Se valida que el usuario exista
        usuario = ajax("<?php echo site_url('sesion/validar'); ?>", {"usuario": login.val(), "password": password.val()}, "JSON");
    	// imprimir(usuario.respuesta);
    	
        // Si el usuario no existe (si es null)
    	if (!usuario.respuesta) {
    		modal([
				"Advertencia", 
				"El usuario '" + login.val() + "' no existe en la base de datos o la contraseña es incorrecta. Por favor verifique los datos e intente nuevamente.", 
				"remove user"
			]);

        	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        	mostrar_mensaje_pie([
        		"estado", 
        		"No se puede iniciar sesión...", 
        		"Esperando que se verifique la información ingresada",
        		"announcement"
    		]);

    		return false;
    	};

    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"carga", 
    		"Verificando permiso...", 
    		"Validando que tenga permiso para ingresar al SICC."
		]);

		// Se valida que el usuario tenga permiso para entrar a la aplicación
		permiso = ajax("<?php echo site_url('sesion/validar_acceso'); ?>", {"id_usuario": usuario.respuesta.Pk_Id_Usuario}, "JSON");
		// imprimir(permiso.respuesta);
		
		// Si no tiene acceso (si es null)
		if (!permiso.respuesta) {
			modal([
				"Advertencia", 
				usuario.respuesta.Nombres + " " + usuario.respuesta.Apellidos + " no tiene permiso para acceder a la aplicación. Por favor contáctese con el área de Sistemas para que se le autorice ingresar.", 
				"lock"
			]);

        	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        	mostrar_mensaje_pie([
        		"estado", 
        		"No se puede acceder a la aplicación", 
        		"No está autorizado el acceso del usuario " + login.val() + " a la aplicación.",
        		"announcement"
    		]);

			return false;
		};

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"carga", 
    		"Verificando actividad...", 
    		"Validando que el usuario esté activo."
		]);

    	// Si el usuario no está activo
		if (usuario.respuesta.Estado != 1) {
			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				usuario.respuesta.Nombres + " " + usuario.respuesta.Apellidos + " no se encuentra activo y, por lo tanto, no puede iniciar sesión. Por favor comuníquese con el administrador del Sistema.", 
				"remove user"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        	mostrar_mensaje_pie([
        		"estado", 
        		"No se puede iniciar sesión...", 
        		"El usuario debe estar activo para ingresar al sistema.",
        		"announcement"
    		]);

    		return false;
		};

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"carga", 
    		"Iniciando sesión...", 
    		"Cargando los datos de la sesión."
		]);

		// Se procede al inicio de la sesión
		inicio_sesion = ajax("<?php echo site_url('sesion/iniciar'); ?>", {"id_usuario": usuario.respuesta.Pk_Id_Usuario}, "HTML");
		// imprimir(inicio_sesion);
		
		// Si no se puede iniciar sesión
		if (inicio_sesion.respuesta != true) {
			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Error", 
				"Ha ocurrido un error y la sesión no ha podido iniciarse. Por favor comuníquese con el administrador del Sistema.", 
				"bug"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        	mostrar_mensaje_pie([
        		"estado", 
        		"No se puede iniciar sesión...", 
        		"Error desconocido. Comuníquese con el área de Sistemas",
        		"bug"
    		]);

			return false;
		}; // if
		
		// Se redirecciona al inicio
		redireccionar("<?php echo site_url(''); ?>");
	} // iniciar_sesion

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Clic en Ingresar
		$("#btn_login").on("click", function(){
			// Se ejecuta la función
			iniciar_sesion();

			return false;
		});
	}); // document.ready
</script>