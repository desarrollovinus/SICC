<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

defined('BASEPATH') OR exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Peajes
 */
Class Peajes extends CI_Controller {
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

    var $dir = "./archivos/peajes/recaudos/";

    /**
	 * Interfaz inicial
	 * @return void 
	 */
	function index()
	{
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Peajes';
		//Nombre del menú que se va a activar
        $this->data['menu'] = 'peajes';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'peajes/inicio/index';
        //Se carga la plantilla con las demas variables
        $this->load->view('core/template', $this->data);
	} // index

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
                	print json_encode($this->peaje_model->cargar($tipo, array("peaje" => $this->input->post('peaje'))));
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
        $this->data['menu'] = 'operaciones';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'peajes/inicio/index';
        //Se carga la plantilla con las demas variables
        $this->load->view('core/template', $this->data);
    } // recaudo_diario

    // Recaudo de niquía
    function recaudo_niquia()
    {
		$this->leer_recaudos($this->dir."RIDYM Niquia ".date("y").date("m").".xlsx");
    } // recaudo_niquia

    // Recaudo de trapiche
    function recaudo_trapiche()
    {
		$this->leer_recaudos($this->dir."RIDYM Trapiche ".date("y").date("m").".xlsx");
    } // recaudo_trapiche

    // Recaudo de cabildo
    function recaudo_cabildo()
    {
		$this->leer_recaudos($this->dir."RIDYM Cabildo ".date("y").date("m").".xlsx");
    } // recaudo_cabildo

	function leer_recaudos($archivo)
	{
		$nombre = explode(" ", $archivo);

		$fecha = strtotime ( '-1 day' , strtotime ( date('Y-m-d') ));
		$fecha = date ( 'Y-m-d' , $fecha );

		$anio = date("Y", strtotime($fecha));
		$mes = date("m", strtotime($fecha));
		$dia = date("d", strtotime($fecha));

		echo $archivo;
		echo "<br>";

		// Se crea el objeto
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		// Se lee el archivo
		$objPHPExcel = $objReader->load($archivo);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		echo "- Valor: ".$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, 46)->getCalculatedValue();
		// echo "- Valor: ".$objWorksheet->getCell('D46')->getCalculatedValue();
		echo "<br>";



		$tipo = 'Excel2007';
		$Reader = PHPExcel_IOFactory::createReader($tipo);
		$objPHPExcel = $Reader->load($archivo);
		
		$data = array();
		$contador = "1";
		while (true) {
			if ($contador < 10) {
				$contador = '0'.$contador;
			}

			try {
				$hoja = $objPHPExcel->setActiveSheetIndexbyName('INF '.$contador);
			} catch (Exception $e) {
				break;
			}

			$pagados = $hoja->getCell('B44')->getCalculatedValue();
			
				// Si pagados

			$sin_pagar = $hoja->getCell('I44')->getCalculatedValue() - $pagados;
			$total_recaudo = $hoja->getCell('D46')->getCalculatedValue();
			$total_sobretasa = $hoja->getCell('J44')->getCalculatedValue();

			if (!$pagados) {
				break;
			}

			$dataTemp = array(
				'Peaje' => $nombre[1],
				'Fecha' => "$anio-$mes-".$contador,
				'pagados' => $pagados,
				'sin_pagar' => $sin_pagar,
				'total_recaudo' => $total_recaudo,
				'total_sobretasa' => $total_sobretasa
			);

			array_push($data, $dataTemp);
			$contador++;
		print_r($dataTemp);
		echo "<br>";
		echo "<br>";
		echo "<br>";
		}
		// echo "<pre>";
		// var_dump($data);
		echo "<br>";

		$this->peaje_model->actualizar($data);

		unset($objPHPExcel);
	}// leer excel
}
/* Fin del archivo Peajes.php */
/* Ubicación: ./application/controllers/Peaje.php */
