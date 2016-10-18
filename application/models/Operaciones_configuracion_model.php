<?php
/**
 * Modelo encargado de gestionar toda la informacion de administración
 * y configuración del sistema de Operaciones
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 */
Class Operaciones_configuracion_model extends CI_Model{
	/**
    * Función constructora de la clase. Se hereda el mismo constructor de la clase para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access   public
    */
    function __construct() {
        parent::__construct();
        /*
	     * db_hatoapps es la conexion a la base de datos unificada de usuarios de hatoapps. Esta se llama
	     * porque en el archivo database.php la variable ['hatoapps']['pconnect] esta marcada como false,
	     * lo que quiere decir que no se conecta persistentemente sino cuando se le invoca, como en esta ocasion.
	     */
        $this->db_operaciones = $this->load->database('sicc_operaciones', TRUE);
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
    		// Actores activos
			case "actores_activos":
				// Consultas
				$this->db_operaciones->select('*');
				$this->db_operaciones->order_by('Prioridad');
				$this->db_operaciones->Where('Estado', 1);

				// Retorno
		        return $this->db_operaciones->get('actores')->result();
			break; // Actores activos

    		// Tipos de novedades activas
			case "novedades_tipos_activos":
				// Consultas
				$this->db_operaciones->select('*');
				$this->db_operaciones->order_by('Nombre');
				$this->db_operaciones->Where('Estado', 1);

				// Retorno
		        return $this->db_operaciones->get('novedades_tipos')->result();
			break; // Tipos de novedades activas
		} // switch
	} // cargar
}
/* Fin del archivo Operaciones_configuracion_model.php */
/* Ubicación: ./application/models/Operaciones_configuracion_model.php */