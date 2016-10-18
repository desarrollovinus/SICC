<h2 class="ui dividing header center aligned">
	Seleccione una aplicación
</h2>

<!-- Contenedor -->
<div id="cont_aplicaciones">
	<!-- Operaciones -->
	<div class="col-md-4" onClick="javascript:cargar('operaciones')">
		<h2 class="ui icon header">
			<i class="car icon"></i>
			<div class="content">
				Operaciones
				<div class="sub header">Gestione las incidencias, accidentes y demás sucesos de la vía.</div>
			</div>
		</h2>
	</div><!-- Operaciones -->

	<!-- Indicadores -->
	<div class="col-md-4" onClick="javascript:cargar('indicadores')">
		<h2 class="ui icon header">
			<i class="puzzle icon"></i>
			<div class="content">
				Indicadores
				<div class="sub header">Configure y evalúe los indicadores aplicables al proyecto.</div>
			</div>
		</h2>
	</div><!-- Indicadores -->
</div><!-- Contenedor -->

<script type="text/javascript">
	/**
     * Carga por Ajax la interfaz seleccionada
     */
    function cargar(tipo){
        // Dependiendo del tipo
        switch(tipo) {
			// Indicadores
            case "indicadores":
                // Se carga la interfaz
    			redireccionar("<?php echo site_url('indicadores'); ?>");
            break; // Indicadores

			// Operaciones
            case "operaciones":
                // Se carga la interfaz
    			redireccionar("<?php echo site_url('operaciones'); ?>");
            break; // Operaciones
        } // switch tipo
	} // cargar

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Configuración de los botones (de esta manera entran desactivados)
		botones();

		// Se muestra el mensaje al pié, enviando el tipo, el título, la descripción y el ícono
		mostrar_mensaje_pie([
    		"estado",
    		"Sesión iniciada",
    		"Bienvenido (a)",
    		"user"
		]);
	}); // document.ready
</script>