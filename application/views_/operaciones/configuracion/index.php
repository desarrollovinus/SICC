<div id="cont_configuracion">
	<!-- Asuntos -->
	<div class="col-md-4" onClick="javascript:cargar('conceptos_medicion')">
		<h2 class="ui icon header">
			<i class="resize horizontal icon"></i>
			<div class="content">
				Asuntos
				<div class="sub header">Asuntos usados para la gestión de la bitácora</div>
			</div>
		</h2>
	</div><!-- Asuntos -->
</div>

<script type="text/javascript">
	/**
     * Carga por Ajax la interfaz seleccionada
     */
    function cargar(tipo){
        // Dependiendo del tipo
        switch(tipo) {
        	// Familias
            case "":
                // Se carga la interfaz
    			cargar_interfaz("cont_configuracion","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Familias
        } // switch tipo
	} // cargar

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Módulo de configuración", 
    		"Administre la aplicación, gestionando listas, permisos y demás configuraciones.",
    		"settings"
		]);
	}); // document.ready
</script>