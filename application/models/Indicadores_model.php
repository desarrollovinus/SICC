<?php
/**
 * Modelo encargado de gestionar toda la informacion de los
 * indicadores
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 */
Class Indicadores_model extends CI_Model{
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
			// Indicador
			case 'indicador':
				$this->db->where('Pk_Id', $id);
		        if($this->db->update('indicadores', $datos)){
		            //Retorna verdadero
		            return true;
		        } // if
			break; // Indicador
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
    		// Indicador
			case "indicador":
				// Consulta
				$this->db->select('*');
				$this->db->where("Pk_Id", $id);

				// Retorno
		        return $this->db->get('indicadores')->row();
			break; // Indicador

    		// Indicadores
			case "indicadores":
				// Consultas
				$sql =
				"SELECT
					i.Pk_Id,
					i.Estado,
					i.Fecha_Creacion,
					i.Fecha_Modificacion,
					i.Fk_Id_Concepto_Medicion,
					i.Fk_Id_Indicador_Familia,
					i.Fk_Id_Periodicidad,
					i.Fk_Id_Unidad_Medida,
					i.Fk_Id_Usuario,
					i.Identificador,
					i.Metodo_Medida,
					i.Nombre,
					n.Nombre AS Norma,
					p.Nombre AS Periodicidad,
					um.Nombre AS Unidad_Medida,
					cm.Nombre AS Concepto_Medicion,
					normas.Nombre AS Norma,
					i.Valor_Aceptacion
				FROM
					indicadores AS i
				INNER JOIN normas AS n ON i.Fk_Id_Norma = n.Pk_Id
				INNER JOIN periodicidades AS p ON i.Fk_Id_Periodicidad = p.Pk_Id
				INNER JOIN unidades_medida AS um ON i.Fk_Id_Unidad_Medida = um.Pk_Id
				INNER JOIN conceptos_medicion AS cm ON i.Fk_Id_Concepto_Medicion = cm.Pk_Id
				INNER JOIN normas ON i.Fk_Id_Norma = normas.Pk_Id";

				// Retorno
		        return $this->db->query($sql)->result();
			break; // Indicadores
    		
    		// Indicadores activos
			case "indicadores_activos":
				// Consultas
				$this->db->select('*');
				$this->db->where("Estado", 1);
				$this->db->order_by('Identificador');

				// Retorno
		        return $this->db->get('indicadores')->result();
			break; // Indicadores activos
    		
    		// Política de un indicador y una unidad funcional
			case "politica":
				// Consultas
				$this->db->select('Valor');
				$this->db->where("Fk_Id_Unidad_Funcional", $id["Id_Unidad_Funcional"]);
				$this->db->where("Fk_Id_Indicador", $id["Id_Indicador"]);

				return $this->db->get('indicadores_politicas')->row();
			break; // Política de un indicador y una unidad funcional
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
            // Indicador
            case "indicador":
                // Si se borra el registro
                if($this->db->delete('indicadores', array("Pk_Id" => $id))){
                    return true;
                } // if
            break; // Indicador

            // Políticas
            case "politicas":
            	// Se borran todos los registros
                $sql1 = "DELETE FROM indicadores_politicas";
                $this->db->query($sql1);

            	// Se resetea el id de la tabla
				$sql2 = "ALTER TABLE indicadores_politicas AUTO_INCREMENT = 1";
                return $this->db->query($sql2);
            break; // Políticas
        } // switch
    } // eliminar

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
			// Indicador
			case "indicador":
				// Si se guarda correctamente
				if($this->db->insert('indicadores', $datos)){
					// Retorna verdadero
					return true;
				} // if
			break; // Indicador

			// Política
			case "politica":
				// Si se guarda correctamente
				if($this->db->insert('indicadores_politicas', $datos)){
					// Retorna verdadero
					return true;
				} // if
			break; // Política
		} // suiche
	} // insertar

	function resultados($indicador, $anio, $mes){
        // Se carga la base de datos de operaciones
        $this->db_operaciones = $this->load->database('sicc_operaciones', TRUE);

		// Según el indicador
		switch ($indicador) {
			// Indicador O5
			case 'O5':
				// Consulta
				$sql = "SELECT
					a.Pk_Id Id_Actor,
					a.Nombre Actor,
					aa.Nombre Accion,
					b.Pk_Id Id_Bitacora,
					n.Fecha_Creacion Fecha_Novedad,
					b.Fecha_Creacion Fecha_Bitacora,
					aa.Tiempo_Estipulado,
					TIME_TO_SEC(aa.Tiempo_Estipulado) Segundos_Estipulados,
					SEC_TO_TIME(
						TIMESTAMPDIFF(
							SECOND,
							n.Fecha_Creacion,
							b.Fecha_Creacion
						)
					) Tiempo_Real,
					TIMESTAMPDIFF(
						SECOND,
						n.Fecha_Creacion,
						b.Fecha_Creacion
					) Segundos_Reales,
					IFNULL(
						TIMESTAMPDIFF(
							SECOND,
							n.Fecha_Creacion,
							b.Fecha_Creacion
						) - TIME_TO_SEC(aa.Tiempo_Estipulado),
						0
					) Diferencia,
					SEC_TO_TIME(
						IFNULL(
							TIMESTAMPDIFF(
								SECOND,
								n.Fecha_Creacion,
								b.Fecha_Creacion
							) - TIME_TO_SEC(aa.Tiempo_Estipulado),
							0
						)
					) Diferencia_Segundos
				FROM
					novedades AS n
				INNER JOIN novedades_actores AS na ON na.Fk_Id_Novedad = n.Pk_Id
				INNER JOIN actores AS a ON na.Fk_Id_Actor = a.Pk_Id
				INNER JOIN actores_acciones AS aa ON aa.Fk_Id_Actor = a.Pk_Id
				LEFT JOIN bitacora AS b ON b.Fk_Id_Actor_Accion = aa.Pk_Id
				AND b.Fk_Id_Novedad = n.Pk_Id
				WHERE
					YEAR (n.Fecha_Creacion) = '{$anio}'
				AND MONTH (n.Fecha_Creacion) = '{$mes}'
				AND n.Fk_Id_Estado <> 3
				AND aa.Tiempo_Estipulado IS NOT NULL 
				ORDER BY
					a.Prioridad ASC";

				// Retorno de resultado
				return $this->db_operaciones->query($sql)->result();
			break; // Indicador O5
		} // suiche
	} // resultados

	/**
	 * Verifica si el identificador de un indicador existe en base de datos
	 * @param  string $identificador Identidicador
	 * @return boolean                true: exito
	 */
	function validar_identificador($identificador){
		// Consulta
		$this->db->where("Identificador", $identificador);

		// Retorno
		return $this->db->get("indicadores")->row();
	} // validar_identificador
}
/* Fin del archivo Indicadores_model.php */
/* Ubicación: ./application/models/Indicadores_model.php */