<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos extends CI_Controller {

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
        $this->load->model('productos_model', 'productos');
        $this->load->model('manager_model', 'manager');
   	}

	public function index()
	{
		$productos = $this->productos->all();
		$categorias = $this->manager->get_fields('categorias', array('id', 'nombre'));
		//$clientes = $this->manager->get_fields('clientes', array('id', 'nombre'));

		$data = array(
			'productos' => $productos, 
			'categorias' => $categorias, 
			//'clientes' => $clientes, 
		);

		$this->load->view('admin/header');
		$this->load->view('admin/productos', $data);
		$this->load->view('admin/footer');
	}

	public function get($id)
	{
		$producto = $this->productos->get_producto($id);
		$imagenes = $this->productos->get_banners($id);

		$response['result']	= "error";
		if ($producto) {
			$response = array(
				'result' => "success",
				'data' => $producto,
				'imagenes' => $imagenes,
			);
		}
		echo json_encode($response);
	}

	public function save() 
	{
		$datos = $this->input->post();
		$datos['url'] = $this->tools->urlfriendly($datos['nombre']);
		$datos['estado'] = 1;

		$id = $datos['id'];
		if (empty($datos['id'])) {
			$query = $this->manager->insert("productos", $datos);
			$id = $this->db->insert_id();
		}
		else {
			$query = $this->manager->update("productos", $datos, $datos['id']);
		}
		if ( $query ) {
			if (!empty($_FILES['tmp_name'])) {
				$fotos['foto'] = $this->upload('foto', 'foto', $id);
				$data = array(
					'id'   => $id,
					'tipo' => 1, //1 Photo
				);
				$this->productos->save_photos($fotos, $data);
			}
			echo $this->tools->reload();
		}
	}

	public function delete()
	{
		$post = $this->tools->objeto($this->input->post());
		$tabla = $post->tabla;
		$id = $post->id;
		$files = $this->manager->get_simplebyfield($tabla, array('archivo'), array('seccion'=>$id));

		if ($this->manager->delete('productos', $id)) {
			foreach ($files as $file) {
				@unlink($file->archivo);
				@unlink(str_replace('full', 'medium', $file->archivo));
				@unlink(str_replace('full', 'small', $file->archivo));
			}
			$response['result'] = "success";
			echo json_encode($response);
		}
	}

	public function upload($file="", $tabla="", $id="", $settings=array('overwrite'=>FALSE, 'filename'=>""))
	{
		if ($file=="") {return "";}
		$sizes = $this->tools->sizes($tabla);
		$filename = ($settings['filename']!="") ? $settings['filename']:$this->tools->cleanfilename($_FILES[$file]['name']);

		$config = array();
		$ruta = 'contenidos/uploads/'.$tabla.'/full/'.$id.'/';
		$config['upload_path'] = "../".$ruta;
		$config['file_name'] = $filename;
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']	= '5000';
		$config['max_width']  = $sizes['full'][0];
		$config['max_height']  = $sizes['full'][1];
		$config['remove_spaces']  = TRUE;
		$config['overwrite']  = $settings['overwrite'];
		$config['exactly']  = TRUE;
		//var_dump($config);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($file))
		{
			$errors = $this->upload->show_errors();
			//var_dump($errors);
			//exit;
			$error = array(
				'result' => FALSE,
				'msg'	 => ""
			);
			$error = $this->tools->error_upload($errors, $config);

			if ($error['result']){
				//echo $this->tools->alert($error['msg']);
				return $error;
			}
			else {
				return "";
			}
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$sizes = $this->tools->sizes($tabla, $_FILES[$file]['tmp_name']);
			//var_dump($sizes);
			$this->load->library('image_lib'); 
			foreach ($sizes as $key => $size) {
				$file = $data['upload_data']['full_path'];
				$path = explode("/", $file);

				$cfg['image_library'] = 'gd2';
				$cfg['source_image']	= $file;
				//$cfg['create_thumb'] = TRUE;
				$cfg['new_image'] = '../contenidos/uploads/'.$tabla.'/'.$key.'/'.$id.'/'.$path[count($path)-1];
				$cfg['maintain_ratio'] = TRUE;
				$cfg['width']	= $sizes[$key][0];
				$cfg['height']	= $sizes[$key][1];

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

	public function change_image() 
	{
		$post = (object)$this->input->post();
		//var_dump($post); exit;
		//echo json_encode($_FILES);
		//exit;
		//echo key($_FILES);
		$settings = array(
			'overwrite' => TRUE,
			'filename' => $post->file,
		);
		$archivo = $this->upload(key($_FILES), $post->grupo, $post->seccion, $settings);
		//$response['result'] = 'error';
		$response =array(
			'result'	=> "error",
			'details'	=> $archivo,
		);
		//var_dump($archivo);
		//exit;
		if (!is_array($response['details'])) {
			$datos = array(
				'archivo' => $archivo,
			);
			$query = $this->manager->update("archivos", $datos, $post->id);
			if ($query) {
				$response = array(
					'result'	=> "success",
					'file'		=> str_replace("full", "small", $archivo),
					'nocache'	=> rand(100,999),
				);
			}
		}
		echo json_encode($response);
	}

	public function oficinas($id) 
	{
		$oficinas = $this->productos->get_offices_admin($id);
		$tipo_productos = $this->manager->get_fields('tipo_inmuebles', array('id', 'nombre'));

		$data = array(
			'oficinas' => $oficinas, 
			'producto' => $id, 
			'tipo_productos' => $tipo_productos, 
		);

		$this->load->view('admin/header');
		$this->load->view('admin/oficinas', $data);
		$this->load->view('admin/footer');
	}

	public function oficina($id)
	{
		switch ($id) {
			case 'save':
				$datos = $this->input->post();
				$datos['estado'] = 1;

				$id = $datos['id'];
				if (empty($datos['id'])) {
					$query = $this->manager->insert("inmuebles", $datos);
					$id = $this->db->insert_id();
				}
				else {
					$query = $this->manager->update("inmuebles", $datos, $datos['id']);
				}
				if ( $query ) {

					$fotos['imagen3d'] = $this->upload('imagen3d', 'planos', $datos['producto']);
					$fotos['plano'] = $this->upload('plano', 'planos', $datos['producto']);

					$data = array(
						'id'   => $id,
						'tipo' => 1, //1 Photo
					);
					$this->productos->save_photos($fotos, $data);
					echo $this->tools->reload();
					//var_dump($fotos);
				}
				break;

			case 'delete':
				$post = (object)$this->input->post();
				$id = $post->id;
				$files = $this->manager->get_simplebyfield('archivos', array('archivo'), array('seccion'=>$id));

				if ($this->manager->delete('inmuebles', $id)) {
					foreach ($files as $file) {
						@unlink($file->archivo);
						@unlink(str_replace('full', 'medium', $file->archivo));
						@unlink(str_replace('full', 'small', $file->archivo));
					}
					$response['result'] = "success";
					echo json_encode($response);
				}
				break;

			default:
				$oficina = $this->productos->get_detailoffice($id);

				$response['result']	= "error";
				if ($oficina) {
					$response = array(
						'result' => "success",
						'data' => $oficina,
					);
				}
				echo json_encode($response);
				break;
		}
	}

	public function urban($id)
	{
		switch ($id) {
			case 'save':
				$datos = $this->input->post();
				$datos['estado'] = 1;

				$id = $datos['id'] = $datos['id_establecimiento'];
				unset($datos['id_establecimiento']);
				if (empty($datos['id'])) {
					$query = $this->manager->insert("establecimientos", $datos);
					$id = $this->db->insert_id();
				}
				else {
					$query = $this->manager->update("establecimientos", $datos, $datos['id']);
				}
				if ( $query ) {

					echo json_encode(array('result'=>"success"));
					//echo $this->tools->reload();
				}
				break;

			case 'delete':
				$id = $this->input->post('id');

				if ($this->manager->delete('establecimientos', $id)) {
					$response['result'] = "success";
					echo json_encode($response);
				}
				break;

			default:
				$oficina = $this->productos->get_detailoffice($id);

				$response['result']	= "error";
				if ($oficina) {
					$response = array(
						'result' => "success",
						'data' => $oficina,
					);
				}
				echo json_encode($response);
				break;
		}
	}

	public function banners($id) 
	{
		switch ($id) {
			case 'delete':
				$post = (object)$this->input->post();
				$id = $post->id;
				$files = $this->manager->get_simplebyfield('archivos', array('archivo'), array('id'=>$id));

				if ($this->manager->delete('archivos', $id)) {
					foreach ($files as $file) {
						@unlink($file);
						@unlink(str_replace('full', 'small', $file));
					}
					$response['result'] = "success";
					echo json_encode($response);
				}
				break;
			
			default:
				# code...
				break;
		}
	}

	public function uploads($file="", $tabla, $id="", $overwrite=FALSE)
	{
		$sizes = $this->tools->sizes($tabla);

		$ruta = 'contenidos/uploads/'.$tabla.'/full/'.$id.'/';
		$config['upload_path'] = "../".$ruta;
		//$config['file_name'] = $this->tools->cleanfilename($_FILES[$file]['name']);
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']	= '5000';
		$config['max_width']  = $sizes['full'][0];
		$config['max_height']  = $sizes['full'][1];
		$config['remove_spaces']  = TRUE;
		$config['overwrite']  = $overwrite;
		$config['exactly']  = TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_uploads($file))
		{
			$errors = $this->upload->show_errors();

			$error = $this->tools->error_upload($errors, $config);
			//var_dump($error); exit;
			if ($error['result']){
				echo $this->tools->alert("Error al subir el archivo: " . $this->upload->current_file() .'\r\r'. $error['msg']);
				exit;
			}
			else {
				return "";
			}
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$fotos = array();$c=1;
			foreach ($data['upload_data']['files'] as $imagen) {
				$fotos[] = $this->tools->url_file_upload($imagen, $ruta);
				
				$sizes = $this->tools->sizes($tabla, $config['upload_path'].$imagen);

				$this->load->library('image_lib'); 
				foreach ($sizes as $key => $size) {
					$file = $data['upload_data']['file_path'].$imagen;
					$path = explode("/", $file);

					$cfg['image_library'] = 'gd2';
					$cfg['source_image']	= $file;
					$cfg['new_image'] = '../contenidos/uploads/'.$tabla.'/'.$key.'/'.$id.'/'.$path[count($path)-1];
					$cfg['maintain_ratio'] = TRUE;
					$cfg['width']	= $sizes[$key][0];
					$cfg['height']	= $sizes[$key][1];

					//$this->image_lib->resize();
					$this->image_lib->clear();
					$this->image_lib->initialize($cfg);
					if ( ! $this->image_lib->resize())
					{
						var_dump( $this->image_lib->display_errors() );
					    //echo $this->image_lib->display_errors();
					}
				}
			}
			return $fotos;
		}
	}

	public function crop($tabla, $path, $cfg)
	{
		$cfg_['image_library'] = 'gd2';
		$cfg_['source_image']  = '../contenidos/uploads/'.$tabla.'/medium/'.$path[count($path)-1];
		$cfg_['maintain_ratio'] = FALSE;
		$cfg_['x_axis']	= intval(($cfg['width'] - 400) / 2);
		$cfg_['y_axis']	= intval(($cfg['height'] - 400) / 2);
		$cfg_['width']	= 400;
		$cfg_['height']	= 400;
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