<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Reportes de peaje
 */
Class Peaje_reportes extends CI_Controller {
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
                // Tráfico
                case 'trafico':
                    // Variables por post
                    $this->data['peaje'] = "niquia";

                    //Se carga la vista que contiene el reporte
                    $this->load->view('peaje/reportes/graficos/trafico', $this->data);
                break; // Tráfico

                // Recaudo
                case 'recaudo':
                    // Variables por post
                    $this->data['peaje'] = "niquia";

                    //Se carga la vista que contiene el reporte
                    $this->load->view('peaje/reportes/graficos/recaudo', $this->data);
                break; // Recaudo

                // Tráfico
                case 'trafico_trapiche':
                    // Variables por post
                    $this->data['peaje'] = "trapiche";

                    //Se carga la vista que contiene el reporte
                    $this->load->view('peaje/reportes/graficos/trafico', $this->data);
                break; // Tráfico

                // Recaudo
                case 'recaudo_trapiche':
                    // Variables por post
                    $this->data['peaje'] = "trapiche";

                    //Se carga la vista que contiene el reporte
                    $this->load->view('peaje/reportes/graficos/recaudo', $this->data);
                break; // Recaudo

                // Tráfico
                case 'trafico_cabildo':
                    // Variables por post
                    $this->data['peaje'] = "cabildo";

                    //Se carga la vista que contiene el reporte
                    $this->load->view('peaje/reportes/graficos/trafico', $this->data);
                break; // Tráfico

                // Recaudo
                case 'recaudo_cabildo':
                    // Variables por post
                    $this->data['peaje'] = "cabildo";

                    //Se carga la vista que contiene el reporte
                    $this->load->view('peaje/reportes/graficos/recaudo', $this->data);
                break; // Recaudo
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar
}
/* Fin del archivo Peaje_reportes.php */
/* Ubicación: ./application/controllers/Peaje_reportes.php */