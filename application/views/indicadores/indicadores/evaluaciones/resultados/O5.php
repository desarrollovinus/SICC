<?php
// Consulta de resultados
$resultados = $this->indicadores_model->resultados("O5", $anio, $mes);
$cont = 0;
$cumplidos = 0;
$incumplidos = 0;

// Recorrido de los resultados
foreach ($resultados as $resultado) {
	// Si el tiempo del registro es negativo
	if ($resultado->Diferencia < 0) {
		// Cumplidos
		$cumplidos++;
	}else{
		// Incumplidos
		$incumplidos++;
	} // if

	// Aumento del contador
	$cont++;
} // foreachn resultados
?>

<!-- Contenedor del gráfico -->
<div class="col-lg-6">
	<div id="cont_grafico"></div>
</div><!-- Contenedor del gráfico -->

<!-- Contenedor de valores -->
<div class="col-lg-6">
	OK
</div><!-- Contenedor de valores -->

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se carga la interfaz
		cargar_interfaz("cont_grafico", "<?php echo site_url('indicadores_reportes/graficos'); ?>", {"tipo": "indicador_O5", "anio": "<?php echo $anio; ?>", "mes": "<?php echo $mes; ?>", "cumplidos": "<?php echo $cumplidos; ?>", "incumplidos": "<?php echo $incumplidos; ?>"});
	}); // document.ready
</script>