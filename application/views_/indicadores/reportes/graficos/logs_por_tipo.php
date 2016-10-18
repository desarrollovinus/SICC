<script type="text/javascript">
    // Cuando el DOM esté listo
    $(document).ready(function() {
    	imprimir("llega")
    	// Se consulta vía ajax los datos del reporte
    	datos = ajax("<?php echo site_url('reportes/cargar') ?>", {"tipo": "logs_por_tipo"}, "JSON");
    	imprimir(datos.respuesta);

    	// Se recorren los arreglos
    	$.each(datos.respuesta, function(key, val){
    		// Se toma el número que viene como cadena de texto y se convierte a número
    		numero = parseFloat(val.y);
			
			// Se reemplaza el valor        	
            val.y = numero;
        })//Fin each

    	// Ejecución del gráfico
        $('#cont_logs_por_tipo').highcharts({
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: 'Historial de registros por tipo de acciones'
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
	                    style: {
	                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
	                    }
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: 'Porcentaje de calibraciones',
	            data: datos.respuesta
	        }]
	    }); // gráfico

	    // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Historial por acciones", 
    		"Gráfico que indica el porcentaje que ha tenido cada acción dentro de la aplicación.",
    		"pie chart"
		]);
    });
</script>