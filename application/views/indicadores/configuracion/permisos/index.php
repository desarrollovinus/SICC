<!-- Contenedor -->
<div id="cont_permisos"></div>

<script type="text/javascript">
	/**
     * Carga por Ajax la interfaz seleccionada
     */
    function cargar(tipo){
        // Dependiendo del tipo
        switch(tipo) {
			// Usuarios
            case "usuarios":
            	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		        mostrar_mensaje_pie([
		        	"carga", 
		        	"Cargando usuarios...", 
		        	"Accesando al listado de usuarios del sistema Hatoapps"
		    	]);

                // Se carga la interfaz
    			cargar_interfaz("cont_configuracion","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Usuarios
        } // switch tipo
	} // cargar
	
	/**
	 * Carga la interfaz de tipo de acciones como se 
	 * visualizarán los permisos
	 */
	function cargar_tipo(tipo, id)
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando permisos...", 
        	"Accesando a los permisos de la aplicación."
    	]);
		    	
		// Carga de interfaz
		cargar_interfaz("cont_segmento_acciones", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": tipo, "id": id});
	} // volver

	/**
	 * Gestiona el registro del formulario vía ajax
	 */
	function guardar()
	{
		// Arreglo para los permisos
		var permisos = new Array();

		// Si el tipo es usuarios
		if ($("#id_tipo").val() == "usuarios") {
			// Declaración de Variables	
			var id_usuario = $("#id_usuario").val();
			var nombre_usuario = $("#select_usuarios option:selected").text();

			//Se recorren los chequeados
	    	$("input[name='permiso[]']:checked").each(function() {
	            //Se agrega el check al arreglo
	            permisos.push($(this).val());
	        });//each
	        // imprimir(permisos);
	        
	        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	        mostrar_mensaje_pie([
	        	"carga", 
	        	"Actualizando datos...", 
	        	"Asignando los nuevos permisos..."
	    	]);
	        
	        // Se borran los permisos anteriores del usuario
	        borrar_permisos = ajax("<?php echo site_url('indicadores_configuracion/eliminar'); ?>", {"tipo": "permisos_usuario", "id": id_usuario}, "HTML");
	        // imprimir(borrar_permisos.respuesta);

	        // Si no se borra correctamente
	        if (!borrar_permisos.respuesta) {
	        	// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
				modal([
					"Error", 
					"Ha ocurrido un error y no se han podido borrar los permisos anteriores del usuario. Por favor comuníquese con el administrador del Sistema.", 
					"bug"
				]);

				// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		    	mostrar_mensaje_pie([
		    		"estado", 
		    		"No se pueden asignar los nuevos permisos al usuario...", 
		    		"Error desconocido. Comuníquese con el área de Sistemas",
		    		"bug"
				]);

				return false;
	        } // if

	        // Si hay algún permiso seleccionado
	    	if (permisos.length > 0) {
	        	// Se agregan vía ajax los nuevos permisos
	        	agregar_permisos = ajax("<?php echo site_url('indicadores_configuracion/insertar'); ?>", {"tipo": "permisos_usuario", "datos": permisos, "id_usuario": id_usuario, "nombre": nombre_usuario});

	        	// Si no se guardó exitosamente
	        	if(!agregar_permisos.respuesta){
	        		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
					modal([
						"Error", 
						"Ha ocurrido un error y no se han podido asignar los permisos al usuario. Por favor comuníquese con el administrador del Sistema.", 
						"bug"
					]);

					// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
			    	mostrar_mensaje_pie([
			    		"estado", 
			    		"No se pueden asignar los nuevos permisos al usuario...", 
			    		"Error desconocido. Comuníquese con el área de Sistemas",
			    		"bug"
					]);

					return false;
	        	} // if
	    	} // if

	    	// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Éxito", 
				"Los permisos para " + nombre_usuario + " se han actualizado correctamente.", 
				"checkmark box"
			]);
	    	
	    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"Permisos actualizados correctamente.", 
	    		"Seleccione otro usuario para modificar los permisos o vuelva atrás.",
	    		"check"
			]);
		} // if tipo
		
		// Si el tipo es módulos
		if ($("#id_tipo").val() == "modulos") {
			// Declaración de Variables	
			var id_modulo = $("#id_modulo").val();
			var nombre_modulo = $("#select_modulos option:selected").text();
			var datos = {};

			// Se consultan los usuarios que tienen permisos a las acciones de este módulo
			borrar_permisos = ajax("<?php echo site_url('indicadores_configuracion/eliminar'); ?>", {"tipo": "permisos_modulo", "id": id_modulo}, "JSON");
			// imprimir(borrar_permisos.respuesta);
			
			// Si no se borra correctamente
	        if (!borrar_permisos.respuesta) {
	        	// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
				modal([
					"Error", 
					"Ha ocurrido un error y no se han podido borrar los permisos anteriores. Por favor comuníquese con el administrador del Sistema.", 
					"bug"
				]);

				// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		    	mostrar_mensaje_pie([
		    		"estado", 
		    		"No se pueden asignar los nuevos permisos...", 
		    		"Error desconocido. Comuníquese con el área de Sistemas",
		    		"bug"
				]);

				return false;
	        } // if

			//Se recorren los chequeados
	    	$("input[name='permiso[]']:checked").each(function() {
	    		// En el arreglo a enviar se almacenan los id de usuario y de la acción
	    		datos["Fk_Id_Usuario"] = $(this).val();
	    		datos["Fk_Id_Accion"] = $(this).attr("data-accion");

	        	// Se agregan vía ajax los nuevos permisos
	        	agregar_permisos = ajax("<?php echo site_url('indicadores_configuracion/insertar'); ?>", {"tipo": "permisos_modulo", "datos": datos});

	        	// Si no se guardó exitosamente
	        	if(!agregar_permisos.respuesta){
	        		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
					modal([
						"Error", 
						"Ha ocurrido un error y no se han podido asignar los permisos al usuario. Por favor comuníquese con el administrador del Sistema.", 
						"bug"
					]);

					// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
			    	mostrar_mensaje_pie([
			    		"estado", 
			    		"No se pueden asignar los nuevos permisos al usuario...", 
			    		"Error desconocido. Comuníquese con el área de Sistemas",
			    		"bug"
					]);

					return false;
	        	} // if
	        });//each

			// Al final, se agrega un solo registro de auditoría para todos los cambios
    		ajax("<?php echo site_url('indicadores_configuracion/insertar'); ?>", {"tipo": "permisos_auditoria", "id_modulo": id_modulo, "nombre": nombre_modulo});

    		// Después de guardados los permisos, procedemos a refrescar los permisos vía ajax
    		
    		
	        
	        // Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Éxito", 
				"Los permisos para el módulo de  " + nombre_modulo + " se han actualizado correctamente.", 
				"checkmark box"
			]);
	    	
	    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"Permisos actualizados correctamente.", 
	    		"Seleccione otro módulo para modificar los permisos o vuelva atrás.",
	    		"check"
			]);
		} // if tipo
	} // guardar

	/**
	 * Lista los usuarios
	 */
	function listar()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando permisos y accesos...", 
        	"Ingresando a la configuración de permisos y accesos"
    	]);

		// Carga de interfaz
		cargar_interfaz("cont_permisos", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "permisos_listar"});
	} // listar

	/**
	 * Vuelve al anterior formulario
	 */
	function volver()
	{
		// Carga de interfaz
		cargar_interfaz("cont_permisos", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "index"});
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>