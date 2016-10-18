<!-- Contenedor -->
<div id="cont_historial"></div>

<script type="text/javascript">
	/**
     * Carga por Ajax la interfaz seleccionada
     */
    function cargar(tipo, datos){
        // Dependiendo del tipo
        switch(tipo) {
			// Tabla de logs
            case "logs":
            	// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
		        mostrar_mensaje_pie([
		        	"carga", 
		        	"Cargando los registros del historial...", 
		        	"Mostrando los registros del historial del usuario. Por favor espere."
		    	]);

                // Se carga la interfaz
    			cargar_interfaz("cont_logs","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "usuario_historial_logs", "id_usuario": datos[0], "id_modulo": datos[1], "id_accion": datos[2]});
            break; // Tabla de logs
        } // switch tipo
	} // cargar

	/**
	 * Lista el historial
	 */
	function listar()
	{
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"carga", 
        	"Cargando el historial del usuario...", 
        	"Accesando a los registros históricos del usuario"
    	]);

		// Carga de interfaz
		cargar_interfaz("cont_historial", "<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "usuario_historial_listar", "id": "<?php echo $id_usuario; ?>"});
	} // listar

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	}); // document.ready
</script>