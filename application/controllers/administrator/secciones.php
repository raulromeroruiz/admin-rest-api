<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Secciones extends CI_Controller {

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
        $this->load->model('secciones_model', 'secciones');
        $this->load->model('manager_model', 'manager');
   	}

	public function index()
	{
		$secciones = $this->secciones->all();

		$data = array(
			'secciones' => $secciones, 
		);

		$this->load->view('admin/header');
		$this->load->view('admin/secciones', $data);
		$this->load->view('admin/footer');
	}

	public function get($id)
	{
		$obra = $this->secciones->get_seccion($id);

		$response['result']	= "error";
		if ($obra) {
			$response['result'] = "success";
			$response['data'] = $obra;
		}
		echo json_encode($response);
	}

	public function save() 
	{
		$datos = $this->input->post();
		$datos['banner'] = $this->upload('banner', 'secciones'); //Upload and return image file

		$str = $datos['contenido'];
		$str = preg_replace("~<(/)?strong>~", "<\\1b>", $str);
		$datos['contenido'] = $str;

		//Unset imagen blank
		if ($datos['banner']=="") { unset($datos['banner']); }

		if (empty($datos['id'])) {
			$query = $this->manager->insert("secciones", $datos);
		}
		else {
			$query = $this->manager->update("secciones", $datos, $datos['id']);
		}
		if ( $query ) {
			echo $this->tools->reload();
		}
	}

	public function upload($file="", $tabla)
	{
		
		$ruta = 'contenidos/uploads/'.$tabla.'/full/';
		$config['upload_path'] = "./".$ruta;
		$config['file_name'] = $this->tools->cleanfilename($_FILES[$file]['name']);
		$config['allowed_types'] = 'jpg|jpeg';
		$config['max_size']	= '5000';
		$config['max_width']  = '970';
		$config['max_height']  = '277';
		$config['remove_spaces']  = TRUE;
		$config['exactly']  = TRUE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file))
		{
			//$error = array('error' => $this->upload->display_errors());
			$errors = $this->upload->show_errors();
			$error = array(
				'result' => FALSE,
				'msg'	 => ""
			);

			/*foreach ($errors as $key => $msg) {
				switch ($key) {
					case 'upload_invalid_filetype':
						$error = TRUE;
						$msgerr  = $msg;
						break;

					case 'upload_invalid_dimensions':
						$error = TRUE;
						$msgerr  = $msg;
						break;

					case 'upload_invalid_filesize':
						$error = TRUE;
						$msgerr  = $msg;
						break;

					default:
						$error = FALSE;
						break;
				}
			}*/
			$error = $this->tools->error_upload($errors);

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

			$sizes = $this->tools->sizes('secciones', $_FILES[$file]['tmp_name']);

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
						//$this->crop('promociones', $path, $cfg);
					}
					//echo "TRUE";
				}
			}

			return $this->tools->url_file_upload( $data['upload_data']['raw_name'].$data['upload_data']['file_ext'], $ruta );
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */