<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Reportes de peaje
 */
Class Peaje_reportes extends CI_Controller {
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

            // //Carga de modelos, librerías, helpers y demás
            $this->load->model(array('peaje_model'));

            // // Carga de permisos
            // $this->data['permisos'] = $this->session->userdata('Permisos');
        } // construct

	/**
     * Carga los datos según el tipo
     * @return void 
     */
    function graficos()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se recibe el array de datos por post
            $tipo = $this->input->post('tipo');
            $id = $this->input->post('id');

            // Dependiendo del tipo
            switch ($tipo) {
                // Trabla de tráfico y recaudos
                case 'tabla':
                    //Se carga la vista que contiene el reporte
                    $this->load->view('peaje/reportes/graficos/tabla');
                break; // Trabla de tráfico y recaudos

                // Tráfico
                case 'trafico':
                    // Variables por post
                    $this->data['peaje'] = $this->input->post("peaje");

                    //Se carga la vista que contiene el reporte
                    $this->load->view('peaje/reportes/graficos/trafico', $this->data);
                break; // Tráfico

                // Recaudo
                case 'recaudo':
                    // Variables por post
                    $this->data['peaje'] = $this->input->post("peaje");

                    //Se carga la vista que contiene el reporte
                    $this->load->view('peaje/reportes/graficos/recaudo', $this->data);
                break; // Recaudo

                // // Tráfico
                // case 'trafico_trapiche':
                //     // Variables por post
                //     $this->data['peaje'] = "trapiche";

                //     //Se carga la vista que contiene el reporte
                //     $this->load->view('peaje/reportes/graficos/trafico', $this->data);
                // break; // Tráfico

                // // Recaudo
                // case 'recaudo_trapiche':
                //     // Variables por post
                //     $this->data['peaje'] = "trapiche";

                //     //Se carga la vista que contiene el reporte
                //     $this->load->view('peaje/reportes/graficos/recaudo', $this->data);
                // break; // Recaudo


                // // Tráfico
                // case 'trafico_cabildo':
                //     // Variables por post
                //     $this->data['peaje'] = "cabildo";

                //     //Se carga la vista que contiene el reporte
                //     $this->load->view('peaje/reportes/graficos/trafico', $this->data);
                // break; // Tráfico

                // // Recaudo
                // case 'recaudo_cabildo':
                //     // Variables por post
                //     $this->data['peaje'] = "cabildo";

                //     //Se carga la vista que contiene el reporte
                //     $this->load->view('peaje/reportes/graficos/recaudo', $this->data);
                // break; // Recaudo
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar
}
/* Fin del archivo Peaje_reportes.php */
/* Ubicación: ./application/controllers/Peaje_reportes.php */