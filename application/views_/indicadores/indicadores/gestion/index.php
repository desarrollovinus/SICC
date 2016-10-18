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
		cargar_interfaz("cont_gestion", "<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": "gestion_crear", "id": 0});
	} // crear

	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void 
	 */
	function editar()
	{
		// Variable del indicador
		var id_indicador = validar_checks();

		// Si hay mas de un check seleccionado
		if(!id_indicador){
			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"No se puede editar ningún ítem. Por favor seleccione solo un registro para continuar", 
				"warning sign"
			]);

			return false;			
		} // if

		// Se carga la interfaz
		cargar_interfaz("cont_gestion", "<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": "gestion_crear", "id": id_indicador});
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
					"No se ha seleccionado ningún registro. Por favor seleccione al menos un indicador para continuar.", 
					"warning sign"
				]);

				return false;			
			} // if

			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal_eliminacion([
				"Advertencia", 
				"Se eliminarán " + cont + " indicadores. ¿Está seguro?", 
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
		        	"Eliminando indicador " + cont + "...", 
		        	"Eliminando el indicador."
		    	]);

		        // Se procede a eliminar el registro vía Ajax
	        	exito = ajax("<?php echo site_url('indicadores/eliminar'); ?>", {"tipo": "indicador", "id": $(this).attr("id"), "nombre": $(this).attr("data-nombre")}, "HTML");
			}); // each

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"Eliminación correcta...", 
	    		"Los indicadores seleccionados se eliminaron correctamente.",
	    		"check"
			]);

			// Se listan todos nuevamente
			listar();
		} // if
	} // eliminar

	/**
	 * Imprime el reporte en el formato especicificado en el tipo
	 * @param  {string} tipo Tipo de reporte
	 */
	function generar_reporte(tipo){
		// marcar_checks();

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
			"carga", 
        	"Generando reporte...", 
        	"Generando el reporte en " + tipo + ". Por favor espere."	
    	]);
		
		// Suiche, según el tipo
		switch(tipo) {
			// PDF
		    case "pdf":
		    	// Se genera el reporte
		        redireccionar("<?php echo site_url('reportes/pdf/indicadores'); ?>");
	        break; // PDF
		} // switch
	} // generar_reporte

	/**
	 * Gestiona el registro del formulario vía ajax
	 */
	function guardar()
	{
		// Se toman los valores
		var nombre = $("#input_nombre");
		var fecha_inicio = $("input[name='_submit']");
		var identificador = $("#input_identificador");
		var id_concepto_medicion = $("#select_concepto_medicion");
		var id_norma = $("#select_norma");
		var id_periodicidad = $("#select_periodicidad");
		var id_unidad_medida = $("#select_unidad_medida");
		var id_familia = $("#select_familia");
		var metodo_medida = $("#input_metodo_medida");
		var valor_aceptacion = $("#input_valor_aceptacion");
		var valor_maximo = $("#input_maximo");
		var valor_minimo = $("#input_minimo");
		var estado = 0;

		// Si es activo, se marca
		if ($("#check_activo").is(":checked")) {var estado = 1;}

		// Arreglo con los datos a validar
        datos_obligatorios = new Array(
            nombre.val(),
            identificador.val(),
            id_norma.val(),
            id_familia.val(),
            id_concepto_medicion.val(),
            id_periodicidad.val(),
            id_unidad_medida.val(),
            valor_maximo.val(),
            valor_minimo.val()
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
        		"No se puede guardar el indicador todavía.", 
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
		var datos = {
    		"Estado": estado,
			"Fecha_Inicio": fecha_inicio.val(),
			"Fk_Id_Concepto_Medicion": id_concepto_medicion.val(),
			"Fk_Id_Indicador_Familia": id_familia.val(),
			"Fk_Id_Norma": id_norma.val(),
			"Fk_Id_Periodicidad": id_periodicidad.val(),
			"Fk_Id_Unidad_Medida": id_unidad_medida.val(),
			"Identificador": identificador.val(),
			"Metodo_Medida": metodo_medida.val(),
			"Nombre": nombre.val(),
			"Valor_Aceptacion": valor_aceptacion.val(),
			"Valor_Maximo": valor_maximo.val(),
			"Valor_Minimo": valor_minimo.val()
		}
		// imprimir(datos);
		
		// Id del indicador
    	id_indicador = $("#id_indicador").val();
    	
    	// Si trae un id
    	if (id_indicador) {
    		// Se procede a modificar
    		exito = ajax("<?php echo site_url('indicadores/actualizar'); ?>", {"tipo": "indicador", "datos": datos, "id": id_indicador}, "HTML");
    	}else{
    		// Se valida que el identificador no esté repetido
	    	existe_identificador = ajax("<?php echo site_url('indicadores/validar_identificador'); ?>", {"identificador": identificador.val()}, "HTML");

	    	// Si el identificador existe
	    	if(existe_identificador.respuesta){
	        	// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
				modal([
					"Advertencia", 
					"El identificador " + identificador.val() + " ya está asignado para otro indicador. Por favor cámbielo o use otro para este indicador.", 
					"warning sign"
				]);

				// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	        	mostrar_mensaje_pie([
	        		"estado", 
	        		"No se puede guardar el indicador todavía.", 
	        		"Esperando que se modifique el identificador.",
	        		"announcement"
	    		]);

				return false;
	    	} // if identificador

    		// Se agrega al arreglo de datos el id del usuario creador
    		datos["Fk_Id_Usuario"] = "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>";

    		// Se guarda los datos en la base de datos
    		exito = ajax("<?php echo site_url('indicadores/insertar'); ?>", {"tipo": "indicador", "datos": datos}, "HTML");
    	} // if

    	// Si el registro no es exitoso
    	if (exito.respuesta != true) {
    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Error", 
				"Ha ocurrido un error y el indicador no ha podido guardarse. Por favor comuníquese con el administrador del Sistema.", 
				"bug"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"No se puede guardar el indicador...", 
	    		"Error desconocido. Comuníquese con el área de Sistemas",
	    		"bug"
			]);

	    	return false;
    	} // if

    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Indicador creado", 
    		"El registro ha sido creado correctamente."
		]);

    	// Se redirecciona a la lista de unidades funcionales
    	listar();
	} // guardar

	/**
	 * Listado
	 */
	function listar()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando gestión...", 
        	"mostrando la gestión de los indicadores"
    	]);

    	// Carga de interfaz
		cargar_interfaz("cont_gestion", "<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": "gestion_listar"});
	} // listar

	/**
	 * Vuelve al anterior formulario
	 */
	function volver()
	{
		// Carga de interfaz
		cargar_interfaz("cont_gestion", "<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": "index"});
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>