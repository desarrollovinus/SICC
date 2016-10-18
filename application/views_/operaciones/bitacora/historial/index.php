<!-- Contenedor -->
<div id="cont_historial"></div>

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

	} // guardar

	/**
	 * Listado
	 */
	function listar()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando historial de la bitácora...", 
        	"mostrando el historial de loa bitácora"
    	]);

    	// Carga de interfaz
		cargar_interfaz("cont_historial", "<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": "historial_listar"});
	} // listar

	/**
	 * Listado
	 */
	function listar_registros()
	{
    	// Carga de interfaz
		cargar_interfaz("cont_registros", "<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": "historial_listar_registros"});
	} // listar_registros

	/**
	 * Vuelve al anterior formulario
	 */
	function volver()
	{
		// Carga de interfaz
		cargar_interfaz("cont_historial", "<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": "index"});
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>