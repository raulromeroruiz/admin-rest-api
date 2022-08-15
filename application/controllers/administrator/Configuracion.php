<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracion extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
   	{
    	parent::__construct();
		$this->load->model('manager_model', 'manager');
		$this->load->model('configuracion_model', 'configuracion');
   	}

	public function index()
	{
		// $this->load->model('categorias_model', 'categorias');

		//$configuracion = $this->consume->all('configuracion');
		//$configuracion = $this->configuracion->get_configuracion();
		$pdf = $this->manager->get_option(1);
		// $bgregistro = $this->manager->get_option(9);
		// $campos = $this->configuracion->fields();
		// $categorias = $this->categorias->categorias_x_parent('categorias');
		// $categorias_nofields = $this->configuracion->nofields();
		// $rrss = $this->manager->all('rrss');
		// $fuentes = $this->manager->all('fuentes');
		// $menu = $this->manager->all('menu');
		// $mensajes = $this->manager->all('mensajes');

		$data = array(
			'pdf' => $pdf,
			// 'bgregistro' => $bgregistro,
			// 'campos' => $campos,
			// 'categorias' => $categorias,
			// 'nocategorias' => $categorias_nofields,
			// 'rrss' => $rrss,
			// 'fuentes' => $fuentes,
			// 'menu' => $menu,
			// 'mensajes' => $mensajes,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/configuracion', $data);
		$this->load->view('admin/footer');
	}

	public function get($tabla, $id)
	{
		$this->load->model('consume_model', 'consume');
		$campos = $this->consume->get( $tabla, $id );

		$result = array(
			'result' => "success",
			'data' => $campos,
		);

		echo json_encode($result);
	}

	public function save() 
	{
		$this->load->model('consume_model', 'consume');
		$this->load->model('configuracion_model', 'configuracion');
		$datos = $this->tools->objeto($this->input->post());

		$datos = $this->input->post();
		$datos['imagen'] = $this->upload('imagen', 'configuracion'); //Upload and return image file
		$datos['fecha'] = $this->tools->datesql($datos['fecha']);
		$datos['url'] = $this->tools->urlfriendly($datos['titulo']);
		$datos['estado'] = 0;
		$datos['autor'] = $_SESSION['admin']->id;

		//Unset imagen blank
		if ($datos['imagen']=="") { unset($datos['imagen']); }

		if (empty($datos['id'])) {
			$query = $this->consume->insert("configuracion", $datos);
		}
		else {
			$query = $this->consume->update("configuracion", $datos, $datos['id']);
		}
		if ( $query ) {
			//$result = array('result' => "success");
			echo $this->tools->reload();
		}
		//echo json_encode($result);
	}

	public function set()
	{
		// var_dump($this->input->post());
		$field = $this->input->post('field');
		$file = $this->input->post('file');
		switch ($field) {
			case 'file':
				$cfg = [
					'file' => $file,
					'dir'  => $file,
				];
				$filepath = $this->upload($cfg);
				$this->manager->set_option(['option' => "pdf", 'value' => $filepath, 'id' => 1]);
				break;
			
			default:
				# code...
				break;
		}
	}

	public function upload($params = [])
	{
		// var_dump($params);
		$tabla = $params['dir'];
		$file = $params['file'];
		$ruta = '../contenidos/uploads/'.$tabla.'/full/';
		if (!is_dir($ruta)){
			mkdir($ruta, 0755, TRUE);
		}
		$config['upload_path'] = $ruta;
		$config['file_name'] = $this->tools->cleanfilename($_FILES[$file]['name']);
		$config['allowed_types'] = 'jpg|jpeg|png|pdf';
		$config['max_size']	= '5000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['remove_spaces']  = TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($file))
		{
			$error = array('error' => $this->upload->display_errors());
			// var_dump($error);
			return "";
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			// var_dump($data);
			return $this->tools->url_file_upload( $data['upload_data']['raw_name'].$data['upload_data']['file_ext'], $ruta );
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */