<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testimonios extends CI_Controller {

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
        $this->load->model('testimonios_model', 'testimonios');
        $this->load->model('manager_model', 'manager');
   	}

	public function index()
	{
		$testimonios = $this->testimonios->all();

		$data = array(
			'testimonios' => $testimonios, 
		);

		$this->load->view('admin/header');
		$this->load->view('admin/testimonios', $data);
		$this->load->view('admin/footer');
	}

	public function get($id)
	{
		$testimonio = $this->testimonios->get_testimonio($id);

		$response['result']	= "error";
		if ($testimonio) {
			$response['result'] = "success";
			$response['data'] = $testimonio;
		}
		echo json_encode($response);
	}

	public function save() 
	{
		$datos = $this->input->post();
		$datos['imagen'] = $this->upload('imagen', 'testimonios'); //Upload and return image file
		$datos['url'] = $this->tools->urlfriendly($datos['nombre'].'-'.$datos['cargo']);
		$datos['estado'] = 1;

		//Unset imagen blank
		if ($datos['imagen']=="") { unset($datos['imagen']); }

		if (empty($datos['id'])) {
			$query = $this->manager->insert("testimonios", $datos);
		}
		else {
			$query = $this->manager->update("testimonios", $datos, $datos['id']);
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
		$config['allowed_types'] = 'jpg|jpeg|png';
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

			$sizes = $this->tools->sizes($tabla, $_FILES[$file]['tmp_name']);

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
					if ($size[0]=="small") {
						$this->crop('testimonios', $path, $cfg);
					}
					//echo "TRUE";
				}
			}

			return $this->tools->url_file_upload( $data['upload_data']['raw_name'].$data['upload_data']['file_ext'], $ruta );
		}
	}

	public function crop($tabla, $path, $cfg)
	{
		$cfg_['image_library'] = 'gd2';
		$cfg_['source_image']  = './contenidos/uploads/'.$tabla.'/small/'.$path[count($path)-1];
		$cfg_['maintain_ratio'] = FALSE;
		$cfg_['x_axis']	= intval(($cfg['width'] - 40) / 2);
		$cfg_['y_axis']	= intval(($cfg['height'] - 40) / 2);
		$cfg_['width']	= 40;
		$cfg_['height']	= 40;

		//$this->image_lib->resize();
		$this->image_lib->clear();
		$this->image_lib->initialize($cfg_);
		if ( ! $this->image_lib->crop())
		{
			var_dump( $this->image_lib->display_errors() );
		}
		else 
		{
			#Delete file
			//@unlink($file);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */