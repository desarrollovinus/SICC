<?php
// Carpeta de archivos de Excel
$dir = "./archivos/peajes/recaudos/";

// // Se recorren los archivos
// foreach(glob($dir.'*', GLOB_NOSORT) as $archivo){
//     echo "Filename: " . $archivo . "<br />";
    
//     // Se crea el objeto
//    	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
// 	$objReader->setReadDataOnly(true);
	 
// 	// Se lee el archivo
// 	$objPHPExcel = $objReader->load($archivo);
// 	$objWorksheet = $objPHPExcel->getActiveSheet();

// 	echo "- Valor: ".$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, 6)->getValue();
// 	echo "<br>";
 	

// 	// echo '<table>' . "\n";
// 	// foreach ($objWorksheet->getRowIterator() as $row) {
// 	// echo '<tr>' . "\n";
	 
// 	// $cellIterator = $row->getCellIterator();
// 	// $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
// 	// // even if it is not set.
// 	// // By default, only cells
// 	// // that are set will be
// 	// // iterated.
// 	// foreach ($cellIterator as $cell) {
// 	// echo '<td>' . $cell->getValue() . '</td>' . "\n";
// 	// }
	 
// 	// echo '</tr>' . "\n";
// 	// }
// 	// echo '</table>' . "\n";
// } // foreach archivos
?>

<h3 class="ui top attached header">
	<i class="plug icon"></i> Tráfico
</h3>
<div class="ui attached segment">
	<p>
		<div id="niquia_trafico"></div>
	</p>

	<p>
		<div id="trapiche_trafico"></div>
	</p>

	<p>
		<!-- <div id="cabildo_trafico"></div> -->
	</p>
</div>

<h3 class="ui top attached header">
	<i class="plug icon"></i> Recaudo
</h3>
<div class="ui attached segment">
	<p>
		<div id="niquia_recaudo"></div>
	</p>

	<p>
		<div id="trapiche_recaudo"></div>
	</p>

	<p>
		<!-- <div id="cabildo_recaudo"></div> -->
	</p>
</div>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Tráfico de Niquía
		$("#niquia_trafico").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "trafico", "peaje": "niquia"});

		// Tráfico de Trapiche
		$("#trapiche_trafico").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "trafico_trapiche", "peaje": "trapiche"});

		// Tráfico de Cabildo
		$("#cabildo_trafico").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "trafico_cabildo", "peaje": "cabildo"});

		
		// Recaudo de Niquía
		$("#niquia_recaudo").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "recaudo", "peaje": "niquia"});
		
		// Recaudo de Trapiche
		$("#trapiche_recaudo").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "recaudo_trapiche", "peaje": "trapiche"});

		// Recaudo de Cabildo
		$("#cabildo_recaudo").load("<?php echo site_url('peaje_reportes/graficos'); ?>", {"tipo": "recaudo_cabildo", "peaje": "cabildo"});

		// Configuración de los botones (de esta manera entran desactivados)
		botones();

		// Se muestra el mensaje al pié, enviando el tipo, el título, la descripción y el ícono
		mostrar_mensaje_pie([
    		"estado",
    		"Recaudo de peajes",
    		"Bienvenido (a)",
    		"car"
		]);
	}); // document.ready
</script>