<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Operaciones_configuracion
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 *
 */
Class Operaciones_configuracion extends CI_Controller{
	/**
    * Función constructora de la clase. Esta función se encarga de verificar que se haya
    * iniciado sesión. si no se ha iniciado, inmediatamente redirecciona
    * 
    * Se hereda el mismo constructor de la clase para evitar sobreescribirlo y de esa manera 
    * conservar el funcionamiento de controlador.
    * 
    * @access   public
    */
    function __construct() {
        parent::__construct();

        // //Si no ha iniciado sesión
        // if(!$this->session->userdata('Pk_Id_Usuario')){
        //     //Se cierra la sesión obligatoriamente
        //     redirect('sesion/cerrar');
        // }//Fin if

        // //Carga de modelos, librerías, helpers y demás
        // $this->load->model(array('configuracion_model'));

        // // Carga de permisos
        // $this->data['permisos'] = $this->session->userdata('Permisos');
    } // construct
    
	/**
     * Carga la interfaz según el tipo
     * @return void 
     */
    function cargar_interfaz()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Dependiendo del tipo
            switch ($this->input->post('tipo')) {
            	// Index
                case 'index':
                    // Se carga la vista
                    $this->load->view('operaciones/configuracion/index');
                break; // Index
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar_interfaz
}
/* Fin del archivo Operaciones_configuracion.php */
/* Ubicación: ./application/controllers/Operaciones_configuracion.php */