<?php
/**
 * Modelo encargado de gestionar toda la informacion de administración
 * y configuración de todo el sistema
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 */
Class Configuracion_model extends CI_Model{
	/**
	 * Permite la actualización de registros existentes en la base de datos
	 * según el tipo
	 * @param  string $tipo  Tipo de información
	 * @param  int $id    Id del registro a actualizar
	 * @param  array $datos Datos a actualizar
	 * @return boolean        true: éxito
	 */
	function actualizar($tipo, $id, $datos){
		// Según el tipo
		switch ($tipo) {
			// Concepto de medición
			case 'concepto_medicion':
				$this->db->where('Pk_Id', $id);
		        if($this->db->update('conceptos_medicion', $datos)){
		            //Retorna verdadero
		            return true;
		        } // if
			break; // Concepto de medición

			// Familia
			case 'familia':
				$this->db->where('Pk_Id', $id);
		        if($this->db->update('familias', $datos)){
		            //Retorna verdadero
		            return true;
		        } // if
			break; // Familia

			// Norma
			case 'norma':
				$this->db->where('Pk_Id', $id);
		        if($this->db->update('normas', $datos)){
		            //Retorna verdadero
		            return true;
		        } // if
			break; // Norma

			// Periodicidad
			case 'periodicidad':
				$this->db->where('Pk_Id', $id);
		        if($this->db->update('periodicidades', $datos)){
		            //Retorna verdadero
		            return true;
		        } // if
			break; // Periodicidad

			// Unidad funcional
			case 'unidad_funcional':
				$this->db->where('Pk_Id', $id);
		        if($this->db->update('unidades_funcionales', $datos)){
		            //Retorna verdadero
		            return true;
		        } // if
			break; // Unidad funcional

			// Unidad de medida
			case 'unidad_medida':
				$this->db->where('Pk_Id', $id);
		        if($this->db->update('unidades_medida', $datos)){
		            //Retorna verdadero
		            return true;
		        } // if
			break; // Unidad de medida
		} // switch 
	} // actualizar

	/**
	 * Permite la carga de datos o grupo de datos
	 * @param  string $tipo Tipo
	 * @param  int $id   Id (cuando lo requiere)
	 * @return array       Datos
	 */
	function cargar($tipo, $id)
	{
		// Dependiendo del tipo
    	switch ($tipo) {
    		// Acciones
			case "acciones":
				// Consultas
				$this->db->select('*');
				$this->db->where("Fk_Id_Modulo", $id);
				$this->db->where("Permiso", 1);
				$this->db->order_by('Nombre');

				// Retorno
		        return $this->db->get('acciones')->result();
			break; // Acciones

    		// Todas las acciones
			case "acciones_logs":
				// Consultas
				$this->db->select('*');
				$this->db->order_by('Nombre');

				// Retorno
		        return $this->db->get('acciones')->result();
			break; // Todas las acciones

			// Años
			case 'anios':
				//Se crea un arreglo
        		$anios = array();

        		//Se declaran los rangos de años
		        $anio_actual = date ("Y") + 5;
		        $anio_inicial = $anio_actual - 50;

		        //Recorrido por años (decreciente)
		        for ($anio = $anio_actual; $anio > $anio_inicial; $anio--) { 
		            //Se agrega el año al arreglo
		            array_push($anios, $anio);
		        }//Fin for

		        //Se retorna el array
        		return $anios;
			break; // Años

    		// Concepto de medición
			case "concepto_medicion":
				// Consulta
				$this->db->select('*');
				$this->db->where("Pk_Id", $id);

				// Retorno
		        return $this->db->get('conceptos_medicion')->row();
			break; // Concepto de medición

    		// Todos los conceptos de medición
			case "conceptos_medicion":
				// Consultas
				$this->db->select('*');
				$this->db->order_by('Nombre');

				// Retorno
		        return $this->db->get('conceptos_medicion')->result();
			break; // Todos los conceptos de medición

    		// Todos los conceptos de medición activos
			case "conceptos_medicion_activos":
				// Consultas
				$this->db->select('*');
				$this->db->where("Estado", 1);
				$this->db->order_by('Nombre');

				// Retorno
		        return $this->db->get('conceptos_medicion')->result();
			break; // Todos los conceptos de medición activos

    		// Familia
			case "familia":
				// Consulta
				$this->db->select('*');
				$this->db->where("Pk_Id", $id);

				// Retorno
		        return $this->db->get('familias')->row();
			break; // Familia
    		
    		// Familias
			case "familias":
				// Consultas
				$this->db->select('*');
				$this->db->order_by('Nombre');

				// Retorno
		        return $this->db->get('familias')->result();
			break; // Familias

			// Familias activas
			case "familias_activas":
				// Consultas
				$this->db->select('*');
				$this->db->where("Estado", 1);
				$this->db->order_by('Nombre');

				// Retorno
		        return $this->db->get('familias')->result();
			break; // Familias activas

    		// Logs de un usuario
			case "logs_usuario":
				// Datos en blanco
				$modulo = "";
				$accion = "";

				// Si tiene módulo
				if ($id["Fk_Id_Modulo"] != "") {
					// Condición
					$modulo = "AND m.Pk_Id = {$id['Fk_Id_Modulo']}";
				} // if

				// Si tiene acción
				if ($id["Fk_Id_Accion"] != "") {
					// Condición
					$accion = "AND a.Pk_Id = {$id['Fk_Id_Accion']}";
				} // if

				// Consulta
				$sql =
				"SELECT
					m.Nombre AS Modulo,
					a.Nombre AS Accion,
					a.Descripcion,
					l.Fecha_Creacion,
					l.Observacion
				FROM
					logs AS l
				INNER JOIN acciones AS a ON l.Fk_Id_Accion = a.Pk_Id
				INNER JOIN modulos AS m ON a.Fk_Id_Modulo = m.Pk_Id
				WHERE
					l.Fk_Id_Usuario = 115
					$modulo
					$accion
				ORDER BY
					l.Fecha_Creacion DESC,
					Modulo DESC,
					Accion DESC";

				// Retorno
		        return $this->db->query($sql)->result();
			break; // Logs de un usuario

			/**
		     * Lista los meses del año
		     * @return [array] [meses con número y nombre, además del número de columna
		     * para efectos del reporte]
		     */
    		case 'meses':
    			//Se crea un arreglo de dos dimensiones con la informacion de cada mes
		        $meses = array(
		            array('Numero' => "01", 'Nombre' => 'Enero', 'Columna' => 'B'),
		            array('Numero' => "02", 'Nombre' => 'Febrero', 'Columna' => 'C'),
		            array('Numero' => "03", 'Nombre' => 'Marzo', 'Columna' => 'D'),
		            array('Numero' => "04", 'Nombre' => 'Abril', 'Columna' => 'E'),
		            array('Numero' => "05", 'Nombre' => 'Mayo', 'Columna' => 'F'),
		            array('Numero' => "06", 'Nombre' => 'Junio', 'Columna' => 'G'),
		            array('Numero' => "07", 'Nombre' => 'Julio', 'Columna' => 'H'),
		            array('Numero' => "08", 'Nombre' => 'Agosto','Columna' => 'I'),
		            array('Numero' => "09", 'Nombre' => 'Septiembre', 'Columna' => 'J'),
		            array('Numero' => "10", 'Nombre' => 'Octubre', 'Columna' => 'K'),
		            array('Numero' => "11", 'Nombre' => 'Noviembre', 'Columna' => 'L'),
		            array('Numero' => "12", 'Nombre' => 'Diciembre', 'Columna' => 'M')
		        ); 

		        //Se retorna el arreglo
		        return $meses;
			break; // Meses
    		
    		// Módulos
			case "modulos":
				// Consultas
				$this->db->select('*');
				$this->db->order_by('Nombre');

				// Retorno
		        return $this->db->get('modulos')->result();
			break; // Módulos

    		// Norma
			case "norma":
				// Consulta
				$this->db->select('*');
				$this->db->where("Pk_Id", $id);

				// Retorno
		        return $this->db->get('normas')->row();
			break; // Norma
    		
    		// Normas
			case "normas":
				// Consultas
				$this->db->select('*');
				$this->db->order_by('Descripcion');

				// Retorno
		        return $this->db->get('normas')->result();
			break; // Normas
    		
    		// Normas activas
			case "normas_activas":
				// Consultas
				$this->db->select('*');
				$this->db->where("Estado", 1);
				$this->db->order_by('Nombre');

				// Retorno
		        return $this->db->get('normas')->result();
			break; // Normas activas

    		// Periodicidad
			case "periodicidad":
				// Consulta
				$this->db->select('*');
				$this->db->where("Pk_Id", $id);

				// Retorno
		        return $this->db->get('periodicidades')->row();
			break; // Periodicidad
    		
    		// Periodicidades
			case "periodicidades":
				// Consultas
				$this->db->select('*');
				$this->db->order_by('Nombre');

				// Periodicidades
		        return $this->db->get('periodicidades')->result();
			break; // Normas
    		
    		// Permisos
			case "permisos":
				// Consulta
				$this->db->select('*');
				$this->db->where("Fk_Id_Usuario", $id);

				// Declaración de arreglo de una dimensión
        		$permisos = array();

        		// Rcorrido de los resultados
		        foreach ($this->db->get("permisos")->result() as $resultado) {
		            // Se adiciona al nuevo arreglo
		            $permisos[$resultado->Fk_Id_Accion] = true;
		        }

				// Se retorna el nuevo arreglo
        		return $permisos;
			break; // Permisos

    		// Usuarios que tienen permiso en una acción específica
			case "permisos_accion":
				// Consulta
				$this->db->select('*');
				$this->db->where("Fk_Id_Accion", $id);

				// Retorno
		        return $this->db->get('permisos')->result();
			break; // Usuarios que tienen permiso en una acción específica

    		// Acciones que están activadas para un módulo específico
			case "permisos_modulo":
				// Consulta
				$sql =
				"SELECT
					permisos.Fk_Id_Usuario,
					permisos.Fk_Id_Accion
				FROM
					permisos
				INNER JOIN acciones ON permisos.Fk_Id_Accion = acciones.Pk_Id
				WHERE
					acciones.Fk_Id_Modulo = $id";

				// Retorno
		        return $this->db->query($sql)->result();
			break; // Acciones que están activadas para un módulo específico

    		// Permisos a un usuario
			case "permisos_usuario":
				// Consulta
				$this->db->select('*');
				$this->db->where("Fk_Id_Usuario", $id);

				// Retorno
		        return $this->db->get('permisos')->result();
			break; // Permisos a un usuario

    		// Unidad funcional
			case "unidad_funcional":
				// Consulta
				$this->db->select('*');
				$this->db->where("Pk_Id", $id);

				// Retorno
		        return $this->db->get('unidades_funcionales')->row();
			break; // Unidad funcional

    		// Segmentos de una unidad funcional
			case "unidad_funcional_segmentos":
				// Consulta
				$this->db->select('*');
				$this->db->where("Fk_Id_Unidad_Funcional", $id);

				// Retorno
		        return $this->db->get('unidades_funcionales_segmentos')->result();
			break; // Segmentos de una unidad funcional

    		// Unidades funcionales
			case "unidades_funcionales":
				// Consulta
				$this->db->select('*');
				$this->db->order_by('Codigo');

				// Retorno
		        return $this->db->get('unidades_funcionales')->result();
			break; // Unidades funcionales
    		
    		// Unidades funcionales activas
			case "unidades_funcionales_activas":
				// Consultas
				$this->db->select('*');
				$this->db->where("Estado", 1);
				$this->db->order_by('Codigo');

				// Retorno
		        return $this->db->get('unidades_funcionales')->result();
			break; // Unidades funcionales activas

    		// Unidad de medida
			case "unidad_medida":
				// Consulta
				$this->db->select('*');
				$this->db->where("Pk_Id", $id);

				// Retorno
		        return $this->db->get('unidades_medida')->row();
			break; // Unidad de medida
    		
    		// Unidades de medida
			case "unidades_medida":
				// Consultas
				$this->db->select('*');
				$this->db->order_by('Nombre');

				// Retorno
		        return $this->db->get('unidades_medida')->result();
			break; // Unidades de medida

    		// Usuario
			case "usuario":
				// Consultas
				$sql =
				"SELECT
					u.Pk_Id_Usuario,
					u.Nombres,
					u.Apellidos,
					u.Documento,
					u.Email,
					u.Estado,
					u.Telefono,
					u.Usuario AS Login,
					(
						SELECT
							IFNULL(COUNT(p.Pk_Id_Permiso), 0)
						FROM
							hatoapps.permisos AS p
						WHERE
							p.Fk_Id_Aplicacion = {$this->config->item('id_aplicacion')}
						AND p.Fk_Id_Usuario = u.Pk_Id_Usuario
					) AS Acceso
				FROM
					hatoapps.usuarios AS u
				WHERE
					u.Pk_Id_Usuario =  $id";

				// Retorno
		        return $this->db->query($sql)->row();
			break; // Usuario

    		// Usuarios
			case "usuarios":
				// Consultas
				$sql =
				"SELECT
					u.Pk_Id_Usuario AS Pk_Id,
					u.Nombres,
					u.Apellidos,
					u.Estado,
					u.Telefono,
					u.Usuario AS Login,
					(
						SELECT
							IFNULL(COUNT(p.Pk_Id_Permiso), 0)
						FROM
							hatoapps.permisos AS p
						WHERE
							p.Fk_Id_Aplicacion = {$this->config->item('id_aplicacion')}
						AND p.Fk_Id_Usuario = u.Pk_Id_Usuario
					) AS Acceso
				FROM
					hatoapps.usuarios AS u
				ORDER BY
					u.Nombres ASC,
					u.Apellidos ASC,
					u.Usuario ASC";

				// Retorno
		        return $this->db->query($sql)->result();
			break; // Usuarios

    		// Usuarios con acceso a la aplicación
			case "usuarios_aplicacion":
				// Consultas
				$sql =
				"SELECT
					u.Pk_Id_Usuario AS Pk_Id,
					u.Nombres,
					u.Apellidos
				FROM
					hatoapps.permisos AS p
				INNER JOIN hatoapps.usuarios AS u ON p.Fk_Id_Usuario = u.Pk_Id_Usuario
				WHERE
					p.Fk_Id_Aplicacion = {$this->config->item('id_aplicacion')}
				ORDER BY
					u.Nombres ASC,
					u.Apellidos ASC";

				// Retorno
		        return $this->db->query($sql)->result();
			break; // Usuarios con acceso a la aplicación
    	} // switch
	} // cargar

	/**
     * Borrado de registros en base de datos
     * @param  string $tipo Tipo de código que se va a ejecutar
     * @param  int $id   Id del registro a borrar
     * @return boolean       true: exitoso
     */
    function eliminar($tipo, $id){
        // Según el tipo
        switch ($tipo) {
            // Concepto de medición
            case "concepto_medicion":
                // Si se borra el registro
                if($this->db->delete('conceptos_medicion', array("Pk_Id" => $id))){
                    return true;
                } // if
            break; // Concepto de medición

            // Familia
            case "familia":
                // Si se borra el registro
                if($this->db->delete('familias', array("Pk_Id" => $id))){
                    return true;
                } // if
            break; // Familia

            // Norma
            case "norma":
                // Si se borra el registro
                if($this->db->delete('normas', array("Pk_Id" => $id))){
                    return true;
                } // if
            break; // Norma

            // Periodicidad
            case "periodicidad":
                // Si se borra el registro
                if($this->db->delete('periodicidades', array("Pk_Id" => $id))){
                    return true;
                } // if
            break; // Periodicidad

            // Acciones que pertenecen a un módulo específico
            case "permisos_modulo":
                // Si se borra el registro
                if($this->db->delete('permisos', array("Fk_Id_Accion" => $id))){
                    return true;
                } // if
            break; // Acciones que pertenecen a un módulo específico

            // Permisos de un usuario
            case "permisos_usuario":
                // Si se borra el registro
                if($this->db->delete('permisos', array("Fk_Id_Usuario" => $id))){
                    return true;
                } // if
            break; // Permisos de un usuario

            // Unidad de medida
            case "unidad_medida":
                // Si se borra el registro
                if($this->db->delete('unidades_medida', array("Pk_Id" => $id))){
                    return true;
                } // if
            break; // Unidad de medida

            // Unidad funcional
            case "unidad_funcional":
                // Si se borra el registro
                if($this->db->delete('unidades_funcionales', array("Pk_Id" => $id))){
                    return true;
                } // if
            break; // Unidad funcional
        } // switch
    } // eliminar

    /**
     * Se procesa una foto y se le da formato mucho más amable
     * @param  string $fecha Fecha sin formato
     * @return string        Fecha formateada
     */
    function formato_fecha($fecha){
    	// Si la fecha toda es cero
    	if ($fecha == "0000-00-00") {
    		return "";
    	} // if

    	// Si el día, el mes o el año están en ceros
    	if (substr($fecha, 8, 2) == "00" || substr($fecha, 5, 2) == "00" || substr($fecha, 0, 4) == "0000") {
    		return "Fecha no válida";
    	} // if

        $dia_num = date("j", strtotime($fecha));
        $dia = date("N", strtotime($fecha));
        $mes = date("m", strtotime($fecha));
        $anio_es = date("Y", strtotime($fecha));

        //Si No hay fecha, devuelva vac&iacute;o en vez de 0000-00-00
        if($fecha == '1969-12-31 19:00:00' || !$fecha){
            return false;
        } // if

        //Nombres de los d&iacute;as
        if($dia == "1"){ $dia_es = "Lunes"; }
        if($dia == "2"){ $dia_es = "Martes"; }
        if($dia == "3"){ $dia_es = "Miercoles"; }
        if($dia == "4"){ $dia_es = "Jueves"; }
        if($dia == "5"){ $dia_es = "Viernes"; }
        if($dia == "6"){ $dia_es = "Sabado"; }
        if($dia == "7"){ $dia_es = "Domingo"; }

        //Nombres de los meses
        if($mes == "1"){ $mes_es = "enero"; }
        if($mes == "2"){ $mes_es = "febrero"; }
        if($mes == "3"){ $mes_es = "marzo"; }
        if($mes == "4"){ $mes_es = "abril"; }
        if($mes == "5"){ $mes_es = "mayo"; }
        if($mes == "6"){ $mes_es = "junio"; }
        if($mes == "7"){ $mes_es = "julio"; }
        if($mes == "8"){ $mes_es = "agosto"; }
        if($mes == "9"){ $mes_es = "septiembre"; }
        if($mes == "10"){ $mes_es = "octubre"; }
        if($mes == "11"){ $mes_es = "noviembre"; }
        if($mes == "12"){ $mes_es = "diciembre"; } 

        //Se foramtea la fecha
        $fecha = $dia_num." de ".$mes_es." de ".$anio_es;
        
        // Se retorna la fecha formateada
        return $fecha;
    }// formato_fecha

	/**
	 * Permite la inserción de datos en la base de datos 
	 * @param  string $tipo  Tipo de inserción
	 * @param  array $datos Datos que se van a insertar
	 * @return boolean        true: exito
	 */
	function insertar($tipo, $datos)
	{
		// Se añade la fecha de creación
		$datos["Fecha_Creacion"] = date('Y-m-d H:i:s');

		// Suiche según el tipo
		switch ($tipo) {
			// Familia
			case "familia":
				// Si se guarda correctamente
				if($this->db->insert('familias', $datos)){
					return true;
				} // if
			break; // Familia

			// Conceptos de medición
			case "concepto_medicion":
				// Si se guarda correctamente
				if($this->db->insert('conceptos_medicion', $datos)){
					return true;
				} // if
			break; // Conceptos de medición

			// Norma
			case "norma":
				// Si se guarda correctamente
				if($this->db->insert('normas', $datos)){
					return true;
				} // if
			break; // Norma

			// Periodicidad
			case "periodicidad":
				// Si se guarda correctamente
				if($this->db->insert('periodicidades', $datos)){
					return true;
				} // if
			break; // Periodicidad

			// Permisos
			case "permisos":
				// Si se guarda correctamente
				if($this->db->insert('permisos', $datos)){
					return true;
				} // if
			break; // Permisos

			// Unidad funcional
			case "unidad_funcional":
				// Si se guarda correctamente
				if($this->db->insert('unidades_funcionales', $datos)){
					// Se retorna el id creado
					return $this->db->insert_id();
				} // if
			break; // Unidad funcional

			// Segmento de una unidad funcional
			case "unidad_funcional_segmento":
				// Si se guarda correctamente
				if($this->db->insert('unidades_funcionales_segmentos', $datos)){
					// Se retorna el id creado
					return $this->db->insert_id();
				} // if
			break; // Segmento de una unidad funcional

			// Unidad de medida
			case "unidad_medida":
				// Si se guarda correctamente
				if($this->db->insert('unidades_medida', $datos)){
					return true;
				} // if
			break; // Unidad de medida
		} // suiche
	} // insertar

	/**
	 * Inserción de logs de auditoría. 
	 * Esta función está aparte de los suiches porque 
	 * maneja información diferente
	 * @param  int $tipo        Tipo de log
	 * @param  string $observacion Información adicional del log
	 * @return boolean        true: exito
	 */
	function insertar_log($tipo, $observacion)
	{
		// Arreglo con los datos
		$datos = array(
			"Fecha_Creacion" => date("Y-m-d H:i:s"),
			"Fk_Id_Accion" => $tipo,
			"Fk_Id_Usuario" => $this->session->userdata('Pk_Id_Usuario'),
			"Observacion" => $observacion
		);

		// Si se inserta correctamente
		if ($this->db->insert('logs', $datos)) {
			// Se retorna verdadero
			return true;
		} // if
	} // insertar_log
}
/* Fin del archivo Configuracion_model.php */
/* Ubicación: ./application/models/Configuracion_model.php */