<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

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
        $this->load->model('usuarios_model', 'usuarios');
        $this->load->model('manager_model', 'manager');

        $this->login = $this->session->login;
   	}

	public function index()
	{
        $usuarios = $this->usuarios->all();
		$tipo_usuarios = $this->usuarios->tipos();
		//$tipo_usuarios = $this->manager->all('tipo_usuarios');
		$data = array(
			'usuarios' => $usuarios, 
            'tipo_usuarios' => $tipo_usuarios, 
			'login' =>  $this->login, 
		);

		$this->load->view('admin/header');
		$this->load->view('admin/usuarios', $data);
		$this->load->view('admin/footer');
	}

	public function get($id)
	{
		$usuario = $this->usuarios->get_usuario($id);

		$response['result']	= "error";
		if ($usuario) {
			$response['result'] = "success";
			$response['data'] = $usuario;
		}
		echo json_encode($response);
	}

	public function save() 
	{
		$datos = $this->input->post();
        $login = $this->login;

        $exist = FALSE;

        $current = $this->manager->where('usuarios', array('id'=>$datos['id']));
        $search = $this->manager->where('usuarios', array('correo'=>$datos['correo']));
        if (empty($datos['id'])) {
            if (!empty($search)) {
                echo $this->tools->alert('El correo ya está registrado');
                exit;
            }
			$datos['username'] = $this->tools->urlfriendly($datos['nombres']);
			$password = rand(11111,99999);
			$datos['password'] = password_hash($password, PASSWORD_DEFAULT);
			$datos['estado'] = 1;
			$query = $this->manager->insert("usuarios", $datos);
		}
		else {
            $filter = array();
            if (!empty($search)) {
                if ($search[0]->correo==$login->correo) {
                    echo $this->tools->alert('El correo ya está registrado');
                    exit;
                }
                else {
                    if ( $search[0]->correo == $current[0]->correo ) {
                        $filter[] = $search[0]->correo;
                        $filter[] = $current[0]->correo;
                    }
                    $search2 = $this->usuarios->search( $datos['correo'], $filter );
                    if (!empty($search2)) {
                        echo $this->tools->alert('El correo ya está registrado');
                        exit;
                    }
                }
            }
			$query = $this->manager->update("usuarios", $datos, $datos['id']);
		}

		if ( $query ) {
			if (empty($datos['id'])) {
				$datos['clave'] = $password;
				echo "<script>top.usuarios.confirm('".json_encode($datos)."');</script>";
			}
			else {
				echo $this->tools->reload();
			}
		}
	}

	public function confirm() 
	{
		$datos = $this->tools->objeto($this->input->post());

		$this->load->library('php_mailer');
		$message = "Estimado ".$datos->nombres.",<br>"
                  ."Se ha creado una cuenta para que administre el contenido de la página web de Chino Charapa.<br>"
                  ."<br>"
                  ."Estos son los datos ingresados:<br>"
                  ."<b>Correo de inicio de sesión : </b>".$datos->correo."<br>"
                  ."<b>Contraseña de ingreso : </b>".$datos->clave."<br>";

        $params = array(
        	'from' => array("noreply@chinocharape.pe", utf8_decode("No Reply")),
        	'subject' => utf8_decode("Registro administrador Chino Charapa"),
        	'message' => utf8_decode($message),
        	'address' => array($datos->correo, utf8_decode($datos->nombres." ".$datos->apellidos)),
        );
        //Send mail
		$send = $this->php_mailer->send($params);

        $response = array('result' => "error");
        if ($send) {
            $response = array('result' => "success");
        }

        echo json_encode($response);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */