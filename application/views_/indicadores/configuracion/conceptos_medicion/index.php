<!-- Contenedor -->
<div id="cont_conceptos"></div>

<script type="text/javascript">
	/**
	 * Función que se activa al presionar el botón crear del menú
	 * @return void 
	 */
	function crear()
	{
		// Se carga la interfaz
		cargar_interfaz("cont_conceptos", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "conceptos_medicion_crear", "id": 0});
	} // crear

	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void 
	 */
	function editar()
	{
		// Variable del concepto de medición
		var id_concepto_medicion = validar_checks();

		// Si hay mas de un check seleccionado
		if(!id_concepto_medicion){
			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"No se puede editar ningún ítem. Por favor seleccione solo un registro para continuar", 
				"warning sign"
			]);

			return false;			
		} // if

		// Se carga la interfaz
		cargar_interfaz("cont_conceptos", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "conceptos_medicion_crear", "id": id_concepto_medicion});
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
					"No se ha seleccionado ningún registro. Por favor seleccione al menos un concepto de medición para continuar.", 
					"warning sign"
				]);

				return false;			
			} // if

			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal_eliminacion([
				"Advertencia", 
				"Se eliminarán " + cont + " familias de indicadores y los indicadores asociados a estas. ¿Está seguro?", 
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
		        	"Eliminando concepto " + cont + "...", 
		        	"Eliminando el concepto de medición y los indicadores asociados a este."
		    	]);

		        // Se procede a eliminar el concepto de medición vía Ajax
	        	exito = ajax("<?php echo site_url('indicadores_configuracion/eliminar'); ?>", {"tipo": "concepto_medicion", "id": $(this).attr("id"), "nombre": $(this).attr("data-nombre")}, "HTML");
			}); // each

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"Eliminación correcta...", 
	    		"Los conceptos me medición seleccionados se eliminaron correctamente.",
	    		"check"
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
		var descripcion = $("#input_descripcion");
		var nombre = $("#input_nombre");
		var estado = 0;

		// Si es activo, se marca
		if ($("#check_activo").is(":checked")) {var estado = 1;}

		// Arreglo con los datos a validar
        datos_obligatorios = new Array(
            descripcion.val()
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
        		"No se puede guardar el concepto todavía.", 
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
    		"Estado": estado,
    		"Descripcion": descripcion.val(),
    		"Nombre": nombre.val()
    	};
    	// imprimir(datos);

    	// Id del concepto de medición
    	id_concepto_medicion = $("#id_concepto_medicion").val();

    	// Si trae un id
    	if (id_concepto_medicion) {
    		// Se procede a modificar
    		exito = ajax("<?php echo site_url('indicadores_configuracion/actualizar'); ?>", {"tipo": "concepto_medicion", "datos": datos, "id": id_concepto_medicion}, "HTML");
    	}else{
    		// Se agrega al arreglo de datos el id del usuario creador
    		datos["Fk_Id_Usuario"] = "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>";

    		// Se guarda los datos en la base de datos
    		exito = ajax("<?php echo site_url('indicadores_configuracion/insertar'); ?>", {"tipo": "concepto_medicion", "datos": datos}, "HTML");
    	} // if
    	
    	// Si el registro no es exitoso
    	if (exito.respuesta != true) {
    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Error", 
				"Ha ocurrido un error y el concepto de medición no ha podido guardarse. Por favor comuníquese con el administrador del Sistema.", 
				"bug"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"No se puede guardar el concepto de medición...", 
	    		"Error desconocido. Comuníquese con el área de Sistemas",
	    		"bug"
			]);

	    	return false;
    	} // if

    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Concepto de medición creado", 
    		"El registro ha sido creado correctamente."
		]);

    	// Se redirecciona a la lista de unidades funcionales
    	listar();
	} // guardar

	/**
	 * Lista los conceptos de medición
	 */
	function listar()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando conceptos de medición...", 
        	"Listando los conceptos de medición aplicables a las políticas de indicadores"
    	]);
		    	
		// Carga de interfaz
		cargar_interfaz("cont_conceptos", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "conceptos_medicion_listar"});
	} // listar

	/**
	 * Vuelve al anterior formulario
	 */
	function volver()
	{
		// Carga de interfaz
		cargar_interfaz("cont_conceptos", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "index"});
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>