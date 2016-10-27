<!-- Contenedor de tráfico -->
<div id="trafico<?php echo $peaje; ?>"></div>

<script type="text/javascript">
	$(function () {
		// Arreglos de datos
		var datos = ajax("<?php echo site_url('peaje/cargar'); ?>", {"tipo": "dias_mes", "anio": "<?php echo date('Y'); ?>", "mes": "<?php echo date('m') ?>", "peaje": "<?php echo $peaje; ?>"}, "JSON");
		
		// Arreglos vacíos
		var dias = [];
		var pagaron = [];
		var no_pagaron = [];

		// Se recorren los registros
		$.each(datos.respuesta, function(key, val){
            dias.push(val.Dia)
            pagaron.push(parseFloat(val.pagados))
            no_pagaron.push( parseFloat(val.sin_pagar))
        })//Fin each
		
		// Se ejecuta el gráfico
		$('#trafico<?php echo $peaje; ?>').highcharts({
		    title: {
		        text: 'Tráfico (vehículos)'
		    },
		    xAxis: {
		    	// Arreglo de los días
		        categories: dias
		    },
		    // Arreglo con las columnas y sus valores
		    series: [{
		        type: 'column',
		        name: 'Pagaron',
		        data: pagaron,
	            color: Highcharts.getOptions().colors[0]
		    }, {
		        type: 'column',
		        name: 'No pagaron',
		        data: no_pagaron,
	            color: Highcharts.getOptions().colors[3]
		    }, {
		    	// Línea
		        type: 'spline',
		        name: 'Curva de comportamiento',
		        data: pagaron,
		        marker: {
		            lineWidth: 2,
		            lineColor: Highcharts.getOptions().colors[5],
		            fillColor: 'white'
		        }
		    }]
		});
	});
</script>