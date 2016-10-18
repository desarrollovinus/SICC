<!-- Contenedor -->
<div id="cont_politicas"></div>

<script type="text/javascript">
	/**
	 * Función que se activa al presionar el botón crear del menú
	 * @return void 
	 */
	function crear()
	{

	} // crear

	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void 
	 */
	function editar()
	{

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
	 * Gestiona el registro del formulario vía ajax
	 */
	function guardar()
	{
		// Se borran todas las políticas anteriores
		eliminar =ajax("<?php echo site_url('indicadores/eliminar'); ?>", {"tipo": "politicas"}, "HTML");
		// imprimir(eliminar)

    	// Se recorren todos los input
		$("[name^='valor']").each(function(index){
			// Se toman los valores
			var id_unidad_funcional = $(this).attr("data-uf");
			var id_indicador = $(this).attr("data-indicador");
			var valor = $(this).val();
			
			var datos = {
				"Fk_Id_Unidad_Funcional": id_unidad_funcional,
				"Fk_Id_Indicador": id_indicador,
				"Valor": valor
			} // datos
			// imprimir(datos);

			// Se crea el registro en base de datos
			ajax("<?php echo site_url('indicadores/insertar'); ?>", {"tipo": "politica", "datos": datos}, "HTML");
		}); // each

		// Se muestra el modal, enviando título, descripción y nombre de la clase del ícono a usar
		modal([
			"Éxito", 
			"Los datos se han actualiado correctamente.", 
			"check"
		]);

		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Políticas actualizadas", 
    		"Los valores de las políticas de indicadores se han actualizado correctamente.",
    		"check"
		]);
	} // guardar

	/**
	 * Listado
	 */
	function listar()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando políticas...", 
        	"mostrando la política de los indicadores"
    	]);

    	// Carga de interfaz
		cargar_interfaz("cont_politicas", "<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": "politicas_listar"});
	} // listar

	/**
	 * Vuelve al anterior formulario
	 */
	function volver()
	{
		// Carga de interfaz
		cargar_interfaz("cont_politicas", "<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": "index"});
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>