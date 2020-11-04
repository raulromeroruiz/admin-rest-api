<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticias extends CI_Controller {

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
        $this->load->model('noticias_model', 'noticias');
        $this->load->model('manager_model', 'manager');
   	}

	public function index()
	{
		$params = $this->input->get();

		//Paginación
		$tamano_pagina = 10;
		$config = [
			'all' => TRUE,
			'filters' => $params,
			'publish' => 'all'
		];
		$rows = $this->noticias->all($config);
		$base = base_url().$this->uri->segment(1)."/".$this->uri->segment(2);
		$start = (isset($params['pagina'])) ? $params['pagina']:1;
		$start = ($start-1) * $tamano_pagina;
		$paginacion = $this->tools->pagination($start, $tamano_pagina, $base, count($rows), $params);

		$config = [
			'start' => $start,
			'limit' => $tamano_pagina,
			'all'   => false,
			'filters' => $params,
			'publish' => 'all'
		];

		$noticias = $this->noticias->all($config);
		$tipo_noticias = $this->manager->all('tipo_noticia');
		$data = array(
			'noticias' => $noticias, 
			'tipo_noticias' => $tipo_noticias, 
			'paginacion' => $paginacion,
		);

		$this->load->view('admin/header');
		$this->load->view('admin/noticias', $data);
		$this->load->view('admin/footer');
	}

	public function get($id)
	{
		$noticia = $this->noticias->get_noticia($id);

		$response['result']	= "error";
		if ($noticia) {
			$response['result'] = "success";
			$response['data'] = $noticia;
		}
		echo json_encode($response);
	}

	public function save() 
	{
		$datos = $this->input->post();
		$datos['imagen'] = $this->upload('imagen', 'noticias'); //Upload and return image file

		$str = $datos['titulo'];
		$str = preg_replace("~<(/)?strong>~", "<\\1b>", $str);
		$str = preg_replace("~<(/)?p>~", "", $str);
		$datos['titulo'] = $str;

		$datos['fecha_creacion'] = $this->tools->datesql($datos['fecha_creacion']);
		$datos['fecha_modificacion'] = date('Y-m-d');
		$datos['url'] = $this->tools->urlfriendly($datos['titulo']);
		$datos['usuario'] = 1;
		$datos['publicado'] = 1;
		$datos['estado'] = 1;

		//Unset imagen blank
		if ($datos['imagen']=="") { unset($datos['imagen']); }

		if (empty($datos['id'])) {
			$query = $this->manager->insert("noticias", $datos);
		}
		else {
			$query = $this->manager->update("noticias", $datos, $datos['id']);
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

			//@$size = getimagesize($_FILES[$file]['tmp_name']);

			//Resize images
			/*
			$sizes = array(
				array('medium', 233, ($size[1]*233) / $size[0]),
				array('small' ,  75,  75),
				);
			*/
			$sizes = $this->tools->sizes('noticias', $_FILES[$file]['tmp_name']);

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
					$cropSizes = array(
						//'full',
						'medium', 
					);
					if (in_array($size[0], $cropSizes)) {
						//Crop
						$params = array(
							'tabla' => "noticias",
							'path' => $path,
							'cfg' => $cfg,
							'sizes' => $size,
						);
						//$this->crop( $params );
					}
					if ($size[0]=="medium") {
						//$this->crop('noticias', $path, $cfg);
					}
					//echo "TRUE";
				}
			}

			return $this->tools->url_file_upload( $data['upload_data']['raw_name'].$data['upload_data']['file_ext'], $ruta );
		}
	}

	//public function crop($tabla, $path, $cfg)
	public function crop($params)
	{
		$path = $params['path'];
		$cfg = $params['cfg'];
		$sizes = $params['sizes'];
		$newsizes = array(
			'full' => array(790,280),
			'medium' => array(400,400),
		);
		/*
		echo "<pre>";
		var_dump($params);
		var_dump($newsizes[$sizes[0]]);
		echo "</pre>";
		*/
		$cfg_['image_library'] = 'gd2';
		$cfg_['source_image']  = './contenidos/uploads/'.$params['tabla'].'/'.$sizes[0].'/'.$path[count($path)-1];
		$cfg_['maintain_ratio'] = FALSE;
		$cfg_['x_axis']	= intval(($cfg['width'] - $newsizes[$sizes[0]][0]) / 2);
		$cfg_['y_axis']	= intval(($cfg['height'] - $newsizes[$sizes[0]][1]) / 2);
		$cfg_['width']	= $newsizes[$sizes[0]][0];
		$cfg_['height']	= $newsizes[$sizes[0]][1];

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