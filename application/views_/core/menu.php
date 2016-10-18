<div id="menu_superior" class="ui menu"> 
    <!-- Ícono menú -->
    <a onclick="javascript:menu_lateral()" class="item">
        <i class="large sidebar icon" ></i>
    </a>

    <!-- Ícono atrás -->
    <a id="icono_volver" onclick="javascript:volver()" class="item" data-content="Volver" data-variation="inverted">
        <i class="large reply icon"></i>
    </a>

    <!-- Menú superior derecho -->
    <div class="right menu">
        <!-- Historial -->
        <a id="icono_historial" class="item" onClick="javascript:historial();" data-content="Ver historial en la aplicación" data-variation="inverted">
            <i class="unhide icon"></i>
        </a>

        <!-- Guardar -->
        <a id="icono_guardar" class="item" onClick="javascript:guardar();" data-content="Guardar" data-variation="inverted">
            <i class="save icon"></i>
        </a>

        <!-- Listar -->
        <a id="icono_listar" class="item" onClick="javascript:listar();" data-content="Mostrar todos los registros" data-variation="inverted">
            <i class="table icon"></i>
        </a>

        <!-- Agregar -->
        <a id="icono_crear" class="item" onClick="javascript:crear();" data-content="Crear nuevo registro" data-variation="inverted">
            <i class="plus icon"></i>
        </a>

        <!-- Editar -->
        <a id="icono_editar" class="item" onClick="javascript:editar();" data-content="Editar registro" data-variation="inverted">
            <i class="edit icon"></i>
        </a>

        <!-- Eliminar -->
        <a id="icono_eliminar" class="item" onClick="javascript:eliminar('confirmacion');" data-content="Eliminar registro" data-variation="inverted">
            <i class="trash icon"></i>
        </a>

        <!-- Generar PDF -->
        <a id="icono_pdf" class="item" onClick="javascript:generar_reporte('pdf');" data-content="Generar PDF" data-variation="inverted">
            <i class="file pdf outline icon"></i>
        </a>
    </div><!-- Menú superior derecho -->
</div>

<div id="menu_lateral" class="ui left vertical inverted labeled icon sidebar menu active">
    <!-- Para el menú de cada aplicación -->
    <?php if ($menu != "general") { ?>
        <!-- Aplicaciones -->
        <a class="item" onClick="javascript:cargar_principal('aplicaciones')">
            <i class="grid layout icon"></i>
            Aplicaciones
        </a>

        <!-- Inicio -->
        <a class="item" onClick="javascript:cargar_principal('inicio')">
            <i class="home icon"></i>
            Inicio
        </a>
    <?php } // if ?>

	<!-- Si el menú es de indicadores -->
	<?php if ($menu == "indicadores") { ?>
		<!-- Indicadores -->
	    <a class="item" onClick="javascript:cargar_principal('indicadores')">
	        <i class="certificate icon"></i>
	        Indicadores
	    </a>

	    <!-- Reportes -->
	    <a class="item" onClick="javascript:cargar_principal('indicadores_reportes')">
	        <i class="line chart icon"></i>
	        Reportes
	    </a>

	    <!-- Configuración -->
	    <a class="item" onClick="javascript:cargar_principal('indicadores_configuracion')">
	        <i class="settings icon"></i>
	        Configuración
	    </a>
    <?php } // if ?>

    <!-- Si el menú es de operaciones -->
    <?php if ($menu == "operaciones") { ?>
	   <!-- Bitácora -->
        <a class="item" onClick="javascript:cargar_principal('operaciones_bitacora')">
            <i class="newspaper icon"></i>
            Bitácora
        </a>

        <!-- Eventos -->
        <a class="item" onClick="javascript:cargar_principal('operaciones_eventos')">
            <i class="fire icon"></i>
            Eventos
        </a>

        <!-- Reportes -->
        <a class="item" onClick="javascript:cargar_principal('operaciones_reportes')">
            <i class="line chart icon"></i>
            Reportes
        </a>

        <!-- Configuración -->
        <a class="item" onClick="javascript:cargar_principal('operaciones_configuracion')">
            <i class="settings icon"></i>
            Configuración
        </a>
    <?php } // if ?>

    <!-- Salir -->
    <a class="item" href="<?php echo site_url('sesion/cerrar') ?>">
        <i class="sign out icon"></i>
        Salir
    </a>
</div>

<script type="text/javascript">
    /**
     * Carga por Ajax la interfaz seleccionada
     */
    function cargar_principal(tipo){
        // Dependiendo del tipo
        switch(tipo) {
            // aplicaciones
            case "aplicaciones":
                // Se carga la interfaz
                redireccionar("<?php echo site_url(''); ?>");
            break; // aplicaciones

            // Indicadores
            case "indicadores":
                // Se carga la interfaz
                cargar_interfaz("cont_principal","<?php echo site_url('indicadores/cargar_interfaz'); ?>", {"tipo": "index"});
            break; // Indicadores
            
            // Configuración de indicadores
            case "indicadores_configuracion":
                // Se carga la interfaz
                cargar_interfaz("cont_principal","<?php echo site_url('indicadores_configuracion/cargar_interfaz'); ?>", {"tipo": "index"});
            break; // Configuración de indicadores

            // Reportes de indicadores
            case "indicadores_reportes":
                // Se carga la interfaz
                cargar_interfaz("cont_principal","<?php echo site_url('indicadores_reportes/cargar_interfaz'); ?>", {"tipo": "index"});
            break; // Reportes de indicadores
            
            // Bitácora de operaciones
            case "operaciones_bitacora":
                // Se carga la interfaz
                cargar_interfaz("cont_principal","<?php echo site_url('operaciones_bitacora/cargar_interfaz'); ?>", {"tipo": "index"});
            break; // Bitácora de operaciones
            
            // Configuración de operaciones
            case "operaciones_configuracion":
                // Se carga la interfaz
                cargar_interfaz("cont_principal","<?php echo site_url('operaciones_configuracion/cargar_interfaz'); ?>", {"tipo": "index"});
            break; // Configuración de operaciones
        } // switch tipo

        // Se quita el menú
        menu_lateral();
    } // switch
</script>