<!-- Contenedor -->
<div id="cont_unidades_funcionales"></div>

<script type="text/javascript">
	/**
	 * Función que se activa al presionar el botón crear del menú
	 * @return void 
	 */
	function crear()
	{
		// Se carga la interfaz
		cargar_interfaz("cont_unidades_funcionales", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "unidades_funcionales_crear", "id": 0});
	} // crear
	
	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void 
	 */
	function editar()
	{
		// Variable de la unidad funcional
		var id_unidad_funcional = validar_checks();

		// Si hay mas de un check seleccionado
		if(!id_unidad_funcional){
			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Advertencia", 
				"No se puede editar ninguna unidad funcional. Por favor seleccione solo un registro para continuar", 
				"warning sign"
			]);

			return false;			
		} // if
		
		// Se carga la interfaz
		cargar_interfaz("cont_unidades_funcionales", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "unidades_funcionales_crear", "id": id_unidad_funcional});
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
					"No se ha seleccionado ningún registro. Por favor seleccione al menos una unidad funcional para continuar.", 
					"warning sign"
				]);

				return false;			
			} // if

			// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal_eliminacion([
				"Advertencia", 
				"Se eliminarán " + cont + " unidades funcionales y las políticas de indicadores asociadas a estas. ¿Está seguro?", 
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
		        	"Eliminando unidad funcional " + cont + "...", 
		        	"Eliminando la unidad funcional y las políticas asociadas a ella."
		    	]);

		        // Se procede a eliminar la unidad funcional vía Ajax
	        	exito = ajax("<?php echo site_url('indicadores_configuracion/eliminar'); ?>", {"tipo": "unidad_funcional", "id": $(this).attr("id"), "nombre": $(this).attr("data-nombre")}, "HTML");
			}); // each

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"Eliminación correcta...", 
	    		"Las unidades funcionales seleccionadas se eliminaron correctamente.",
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
		var nombre = $("#input_nombre");
		var codigo = $("#input_codigo");
		var abscisado = $("#input_abscisado");
		var longitud = $("#input_longitud");
		var segmento = $("#input_segmento");
		var monto = $("#input_monto");
		var peso = $("#input_peso");
		var estado = 0;

		// Si es activo, se marca
		if ($("#check_activo").is(":checked")) {var estado = 1;}

		// Arreglo con los datos a validar
        datos_obligatorios = new Array(
            nombre.val(),
            abscisado.val(),
            longitud.val(),
			codigo.val()
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
        		"No se puede guardar la unidad funcional todavía.", 
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
    		"Abscisado_Inicial": abscisado.val(),
    		"Codigo": codigo.val(),
    		"Estado": estado,
    		"Longitud": longitud.val(),
    		"Monto": monto.val(),
    		"Nombre": nombre.val(),
    		"Peso": peso.val(),
    		"Tamanio_Segmento": segmento.val()
    	};
    	// imprimir(datos);
		
		// Id de la unidad funcional
    	id_unidad = $("#id_unidad").val();// Longitud de la unidad funcional
			

    	// Si trae un id
    	if (id_unidad) {
    		// Se procede a modificar
    		exito = ajax("<?php echo site_url('indicadores_configuracion/actualizar'); ?>", {"tipo": "unidad_funcional", "datos": datos, "id": id_unidad}, "HTML");
    	}else{
    		// Se agrega al arreglo de datos el id del usuario creador
    		datos["Fk_Id_Usuario"] = "<?php echo $this->session->userdata('Pk_Id_Usuario'); ?>";
    		
    		// Se guarda los datos en la base de datos
    		exito = ajax("<?php echo site_url('indicadores_configuracion/insertar'); ?>", {"tipo": "unidad_funcional", "datos": datos}, "HTML");

    		// Si se guardó exitosamente
    		if (exito.respuesta) {
    			// Tamaño de la longitud
				longitud = longitud.val();

				// Tamaño del segmento
				tamanio_segmento = parseFloat(segmento.val());

				// Total de segmentos
				total = longitud/tamanio_segmento;

				// Contador
				var cont = 0;

				// Recorrido de los segmentos
				for (var i = 1; i <= total; i++){
					// Si hay un segmento
					if (i % 1 == 0) {
						// Aumento del contador
						cont = cont + tamanio_segmento;

						// Valor a guardar
						valor = tamanio_segmento;
					} // if

					// Si es el último segmento completo
					if (i+1 > total) {
						// Se guarda el sobrante
						cont = longitud - cont;

						// Se almacena el valor
						valor = tamanio_segmento + cont  ;
					}

					// Arreglo a guardar el segmento
    				datos_segmento = {
    					"Fk_Id_Unidad_Funcional": exito.respuesta,
    					"Numero": i,
    					"Valor": valor
    				} // datos
    				// imprimir(datos_segmento);
    				
    				// Se guarda el segmento en base de datos
    				ajax("<?php echo site_url('indicadores_configuracion/insertar'); ?>", {"tipo": "unidad_funcional_segmento", "datos": datos_segmento}, "HTML");
				} // for
    			// imprimir(datos_segmento);
    		} // if
    	} // if
    	
    	// Si el registro no es exitoso
    	if (!exito.respuesta) {
    		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
			modal([
				"Error", 
				"Ha ocurrido un error y la unidad funcional no ha podido guardarse. Por favor comuníquese con el administrador del Sistema.", 
				"bug"
			]);

			// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
	    	mostrar_mensaje_pie([
	    		"estado", 
	    		"No se puede guardar la unidad funcional...", 
	    		"Error desconocido. Comuníquese con el área de Sistemas",
	    		"bug"
			]);

	    	return false;
    	} // if

    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Unidad funcional creada", 
    		nombre.val() + " ha sido creada correctamente."
		]);

    	// Se redirecciona a la lista de unidades funcionales
    	listar();
	} // guardar

	/**
	 * Lista las unidades funcionales
	 */
	function listar()
	{
    	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando unidades funcionales...", 
        	"Listando todas las unidades funcionales del proyecto"
    	]);
		    	
		// Carga de interfaz
		cargar_interfaz("cont_unidades_funcionales", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "unidades_funcionales_listar"});
	} // listar

	/**
	 * Vuelve al anterior formulario
	 */
	function volver()
	{
		// Carga de interfaz
		cargar_interfaz("cont_unidades_funcionales", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "index"});
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>