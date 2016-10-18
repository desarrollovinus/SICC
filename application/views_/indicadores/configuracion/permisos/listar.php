<div class="ui form ">
	<!-- Configuración por usuarios -->
	<div class="col-lg-6">
		<div class="ui sub header">Configuración por usuarios</div>
		<select id="select_usuarios" class="ui fluid search dropdown">
			<!-- Option vacío -->
			<option value="">Seleccione o escriba el nombre de un usuario</option>

			<!-- Recorrido de los usuarios -->
			<?php foreach ($this->configuracion_model->cargar("usuarios_aplicacion", NULL) as $usuario) { ?>
				<option value="<?php echo $usuario->Pk_Id; ?>"><?php echo $usuario->Nombres." ".$usuario->Apellidos; ?></option>
			<?php } // foreach usuarios ?>
		</select>
	</div><!-- Configuración por usuarios -->

	<!-- Configuración por Módulos -->
	<div class="col-lg-6">
		<div class="ui sub header">Configuración por módulos</div>
		<select id="select_modulos" class="ui fluid search dropdown">
			<!-- Option vacío -->
			<option value="">Seleccione o escriba el nombre de un módulo</option>

			<!-- Recorrido de los módulos -->
			<?php foreach ($this->configuracion_model->cargar("modulos", NULL) as $modulo) { ?>
				<option value="<?php echo $modulo->Pk_Id; ?>"><?php echo $modulo->Nombre; ?></option>
			<?php } // foreach modulos ?>
		</select>
	</div><!-- Configuración por Módulos -->	
</div>

<div class="clear"></div>

<div class="ui divider"></div>

<!-- Interfaz que cargará las acciones -->
<div id="cont_segmento_acciones">
	<ul>
		<li>Seleccione "Configuración por usuarios" si desea configurarle permisos específicos</li>
		<li>Seleccione "Configuración por módulos" si desea configurar los usuarios que tienen accesos a cada acción del módulo elegido.</li>
	</ul>

	<div class="ui small message">
		Los usuarios que aparecen en la lista son los que tienen acceso activo a la aplicación. Para activarlo, vaya a a la sección a <a onClick="javascript:cargar('usuarios')" style="cursor: pointer;">"Usuarios"</a>.
	</div>
</div>

		</div>
<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Activación de los selects
		$('#select_modulos, #select_usuarios').dropdown({
			allowAdditions: true,
			onChange: function(){
				// Si es un valor válido
				if ($(this).val() != "") {
					// Si es por módulos
					if ($(this).attr("id") == "select_modulos") {
						// Se almacena el tipo
						var tipo = "permisos_tipo_modulo"
					} // if

					// Si es por usuarios
					if ($(this).attr("id") == "select_usuarios") {
						// Se almacena el tipo
						var tipo = "permisos_tipo_usuario"
					} // if

					// Se carga la Interfaz
					cargar_tipo(tipo, $(this).val());
				} // if
			} // on change
		}); // dropdown

        // Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Permisos y accesos", 
    		"Listado de todos los permisos y accesos de los usuarios al sistema.",
    		"privacy"
		]);
	}); // document.ready
</script>