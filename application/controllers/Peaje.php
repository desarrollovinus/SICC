<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Peaje
 */
Class Peaje extends CI_Controller {
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
	        //Se carga la librería de PDF, Word y la libreráa de Excel
	        // require('system/libraries/Fpdf.php');
	        require('system/libraries/PHPExcel.php');
	        require_once('system/libraries/PHPExcel/IOFactory.php');
	        // require('system/libraries/PHPWord.php');

	        // //Carga de modelos, librerías, helpers y demás
	        $this->load->model(array('peaje_model'));

	        // // Carga de permisos
	        // $this->data['permisos'] = $this->session->userdata('Permisos');
	    } // construct

    /**
     * Carga los datos según el tipo
     * @return void 
     */
    function cargar()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se recibe el array de datos por post
            $tipo = $this->input->post('tipo');
            $id = $this->input->post('id');

            // Dependiendo del tipo
            switch ($tipo) {
                // Días del mes
                case 'dias_mes':
                	print json_encode($this->peaje_model->cargar($tipo, array("anio" => $this->input->post('anio'), "mes" => $this->input->post('mes'), "peaje" => $this->input->post('peaje'))));
                break; // Días del mes
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar

	    function recaudo_diario()
	    {
	    	//se establece el titulo de la pagina
	        $this->data['titulo'] = 'Recaudo de peaje diario';
			//Nombre del menú que se va a activar
	        $this->data['menu'] = 'general';
	        //Se establece la vista que tiene el contenido principal
	        $this->data['contenido_principal'] = 'peaje/inicio/index';
	        //Se carga la plantilla con las demas variables
	        $this->load->view('core/template', $this->data);
    } // recaudo_diario
}
/* Fin del archivo Peaje.php */
/* Ubicación: ./application/controllers/Peaje.php */