<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Variables para el gráfico
		var cumplidos = parseFloat("<?php echo $cumplidos; ?>");
		var incumplidos = parseFloat("<?php echo $incumplidos; ?>");

		imprimir(incumplidos);

	    $('#cont_grafico').highcharts({
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: 0,
	            plotShadow: false
	        },
	        title: {
	            text: 'Indicador<br>O5',
	            align: 'center',
	            verticalAlign: 'middle',
	            y: 40
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                dataLabels: {
	                    enabled: true,
	                    distance: -50,
	                    style: {
	                        fontWeight: 'bold',
	                        color: 'white',
	                        textShadow: '0px 1px 2px black'
	                    }
	                },
	                startAngle: -90,
	                endAngle: 90,
	                center: ['50%', '75%']
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: 'Browser share',
	            innerSize: '50%',
	            data: [
	                ['Cumplidos',   cumplidos],
	                ['Incumplidos',       incumplidos],
	                {
	                    name: 'Proprietary or Undetectable',
	                    // y: 0.2,
	                    y: 0,
	                    dataLabels: {
	                        enabled: false
	                    }
	                }
	            ]
	        }]
	    });
	}); // document.ready
</script>