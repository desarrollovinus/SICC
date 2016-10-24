<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Informes
 */
Class Informes extends CI_Controller {
	function __construct() {
        parent::__construct();

        /*//Si no ha iniciado sesión o es usuario responsable
        if(!$this->session->userdata('id_usuario') || $this->session->userdata('tipo') == '2'){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if*/
        
        // Carga de modelos y librerías
        // $this->load->model(array('informes_model', 'equipos_model', 'cronograma_model', 'ordenes_trabajo_model', 'ordenes_salida_model'));
        // $this->load->library(array('PHPExcel', 'PHPWord'));

        //Se carga las librerías
        require('system/libraries/Fpdf.php');
        require('system/libraries/Barcode.inc.php');

        //Definir la ruta de las fuentes
        define('FPDF_FONTPATH','system/fonts/');
    }

}
/* Fin del archivo Informes.php */
/* Ubicación: ./application/controllers/Informes.php */