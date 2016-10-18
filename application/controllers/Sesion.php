<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Sesión
 */
Class Sesion extends CI_Controller {
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

        //Carga de modelos, librerías, helpers y demás
        $this->load->model(array('sesion_model', 'configuracion_model'));
    } // construct

	/**
	 * Interfaz inicial
	 * @return void 
	 */
	function index()
	{
		//se establece el titulo de la pagina
        $this->data['titulo'] = 'Login';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'sesion/index';
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
                // Usuario
                case 'usuario':
                    // Si no trae clave para cambiar
                    if ($datos["Password"] == 0) {
                        // Se elimina el campo del arreglo
                        unset($datos["Password"]);
                    }else{
                        // Se encripta la clave
                        $datos["Password"] = md5($datos["Password"]);
                    } // if

                    // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                    $this->configuracion_model->insertar_log(7, "{$datos['Nombres']} {$datos['Apellidos']} ($id)");

                    // Si se actualiza
                    if ($this->sesion_model->actualizar($tipo, $id, $datos)) {
                        // Retorna verdadero
                        echo true;
                    } // if
                break; // Usuario
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // actualizar

    /**
     * Destruye la sesión que hay en uso
     * @return void 
     */
    function cerrar()
    {
        // Si la sesión sigue viva en el momento de entrar
        if ($this->session->userdata("Pk_Id_Usuario")) {
            // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
            $this->configuracion_model->insertar_log(4, "{$this->session->userdata('Nombres')} {$this->session->userdata('Apellidos')}");
        } // if

        //Se destruye la sesión actual
        $this->session->sess_destroy();
        
        //Se redirige hacia el controlador principal
        redirect(site_url('sesion'));
    } // cerrar

    /**
     * Realiza el proceso de inicio de sesión
     * @return 
     */
    function iniciar()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se toma el id de usuario por post
            $id_usuario = $this->input->post("id_usuario");

            // Se cargan los datos del usuario
            $usuario = $this->sesion_model->cargar("usuario", $id_usuario);

            //Se arma un arreglo con los datos de sesion que va a mantener
            $datos_sesion = array(
                'Pk_Id_Usuario' => $usuario->Pk_Id_Usuario,
                'Nombres' => $usuario->Nombres,
                'Apellidos' => $usuario->Apellidos,
                'Documento' => $usuario->Documento,
                'Usuario' => $usuario->Usuario,
                'Email' => $usuario->Email,
                'Telefono' => $usuario->Telefono,
                'Tipo' => $usuario->Tipo,
                'Fk_Id_Area' => $usuario->Fk_Id_Area,
                'Permisos' => $this->configuracion_model->cargar("permisos", $id_usuario) // Carga de permisos
            );
            
            // Se carga la sesión
            $this->session->set_userdata($datos_sesion);

            // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
            $this->configuracion_model->insertar_log(3, "$usuario->Nombres $usuario->Apellidos");

            // Se retorna verdadero
            echo true;
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // iniciar

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
                // Acceso a la aplicacíón
                case 'acceso':
                    // Si se guarda correctamente
                    if ($this->sesion_model->insertar($tipo, $datos)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(5, $this->input->post("nombre"));

                        // Se retorna verdadero
                        echo true;
                    } 
                break; // Acceso a la aplicacíón

                // Usuario
                case 'usuario':
                    // Se adiciona la contraseña al arreglo
                    $datos["Password"] = md5($datos["Password"]);

                    // Inserción
                    $guardar = $this->sesion_model->insertar($tipo, $datos);

                    // Si se guarda correctamente
                    if ($guardar > 0) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(6, "{$datos['Nombres']} {$datos['Apellidos']} ($guardar)");

                        // Se retorna verdadero
                        echo $guardar;
                    } // if
                break; // Usuario
            } // switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // insertar

    /**
     * Proceso de borrado o eliminación de 
     * un registro de base de datos
     * @return boolean 
     */
    function eliminar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Datos por POST
            $tipo = $this->input->post("tipo");
            $id = $this->input->post("id");

            // Suiche
            switch ($tipo) {
                // Acceso a la aplicación
                case "acceso":
                    // Si se ejecuta el modelo correctamente
                    if ($this->sesion_model->eliminar($tipo, $id)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(5, $this->input->post("nombre"));

                        echo true; 
                    } // if
                break; // Acceso a la aplicación

                // Usuario
                case "usuario":
                    // Si se ejecuta el modelo correctamente
                    if ($this->sesion_model->eliminar($tipo, $id)) {
                        // Se inserta el registro en auditoria enviando  tipo de auditoria y id correspondiente
                        $this->configuracion_model->insertar_log(9, $this->input->post("nombre"));

                        echo true; 
                    } // if
                break; // Usuario
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    } // eliminar

    /**
     * Verifica que el usuario exista en base de datos
     * @return [type] [description]
     */
    function validar()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se ejecuta el modelo de consulta
            $datos_usuario = $this->sesion_model->validar($this->input->post("usuario"), md5($this->input->post("password")));

            // Se retorna el arreglo con la información del usuario
            print json_encode($datos_usuario);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // validar

    /**
     * Verifica que el usuario tenga permiso para entrar a la aplicación
     * @return array Datos del usuario
     */
    function validar_acceso()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se consulta en la base de datos si tiene acceso
            $acceso = $this->sesion_model->validar_acceso($this->input->post("id_usuario"));

            // Se retorna el arreglo
            print json_encode($acceso);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // validar_acceso

    /**
     * Verifica en base de datos que el nombre de usuario
     * consultado exista
     * @return [type] [description]
     */
    function validar_usuario()
    {
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Si existe el usuario
            if ($this->sesion_model->validar_usuario($this->input->post('usuario'))) {
                // Se falso (Si hay un usuario)
                echo false;
            }else{
                // Verdadero (Disponible)
                echo true;
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    } // validar_usuario
}
/* Fin del archivo Sesion.php */
/* Ubicación: ./application/controllers/Sesion.php */