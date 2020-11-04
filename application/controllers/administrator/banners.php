<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banners extends CI_Controller {

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
        $this->load->model('banners_model', 'banners');
        $this->load->model('manager_model', 'manager');
   	}

	public function index()
	{

		$params = $this->input->get();
		$page = (isset($params['pagina'])) ? $params['pagina']:1;
		$per_page = 10;
		$start = ($page - 1) * $per_page;
		$banners = $this->banners->all(array($start, $per_page));
		$rows = $this->banners->all();
		$base = $base = base_url().$this->uri->segment(1)."/".$this->uri->segment(2);

		$pagination = $this->tools->pagination($start, $per_page, $base, count($rows), $params);

		$data = array(
			'banners' => $banners, 
			'pagination' => $pagination, 
		);

		$this->load->view('admin/header');
		$this->load->view('admin/banners', $data);
		$this->load->view('admin/footer');
	}

	public function get($id)
	{
		$banner = $this->banners->get_banner($id);

		$response['result']	= "error";
		if ($banner) {
			$response['result'] = "success";
			$response['data'] = $banner;
		}
		echo json_encode($response);
	}

	public function save() 
	{
		$datos = $this->input->post();
		$datos['imagen'] = $this->upload('imagen', 'banners'); //Upload and return image file
		$datos['imagen_mobile'] = $this->upload('mobile', 'banner_mobile'); //Upload and return image file
		$datos['url'] = $this->tools->urlfriendly($datos['nombre']);
		$datos['estado'] = 1;

		$str = $datos['contenido'];
		$str = preg_replace("~<(/)?strong>~", "<\\1b>", $str);
		$datos['contenido'] = $str;

		//Unset imagen blank
		if ($datos['imagen']=="") { unset($datos['imagen']); }
		if ($datos['imagen_mobile']=="") { unset($datos['imagen_mobile']); }

		if (empty($datos['id'])) {
			$q = $this->db->query("SELECT MAX(orden) as orden FROM banners");
			$q = $q->row();
			$datos['orden'] = $q->orden + 1;
			$query = $this->manager->insert("banners", $datos);
		}
		else {
			$query = $this->manager->update("banners", $datos, $datos['id']);
		}
		if ( $query ) {
			//$result = array('result' => "success");
			echo $this->tools->reload();
		}
	}

	public function upload($file="", $tabla)
	{
		$sizes = $this->tools->sizes($tabla);

		$ruta = 'contenidos/uploads/'.$tabla.'/full/';
		$config['upload_path'] = "./".$ruta;
		$config['file_name'] = $this->tools->cleanfilename($_FILES[$file]['name']);
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']	= '5000';
		$config['max_width']  =  $sizes[0][1];
		$config['max_height']  =  $sizes[0][2];
		$config['remove_spaces']  = TRUE;
		$config['exactly']  = TRUE;

		$this->load->library('upload');

		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($file))
		{
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
					if ($size[0]=="medium") {
						//$this->crop('promociones', $path, $cfg);
					}
					//echo "TRUE";
				}
			}

			return $this->tools->url_file_upload( $data['upload_data']['raw_name'].$data['upload_data']['file_ext'], $ruta );
		}
	}

	public function get_urls()
	{
		$post = $this->tools->objeto($this->input->post());

		switch ($post->tabla) {
			case 'secciones':
				$this->db->select('titulo as nombre');
				$this->db->select("CONCAT('', url) as url", FALSE);
				break;
			case 'noticias':
				$this->db->select('titulo as nombre');
				$this->db->select("CONCAT('noticias/', url, '-', id) as url", FALSE);
				break;
			case 'obras':
				$this->db->select("CONCAT(obra,' ', nombre) as nombre", FALSE);
				$this->db->select("CONCAT('obras/', IF(condicion=0, 'en-ejecucion/', 'realizadas/'), url, '-', id) as url", FALSE);
				break;
		}

		$q = $this->db->get($post->tabla);

		$opt = "<option value='#'>Seleccione la página de destino</option>";
		foreach ($q->result() as $v) {
			$opt .= "<option value='".$v->url."'>". $v->nombre ."</option>";
		}
		$response['data'] = $opt;

		echo json_encode($response);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */