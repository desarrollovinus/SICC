/**
 * Permite procesar una solicitud vía Ajax
 * @param  {string} url            Url del controlador a donde irá
 * @param  {JSON} datos          arreglo de datos enviados
 * @param  {string} tipo_respuesta Es lo que espera como respuesta, sea texto o JSON
 * @return {string o JSON}                Dato que retornará
 */
function ajax(url, datos, tipo_respuesta)
{
	//Variable de exito
    var exito;

    // Petición ajax
	$.ajax({
		url: url,
		type: "POST",
		dataType: tipo_respuesta, // xml, json, script o html
		data: datos,
		async: false,
		success: function(respuesta){
			// Arreglo con los datos a retornar
			exito = {
				"estado": true,
				"respuesta": respuesta
			} // if
		}, // success
		error: function(respuesta){
			// Arreglo con los datos a retornar
			exito = {
				"estado": false,
				"respuesta": respuesta,
				"mensaje": respuesta
			} // if
		} // error
	});

	// Se retorna el arreglo
	return exito;
} // ajax

/**
 * Configuración de los botones que aparecen activos en
 * el menú superior derecho
 * @param  array parametros Arreglo JSON con los botones activos o inactivos
 * @return {[type]}            [description]
 */
function botones(parametros)
{
	// Se declaran las variables
	var crear = $("#icono_crear");
	var editar = $("#icono_editar");
	var eliminar = $("#icono_eliminar");
	var guardar = $("#icono_guardar");
	var historial = $("#icono_historial");
	var listar = $("#icono_listar");
	var pdf = $("#icono_pdf");
	var volver = $("#icono_volver");

	// Se ocultan todos los íconos por defecto
	crear.hide();
	editar.hide();
	eliminar.hide();
	guardar.hide();
	historial.hide();
	listar.hide();
	pdf.hide();
	volver.hide();

	// Si trae alguna Configuración
	if (parametros) {
		// Activamos según los parámetros verdaderos
		if (parametros.crear) { 
			crear.show(); 
			crear.popup({inline: true});
		};

		if (parametros.editar) { 
			editar.show(); 
			editar.popup({inline: true});
		};

		if (parametros.eliminar) { 
			eliminar.show(); 
			eliminar.popup({inline: true});
		};

		if (parametros.guardar) { 
			guardar.show(); 
			guardar.popup({inline: true});
		};

		if (parametros.historial) { 
			historial.show(); 
			historial.popup({inline: true});
		};

		if (parametros.listar) { 
			listar.show(); 
			listar.popup({inline: true});
		};

		if (parametros.pdf) { 
			pdf.show(); 
			pdf.popup({inline: true});
		};

		if (parametros.volver) { 
			volver.show(); 
			volver.popup({inline: true});
		};
	} // if
} // botones

/**
 * Carga la interfaz seleccionada
 * @param  {string} contenedor Nombre del contenedor donde se va a cargar
 * @param  {string} url        Url que va a cargar
 * @param  {array} datos      Datos a cargar
 * @return {void}            
 */
function cargar_interfaz(contenedor, url, datos)
{
	// Configuración de los botones (de esta manera entran desactivados)
	botones();

	// Carga de la interfaz
	$("#" + contenedor).hide().load(url, datos).fadeIn('500');
} // cargar_interfaz

/**
 * Esta función cuenta los checks para saber cuáles imprimirá
 * en reportes o en otra cosa
 * @return {boolean} true: tiene al menos uno; false: no tiene ninguno seleccionado
 */
function marcar_checks(){
	// Variable contadora
	var cont = 0;

	var ids = new Array();

	// Se recorren los checkbox chequeados
	$("input[name='seleccionado']:checked").each(function(index){
		// Aumento del contador
		cont++;
		ids.push($("input[name='seleccionado']:checked").attr("id"));
	});

	// // Si hay solo un check seleccionado
	// if (cont > 0) {
	// 	// Exito
	// 	return $("input[name='seleccionado']:checked").attr("id");
	// }else{
	// 	// Retorno falso
	// 	return false;
	// } // if

	imprimir(ids)
} // marcar_checks

/**
 * Imprime un mensaje en consola
 * @param  {string} mensaje Mensaje a imprimir
 * @return {string}         Mensaje a imprimir
 */
function imprimir(mensaje)
{
	// Se imprime el mensaje
	console.log(mensaje);
} // imprimir

/**
 * Mensaje mostrado al pié de la página
 * @param  {array} datos Datos de carga
 * @return {void}       
 */
function mostrar_mensaje_pie(datos)
{
	// Nombre de la clase del ícono del pié de página
	var icono_pie = $("#icono_pie").val();

	// Suiche
	switch(datos[0]) {
		// Usado cuando se esté cargando una interfaz
		case "carga":
			$("#cargador .header").text(datos[1]); // Agrega el título
			$("#cargador>i").removeClass(icono_pie); // Elimina los íconos anteriores
			$("#cargador>i").addClass("circle loading"); // Agrega los íconos y la animación
			$("#cargador p").text(datos[2]); // Agrega la descripción
		break;

		// Usado cuando se esté cargando una interfaz
		case "estado":
			$("#cargador .header").text(datos[1]); // Agrega el título
			$("#cargador>i").removeClass("circle loading " + icono_pie); // Elimina la animación y los íconos anteriores
			$("#cargador p").text(datos[2]); // Agrega la descripción
			$("#icono_pie").val(datos[3]); // Almacena el nuevo ícono vigente
			$("#cargador>i").addClass(datos[3]); // Agrega el nuevo ícono
		break;

		// Cuando ya realizó la acción
		case "final":
			setTimeout(function(){
				$("#cargador .header").text(datos[1]); // Agrega el título
				$("#cargador>i").removeClass("circle loading " + icono_pie); // Elimina la animación y los íconos anteriores
				$("#cargador p").text(datos[2]); // Agrega la descripción
				$("#cargador>i").addClass(datos[3]); // Agrega el nuevo ícono
			}, 3500);
		break;
	} // Suiche
} // mensaje_pie

function mensaje_pie()
{
	imprimir("cambiar nombre de función")
}

/**
 * Activa o desactiva el menú lateral
 * @return void
 */
function menu_lateral(){
    // Activa o desactiva el botón
    $('.ui.sidebar').sidebar('toggle');
} // menu_lateral

/**
 * Muestra un mensaje como modal. Se usa para todo tipo
 * de mensajes de aviso y confirmación
 * @param  {string} titulo  Título del mensaje
 * @param  {string} mensaje Descripción del mensaje a enviar
 * @param  {string} icono   Nombre de la clase del ícono que va a mostar
 */
function modal(datos)
{
	// Se ponen los valores que se reciben antes de enviar el modal
	$('#modal_mensaje .image>i').addClass(datos[2]);
	$('#modal_mensaje .header').text(datos[0])
	$('#modal_mensaje .description>p').text(datos[1]);

	// Se abre el modal
	$('#modal_mensaje').modal('show');
} // modal

/**
 * Muestra un mensaje como modal. Se usa para 
 * los mensajes de confirmación de eliminación de registros
 * @param  {string} titulo  Título del mensaje
 * @param  {string} mensaje Descripción del mensaje a enviar
 * @param  {string} icono   Nombre de la clase del ícono que va a mostar
 */
function modal_eliminacion(datos)
{
	// Se ponen los valores que se reciben antes de enviar el modal
	$('#modal_eliminacion .image>i').addClass(datos[2]);
	$('#modal_eliminacion .header').text(datos[0])
	$('#modal_eliminacion .description>p').text(datos[1]);

	// Se abre el modal
	$('#modal_eliminacion').modal('show');
} // modal_eliminar

/**
 * Redirecciona al sitio indicado
 * @param  {string} url Url a donde redireccionará
 * @return {void}     
 */
function redireccionar(url)
{
    //Se redirecciona
    location.href = url;
} // redireccionar

/**
 * Permite que todos los checks de una tabla o una lista
 * se seleccionen o deseleccionen
 */
function seleccionar_todo(tabla)
{
	// Si el elemento está siendo chequeado
	if ($("#todos").is(":checked")) {
        // Estará activo
        activo = true;
	} else {
        // Estará desactivado
        activo = false;
	} // if

	// Definición de tanla
	oTable = $('#' + tabla).dataTable();

	// Si está chequeado
	if ($("#todos").is(":checked")){
        // Se chequean todos
        $('input[name=\'seleccionado\']', oTable.fnGetNodes()).prop('checked', activo);
    } else {
    	// Se desactivan todos los checks
        $('input[name=\'seleccionado\']', oTable.fnGetNodes()).removeAttr('checked');
    } // if
} // seleccionar_todo

/**
 * Pone un valor por defecto a un select
 * @param  {string} elemento Nombre del select
 * @param  {string} valor    Valor del option
 */
function select_por_defecto(elemento, valor)
{
	// Se pone el valor por defecto al elemento seleccionado
	$('#' + elemento + ' option[value="' + valor + '"]').attr("selected",true);
} // select_por_defecto

/**
 * Escanea todos los campos en búsqueda de campos vacíos
 * @param  {array} campos Textos de los campos a validar
 * @return {boolean}        1: Campos con información; 0: campos pendientes por llenar
 */
function validar_campos_obligatorios(campos)
{
    //Variable contadora
    validacion = 0;

    //Recorrido para validar cada campo
    for (var i = 0; i < campos.length; i++){
        // validacion campo a campo
        if($.trim(campos[i]) != "") {
        	// Se aumenta el contador
            validacion++;
        } // if
    } // for

    //Si todos los campos superan la validación
    if (validacion == campos.length) {
        //Retorna ok
        return true;
    } else {
        //Retorna falso
        return false;
    } // if

    //Se resetea la variable contadora
    validacion = 0;
} // validar_campos_obligatorios

/**
 * Esta función valida los checks para que tenga solo uno
 * seleccionado, para posteriormente editarlo
 * @return {boolean} true: tiene solo uno; false: tiene varios seleccionados
 */
function validar_checks(){
	// Variable contadora
	var cont = 0;

	// Se recorren los checkbox chequeados
	$("input[name='seleccionado']:checked").each(function(index){
		// Aumento del contador
		cont++;

		// imprimir("El checkbox con valor " + $(this).attr("id") + " está seleccionado");
	});

	// Si hay solo un check seleccionado
	if (cont == 1) {
		// Exito
		return $("input[name='seleccionado']:checked").attr("id");
	}else{
		// Retorno falso
		return false;
	} // if
} // validar_checks