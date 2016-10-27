<?php
/**
 * Modelo encargado de gestionar toda la informacion de peajes
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 */
Class Peaje_model extends CI_Model{
	/**
    * Función constructora de la clase. Se hereda el mismo constructor de la clase para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access   public
    */
    function __construct() {
        parent::__construct();
        /*
	     * sicc_peajes es la conexion a la base de datos de peajes
	     */
        $this->db_peajes = $this->load->database('sicc_peajes', TRUE);
    } // construct

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
    		// Días del mes
			case "dias_mes":
				// Consultas
				$sql =
				"SELECT
						DAY(r.Fecha) Dia,
						r.Fecha,
						r.pagados,
						r.sin_pagar,
						r.total_recaudo,
						r.total_sobretasa
					FROM
						recaudos AS r
					WHERE
						YEAR (r.Fecha) = {$id['anio']}
					AND MONTH (r.Fecha) = {$id['mes']}
					AND r.Peaje = '{$id['peaje']}'
					ORDER BY
						r.Fecha ASC";

				// Retorno
		        return $this->db_peajes->query($sql)->result();
			break; // Días del mes

			// Tráfico del día
			case 'trafico_acumulado':
				$dia = "";
				
				if (isset($id["dia"])) {
					$dia = "AND DAY(r.Fecha) = {$id['dia']}";
				}
				
				$sql =
				"SELECT
					SUM(r.pagados) Trafico_Acumulado,
					SUM(r.total_recaudo) Recaudo_Acumulado
				FROM
					recaudos AS r
				WHERE
					YEAR (r.Fecha) = {$id['anio']}
				AND MONTH (r.Fecha) = {$id['mes']}
				AND r.Peaje = '{$id['peaje']}'
				$dia";

		        return $this->db_peajes->query($sql)->row();
			break; // Tráfico del día
		} // switch
	} // cargar
}
/* Fin del archivo Peaje_model.php */
/* Ubicación: ./application/models/Peaje_model.php */