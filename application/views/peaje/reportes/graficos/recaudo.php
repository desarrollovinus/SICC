<!-- Contenedor de recaudo -->
<div id="recaudo"></div>

<script type="text/javascript">
	$(function () {
		// Arreglos de datos
		// Se consultan los días
		var dias2 = ajax("<?php echo site_url('peaje/cargar'); ?>", {"tipo": "dias_mes", "anio": "<?php echo date('Y'); ?>", "mes": "<?php echo date('m') ?>", "peaje": "<?php echo $peaje; ?>"}, "JSON");
		var dias = [];
		var recaudo = [];
		var sobretasa = [];

		$.each(dias2.respuesta, function(key, val){
            dias.push(val.Dia)
            recaudo.push(parseFloat(val.total_recaudo))
            sobretasa.push( parseFloat(val.total_sobretasa))
        })//Fin each
		

		$('#recaudo').highcharts({
		    title: {
		        text: '<?php echo $peaje ?>'
		    },
		    xAxis: {
		    	// Arreglo de los días
		        categories: dias
		        // categories: ['01', '02', '03', '04', '05']
		    }/*,
		    labels: {
		        items: [{
		            html: 'Total recaudo / sobretasa',
		            style: {
		                left: '50px',
		                top: '18px',
		                color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
		            }
		        }]
		    }*/,
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