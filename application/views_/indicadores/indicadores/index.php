<div id="cont_indicadores">
	<!-- Gestión -->
	<div class="col-md-4" onClick="javascript:cargar('gestion')">
		<h2 class="ui icon header">
			<i class="exchange icon"></i>
			<div class="content">
				Gestión
				<div class="sub header">Cree, modifique y elimine indicadores.</div>
			</div>
		</h2>
	</div><!-- Gestión -->

	<!-- Políticas -->
	<div class="col-md-4" onClick="javascript:cargar('politicas')">
		<h2 class="ui icon header">
			<i class="flag icon"></i>
			<div class="content">
				Políticas
				<div class="sub header">Configure las políticas de los indicadores.</div>
			</div>
		</h2>
	</div><!-- Políticas -->

	<!-- Evaluación -->
	<div class="col-md-4" onClick="javascript:cargar('evaluaciones')">
		<h2 class="ui icon header">
			<i class="calculator icon"></i>
			<div class="content">
				Evaluación
				<div class="sub header">Evalúe los indicadores en cada unidad funcional.</div>
			</div>
		</h2>
	</div><!-- Evaluación -->
</div>

<script type="text/javascript">
	/**
     * Carga por Ajax del la interfaz seleccionada
     */
    function cargar(tipo){
        // Dependiendo del tipo
        switch(tipo) {
			// Evaluaciones
            case "evaluaciones":
                // Se carga la interfaz
    			cargar_interfaz("cont_indicadores","<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Evaluaciones

			// Gestión
            case "gestion":
                // Se carga la interfaz
    			cargar_interfaz("cont_indicadores","<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Gestión

			// Políticas
            case "politicas":
                // Se carga la interfaz
    			cargar_interfaz("cont_indicadores","<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Políticas
        } // switch tipo
	} // cargar

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se muestra el mensaje al pié, enviando el tipo, el título, la descripción y el ícono
		mostrar_mensaje_pie([
    		"estado",
    		"Indicadores",
    		"Gestión de indicadores",
    		"certificate"
		]);
	}); // document.ready
</script>