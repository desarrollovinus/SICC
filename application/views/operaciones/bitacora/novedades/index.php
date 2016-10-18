<!-- Contenedor -->
<div id="cont_gestion"></div>

<script type="text/javascript">
	/**
	 * Función que se activa al presionar el botón crear del menú
	 * @return void 
	 */
	function crear()
	{
		// Se carga la interfaz
		cargar_interfaz("cont_gestion", "<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": "novedades_crear", "id": 0});
	} // crear

	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void 
	 */
	function editar()
	{
		// Variable de la novedad
		var id_novedad = validar_checks();

		// Si hay mas de un check seleccionado
		if(!id_novedad){
			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"No se puede editar ninguna novedad. Por favor seleccione solo un registro para continuar", 
				"warning sign"
			]);

			return false;			
		} // if

		// Se carga la interfaz
		cargar_interfaz("cont_gestion", "<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": "novedades_crear", "id": id_novedad});
	} // editar

	/**
	 * Eliminación de registros en base de datos
	 * @param  {string} tipo tipo a eliminar
	 * @return {boolean}      true: exitoso
	 */
	function eliminar(tipo)
	{

	} // eliminar

	/**
	 * Imprime el reporte en el formato especicificado en el tipo
	 * @param  {string} tipo Tipo de reporte
	 */
	function generar_reporte(tipo){

	} // generar_reporte

	/**
	 * Gestiona el registro del formulario vía ajax
	 */
	function guardar()
	{
		// Se toman los valores
		var id_asunto = $("#select_novedad_tipo");
		var anotacion = $("#input_anotacion");
		var evento = $("#select_novedad_tipo option:selected").attr("data-evento"); // Define si el tipo de novedad crea un evento

		// Arreglo con los datos a validar
        datos_obligatorios = new Array(
            id_asunto.val(),
            anotacion.val()
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
        		"No se puede guardar el registro todavía.", 
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
    		"Anotacion": anotacion.val(),
    		"Fk_Id_Novedad_Tipo": id_asunto.val()
    	};
    	// imprimir(datos);

    	// Id de la novedad
    	id_novedad = $("#id_novedad").val();

    	// Si trae un id
    	if (id_novedad) {
    		// Se procede a modificar
    		exito = ajax("<?php echo site_url('operaciones_bitacora/actualizar'); ?>", {"tipo": "novedad", "datos": datos, "id": id_novedad}, "HTML");
    	}else{
			// Se agrega al arreglo de datos el id del usuario creador
    		datos["Fk_Id_Usuario"] = "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>";
    		
    		// Se guarda los datos en la base de datos
    		exito = ajax("<?php echo site_url('operaciones_bitacora/insertar'); ?>", {"tipo": "novedad", "datos": datos}, "HTML");

    		// Se toma el id de la novedad creado
			id_novedad = exito.respuesta;
    	} // if
    	
    	// Si crea evento
    	if (evento == 1) {
    		// Se recorren los actores chequeados
			$("[name^='actores']:checked").each(function(index){
				// Arreglo de datos del actor
				datos_actor = {
					"Fk_Id_Actor": $(this).attr("id"),
					"Fk_Id_Novedad": id_novedad
				};
				
				// Si el check no existía antes
				if ($(this).attr("data-existe") == 0) {
					// Mediante Ajax se guarda el registro
					ajax("<?php echo site_url('operaciones_bitacora/insertar'); ?>", {"tipo": "novedad_actor", "datos": datos_actor}, "HTML");
				};
			}); // each

			// Se redirige a la pantalla de actores
			listar_actores(id_novedad);
    	} else {
    		// Se redirige a la lista de eventos
    		listar();
    	} // if
	} // guardar

	/**
	 * Listado
	 */
	function listar()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando bitácora...", 
        	"mostrando la gestión de la bitácora"
    	]);

    	// Carga de interfaz
		cargar_interfaz("cont_gestion", "<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": "novedades_listar"});
	} // listar

	/**
	 * Listado de actores
	 */
	function listar_actores(id_novedad)
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando actores participantes en la novedad...", 
        	"mostrando todos los actores que participan en la novedad"
    	]);

    	// Carga de interfaz
		cargar_interfaz("cont_gestion", "<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": "novedades_actores_listar", "id_novedad": id_novedad});
	} // listar_actores

	/**
	 * Listado
	 */
	function listar_registros()
	{
    	// Carga de interfaz
		cargar_interfaz("cont_novedades", "<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": "registros_listar"});
	} // listar_registros

	/**
	 * Genera los registros en la bitácora para la interfaz de actores en cada novedad
	 * @param  {int} id_accion  Id de la acción del actor
	 * @param  {int} id_novedad Id de la novedad
	 */
	function marcar(id_accion, id_novedad){
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Creando el registro en la bitácora...", 
        	"Marcando la hora del registro"
    	]);

    	// Si ya existe la bitácora
    	if ($("#accion" + id_accion).attr("data-existe") == 1) {
    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"Ya este registro se creó. Por favor genere otro registro en la bitácora que aun no esté informado.", 
				"warning sign"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        	mostrar_mensaje_pie([
        		"estado", 
        		"No se puede guardar el registro todavía.", 
        		"Esperando que se haga un registro diferente en bitácora.",
        		"announcement"
    		]);

			return false;
    	};
    	
    	// Datos a enviar
    	datos = {
    		"Fk_Id_Usuario": "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>",
    		"Fk_Id_Actor_Accion": id_accion,
    		"Fk_Id_Novedad": id_novedad
    	};
    	// imprimir(datos)

		// Mediante ajax se crea el registro en la bitácora
		registro = ajax("<?php echo site_url('operaciones_bitacora/insertar'); ?>", {"tipo": "registro", "datos": datos}, "HTML");
		
		// Si no trae respuesta
		if (!registro.respuesta) {
			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Error", 
				"Ha ocurrido un error y el registro no ha podido guardarse. Por favor comuníquese con el administrador del Sistema.", 
				"bug"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"No se puede crear el registro en la bitácora...", 
	    		"Error desconocido. Comuníquese con el área de Sistemas",
	    		"bug"
			]);

	    	return false;
		} // if

		// Se marca el cuadro como activo
		$("#accion" + id_accion).addClass('active');

		// Se pone la hora
		$("#hora" + id_accion).text(registro.respuesta);

		// Se pinta el check
		$("#accion" + id_accion).addClass('completed');

		//
		$("#accion" + id_accion).attr({"data-existe": 1});

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Registro creado", 
    		"Se ha guardado en la base de datos el registro a las " + registro.respuesta + ".",
    		"checkmark"
		]);
	} // marcar

	/**
	 * Vuelve al anterior formulario
	 */
	function volver()
	{
		// Carga de interfaz
		cargar_interfaz("cont_gestion", "<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": "index"});
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>