<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Indicadores
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 *
 */
Class Indicadores extends CI_Controller{
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
        $this->load->model(array("indicadores_model", "configuracion_model"));

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
        $this->data['titulo'] = 'Indicadores';
        //Nombre del menú que se va a activar
        $this->data['menu'] = 'indicadores';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'indicadores/inicio/index';
        //Se carga la plantilla con las demas variables
        $this->load->view('core/template', $this->data);
    } // index

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
                // Indicador
                case 'indicador':
                    // Se ejecuta el modelo
                    echo $this->indicadores_model->actualizar($tipo, $id, $datos);

                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    $this->configuracion_model->insertar_log(28, "{$datos['Nombre']} ({$id})");
                break; // Indicador
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // actualizar

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
                // Evaluaciones
                case 'evaluaciones':
                    // Se carga la vista
                    $this->load->view('indicadores/indicadores/evaluaciones/index');
                break; // Evaluaciones

                // Crear evaluación
                case 'evaluaciones_crear':
                    // Se recibe por post la variable que define si es una norma nueva o editada
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('indicadores/indicadores/evaluaciones/crear', $this->data);
                break; // Crear evaluación

                // Listar evaluaciones
                case 'evaluaciones_listar':
                    // Se carga la vista
                    $this->load->view('indicadores/indicadores/evaluaciones/listar');
                break; // Listar evaluaciones

                // Evaluación según la familia de indicadores
                case 'evaluaciones_familia':
                    // Se recibe por post la variable que define si es una norma nueva o editada
                    $this->data["id_unidad_funcional"] = $this->input->post("id_unidad_funcional");
                    $this->data["id_indicador"] = $this->input->post("id_indicador");

                    // Si la familia es 1 (operación)
                    if ($this->input->post("id_familia") == 1) {
                        // Se carga la vista
                        $this->load->view('indicadores/indicadores/evaluaciones/operacion', $this->data);
                    } // if

                    // Si la familia es 1 (operación)
                    if ($this->input->post("id_familia") == 2) {
                        // Se carga la vista
                        $this->load->view('indicadores/indicadores/evaluaciones/estado', $this->data);
                    } // if
                break; // Evaluación según la familia de indicadores

                // Resultados de evaluaciones según el indicador
                case 'evaluaciones_resultados':
                    // Variables por post
                    $indicador = $this->input->post("indicador");
                    $this->data['indicador'] = $indicador;
                    $this->data['anio'] = $this->input->post("anio");
                    $this->data['mes'] = $this->input->post("mes");

                    // Según el indicador
                    switch ($indicador) {
                        case 'O5':
                            // Se carga la vista
                            $this->load->view('indicadores/indicadores/evaluaciones/resultados/'.$indicador, $this->data);
                        break; // O5
                    } // suiche
                break; // Resultados de evaluaciones según el indicador

                // Gestión
                case 'gestion':
                    // Se carga la vista
                    $this->load->view('indicadores/indicadores/gestion/index');
                break; // Gestión

                // Crear indicador
                case 'gestion_crear':
                    // Se recibe por post la variable que define si es una norma nueva o editada
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('indicadores/indicadores/gestion/crear', $this->data);
                break; // Crear indicador

                // Listar gestión de indicadores
                case 'gestion_listar':
                    // Se carga la vista
                    $this->load->view('indicadores/indicadores/gestion/listar');
                break; // Listar gestión de indicadores

                // Index
                case 'index':
                    // Se carga la vista
                    $this->load->view('indicadores/indicadores/index');
                break; // Index

                // Políticas
                case 'politicas':
                    // Se carga la vista
                    $this->load->view('indicadores/indicadores/politicas/index');
                break; // Políticas

                // Listar políticas de indicadores
                case 'politicas_listar':
                    // Se carga la vista
                    $this->load->view('indicadores/indicadores/politicas/listar');
                break; // Listar políticas de indicadores
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // cargar_interfaz

    /**
     * Proceso de borrado o eliminación de 
     * un registro de base de datos
     * @return boolean 
     */
    function eliminar()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Datos por POST
            $tipo = $this->input->post("tipo");
            $id = $this->input->post("id");

            // Suiche
            switch ($tipo) {
                // Indicador
                case "indicador":
                    // Si se ejecuta el modelo correctamente
                    if ($this->indicadores_model->eliminar($tipo, $id)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(29, "{$this->input->post("nombre")} ({$id})");

                        echo true;
                    } // if
                break; // Indicador

                // Políticas
                case "politicas":
                    // Si se ejecuta el modelo correctamente
                    if ($this->indicadores_model->eliminar($tipo, NULL)) {
                        echo true;
                    } // if
                break; // Políticas
            } // switch
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    } // eliminar

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
                // Indicador
                case 'indicador':
                    // Si se guarda correctamente
                    if ($this->indicadores_model->insertar($tipo, $datos)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(27, $datos['Nombre']);

                        // Se retorna verdadero
                        echo true;
                    } // if
                break; // Indicador

                // Política
                case 'politica':
                    // Si se guarda correctamente
                    if ($this->indicadores_model->insertar($tipo, $datos)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        // $this->configuracion_model->insertar_log(27, "");

                        // Se retorna verdadero
                        echo true;
                    } // if
                break; // Política
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // insertar

    /**
     * Verifica si el identificador de un indicador existe en base de datos
     * @param  string $identificador Identidicador
     * @return boolean                true: exito
     */
    function validar_identificador()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Si existe el indicador
            if ($this->indicadores_model->validar_identificador($this->input->post("identificador"))) {
                echo true;
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // validar_identificador
}
/* Fin del archivo Indicadores.php */
/* Ubicación: ./application/controllers/Indicadores.php */