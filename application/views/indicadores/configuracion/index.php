<div id="cont_configuracion">
	<!-- Conceptos de medición -->
	<div class="col-md-4" onClick="javascript:cargar('conceptos_medicion')">
		<h2 class="ui icon header">
			<i class="resize horizontal icon"></i>
			<div class="content">
				Conceptos de medición
				<div class="sub header">Características físicas de la infraestructura o equipos que van a ser verificados</div>
			</div>
		</h2>
	</div><!-- Conceptos de medición -->

	<!-- Familias -->
	<div class="col-md-4" onClick="javascript:cargar('familias')">
		<h2 class="ui icon header">
			<i class="block layout icon"></i>
			<div class="content">
				Familias
				<div class="sub header">Gestione las familias a las que van a pertenecer los indicadores</div>
			</div>
		</h2>
	</div><!-- Familias -->

	<!-- Normas -->
	<div class="col-md-4" onClick="javascript:cargar('normas')">
		<h2 class="ui icon header">
			<i class="book icon"></i>
			<div class="content">
				Normas
				<div class="sub header">Listado de normatividades aplicables al proyecto y a los indicadores.</div>
			</div>
		</h2>
	</div><!-- Normas -->

	<!-- Periodicidades -->
	<div class="col-md-4" onClick="javascript:cargar('periodicidades')">
		<h2 class="ui icon header">
			<i class="wait icon"></i>
			<div class="content">
				Periodicidades
				<div class="sub header">Configure los lapsos de tiempo que habrá en los indicadores.</div>
			</div>
		</h2>
	</div><!-- Periodicidades -->

	<!-- Permisos -->
	<div onClick="javascript:cargar('permisos')" class="col-md-4">
		<h2 class="ui icon header">
			<i class="privacy icon"></i>
			<div class="content">
				Permisos y accesos
				<div class="sub header">Configure los permisos de cada usuario que tenga acceso a la aplicación.</div>
			</div>
		</h2>
	</div><!-- Permisos -->
	
	<!-- Unidades funcionales -->
	<div class="col-md-4" onClick="javascript:cargar('unidades_funcionales')">
		<h2 class="ui icon header">
			<i class="road icon"></i>
			<div class="content">
				Unidades Funcionales
				<div class="sub header">Gestione las unidades funcionales del proyecto y que serán configurados en las políticas de los indicadores.</div>
			</div>
		</h2>
	</div><!-- Unidades funcionales -->

	<!-- Unidades de medida -->
	<div class="col-md-4" onClick="javascript:cargar('unidades_medida')">
		<h2 class="ui icon header">
			<i class="dashboard icon"></i>
			<div class="content">
				Unidades de medida
				<div class="sub header">Defina y especifique las unidades de medida de los indicadores.</div>
			</div>
		</h2>
	</div><!-- Unidades de medida -->

	<!-- Usuarios -->
	<div onClick="javascript:cargar('usuarios')" class="col-md-4">
		<h2 class="ui icon header">
			<i class="users icon"></i>
			<div class="content">
				Usuarios
				<div class="sub header">Administre los usuarios y permita el acceso a la aplicación.</div>
			</div>
		</h2>
	</div><!-- Usuarios -->
</div>

<script type="text/javascript">
	/**
     * Carga por Ajax la interfaz seleccionada
     */
    function cargar(tipo){
        // Dependiendo del tipo
        switch(tipo) {
			// Conceptos de medición
            case "conceptos_medicion":
                // Se carga la interfaz
    			cargar_interfaz("cont_configuracion","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Conceptos de medición

			// Familias
            case "familias":
                // Se carga la interfaz
    			cargar_interfaz("cont_configuracion","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Familias

			// Normas
            case "normas":
                // Se carga la interfaz
    			cargar_interfaz("cont_configuracion","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Normas

			// Periodicidades
            case "periodicidades":
                // Se carga la interfaz
    			cargar_interfaz("cont_configuracion","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Periodicidades

			// Permisos y accesos
            case "permisos":
                // Se carga la interfaz
    			cargar_interfaz("cont_configuracion","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Permisos y accesos

			// Unidades funcionales
            case "unidades_funcionales":
                // Se carga la interfaz
    			cargar_interfaz("cont_configuracion","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Unidades funcionales

			// Unidades de medida
            case "unidades_medida":
                // Se carga la interfaz
    			cargar_interfaz("cont_configuracion","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Unidades de medida

			// Usuarios
            case "usuarios":
                // Se carga la interfaz
    			cargar_interfaz("cont_configuracion","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": tipo});
            break; // Usuarios
        } // switch tipo
	} // cargar

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Se muestra el mensaje al pié, enviando el tipo, el título y la descripción
    	mostrar_mensaje_pie([
    		"estado", 
    		"Módulo de configuración", 
    		"Administre la aplicación, gestionando listas, usuarios y configuraciones.",
    		"settings"
		]);
	}); // document.ready
</script>