<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends CI_Controller {

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
        $this->load->model('clientes_model', 'clientes');
        $this->load->model('manager_model', 'manager');
   	}

	public function index()
	{
		$clientes = $this->clientes->all();
		$data = array(
			'clientes' => $clientes, 
		);

		$this->load->view('admin/header');
		$this->load->view('admin/clientes', $data);
		$this->load->view('admin/footer');
	}

	public function get($id)
	{
		$cliente = $this->clientes->get_cliente($id);

		$response['result']	= "error";
		if ($cliente) {
			$response['result'] = "success";	
			$response['data'] = $cliente;
		}
		echo json_encode($response);
	}

	public function save() 
	{
		$datos = $this->input->post();
		$datos['cliente'] = (isset($datos['cliente'])) ? $datos['cliente']:0;
		$datos['logo'] = $this->upload('imagen', 'clientes'); //Upload and return image file
		$datos['estado'] = 1;

		//Unset imagen blank
		if ($datos['logo']=="") { unset($datos['logo']); }

		if (empty($datos['id'])) {
			$query = $this->manager->insert("clientes", $datos);
		}
		else {
			$query = $this->manager->update("clientes", $datos, $datos['id']);
		}
		if ( $query ) {
			//$result = array('result' => "success");
			echo $this->tools->reload();
		}
	}

	public function upload($file="", $tabla)
	{
		
		$ruta = 'contenidos/uploads/'.$tabla.'/full/';
		$config['upload_path'] = "./".$ruta;
		$config['file_name'] = $this->tools->cleanfilename($_FILES[$file]['name']);
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size']	= '5000';
		$config['max_width']  = '2048';
		$config['max_height']  = '2048';
		$config['remove_spaces']  = TRUE;
		$config['exactly']  = FALSE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file))
		{
			$errors = $this->upload->show_errors();
			
			$error = $this->tools->error_upload($errors, $config);
			if ($error['result']){
				echo $this->tools->alert($error['msg']);
				exit;
			}
			else {
				return "";
			}
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$sizes = $this->tools->sizes('clientes', $_FILES[$file]['tmp_name']);

			$this->load->library('image_lib'); 
			foreach ($sizes as $size) {
				$file = $data['upload_data']['full_path'];
				$path = explode("/", $file);

				$cfg['image_library'] = 'gd2';
				$cfg['source_image']	= $file;
				//$cfg['create_thumb'] = TRUE;
				$cfg['new_image'] = './contenidos/uploads/'.$tabla.'/'.$size[0].'/'.$path[count($path)-1];
				$cfg['maintain_ratio'] = TRUE;
				$cfg['width']	= $size[1];
				$cfg['height']	= $size[2];

				//$this->image_lib->resize();
				$this->image_lib->clear();
				$this->image_lib->initialize($cfg);
				if ( ! $this->image_lib->resize())
				{
					var_dump( $this->image_lib->display_errors() );
				    //echo $this->image_lib->display_errors();
				}
				else {
					if ($size[0]=="medium") {
						//$this->create_image($path, $cfg);
					}
					if ($size[0]=="small") {
						$this->convert_image($path, $cfg);
					}
					//echo "TRUE";
				}
			}

			return str_replace('full', 'medium', $ruta). $data['upload_data']['raw_name'].".jpg";
			//return str_replace('full', 'medium', $this->tools->url_file_upload( $data['upload_data']['raw_name'].$data['upload_data']['file_ext'], $ruta ) );
		}
	}

	public function create_image($path, $cfg){
		$imagen = './contenidos/uploads/clientes/medium/'.$path[count($path)-1];
		$info = getimagesize($imagen);
		$file = $path[count($path)-1];
		$filename = explode(".", $file);
		switch ($info['mime']) {
			case 'image/png':
				$im = imagecreatefrompng($imagen);
				break;
			case 'image/gif':
				$im = imagecreatefromgif($imagen);
				break;
			case 'image/jpeg':
				$im = imagecreatefromjpeg($imagen);
				break;
			
		}
		//Delete image
		@unlink('./contenidos/uploads/clientes/medium/'.$file);
		
		$posX = intval( (540 - $info[0]) / 2 );
		$posY = intval( (300 - $info[1]) / 2 );
		$bg = imagecreatefromjpeg('./static/images/background-clientes.jpg');

		imagecopy($bg, $im, $posX, $posY, 0, 0, $info[0], $info[1]);

		imagejpeg($bg, './contenidos/uploads/clientes/medium/'.$filename[0].".jpg", 85);
		imagedestroy($bg);
		imagedestroy($im);
	}

	public function convert_image($path, $cfg) {
		$imagen = './contenidos/uploads/clientes/small/'.$path[count($path)-1];
		$info = getimagesize($imagen);
		$file = $path[count($path)-1];
		$filename = explode(".", $file);
		switch ($info['mime']) {
			case 'image/png':
				$im = imagecreatefrompng($imagen);
				break;
			case 'image/gif':
				$im = imagecreatefromgif($imagen);
				break;
			case 'image/jpeg':
				$im = imagecreatefromjpeg($imagen);
				break;
			
		}
		//Delete image
		@unlink('./contenidos/uploads/clientes/small/'.$file);

		$posX = intval( (268 - $info[0]) / 2 );
		$posY = intval( (151 - $info[1]) / 2 );
		$bg = imagecreatetruecolor($info[0], $info[1]);

		imagecopy($bg, $im, 0, 0, 0, 0, $info[0], $info[1]);

		imagejpeg($bg, './contenidos/uploads/clientes/small/'.$filename[0].".jpg", 90);
		imagedestroy($bg);
		imagedestroy($im);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */