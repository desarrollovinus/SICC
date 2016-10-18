<div id="cont_reportes">
	<!-- PDF -->
	<div onClick="javascript:cargar('pdf')" class="col-md-4">
		<h2 class="ui icon header">
			<i class="file pdf outline icon"></i>
			<div class="content">
				PDF
				<div class="sub header">Todos los reportes en formato PDF.</div>
			</div>
		</h2>
	</div><!-- PDF -->

	<!-- Excel -->
	<div onClick="javascript:cargar('excel')" class="col-md-4">
		<h2 class="ui icon header">
			<i class="file excel outline icon"></i>
			<div class="content">
				Excel
				<div class="sub header">Todos los reportes en hojas de cálculo.</div>
			</div>
		</h2>
	</div><!-- Excel -->

	<!-- Word -->
	<div onClick="javascript:cargar('word')" class="col-md-4">
		<h2 class="ui icon header">
			<i class="file word outline icon"></i>
			<div class="content">
				Word
				<div class="sub header">Todos los reportes en documentos de texto.</div>
			</div>
		</h2>
	</div><!-- Word -->

	<!-- Pantalla -->
	<div onClick="javascript:cargar('pdf')" class="col-md-4">
		<h2 class="ui icon header">
			<i class="desktop icon"></i>
			<div class="content">
				Pantalla
				<div class="sub header">Todos los reportes visuales en pantalla.</div>
			</div>
		</h2>
	</div><!-- Pantalla -->

	<!-- Gráficos -->
	<div onClick="javascript:cargar('graficos')" class="col-md-4">
		<h2 class="ui icon header">
			<i class="pie chart icon"></i>
			<div class="content">
				Gráficos
				<div class="sub header">Todos los reportes con gráficos.</div>
			</div>
		</h2>
	</div><!-- Gráficos -->
</div>

<script type="text/javascript">
	/**
     * Carga por Ajax del reporte seleccionado
     */
    function cargar(tipo){
        // Dependiendo del tipo
        switch(tipo) {
			// Excel
            case "excel":
                // Se carga el reporte
    			location.href = "<?php echo site_url('indicadores_reportes/excel'); ?>";
            break; // Excel

			// Gráficos
            case "graficos":
            imprimir("aqui")
                // Se carga el reporte
				cargar_interfaz("cont_reportes", "<?php echo site_url('indicadores_reportes/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Gráficos
                
			// PDF
            case "pdf":
                // Se carga el reporte
    			window.open("<?php echo site_url('indicadores_reportes/pdf'); ?>", "_blank");
            break; // PDF

			// Word
            case "word":
                // Se carga el reporte
    			location.href = "<?php echo site_url('indicadores_reportes/word'); ?>";
            break; // Word
        } // switch tipo
	} // cargar

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Módulo de reportes", 
    		"Gestione todos los reportes de la aplicación y en todos los formatos.",
    		"line chart"
		]);
	}); // document.ready
</script>