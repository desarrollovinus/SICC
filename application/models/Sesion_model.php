<?php
/**
 * Modelo encargado de gestionar toda la informacion de sesiones
 * y de interacciones del usuario al ingresar a la aplicación
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 */
Class Sesion_model extends CI_Model{
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
        $this->db_hatoapps = $this->load->database('hatoapps', TRUE);
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
            // Acceso a la aplicación
            case 'acceso':
                $this->db_hatoapps->where('Pk_Id_Usuario', $id);
                if($this->db_hatoapps->update('permisos', $datos)){
                    //Retorna verdadero
                    return true;
                } // if
            break; // Acceso a la aplicación

            // Usuario
            case 'usuario':
                $this->db_hatoapps->where('Pk_Id_Usuario', $id);
                if($this->db_hatoapps->update('usuarios', $datos)){
                    //Retorna verdadero
                    return true;
                } // if
            break; // Usuario
        }
    } // actualizar

    /**
     * Permite la carga de uno o varios arreglos, mediante el suiche
     * @param  string $tipo Tipo de caso al que accederá
     * @param  int $id   id adicional que se puede usar
     * @return array       Datos
     */
    function cargar($tipo, $id)
    {
    	// Suiche de tipo de carga
    	switch ($tipo) {
    		/**
    		 * Permisos a los que tiene el usuario
    		 * El id recibido es el id de usuario
    		 */
    		case "permisos":
    			// Consulta
		    	$this->db->select("Fk_Id_Accion");
		    	$this->db->where("Fk_Id_Usuario", $id);
				
				// Arreglo nuevo (unidimensional)
    			$permisos = array();

    			// Se recorre los resultados
    			foreach ($this->db->get("permisos")->result() as $resultado) {
					// Se agrega el dato al arreglo unidimensional
					$permisos[$resultado->Fk_Id_Accion] = true;
				} // foreach

				// Se retorna el arreglo
    			return $permisos;
			break; // permisos

			/**
    		 * Permisos a los que tiene el usuario
    		 * El id recibido es el id de usuario
    		 */
    		case "usuario":
    			// Consulta
		    	$this->db_hatoapps->select("*");
		    	$this->db_hatoapps->where("Pk_Id_Usuario", $id);
				
				// Se retorna el arreglo
				return $this->db_hatoapps->get("usuarios")->row();
			break; // permisos
    	} // suiche
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
            // Acceso a la aplicación
            case "acceso":
                // Si se borra el registro
                if($this->db_hatoapps->delete('permisos', array("Fk_Id_Usuario" => $id, "Fk_Id_Aplicacion" => $this->config->item('id_aplicacion')))){
                    return true;
                }
            break; // Acceso a la aplicación

            // Usuario
            case "usuario":
                // Si se borra el registro
                if($this->db_hatoapps->delete('usuarios', array("Pk_Id_Usuario" => $id))){
                    return true;
                } // if
            break; // Usuario
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
        switch ($tipo) {
            // Acceso a la aplicación
            case "acceso":
                // Si se guarda correctamente
                if($this->db_hatoapps->insert('permisos', $datos)){
                    return true;
                }
            break; // Acceso a la aplicación

            // Usuario
            case "usuario":
                // Si se guarda correctamente
                if($this->db_hatoapps->insert('usuarios', $datos)){
                    // Se retorna el id
                    return $this->db_hatoapps->insert_id();
                } // if
            break; // Usuario
        } // suiche
    } // insertar

    /**
     * Permite verificar si el usuario existe y coincide con la 
     * contraseña ingresada
     * @param  [string] $login    Nombre de usuario
     * @param  [string] $password Clave encriptada
     * @return [boolean]           True: existe; false: no existe
     */
    function validar($login, $password){
    	// Consulta
    	$this->db_hatoapps->select("*");
    	$this->db_hatoapps->where("Usuario", $login);
    	$this->db_hatoapps->where("Password", $password);

    	// Retorno del arreglo
    	return $this->db_hatoapps->get("usuarios")->row();
    } // validar

    /**
     * Verifica que el usuario exista en la base de datos
     * @param  string $usuario Nombre del usuario
     * @return boolean          true: exitoso
     */
    function validar_usuario($usuario){
        // Consulta
        $this->db_hatoapps->where("Usuario", $usuario);

        //Si existe el usuario
        if (count($this->db_hatoapps->get("usuarios")->row()) == 1) {
            //se retorna verdadero
            return true;
        } // if
    } // validar_usuario

    /**
     * Verifica que el usuario tenga permiso para ingresar a la aplicación
     * @param  int $id_usuario Id del usuario
     * @return boolean             true: existe; false: no existe
     */
    function validar_acceso($id_usuario){
    	//Se validan el id del usuario y el id de la aplicacion
        $this->db_hatoapps->where('Fk_Id_Usuario', $id_usuario);
        $this->db_hatoapps->where('Fk_Id_Aplicacion', $this->config->item('id_aplicacion'));

        // Se retorna el resultado
        return $this->db_hatoapps->get('permisos')->row();
    } // validar_acceso
}
/* Fin del archivo sesion_model.php */
/* Ubicación: ./application/models/sesion_model.php */