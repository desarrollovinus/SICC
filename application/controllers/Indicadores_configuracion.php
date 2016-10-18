<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Indicadores_configuracion
 * 
 * @author              John Arley Cano Salinas (johnarleycano@hotmail.com)
 * @copyright           CONCESIÓN VIAL VÍAS DEL NUS S.A.S.
 *
 */
Class Indicadores_configuracion extends CI_Controller{
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
        $this->load->model(array('configuracion_model'));

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
        $this->data['titulo'] = 'Configuración';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'indicadores/configuracion/index';
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
                // Concepto de medición
                case 'concepto_medicion':
                    // Se ejecuta el modelo
                    echo $this->configuracion_model->actualizar($tipo, $id, $datos);

                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    $this->configuracion_model->insertar_log(24, "{$datos['Nombre']} ({$id})");
                break; // Concepto de medición

                // Familia
                case 'familia':
                    // Se ejecuta el modelo
                    echo $this->configuracion_model->actualizar($tipo, $id, $datos);

                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    $this->configuracion_model->insertar_log(10, "{$datos['Nombre']} ({$id})");
                break; // Familia

                // Norma
                case 'norma':
                    // Se ejecuta el modelo
                    echo $this->configuracion_model->actualizar($tipo, $id, $datos);

                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    $this->configuracion_model->insertar_log(14, "{$datos['Nombre']} ({$id})");
                break; // Norma

                // Periodicidad
                case 'periodicidad':
                    // Se ejecuta el modelo
                    echo $this->configuracion_model->actualizar($tipo, $id, $datos);

                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    $this->configuracion_model->insertar_log(17, "{$datos['Nombre']} ({$id})");
                break; // Periodicidad

                // Unidad funcional
                case 'unidad_funcional':
                    // Se ejecuta el modelo
                    echo $this->configuracion_model->actualizar($tipo, $id, $datos);

                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    $this->configuracion_model->insertar_log(2, "{$datos['Nombre']} ({$id})");
                break; // Unidad funcional

                // Unidad de medida
                case 'unidad_medida':
                    // Se ejecuta el modelo
                    echo $this->configuracion_model->actualizar($tipo, $id, $datos);

                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    $this->configuracion_model->insertar_log(20, "{$datos['Nombre']} ({$id})");
                break; // Unidad de medida
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
                // Conceptos de medición
                case 'conceptos_medicion':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/conceptos_medicion/index');
                break; // Conceptos de medición

                // Crear conceptos de medición
                case 'conceptos_medicion_crear':
                    // Se recibe por post la variable que define si es una norma nueva o editada
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/conceptos_medicion/crear', $this->data);
                break; // Crear conceptos de medición

                // Listar conceptos de medición
                case 'conceptos_medicion_listar':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/conceptos_medicion/listar');
                break; // Listar conceptos de medición

                // Familias
                case 'familias':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/familias/index');
                break; // Familias

                // Crear familias
                case 'familias_crear':
                    // Se recibe por post la variable que define si es una norma nueva o editada
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/familias/crear', $this->data);
                break; // Crear familias

                // Listar familias
                case 'familias_listar':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/familias/listar');
                break; // Listar familias

                // Index
                case 'index':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/index');
                break; // Index

                // Inicio
                case 'inicio':
                    // Se carga la vista
                    $this->load->view('indicadores/inicio/index');
                break; // Inicio

                // Listar logs de auditoría
                case 'logs_listar':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/logs/listar');
                break; // Listar logs de auditoría

                // Normas
                case 'normas':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/normas/index');
                break; // Normas

                // Crear normas
                case 'normas_crear':
                    // Se recibe por post la variable que define si es una norma nueva o editada
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/normas/crear', $this->data);
                break; // Crear normas

                // Listar normas
                case 'normas_listar':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/normas/listar');
                break; // Listar normas

                // Periodicidades
                case 'periodicidades':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/periodicidades/index');
                break; // Periodicidades

                // Crear periodicidades
                case 'periodicidades_crear':
                    // Se recibe por post la variable que define si es una periodicidad nueva o editada
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/periodicidades/crear', $this->data);
                break; // Crear periodicidades

                // Listar periodicidades
                case 'periodicidades_listar':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/periodicidades/listar');
                break; // Listar periodicidades

                // Permisos y accesos
                case 'permisos':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/permisos/index');
                break; // Permisos y accesos

                // Listar permisos
                case 'permisos_listar':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/permisos/listar');
                break; // Listar permisos

                // Interfaz de permisos por módulos
                case 'permisos_tipo_modulo':
                    // Se toma el id por POST
                    $this->data["id_modulo"] = $this->input->post("id"); 

                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/permisos/listar_modulos', $this->data);
                break; // Interfaz de permisos por módulos

                // Interfaz de permisos por usuarios
                case 'permisos_tipo_usuario':
                    // Se toma el id por POST
                    $this->data["id_usuario"] = $this->input->post("id"); 

                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/permisos/listar_usuarios', $this->data);
                break; // Interfaz de permisos por usuarios

                // Unidades de medida
                case 'unidades_medida':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/unidades_medida/index');
                break; // Unidades de medida

                // Crear unidades de medida
                case 'unidades_medida_crear':
                    // Se recibe por post la variable que define si es una periodicidad nueva o editada
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/unidades_medida/crear', $this->data);
                break; // Crear unidades de medida

                // Listado de las unidades de medida
                case 'unidades_medida_listar':
                    // Se recibe por post el id de la unidad de medida
                    $this->data["id_usuario"] = $this->input->post("id");
                    
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/unidades_medida/listar', $this->data);
                break; // Listado de las unidades de medida

                // Historial del usuario
                case 'usuario_historial':
                    // Se recibe por post el id del usuario al que se le mostrará el historial
                    $this->data["id_usuario"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/usuarios/historial/index', $this->data);
                break; // Historial del usuario

                // Listado del historial del usuario
                case 'usuario_historial_listar':
                    // Se recibe por post el id del usuario al que se le mostrará el historial
                    $this->data["id_usuario"] = $this->input->post("id");
                    
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/usuarios/historial/listar', $this->data);
                break; // Listado del historial del usuario

                // Logs del historial del usuario
                case 'usuario_historial_logs':
                    // Se recibe los datos por POST
                    $this->data["id_usuario"] = $this->input->post("id_usuario");
                    $this->data["id_modulo"] = $this->input->post("id_modulo");
                    $this->data["id_accion"] = $this->input->post("id_accion");

                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/usuarios/historial/logs', $this->data);
                break; // Logs del historial del usuario

                // Usuarios
                case 'usuarios':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/usuarios/index');
                break; // Usuarios

                // Crear usuarios
                case 'usuarios_crear':
                    // Se recibe por post la variable que define si es un usuario nuevo o editado
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/usuarios/crear', $this->data);
                break; // Crear usuarios

                // Unidades funcionales
                case 'unidades_funcionales':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/unidades_funcionales/index');
                break; // Unidades funcionales

                // Crear unidades funcionales
                case 'unidades_funcionales_crear':
                    // Se recibe por post la variable que define si es una unidad funcional nueva o editada
                    $this->data["id"] = $this->input->post("id");

                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/unidades_funcionales/crear', $this->data);
                break; // Crear unidades funcionales

                // Listar unidades funcionales
                case 'unidades_funcionales_listar':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/unidades_funcionales/listar');
                break; // Listar unidades funcionales

                // Listar usuarios
                case 'usuarios_listar':
                    // Se carga la vista
                    $this->load->view('indicadores/configuracion/usuarios/listar');
                break; // Listar usuarios
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
                // Concepto de medición
                case "concepto_medicion":
                    // Si se ejecuta el modelo correctamente
                    if ($this->configuracion_model->eliminar($tipo, $id)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(26, "{$this->input->post("nombre")} ({$id})");

                        echo true;
                    } // if
                break; // Concepto de medición

                // Familia
                case "familia":
                    // Si se ejecuta el modelo correctamente
                    if ($this->configuracion_model->eliminar($tipo, $id)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(23, "{$this->input->post("nombre")} ({$id})");

                        echo true;
                    } // if
                break; // Familia

                // Norma
                case "norma":
                    // Si se ejecuta el modelo correctamente
                    if ($this->configuracion_model->eliminar($tipo, $id)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(16, "{$this->input->post("nombre")} ({$id})");

                        echo true; 
                    } // if
                break; // Norma

                // Periodicidad
                case "periodicidad":
                    // Si se ejecuta el modelo correctamente
                    if ($this->configuracion_model->eliminar($tipo, $id)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(19, "{$this->input->post("nombre")} ({$id})");

                        echo true; 
                    } // if
                break; // Periodicidad

                // Permisos de un usuario
                case "permisos_usuario":
                    // Si se ejecuta el modelo correctamente
                    if ($this->configuracion_model->eliminar($tipo, $id)) {
                        echo true; 
                    } // if
                break; // Permisos de un usuario

                // Todas las acciones de un módulo específico
                case "permisos_modulo":
                    // Primero, se consulta los permisos existentes para el módulo
                    $acciones_modulo = $this->configuracion_model->cargar($tipo, $id);

                    // Se recorren las acciones
                    foreach ($acciones_modulo as $accion) {
                        // Se elimina la acción
                        $this->configuracion_model->eliminar($tipo, $accion->Fk_Id_Accion);
                    } // foreach

                    echo true; 
                break; // Todas las acciones de un módulo específico

                // Unidad de medida
                case "unidad_medida":
                    // Si se ejecuta el modelo correctamente
                    if ($this->configuracion_model->eliminar($tipo, $id)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(8, "{$this->input->post("nombre")} ({$id})");

                        echo true; 
                    } // if
                break; // Unidad de medida

                // Unidad funcional
                case "unidad_funcional":
                    // Si se ejecuta el modelo correctamente
                    if ($this->configuracion_model->eliminar($tipo, $id)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(13, "{$this->input->post("nombre")} ({$id})");

                        echo true; 
                    } // if
                break; // Unidad funcional
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
                // Concepto de medición
                case 'concepto_medicion':
                    // Si se guarda correctamente
                    if ($this->configuracion_model->insertar($tipo, $datos)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(25, $datos['Nombre']);

                        // Se retorna verdadero
                        echo true;
                    } // if
                break; // Concepto de medición

                // Familia
                case 'familia':
                    // Si se guarda correctamente
                    if ($this->configuracion_model->insertar($tipo, $datos)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(22, $datos['Nombre']);

                        // Se retorna verdadero
                        echo true;
                    } // if
                break; // Familia

                // Norma
                case 'norma':
                    // Si se guarda correctamente
                    if ($this->configuracion_model->insertar($tipo, $datos)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(15, $datos['Nombre']);

                        // Se retorna verdadero
                        echo true;
                    } // if
                break; // Norma

                // Periodicidad
                case 'periodicidad':
                    // Si se guarda correctamente
                    if ($this->configuracion_model->insertar($tipo, $datos)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(18, $datos['Nombre']);

                        // Se retorna verdadero
                        echo true;
                    } // if
                break; // Periodicidad

                // Este se usa para ingresar el log cuando se agreguen uno o varios permisos en
                // la configuración por módulos. El registro se hace una sola vez
                case 'permisos_auditoria':
                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    $this->configuracion_model->insertar_log(12, $this->input->post("nombre")." ({$this->input->post('id_modulo')})");
                break; // Permisos de auditoría

                // Acciones que pertenecen a un módulo y para cada usuario elegido
                case 'permisos_modulo':
                    // Se guarda
                    $this->configuracion_model->insertar("permisos", $datos);
                        
                    echo true;
                break; // Acciones que pertenecen a un módulo y para cada usuario elegido

                // Permisos del usuario
                case 'permisos_usuario':
                    // Se recibe el id de usuario por POST
                    $id_usuario = $this->input->post("id_usuario");
                    
                    // Recorrido de los permisos
                    foreach ($datos as $permiso) {
                        // Se guarda
                        $this->configuracion_model->insertar("permisos", array('Fk_Id_Accion' => $permiso, 'Fk_Id_Usuario' => $id_usuario));
                    } // foreach

                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    $this->configuracion_model->insertar_log(11, $this->input->post("nombre")." ({$id_usuario})");

                    // Se retorna verdadero
                    echo true;
                break; // Permisos del usuario

                // Unidad funcional
                case 'unidad_funcional':
                    // Se ejecuta el modelo
                    $exito = $this->configuracion_model->insertar($tipo, $datos);

                    // Si se guarda correctamente
                    if ($exito) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(1, $datos['Nombre']);

                        // Se retorna verdadero
                        echo $exito;
                    } // if
                break; // Unidad funcional

                // Segmento de una unidad funcional
                case 'unidad_funcional_segmento':
                    // Se ejecuta el modelo
                    echo $this->configuracion_model->insertar($tipo, $datos);
                break; // Segmento de una unidad funcional

                // Unidad de medida
                case 'unidad_medida':
                    // Si se guarda correctamente
                    if ($this->configuracion_model->insertar($tipo, $datos)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(21, $datos['Nombre']);

                        // Se retorna verdadero
                        echo true;
                    } // if
                break; // Unidad de medida
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // insertar
}
/* Fin del archivo Indicadores_configuracion.php */
/* Ubicación: ./application/controllers/Indicadores_configuracion.php */