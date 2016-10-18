<!-- Contenedor -->
<div id="cont_periodicidades"></div>

<script type="text/javascript">
	/**
	 * Función que se activa al presionar el botón crear del menú
	 * @return void 
	 */
	function crear()
	{
		// Se carga la interfaz
		cargar_interfaz("cont_periodicidades", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "periodicidades_crear", "id": 0});
	} // crear

	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void 
	 */
	function editar()
	{
		// Variable de la periodicidad
		var id_periodicidad = validar_checks();

		// Si hay mas de un check seleccionado
		if(!id_periodicidad){
			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"No se puede editar ninguna periodicidad. Por favor seleccione solo un registro para continuar", 
				"warning sign"
			]);

			return false;			
		} // if

		// Se carga la interfaz
		cargar_interfaz("cont_periodicidades", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "periodicidades_crear", "id": id_periodicidad});
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
		if (tipo == "confirmacion"){
			// Se recorren los checkbox chequeados
			$("[name^='seleccionado']:checked").each(function(index){
				// Aumento del contador
				cont++;

				// imprimir("El checkbox con valor " + $(this).attr("id") + " está seleccionado");
			}); // each

			// Si no hay checks seleccionados
			if(cont == 0){
				// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
				modal([
					"Advertencia", 
					"No se ha seleccionado ningún registro. Por favor seleccione al menos una periodicidad para continuar.", 
					"warning sign"
				]);

				return false;			
			} // if

			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal_eliminacion([
				"Advertencia", 
				"Se eliminarán " + cont + " periodicidades y los indicadores asociados a estas. ¿Está seguro?", 
				"warning circle"
			]);
		}else if(tipo = "aceptacion"){
			// Se recorren los checkbox chequeados
			$("[name^='seleccionado']:checked").each(function(index){
				// Aumento del contador
				cont++;

				// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		        mostrar_mensaje_pie([
		        	"carga", 
		        	"Eliminando periodicidad " + cont + "...", 
		        	"Eliminando la periodicidad y los indicadores asociados a ella."
		    	]);

		        // Se procede a eliminar la unidad funcional vía Ajax
	        	exito = ajax("<?php echo site_url('indicadores_configuracion/eliminar'); ?>", {"tipo": "periodicidad", "id": $(this).attr("id"), "nombre": $(this).attr("data-nombre")}, "HTML");
			}); // each

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"Eliminación correcta...", 
	    		"Las periodicidades seleccionadas se eliminaron correctamente.",
	    		"bug"
			]);
			
			// Se listan todos nuevamente
			listar();
		} // if
	} // eliminar

	/**
	 * Gestiona el registro del formulario vía ajax
	 */
	function guardar()
	{
		// Se toman los valores
		var nombre = $("#input_nombre");
		var codigo = $("#input_codigo");
		var dias = $("#input_dias");
		var estado = 0;

		// Si es activo, se marca
		if ($("#check_activo").is(":checked")) {var estado = 1;}

		// Arreglo con los datos a validar
        datos_obligatorios = new Array(
            nombre.val(),
			codigo.val(),
			dias.val()
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
        		"No se puede guardar la periodicidad todavía.", 
        		"Esperando que se diligencien los datos obligatorios.",
        		"announcement"
    		]);

			return false;
        } // if

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Guardando datos...", 
        	"Ingresando los datos en base de datos."
    	]);

    	// Se recogen los datos a guardar
    	datos = {
    		"Codigo": codigo.val(),
    		"Dias": dias.val(),
    		"Estado": estado,
    		"Nombre": nombre.val()
    	};
    	// imprimir(datos);
    	
    	// Id de la periodicidad
    	id_periodicidad = $("#id_periodicidad").val();

    	// Si trae un id
    	if (id_periodicidad) {
    		// Se procede a modificar
    		exito = ajax("<?php echo site_url('indicadores_configuracion/actualizar'); ?>", {"tipo": "periodicidad", "datos": datos, "id": id_periodicidad}, "HTML");
    	}else{
    		// Se agrega al arreglo de datos el id del usuario creador
    		datos["Fk_Id_Usuario"] = "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>";
    		
    		// Se guarda los datos en la base de datos
    		exito = ajax("<?php echo site_url('indicadores_configuracion/insertar'); ?>", {"tipo": "periodicidad", "datos": datos}, "HTML");
    	} // if

    	// Si el registro no es exitoso
    	if (exito.respuesta != true) {
    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Error", 
				"Ha ocurrido un error y la periodicidad no ha podido guardarse. Por favor comuníquese con el administrador del Sistema.", 
				"bug"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"No se puede guardar la periodicidad...", 
	    		"Error desconocido. Comuníquese con el área de Sistemas",
	    		"bug"
			]);

	    	return false;
    	} // if

    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Periodicidad creada", 
    		nombre.val() + " ha sido creada correctamente."
		]);

    	// Se redirecciona a la lista de unidades funcionales
    	listar();
	} // guardar

	/**
	 * Lista las periodicidades
	 */
	function listar()
	{
    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando periodicidades...", 
        	"Listando todas los lapsos de tiempo registrados"
    	]);
		    	
		// Carga de interfaz
		cargar_interfaz("cont_periodicidades", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "periodicidades_listar"});
	} // listar

	/**
	 * Vuelve al anterior formulario
	 */
	function volver()
	{
		// Carga de interfaz
		cargar_interfaz("cont_periodicidades", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "index"});
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>