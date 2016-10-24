<!-- Contenedor de tráfico -->
<div id="trafico"></div>
<?php echo "trafico " . $peaje; ?>

<script type="text/javascript">
	$(function () {
		imprimir("tráfico de " + "<?php echo $peaje; ?>")
		// Arreglos de datos
		// Se consultan los días
		var dias2 = ajax("<?php echo site_url('peaje/cargar'); ?>", {"tipo": "dias_mes", "anio": "<?php echo date('Y'); ?>", "mes": "<?php echo date('m') ?>", "peaje": "<?php echo $peaje; ?>"}, "JSON");
		var dias = [];
		var pagaron = [];
		var no_pagaron = [];

		$.each(dias2.respuesta, function(key, val){
            dias.push(val.Dia)
            pagaron.push(parseFloat(val.pagados))
            no_pagaron.push( parseFloat(val.sin_pagar))
        })//Fin each
		

		$('#trafico').highcharts({
		    title: {
		        text: 'Informe de tráfico diario del mes de octubre ('+'<?php echo $peaje ?>'+')'
		    },
		    xAxis: {
		    	// Arreglo de los días
		        categories: dias
		        // categories: ['01', '02', '03', '04', '05']
		    },
		    labels: {
		        /*items: [{
		            html: 'Total pagando / sin pagar',
		            style: {
		                left: '50px',
		                top: '18px',
		                color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
		            }
		        }]*/
		    },
		    // Arreglo con las columnas y sus valores
		    series: [{
		        type: 'column',
		        name: 'Total',
		        data: pagaron,
	            color: Highcharts.getOptions().colors[0]
		    }, {
		        type: 'column',
		        name: 'Sobretasa',
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