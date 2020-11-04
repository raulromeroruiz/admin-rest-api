<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contenidos extends CI_Controller {

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
        $this->load->model('contenidos_model', 'contenidos');
        $this->load->model('manager_model', 'manager');
   	}

	public function index()
	{
		$params = $this->tools->objeto($this->input->get());
		$contenidos = $this->manager->where('contenidos', array('seccion' => $params->id));

		$data = array(
			'contenidos' => $contenidos, 
		);

		$this->load->view('admin/header');
		$this->load->view('admin/contenidos', $data);
		$this->load->view('admin/footer');
	}

	public function get($id)
	{
		$obra = $this->contenidos->get_seccion($id);

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
		if ($datos['tipo']=="img") {
			$datos['contenido'] = $this->upload('imagen', 'contenidos', $datos['id']); //Upload and return image file
			//Unset imagen blank
			if ($datos['contenido']=="") { unset($datos['contenido']); }
		}
		else {
			$datos['contenido'] = $datos['contenido-'.$datos['tipo']];
			unset($datos['contenido-texto'], $datos['contenido-html']);
		}

		if (empty($datos['id'])) {
			$query = $this->manager->insert("contenidos", $datos);
		}
		else {
			$query = $this->manager->update("contenidos", $datos, $datos['id']);
		}
		if ( $query ) {
			echo $this->tools->reload();
		}
	}

	public function upload($file="", $tabla, $id="")
	{
		
		$ruta = 'contenidos/uploads/'.$tabla.'/full/';
		$config['upload_path'] = "./".$ruta;
		$config['file_name'] = $this->tools->cleanfilename($_FILES[$file]['name']);
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']	= '5000';
		$config['max_width']  = '4096';
		$config['max_height']  = '4096';
		$config['remove_spaces']  = TRUE;
		$config['exactly']  = FALSE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file))
		{
			//$error = array('error' => $this->upload->display_errors());
			$errors = $this->upload->show_errors();
			$error = array(
				'result' => FALSE,
				'msg'	 => ""
			);
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

			@$size = getimagesize($_FILES[$file]['tmp_name']);

			$arrSize = array(
				1 => array(
						array('medium', 423, ($size[1]*423) / $size[0]),
						array('small' ,  200,  200),
					),
				3 => array(
						array('medium', 393, ($size[1]*393) / $size[0]),
						array('small' ,  200,  200),
					),
				4 => array(
						array('medium', 393, ($size[1]*393) / $size[0]),
						array('small' ,  200,  200),
					),
			);
			//Resize images
			$sizes = $arrSize[$id];

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
						$this->crop('contenidos', $path, $cfg, $id);
					}
					//echo "TRUE";
				}
			}

			return $this->tools->url_file_upload( $data['upload_data']['raw_name'].$data['upload_data']['file_ext'], $ruta );
		}
	}

	public function crop($tabla, $path, $cfg, $id)
	{
		$sizes_ = array(
			1 => array(423, 157),
			3 => array(393, 142),
			4 => array(393, 142),
		);

		$cfg_['image_library'] = 'gd2';
		$cfg_['source_image']  = './contenidos/uploads/'.$tabla.'/medium/'.$path[count($path)-1];
		$cfg_['maintain_ratio'] = FALSE;
		$cfg_['x_axis']	= intval(($cfg['width'] - $sizes_[$id][0]) / 2);
		$cfg_['y_axis']	= intval(($cfg['height'] - $sizes_[$id][1]) / 2);
		$cfg_['width']	= $sizes_[$id][0];
		$cfg_['height']	= $sizes_[$id][1];

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