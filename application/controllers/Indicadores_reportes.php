<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Indicadores_reportes
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 *
 */
Class Indicadores_reportes extends CI_Controller{
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

        //Se carga la librería de PDF, Word y la libreráa de Excel
        require('system/libraries/Fpdf.php');
        require('system/libraries/PHPExcel.php');
        require('system/libraries/PHPWord.php');

        //Definir la ruta de las fuentes
        define('FPDF_FONTPATH','system/fonts/');

        //Carga de modelos, librerías, helpers y demás
        $this->load->model(array('reportes_model', 'indicadores_model'));
        
        // Carga de permisos
        $this->data['permisos'] = $this->session->userdata('Permisos');
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
                // Logs por tipo de acción
                case 'logs_por_tipo':
                    // Se hace la consulta y se retorna el arreglo
                    print json_encode($this->reportes_model->cargar($tipo, NULL));
                break; // Logs por tipo de acción

            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar

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
                    $this->load->view('indicadores/reportes/index');
                break; // Index

                // Gráficos
                case 'graficos':
                    //Se carga la vista
                    $this->load->view('indicadores/reportes/graficos/index');
                break; // Gráficos
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar_interfaz

    function excel(){
        //Se carga la vista que contiene el reporte
        $this->load->view('indicadores/reportes/excel/prueba');
    } // excel

    function graficos(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Suiche tipo
            switch ($this->input->post("tipo")) {
                // Indicador O5
                case "indicador_O5":
                    // Variables por post
                    $this->data['anio'] = $this->input->post("anio");
                    $this->data['mes'] = $this->input->post("mes");
                    $this->data['cumplidos'] = $this->input->post("cumplidos");
                    $this->data['incumplidos'] = $this->input->post("incumplidos");

                    //Se carga la vista que contiene el reporte
                    $this->load->view('indicadores/reportes/graficos/indicador_O5', $this->data);
                break; // Indicador O5

                // Logs categorizados por módulo
                case "logs_por_modulo":
                    //Se carga la vista que contiene el reporte
                    $this->load->view('indicadores/reportes/graficos/logs_por_modulo');
                break; // Logs categorizados por módulo

                // Logs categorizados por tipo
                case "logs_por_tipo":
                    //Se carga la vista que contiene el reporte
                    $this->load->view('indicadores/reportes/graficos/logs_por_tipo');
                break; // Logs categorizados por tipo
            } // switch
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // excel

    function pdf(){
        // Suiche tipo
        switch ($this->uri->segment(3)) {
            // Indicadores
            case "indicadores":
                // Carha del reporte
                $this->load->view('indicadores/reportes/pdf/indicadores');
            break; // Indicadores
        } // switch
    } // pdf

    function word(){
        //Se carga la vista que contiene el reporte
        $this->load->view('indicadores/reportes/word/prueba');
    } // excel
}
/* Fin del archivo Indicadores_reportes.php */
/* Ubicación: ./application/controllers/Indicadores_reportes.php */