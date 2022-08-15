<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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

	private $login = null;

	public function __construct()
   	{
    	parent::__construct();
        $this->load->model('manager_model', 'manager');
   	}

	public function index()
	{
		$this->load->view('admin/index');
	}

	public function manager($action="")
	{
		$datos = $this->input->post();
		$tabla = $datos['tabla'];
		$id = $datos['id'];
		unset($datos['action'], $datos['tabla'], $datos['id']);

		$response['result'] = "error";
		switch ($action) {
			case 'insert':
				$q = $this->db->insert($tabla, $datos);
				break;
			case 'update':
				$q = $this->db->update($tabla, $datos, "id = $id");
				break;
			case 'delete':
				$q = $this->db->delete($tabla, array('id'=>$id));
				break;
			case 'editar':
				#
				break;
		}

		if ($q) {
			$response['result'] = "success";
		} 

		echo json_encode($response);
	}

	public function actions()
	{
		$datos = $this->input->post();
		switch ($datos['accion']) {
			case 'delete':
				$this->db->where_in('id', $datos['id']);
				$q = $this->db->delete($datos['tabla']);
				break;
			case 'publish':
				$this->db->where_in('id', $datos['id']);
				$q = $this->db->update($datos['tabla'], array('publicado' => 1));
				break;
			case 'unpublish':
				$this->db->where_in('id', $datos['id']);
				$q = $this->db->update($datos['tabla'], array('publicado' => 0));
				break;
			case 'available':
				$this->db->where_in('id', $datos['id']);
				$q = $this->db->update($datos['tabla'], array('estado' => 1));
				break;
			case 'unavailable':
				$this->db->where_in('id', $datos['id']);
				$q = $this->db->update($datos['tabla'], array('estado' => 0));
				break;
		}

		if ($q) {
			$response['result'] = "success";
		}

		echo json_encode($response);
	}

	public function login()
	{
		$datos = $this->input->post();
		$datos['password'] = ($datos['password']!="") ? md5($datos['password']):"";

		list($login, $response) = $this->manager->login($datos);
		if ($login) {
			if (in_array($response->tipo, array(1,2,3))) {
				$_SESSION['login'] = $response;
				$response = array('result'=>"success");
			}
			else {
				$response = array('result'=>"error", 'message'=>"No esta autorizado para acceder al sistema");
			}
		}
		else {
			if ($datos['correo']==""){
				$response = "Ingrese su usuario o correo";
			}
			elseif ($datos['password']=="") {
				$response = "Ingrese su contraseña";
			}
			$response = array('result'=>"error", 'message'=>$response);
		}
		echo json_encode($response);
	}

	public function logout()
	{
		unset($_SESSION);
		session_destroy();
		echo "<script>location.href='".base_url()."admin'</script>";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */