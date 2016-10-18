<!-- Contenedor -->
<div id="cont_bitacora">
	<!-- Novedades -->
	<div class="col-md-4" onClick="javascript:cargar('novedades')">
		<h2 class="ui icon header">
			<i class="exchange icon"></i>
			<div class="content">
				Novedades
				<div class="sub header">Cree, modifique y revise las novedades.</div>
			</div>
		</h2>
	</div><!-- Novedades -->

	<!-- Historial -->
	<div class="col-md-4" onClick="javascript:cargar('historial')">
		<h2 class="ui icon header">
			<i class="history icon"></i>
			<div class="content">
				Historial
				<div class="sub header">Revise el histórico de anotaciones en la bitácora</div>
			</div>
		</h2>
	</div><!-- Historial -->

	<!-- Twitter -->
	<div class="col-md-4" onClick="javascript:cargar('gestion')">
		<h2 class="ui icon header">
			<i class="twitter icon"></i>
			<div class="content">
				Twitter
				<div class="sub header">Publique mensajes del estado de la vía e informativos en Twitter.</div>
			</div>
		</h2>
	</div><!-- Twitter -->
</div>

<script type="text/javascript">
	/**
     * Carga por Ajax la interfaz seleccionada
     */
    function cargar(tipo){
        // Dependiendo del tipo
        switch(tipo) {
        	// Historial
            case "historial":
                // Se carga la interfaz
    			cargar_interfaz("cont_bitacora","<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Historial

        	// Novedades
            case "novedades":
                // Se carga la interfaz
    			cargar_interfaz("cont_bitacora","<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Novedades
        } // switch tipo
	} // cargar

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Bitácora", 
    		"Gestione el día a día de la operación, publique mensajes en Twitter y reporte eventos.",
    		"settings"
		]);
	}); // document.ready
</script>