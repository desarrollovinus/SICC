<center>
	<h2 class="ui header">
		<i class="bus icon"></i>
		<div class="content">
			Informe de tráfico y recaudo - Hatovial S.A.S.
		</div>
	</h2>
</center>



<div class="ui divider"></div>

<!-- Tabla de acumulados -->
<div id="tbl_datos"></div>

<div class="ui top attached tabular menu">
	<a class="item active" data-tab="niquia">Niquía</a>
	<a class="item" data-tab="trapiche">Trapiche</a>
	<a class="item" data-tab="cabildo">Cabildo</a>
</div>

<!-- Niquía -->
<div class="ui bottom attached tab segment active" data-tab="niquia">
	<div id="niquia_trafico"></div>
	<div id="niquia_recaudo"></div>
</div><!-- Niquía -->

<!-- Trapiche -->
<div class="ui bottom attached tab segment" data-tab="trapiche">
	<div id="trapiche_trafico"></div>
	<div id="trapiche_recaudo"></div>
</div><!-- Trapiche -->

<!-- Cabildo -->
<div class="ui bottom attached tab segment" data-tab="cabildo">
	<div id="cabildo_trafico"></div>
	<div id="cabildo_recaudo"></div>
</div><!-- Cabildo -->

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		$('.menu .item').tab();

		// $("#tbl_datos_niquia, #tbl_datos_trapiche, #tbl_datos_cabildo").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "tabla"});
		$("#tbl_datos").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "tabla"});

		// Tráfico de Niquía
		$("#niquia_trafico").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "trafico", "peaje": "niquia"});

		// // Recaudo de Niquía
		$("#niquia_recaudo").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "recaudo", "peaje": "niquia"});

		// Tráfico de Trapiche
		$("#trapiche_trafico").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "trafico", "peaje": "trapiche"});

		// // Recaudo de Trapiche
		$("#trapiche_recaudo").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "recaudo", "peaje": "trapiche"});
		
		// Tráfico de Cabildo
		$("#cabildo_trafico").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "trafico", "peaje": "cabildo"});

		// // Recaudo de Cabildo
		$("#cabildo_recaudo").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "recaudo", "peaje": "cabildo"});

		// Configuración de los botones (de esta manera entran desactivados)
		botones();

		// Se oculta la barra inferior
		$("#cargador").hide();
	}); // document.ready
</script>