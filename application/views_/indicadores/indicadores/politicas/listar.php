<?php
// Carga de datos
$unidades_funcionales_activas = $this->configuracion_model->cargar("unidades_funcionales_activas", NULL);
$indicadores_activos = $this->indicadores_model->cargar("indicadores_activos", NULL);
?>

<h2 class="ui dividing header center aligned">
	Políticas de indicadores
</h2>

<div class="table_responsive">
	<table class="table table-striped table-hover" id="tbl_politicas">
		<thead>
			<tr>
				<th class="text-center">Id</th>
				<th class="text-center">Indicador</th>
				<!-- Se recorren las unidades funcionales -->
				<?php foreach ($unidades_funcionales_activas as $unidad_funcional) { ?>
					<th class="text-center"><?php echo "{$unidad_funcional->Codigo} <br> ($unidad_funcional->Nombre)"; ?></th>
				<?php } // foreach  ?>
			</tr>
		</thead>
		<tbody>
			<!-- Se recorren los indicadores activos -->
			<?php foreach ($indicadores_activos as $indicador) { ?>
				<tr>
					<td width="50px"><?php echo $indicador->Identificador; ?></td>
					<td width="20%"><?php echo $indicador->Nombre; ?></td>
					<?php
					// Se recorren las unidades funcionales
					foreach ($unidades_funcionales_activas as $unidad_funcional) {
						// Se consulta la política creada para el indicador y la unidad funcional
						$politica = $this->indicadores_model->cargar("politica", array("Id_Unidad_Funcional" => $unidad_funcional->Pk_Id, "Id_Indicador" => $indicador->Pk_Id));
					?>
						<td class="text-center">
							<div class="field">
								<input type="text" data-uf='<?php echo $unidad_funcional->Pk_Id; ?>' data-indicador="<?php echo $indicador->Pk_Id; ?>" class="input_politica" name="valor" value="<?php if(isset($politica->Valor)){echo $politica->Valor;} ?>">
							</div>
						</td>
					<?php
					} // foreach 
					?>
				</tr>
			<?php } // foreach  ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de la tabla
        $('#tbl_politicas').DataTable({
	    	paging: true,
	    	"scrollX": true
		});

        // Campos a bloquear para que sea sólo numérico (todos los input)
		$("[name^='valor']").numericInput({
            allowFloat: true, 
            allowNegative: false
        });

        // Se activan los botones
        botones({"guardar": true, "volver": true});

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
        	"Gestión de políticas de indicadores", 
        	"Configure las políticas de indicadores.",
        	"flag"
    	]);
	}); // document.ready
</script>