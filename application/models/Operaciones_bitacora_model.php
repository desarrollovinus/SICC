<?php
/**
 * Modelo encargado de gestionar toda la informacion de la bitácora
 * de operaciones
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 */
Class Operaciones_bitacora_model extends CI_Model{
	/**
    * Función constructora de la clase. Se hereda el mismo constructor de la clase para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access   public
    */
    function __construct() {
        parent::__construct();
        /*
	     * sicc_operaciones es la conexion a la base de datos unificada de usuarios de hatoapps. Esta se llama
	     * porque en el archivo database.php la variable ['hatoapps']['pconnect] esta marcada como false,
	     * lo que quiere decir que no se conecta persistentemente sino cuando se le invoca, como en esta ocasion.
	     */
        $this->db_operaciones = $this->load->database('sicc_operaciones', TRUE);
    } // construct

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
			// Novedad  
			case 'novedad':
				$this->db_operaciones->where('Pk_Id', $id);
		        if($this->db_operaciones->update('novedades', $datos)){
		            //Retorna verdadero
		            return true;
		        } // if
			break; // Novedad 
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
    		// Acciones de un autor
			case "actores_acciones":
				// Consultas
				$this->db_operaciones->select('*');
				$this->db_operaciones->where("Fk_Id_Actor", $id);
				$this->db_operaciones->order_by("Prioridad");

				// Retorno
		        return $this->db_operaciones->get('actores_acciones')->result();
			break; // Acciones de un autor

    		// Actores de una novedad
			case "actores_novedad":
				// Consultas
				$sql =
				"SELECT
					a.Pk_Id,
					a.Color,
					a.Icono,
					a.Nombre
				FROM
					novedades_actores AS na
				INNER JOIN actores AS a ON na.Fk_Id_Actor = a.Pk_Id
				WHERE
					na.Fk_Id_Novedad = $id
				ORDER BY
					a.Prioridad ASC";

				// Retorno
		        return $this->db_operaciones->query($sql)->result();
			break; // Actores de una novedad

    		// Novedad
			case "novedad":
				// Consultas
				$this->db_operaciones->select('*');
				$this->db_operaciones->where("Pk_Id", $id);

				// Retorno
		        return $this->db_operaciones->get('novedades')->row();
			break; // Novedad

    		// Novedades
			case "novedades":
				// Consultas
				$sql =
				"SELECT
					n.Pk_Id,
					n.Anotacion,
					n.Fecha_Creacion,
					nt.Nombre AS Tipo,
					e.Nombre AS Estado,
					e.Color,
					n.Fk_Id_Novedad_Tipo
				FROM
					novedades AS n
				INNER JOIN estados AS e ON n.Fk_Id_Estado = e.Pk_Id
				INNER JOIN novedades_tipos AS nt ON n.Fk_Id_Novedad_Tipo = nt.Pk_Id
				ORDER BY
					n.Fecha_Creacion DESC";

				// Retorno
		        return $this->db_operaciones->query($sql)->result();
			break; // Novedades

    		// Registro
			case "registro":
				// Consultas
				$this->db_operaciones->select('*');
				$this->db_operaciones->where($id);

				// Retorno
		        return $this->db_operaciones->get('bitacora')->row();
			break; // Registro

    		// Registros
			case "registros":
				// Consultas
				$this->db_operaciones->select('*');
				$this->db_operaciones->order_by("Fecha_Creacion", "DESC");

				// Retorno
		        return $this->db_operaciones->get('bitacora')->result();
			break; // Registros
		} // switch
	} // cargar

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
			// Novedad
			case "novedad":
				// Si se guarda correctamente
				if($this->db_operaciones->insert('novedades', $datos)){
					// Se retorna el id creado
					return $this->db_operaciones->insert_id();
				} // if
			break; // Novedad

			// Actor de una novedad
			case "novedad_actor":
				// Si se guarda correctamente
				if($this->db_operaciones->insert('novedades_actores', $datos)){
					// Se retorna el id creado
					return true;
				} // if
			break; // Actor de una novedad

    		// Registro
			case "registro":
				// Si se guarda correctamente
				if($this->db_operaciones->insert('bitacora', $datos)){
					// Se retorna el id creado
					return $datos["Fecha_Creacion"];
				} // if
			break; // Registro
		} // suiche
	} // insertar
}
/* Fin del archivo Operaciones_bitacora_model.php */
/* Ubicación: ./application/models/Operaciones_bitacora_model.php */