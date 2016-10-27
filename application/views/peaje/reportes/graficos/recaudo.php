<!-- Contenedor de recaudo -->
<div id="recaudo<?php echo $peaje; ?>"></div>

<script type="text/javascript">
	$(function () {
		// Arreglos de datos
		var datos = ajax("<?php echo site_url('peaje/cargar'); ?>", {"tipo": "dias_mes", "anio": "<?php echo date('Y'); ?>", "mes": "<?php echo date('m') ?>", "peaje": "<?php echo $peaje; ?>"}, "JSON");
		
		// Arreglos vacíos
		var dias = [];
		var recaudo = [];
		var sobretasa = [];

		// Se recorren los registros
		$.each(datos.respuesta, function(key, val){
			// Se almacenan en los arreglos
            dias.push(val.Dia)
            recaudo.push(parseFloat(val.total_recaudo))
            sobretasa.push( parseFloat(val.total_sobretasa))
        })//Fin each
		
		// Se ejecuta el gráfico
		$('#recaudo<?php echo $peaje; ?>').highcharts({
		    title: {
		        text: 'Recaudo (pesos)'
		    },
		    xAxis: {
		    	// Arreglo de los días
		        categories: dias
		    },
		    // Arreglo con las columnas y sus valores
		    series: [{
		        type: 'column',
		        name: 'Subtotal',
		        data: recaudo,
	            color: Highcharts.getOptions().colors[2]
		    }, {
		        type: 'column',
		        name: 'Sobretasa',
		        data: sobretasa,
	            color: Highcharts.getOptions().colors[1]
		    }, {
		    	// Línea
		        type: 'spline',
		        name: 'Curva de comportamiento',
		        data: recaudo,
		        marker: {
		            lineWidth: 2,
		            lineColor: Highcharts.getOptions().colors[3],
		            fillColor: 'white'
		        }
		    }]
		});
	});
</script>