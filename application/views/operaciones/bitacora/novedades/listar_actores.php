<?php
// Se consultan los datos necesarios
$actores_novedad = $this->operaciones_bitacora_model->cargar("actores_novedad", $id_novedad);
?>

<div class="ui column grid">
	<div class="column">
		<div class="ui raised segment">
			<?php
			// Recorrido de los actores
			foreach ($actores_novedad as $actor) {
				// Variables a tomar
				$nombre = $actor->Nombre;
				$color = $actor->Color;
				$icono = $actor->Icono;
				$id_actor = $actor->Pk_Id;
			?>
				<a class="ui <?php echo $color; ?> ribbon label"><?php echo $nombre; ?></a>
				<!-- <span>Account Details</span> -->
				<p>
					<div class="ui steps">
						<!-- Ícono de cada actor como cabecera -->
						<div class="link step active">
							<i class="<?php echo $icono; ?> icon"></i>
						</div>

						<?php
						// Recorrido de las acciones del actor
						foreach ($this->operaciones_bitacora_model->cargar("actores_acciones", $id_actor) as $accion) {
							// Variables a tomar
							$id_accion = $accion->Pk_Id;
							$nombre = $accion->Nombre;

							// Se consulta si la acción ya tiene bitácora creada
							$bitacora = $this->operaciones_bitacora_model->cargar("registro", array("Fk_Id_Novedad" => $id_novedad, "Fk_Id_Actor_Accion" => $id_accion));

							// Si existe la bitácora
							if($bitacora){
								// Clases que activan
								$clase = "active completed";
								$hora = date("g:i a", strtotime($bitacora->Fecha_Creacion));
								$existe = 1;
							} else {
								// Sin clases
								$clase = "";
								$hora = "Sin informar";
								$existe = 0;
							} // if
							?>

							<!-- Acción -->
							<div id="accion<?php echo $id_accion; ?>" onClick="javascript:marcar(<?php echo $id_accion; ?>, <?php echo $id_novedad; ?>)" data-existe="<?php echo $existe; ?>" class="link step <?php echo $clase ;?>">
								<i class="checkmark icon"></i>
								<div class="content">
									<div class="title"><?php echo $nombre; ?></div>
									<div id="hora<?php echo $id_accion; ?>" class="description"><?php echo $hora; ?></div>
								</div>
							</div><!-- Acción -->
						<?php } // foreach acciones ?>
					</div>
				</p>
			<?php
			} // foreach novedades
			?>
		</div>
	</div>
</div>

<script>
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se activan los botones
        botones({"volver": true});
        
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
        mostrar_mensaje_pie([
        	"estado", 
        	"Bitácora de la novedad", 
        	"Todos",
        	"book"
    	]);
	}); // document.ready
</script>