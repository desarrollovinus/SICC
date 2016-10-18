<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Inicio
 */
Class Inicio extends CI_Controller {
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

        //Si no ha iniciado sesión
        if(!$this->session->userdata('Pk_Id_Usuario')){
            //Se cierra la sesión obligatoriamente
            redirect('sesion/cerrar');
        }//Fin if

        //Carga de modelos, librerías, helpers y demás
        $this->load->model(array('sesion_model', 'configuracion_model'));

        // Carga de permisos
        $this->data['permisos'] = $this->session->userdata('Permisos');
    } // construct

	/**
	 * Interfaz inicial
	 * @return void 
	 */
	function index()
	{
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Aplicaciones';
		//Nombre del menú que se va a activar
        $this->data['menu'] = 'general';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'inicio/index';
        //Se carga la plantilla con las demas variables
        $this->load->view('core/template', $this->data);
	} // index

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
                    $this->load->view('inicio/index');
                break; // Index
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar_interfaz
}
/* Fin del archivo Inicio.php */
/* Ubicación: ./application/controllers/Inicio.php */