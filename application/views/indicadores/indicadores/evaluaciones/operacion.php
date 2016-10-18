<form class="ui form">
	<!-- Año -->
	<div class="col-lg-4">
		<div class="field">
			<label for="select_anio">Año</label>
			<select id="select_anio" class="ui fluid search dropdown" autofocus>
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de los años -->
				<?php foreach ($this->configuracion_model->cargar("anios", NULL) as $anio) { ?>
					<option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
				<?php } // foreach ?>
			</select>
		</div>
	</div><!-- Año -->

	<!-- Mes -->
	<div class="col-lg-4">
		<div class="field">
			<label for="select_mes">Mes</label>
			<select id="select_mes" class="ui fluid search dropdown">
				<!-- Option vacío -->
				<option value="">Obligatorio</option>

				<!-- Recorrido de los meses -->
				<?php foreach ($this->configuracion_model->cargar("meses", NULL) as $mes) { ?>
					<option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
				<?php } // foreach ?>
			</select>
		</div>
	</div><!-- Mes -->
</form>

<!-- Contenedor de resultados -->
<div id="cont_resultados"></div>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Variables
		anio = $("#select_anio");
		mes = $("#select_mes");

		// Se ponen los valores por defecto (Año y mes actuales)
		select_por_defecto("select_anio", "<?php echo date('Y'); ?>");
		select_por_defecto("select_mes", "<?php echo date('m'); ?>");
		
		// Activación de los selects
		$("#select_anio, #select_mes").dropdown({
			allowAdditions: true
		}); // dropdown

		// de entrada, se lista la interfaz
		cargar_interfaz("cont_resultados", "<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": "evaluaciones_resultados", "indicador": "O5", "anio": anio.val(), "mes": mes.val()});

		// Cuando se cambie el año o el mes
		$("#select_anio, #select_mes").on("change", function(){
			// Se lista la interfaz
			cargar_interfaz("cont_resultados", "<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": "evaluaciones_resultados", "indicador": "O5", "anio": anio.val(), "mes": mes.val()});
		}); // change
	}); // document.ready
</script>