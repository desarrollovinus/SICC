<?php
// Se consulta los segmentos de la unidad funcional elegida
$segmentos = $this->configuracion_model->cargar("unidad_funcional_segmentos", $id_unidad_funcional);

// Se recorren los segmentos
foreach ($segmentos as $segmento) { ?>
	<!-- Segmento -->
	<div class="col-lg-2">
		<div class="field">
			<!-- Título -->
			<div class="ui label" style="width: 100%;">
				Segmento <?php echo $segmento->Numero; ?>
				<div class="detail"><?php echo number_format($segmento->Valor, 0, "","."); ?></div>
			</div>

			<!-- Campo -->
			<input type="text" id="input_segmento" value="<?php if(isset($indicador->Nombre)){echo $indicador->Nombre;} ?>" name="evaluacion">
			<br><br>
		</div>
	</div><!-- Segmento -->
<?php } // foreach segmentos ?>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"listar": true, "guardar": true, "volver": true});
	}); // document.ready
</script>