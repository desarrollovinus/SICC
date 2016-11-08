<div class="table_responsive">
	<table class="table table-striped table-hover" id="tbl_registros">
		<thead>
			<tr>
				<th>Peaje</th>
				<th class="text-right">TPD Acumulado (vehículos)</th>
				<th class="text-right">TPD día (vehículos)</th>
				<th class="text-right">Recaudo acumulado (pesos)</th>
				<th class="text-right">Recaudo día (pesos)</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Niquía
			$niquia_acumulado = $this->peaje_model->cargar("trafico_acumulado", array("peaje" => "Niquia"));
			$niquia_dia = $this->peaje_model->cargar("trafico_acumulado", array("peaje" => "Niquia", "dia" => true));
			
			// Trapiche
			$trapiche_acumulado = $this->peaje_model->cargar("trafico_acumulado", array("peaje" => "Trapiche"));
			$trapiche_dia = $this->peaje_model->cargar("trafico_acumulado", array("peaje" => "Trapiche", "dia" => true));
			
			// Cabildo
			$cabildo_acumulado = $this->peaje_model->cargar("trafico_acumulado", array("peaje" => "Cabildo", "anio" => date("Y"), "mes" => date("m")));
			$cabildo_dia = $this->peaje_model->cargar("trafico_acumulado", array("peaje" => "Cabildo", "dia" => true));
			?>

			<tr>
				<td>Niquía</td>
				<td class="text-right"><?php echo number_format($niquia_acumulado->Trafico_Acumulado, 0, '', '.'); ?></td> <!-- TPD acumulado -->
				<td class="text-right"><?php echo number_format($niquia_dia->Trafico_Acumulado, 0, '', '.'); ?></td> <!-- TPD día -->
				<td class="text-right"><?php echo "$ ".number_format($niquia_acumulado->Recaudo_Acumulado, 0, '', '.'); ?></td> <!-- Recaudo acumulado -->
				<td class="text-right"><?php echo "$ ".number_format($niquia_dia->Recaudo_Acumulado, 0, '', '.'); ?></td> <!-- Recaudo día -->
			</tr>
			<tr>
				<td>Trapiche</td>
				<td class="text-right"><?php echo number_format($trapiche_acumulado->Trafico_Acumulado, 0, '', '.'); ?></td> <!-- TPD acumulado -->
				<td class="text-right"><?php echo number_format($trapiche_dia->Trafico_Acumulado, 0, '', '.'); ?></td> <!-- TPD día -->
				<td class="text-right"><?php echo "$ ".number_format($trapiche_acumulado->Recaudo_Acumulado, 0, '', '.'); ?></td> <!-- Recaudo acumulado -->
				<td class="text-right"><?php echo "$ ".number_format($trapiche_dia->Recaudo_Acumulado, 0, '', '.'); ?></td> <!-- Recaudo día -->
			</tr>
			<tr>
				<td>Cabildo</td>
				<td class="text-right"><?php echo number_format($cabildo_acumulado->Trafico_Acumulado, 0, '', '.'); ?></td> <!-- TPD acumulado -->
				<td class="text-right"><?php echo number_format($cabildo_dia->Trafico_Acumulado, 0, '', '.'); ?></td> <!-- TPD día -->
				<td class="text-right"><?php echo "$ ".number_format($cabildo_acumulado->Recaudo_Acumulado, 0, '', '.'); ?></td> <!-- Recaudo acumulado -->
				<td class="text-right"><?php echo "$ ".number_format($cabildo_dia->Recaudo_Acumulado, 0, '', '.'); ?></td> <!-- Recaudo día -->
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td class="text-right"><b>Total</b></td>
				<td class="text-right"><b><?php echo "$ ".number_format(($niquia_acumulado->Recaudo_Acumulado + $trapiche_acumulado->Recaudo_Acumulado + $cabildo_acumulado->Recaudo_Acumulado), 0, '', '.') ?></b></td>
				<td class="text-right"><b><?php echo "$ ".number_format(($niquia_dia->Recaudo_Acumulado + $trapiche_dia->Recaudo_Acumulado + $cabildo_dia->Recaudo_Acumulado), 0, '', '.') ?></b></td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de la tabla
        $('#tbl_registros').DataTable({
	    	"paging": false,
	    	"scrollX": true,
	    	"searching": false,
	    	"info": false,
	    	"ordering": false
		});
	}); // document.ready
</script>