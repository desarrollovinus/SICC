<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Operaciones_bitacora
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 *
 */
Class Operaciones_bitacora extends CI_Controller{
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
        $this->load->model(array("configuracion_model", "operaciones_configuracion_model", "operaciones_bitacora_model"));

        // // Carga de permisos
        // $this->data['permisos'] = $this->session->userdata('Permisos');
    } // construct

    /**
     * Actualiza registros en base de datos
     * @return void 
     */
    function actualizar()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se recibe el array de datos por post
            $tipo = $this->input->post('tipo');
            $id = $this->input->post('id');
            $datos = $this->input->post('datos');

            // Dependiendo del tipo
            switch ($tipo) {
                // Novedad
                case 'novedad':
                    // Se ejecuta el modelo
                    echo $this->operaciones_bitacora_model->actualizar($tipo, $id, $datos);

                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    // $this->configuracion_model->insertar_log(10, "{$datos['Nombre']} ({$id})");
                break; // Novedad
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // actualizar

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
                // 
                case '':
                    
                break; // 
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
                // Historial
                case 'historial':
                    // Se carga la vista
                    $this->load->view('operaciones/bitacora/historial/index');
                break; // Historial

                // Listado del historial
                case 'historial_listar':
                    // Se recibe por post la variable de evento
                    $this->data["id_bitacora"] = $this->input->post("id_bitacora");

                    // Se carga la vista
                    $this->load->view('operaciones/bitacora/historial/listar', $this->data);
                break; // Listado del historial

                // Listado del historial de registros
                case 'historial_listar_registros':
                    // Se carga la vista
                    $this->load->view('operaciones/bitacora/historial/registros');
                break; // Listado del historial de registros

                // Novedades
                case 'novedades':
                    // Se carga la vista
                    $this->load->view('operaciones/bitacora/novedades/index');
                break; // Novedades

                // Listar actores de la gestión de bitácora
                case 'novedades_actores_listar':
                    // Se recibe por post la variable de evento
                    $this->data["id_novedad"] = $this->input->post("id_novedad");

                    // Se carga la vista
                    $this->load->view('operaciones/bitacora/novedades/listar_actores', $this->data);
                break; // Listar actores de la gestión de bitácora

                // Crear bitácora
                case 'novedades_crear':
                    // Se recibe por post la variable que define si es un registro nuevo o una edición
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('operaciones/bitacora/novedades/crear', $this->data);
                break; // Crear bitácora

                // Listar gestión de bitácora
                case 'novedades_listar':
                    // Se carga la vista
                    $this->load->view('operaciones/bitacora/novedades/listar');
                break; // Listar gestión de bitácora

                // Index
                case 'index':
                    // Se carga la vista
                    $this->load->view('operaciones/bitacora/index');
                break; // Index

                // Novedades de la bitácora
                case 'registros_listar':
                    // Se carga la vista
                    $this->load->view('operaciones/bitacora/novedades/registros');
                break; // Novedades de la bitácora
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar_interfaz

    /**
     * Proceso de registro de base de datos
     * @return boolean 
     */
    function insertar()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se recibe el array de datos por post
            $datos = $this->input->post('datos');
            $tipo = $this->input->post('tipo');

            // Dependiendo del tipo
            switch ($tipo) {
                // Novedad
                case 'novedad':
                    // Se ejecuta el modelo
                    $id = $this->operaciones_bitacora_model->insertar($tipo, $datos);
                    
                    // Si se guarda correctamente
                    if ($id) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(30, NULL);

                        // Se retorna verdadero
                        echo $id;
                    } // if
                break; // Novedad

                // Actor de una novedad
                case 'novedad_actor':
                    // Si se guarda correctamente
                    if ($this->operaciones_bitacora_model->insertar($tipo, $datos)) {
                        // Se retorna verdadero
                        echo true;
                    } // if
                break; // Actor de una novedad

                // Registro
                case 'registro':
                    // Se envía al modelo
                    $registro = $this->operaciones_bitacora_model->insertar($tipo, $datos);
                    
                    // Si se guarda correctamente
                    if ($registro) {
                        // Se retorna verdadero
                        echo date("g:i a", strtotime($registro));
                    } // if
                break; // Registro
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // insertar
}
/* Fin del archivo Operaciones_bitacora.php */
/* Ubicación: ./application/controllers/Operaciones_bitacora.php */