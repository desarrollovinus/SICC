<!-- Contenedor -->
<div id="cont_logs"></div>

<script type="text/javascript">
	/**
	 * Lista los usuarios
	 */
	function cargar_grafico(tipo)
	{
		// Dependiendo del tipo
        switch(tipo) {
			// Logs por tipo
            case "logs_por_tipo":
                // Se carga la interfaz
    			cargar_interfaz("cont_logs_por_tipo","<?php echo site_url('reportes/graficos'); ?>", {"tipo": tipo});
            break; // ULogs por tipo
        } // switch tipo
	} // cargar_grafico

	/**
	 * Lista los usuarios
	 */
	function listar()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando información del historial...", 
        	"Accesando a los reportes y configuraciones del historial"
    	]);

		// Carga de interfaz
		cargar_interfaz("cont_logs", "<?php echo site_url('configuracion/cargar_interfaz'); ?>", {"tipo": "logs_listar"});
	} // listar

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>