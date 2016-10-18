<?php
/**
 * Modelo encargado de gestionar toda la informacion de los
 * reportes de la aplicación
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 */
Class Reportes_model extends CI_Model{
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
    		// logs por tipo de acción
			case "logs_por_tipo":
				// Consultas
				$sql1 = 
				"SET @total = (
					SELECT
						COUNT(Pk_Id)
					FROM
						logs AS arc
				);";
			
				// Ejecución de la primera consulta
				$this->db->query($sql1);

				// Consulta 2
				$sql2 =
				"SELECT
					a.Nombre AS name,
					COUNT(l.Pk_Id) AS Cantidad,
					ROUND(
						(
							(Count(l.Pk_Id) * 100) / @total
						),
						2
					) AS y
				FROM
					logs AS l
				INNER JOIN acciones AS a ON l.Fk_Id_Accion = a.Pk_Id
				GROUP BY
					a.Pk_Id
				ORDER BY
					Cantidad DESC";

				// Se retorna el resultado
				return $this->db->query($sql2)->result();
			break; // logs por tipo de acción
    	} // switch
	} // cargar
}
/* Fin del archivo Reportes_model.php */
/* Ubicación: ./application/models/Reportes_model.php */