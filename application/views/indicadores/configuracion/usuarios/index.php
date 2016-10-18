<!-- Contenedor -->
<div id="cont_usuarios"></div>

<script type="text/javascript">
	/**
	 * Función encargada de dar o revocar los permisos
	 * de acceso a la aplicación a un usuario específico
	 * @param  {int} id_usuario Id del usuario
	 * @param  {string} nombres    Nombre completo del usuario
	 * @return {void}            
	 */
	function accesar(id_usuario, nombres){
		// Datos a enviar para la actualización
		datos = {
			"Fk_Id_Usuario": id_usuario,
			"Fk_Id_Aplicacion": "<?php echo $this->config->item('id_aplicacion'); ?>",
		};
		// imprimir(datos)
			
		// Si el check del usuario seleccionado está activo
		if($("#check" + id_usuario).is(":checked")){
			// Variables para los cambios
			var texto = "No";
			var titulo = "Acceso denegado";
			var descripcion = "El permiso de acceso a la aplicación ha sido eliminado a " + nombres + ".";
			var icono = "warning circle";
	
			// Mediante ajax, se elimina el permiso
			exito = ajax("<?php echo site_url('sesion/eliminar'); ?>", {"tipo": "acceso", "id": id_usuario, "nombre": nombres}, "HTML");
		}else{
			// Variables para los cambios
			var texto = "Si";
			var titulo = "Acceso concedido";
			var descripcion = "El permiso de acceso a la aplicación se le ha otorgado correctamente a " + nombres + ".";
			var icono = "check circle";

			// Mediante ajax, se le da permiso para que acceda a la aplicación
			exito = ajax("<?php echo site_url('sesion/insertar'); ?>", {"tipo": "acceso", "datos": datos, "nombre": nombres}, "HTML");
		} // if

		// Si el registro no es exitoso
    	if (exito.respuesta != true) {
    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Acceso ", 
				"Ha ocurrido un error y la actualización no se ha podido realizar. Por favor comuníquese con el administrador del Sistema.", 
				"bug"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"No se puede guardar dar acceso...", 
	    		"Error desconocido. Comuníquese con el área de Sistemas",
	    		"bug"
			]);

	    	return false;
    	} // if

		// Se cambia el texto
		$("#label" + id_usuario).text(texto);

		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
		modal([
			titulo, 
			descripcion, 
			icono
		]);
	} // accesar

	/**
	 * Función que se activa al presionar el botón crear del menú
	 * @return void 
	 */
	function crear()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando el formulario...", 
        	"Accesando al formulario de creación del usuario."
    	]);

		// Se carga la interfaz
		cargar_interfaz("cont_usuarios", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "usuarios_crear", "id": 0});
	} // crear

	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void 
	 */
	function editar()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando el formulario...", 
        	"Accesando al formulario de edición del usuario."
    	]);

		// Variable del usuario
		var id_usuario = validar_checks();

		// Si hay mas de un check seleccionado
		if(!id_usuario){
			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"No se puede editar ningún usuario. Por favor seleccione solo un registro para continuar", 
				"warning sign"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	        mostrar_mensaje_pie([
	        	"estado", 
	        	"Seleccione un usuario...", 
	        	"Debe seleccionar un usuario para poder editarlo."
	    	]);

			return false;			
		} // if
    	
		// Se carga la interfaz
		cargar_interfaz("cont_usuarios", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "usuarios_crear", "id": id_usuario});
	} // editar

	/**
	 * Eliminación de registros en base de datos
	 * @param  {string} tipo tipo a eliminar
	 * @return {boolean}      true: exitoso
	 */
	function eliminar(tipo)
	{
		// Variable contadora
		var cont = 0;

		// Si es confirmación
		if (tipo == "confirmacion") {
			// Se recorren los checkbox chequeados
			$("[name^='seleccionado']:checked").each(function(index){
				// Aumento del contador
				cont++;

				// imprimir("El checkbox con valor " + $(this).attr("id") + " está seleccionado");
			}) // each

			// Si no hay checks seleccionados
			if(cont == 0){
				// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
				modal([
					"Advertencia", 
					"No se ha seleccionado ningún registro. Por favor seleccione al menos un usuario para continuar.", 
					"warning sign"
				]);

				return false;			
			} // if

			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal_eliminacion([
				"Advertencia", 
				"Se eliminarán " + cont + " usuarios y sus respectivos permisos a esta y otras aplicaciones que dependen de la base de datos Hatoapps. ¿Está seguro?", 
				"warning circle"
			]);
		}else if(tipo = "aceptacion"){
	    	// Se recorren los checkbox chequeados
			$("[name^='seleccionado']:checked").each(function(index){
				// Aumento del contador
				cont++;

				// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		        mensaje_pie([
		        	"carga", 
		        	"Eliminando usuario " + cont + "...", 
		        	"Eliminando el usuario y todos sus accesos de la base de datos Hatoapps."
		    	]);

		        // Se procede a eliminar el usuario vía Ajax
	        	exito = ajax("<?php echo site_url('sesion/eliminar'); ?>", {"tipo": "usuario", "id": $(this).attr("id"), "nombre": $(this).attr("data-nombre")}, "HTML");
			}) // each

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"Eliminación correcta...", 
	    		"Los usuarios seleccionados se eliminaron correctamente.",
	    		"bug"
			]);

			// Se listan todos nuevamente
			listar()
		} // if
	} // eliminar

	/**
	 * Gestiona el registro del formulario vía ajax
	 */
	function guardar()
	{
		// Se toman los valores
		var nombres = $("#input_nombres");
		var apellidos = $("#input_apellidos");
		var documento = $("#input_documento");
		var email = $("#input_email");
		var telefono = $("#input_telefono");
		var login = $("#input_login");
		var login_anterior = $("#input_login_anterior");
		var password1 = $("#input_clave");
		var password2 = $("#input_clave2");
		var estado = 0;
    	var id_usuario = $("#id_usuario").val();
    	var pass = 0; // Variable para verificar si la contraseña se guarda o no

		// Si es activo, se marca
		if ($("#check_activo").is(":checked")) {var estado = 1;}

		// Arreglo con los datos a validar
        datos_obligatorios = new Array(
			apellidos.val(),
            nombres.val(),
			login.val(),
			documento.val()
        );
		// imprimir(datos_obligatorios);
		
		// Se ejecuta la validación de los datos obligatorios
        validacion = validar_campos_obligatorios(datos_obligatorios);

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
			"carga", 
        	"Verificando información...", 
        	"Validando que se hayan ingresado los datos obligatorios."
    	]);

    	//Si no supera la validacíón
        if (!validacion) {
        	// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"Faltan campos por diligenciar. Por favor asegúrese de ingresar los campos marcados como obligatorios.", 
				"warning sign"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        	mostrar_mensaje_pie([
        		"estado",
        		"No se puede guardar los cambios todavía...",
        		"Esperando que se diligencien los datos obligatorios.",
        		"announcement"
    		]);

			return false;
        } // if

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
			"carga", 
        	"Validando contraseñas...", 
        	"Validando que se hayan ingresado ambas contraseñas."
    	]);
    	
    	// Si es usuario nuevo (no trae un id) o ha digitado alguna de las contraseñas
    	if (!id_usuario || $.trim(password1.val()) != "" || $.trim(password2.val()) != ""){
    		// Arreglo con los datos a validar que solo aplica para los nuevos usuarios
	        datos_obligatorios = new Array(
				password1.val(),
				password2.val()
	        );
			// imprimir(datos_obligatorios);
			
			// Se ejecuta la validación de los datos obligatorios
	        validacion = validar_campos_obligatorios(datos_obligatorios);

	        //Si no supera la validacíón
	        if (!validacion) {
	        	// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
				modal([
					"Advertencia", 
					"Por favor digite la contraseña en ambas ocasiones.", 
					"warning sign"
				]);

				// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	        	mostrar_mensaje_pie([
	        		"estado", 
	        		"No se puede guardar los cambios todavía...", 
	        		"Esperando que se digite la contraseña.",
	        		"announcement"
	    		]);

				return false;
	        } // if
    	} // if

    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Verificando usuario...", 
        	"El sistema está consultando la disponibilidad del usuario."
    	]);

    	// Si es usuario nuevo (no trae un id) o si cambió el nombre de usuario
    	if (!id_usuario || $.trim(login.val()) != $.trim(login_anterior.val())){
    		// se valida el nombre de usuario elegido
    		login_disponible = ajax("<?php echo site_url('sesion/validar_usuario'); ?>", {"usuario": $.trim(login.val())}, "HTML");

    		// Si el usuario no está disponible
    		if (!login_disponible.respuesta) {
    			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
				modal([
					"Advertencia", 
					"El nombre de usuario '" + $.trim(login.val()) + "' ya está en uso. Por favor digite un nombre de usuario diferente.", 
					"warning sign"
				]);

				// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	        	mostrar_mensaje_pie([
	        		"estado", 
	        		"Nombre de usuario no válido", 
	        		"Esperando que se cambie el nombre de usuario.",
	        		"announcement"
	    		]);

    			return false;
    		};
    	} // if

    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Verificando contraseñas...", 
        	"El sistema está comprobando que ambas contraseñas coincidan."
    	]);

    	// Si las contraseñas son diferentes
    	if ($.trim(password1.val()) != $.trim(password2.val())) {
    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"Las contraseñas no coinciden. Por favor intente nuevamente.", 
				"warning sign"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        	mostrar_mensaje_pie([
        		"estado", 
        		"Contraseñas diferentes", 
        		"Esperando que las contraseñas coincidan.",
        		"announcement"
    		]);

			return false;
    	};

    	// Si al fin hay clave
    	if ($.trim(password1.val()) != "") {
    		// La clave es la que se ingresó
    		var pass = $.trim(password1.val())
    	} // if

    	// Se recogen los datos a guardar
    	datos = {
    		"Apellidos": apellidos.val(),
    		"Documento": documento.val(),
    		"Email": email.val(),
    		"Estado": estado,
    		"Nombres": nombres.val(),
    		"Password": pass,
    		"Telefono": telefono.val(),
    		"Tipo": 1,
    		"Usuario": login.val()
    	};
    	// imprimir(datos);

    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Guardando datos...", 
        	"El sistema está guardando la información."
    	]);

        // Si trae id de usuario (usuario a actualizar)
    	if (id_usuario) {
    		// Se procede a modificar
    		exito = ajax("<?php echo site_url('sesion/actualizar'); ?>", {"tipo": "usuario", "datos": datos, "id": id_usuario}, "HTML");
    	}else{
    		// Se guarda los datos en la base de datos
    		exito = ajax("<?php echo site_url('sesion/insertar'); ?>", {"tipo": "usuario", "datos": datos}, "HTML");

    		// Datos a enviar para la actualización
			datos = {
				"Fk_Id_Usuario": exito.respuesta,
				"Fk_Id_Aplicacion": "<?php echo $this->config->item('id_aplicacion'); ?>",
			};
			// imprimir(datos)

    		// Mediante ajax, se le da permiso para que acceda a la aplicación (usuarios nuevos)
			acceso = ajax("<?php echo site_url('sesion/insertar'); ?>", {"tipo": "acceso", "datos": datos, "nombre": nombres.val() + " " + apellidos.val()}, "HTML");
			// imprimir(acceso)
    	} // if

    	// Si el registro no es exitoso
    	if (!exito.respuesta) {
    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Error", 
				"Ha ocurrido un error y el usuario no ha podido guardarse. Por favor comuníquese con el administrador del Sistema.", 
				"bug"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"No se puede guardar el usuario...", 
	    		"Error desconocido. Comuníquese con el área de Sistemas",
	    		"bug"
			]);

	    	return false;
    	} // if

    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Usuario", 
    		nombres.val() + apellidos.val() + " ha sido creado correctamente y tiene acceso autorizado a la aplicación.",
    		"check"
		]);

    	// Se redirecciona a la lista de unidades funcionales
    	listar();
	} // guardar

	/**
	 * Carga la interfaz del historial del usuario
	 * @return void
	 */
	function historial()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando historial del usuario...", 
        	"Accesando al historial en la aplicación para este usuario"
    	]);

		// Variable del usuario
		var id_usuario = validar_checks();

		// Si hay mas de un check seleccionado
		if(!id_usuario){
			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"No se puede accesar al historial. Por favor un único usuario para continuar.", 
				"warning sign"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	        mostrar_mensaje_pie([
	        	"estado", 
	        	"Seleccione un único usuario...", 
	        	"Debe seleccionar un usuario para poder ver su historial."
	    	]);

			return false;			
		} // if

		// Carga de interfaz
		cargar_interfaz("cont_usuarios", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "usuario_historial", "id": id_usuario});
	} // historial

	/**
	 * Lista los usuarios
	 */
	function listar()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando usuarios...", 
        	"Accesando al listado de usuarios del sistema Hatoapps"
    	]);

		// Carga de interfaz
		cargar_interfaz("cont_usuarios", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "usuarios_listar"});
	} // listar

	/**
	 * Vuelve al anterior formulario
	 */
	function volver()
	{
		// Carga de interfaz
		cargar_interfaz("cont_usuarios", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "index"});
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>