<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfil extends CI_Controller {

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
        $this->load->model('perfil_model', 'perfil');
        $this->load->model('manager_model', 'manager');
        $this->load->model('usuarios_model', 'usuarios');

        if (isset($_SESSION['login'])) {
        	$this->login = $_SESSION['login'];
        }
   	}

	public function index()
	{
        $perfil = $this->manager->get_simplebyfield('usuarios', array('id, nombres, apellidos, correo, tipo'), array('id'=>$this->login->id));
        $tipo_usuarios = $this->usuarios->tipos();
		//$tipo_usuarios = $this->manager->all('tipo_usuarios');

		$data = array(
			'perfil' => $perfil, 
			'tipo_usuarios' => $tipo_usuarios, 
		);

		$this->load->view('admin/header');
		$this->load->view('admin/perfil', $data);
		$this->load->view('admin/footer');
	}

	public function get($id)
	{
		$usuario = $this->perfil->get_usuario($id);

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
        $query = $error = FALSE;
        $response = array();
        $new_password = $datos['password'];

        $search = $this->manager->where('usuarios', array('correo'=>$datos['correo'])); //var_dump($search);
        if (!empty($search)) {
            if ($search[0]->correo!=$login->correo) {
                $response = array(
                    'message' => "El correo ya se encuentra registrado",
                    'result' => "error",
                );
                $error = TRUE;
            }
        }
        //echo md5($datos['pa'])
        //var_dump($datos);
        //var_dump($search);
        //exit;

		if ($error) {
			//$query = $this->manager->insert("perfil", $datos);
		}
		else {
			$datos['username'] = $this->tools->urlfriendly($datos['nombres']);
			//Validar Password
            if (!empty($datos['password']) || !empty($datos['cpassword'])) {
                if ($datos['password'] != $datos['cpassword']) {
                    $response = array(
                        'message' => "Debe confirmar su nueva contraseña",
                        'result' => "error",
                    );
                    echo json_encode($response);
                    exit;
                }
                else {
                    $datos['password'] = md5($datos['password']);
                    unset($datos['cpassword']);
                    //$query = $this->manager->update("usuarios", $datos, $datos['id']);
                }
            }
            else {
                unset($datos['password']);
                unset($datos['cpassword']);
            }
    		$query = $this->manager->update("usuarios", $datos, $datos['id']);
		}

		if ( $query ) {
            $response = array(
                'message' => "Se cerrará la sesión para que pueda usar sus nuevos datos",
                'result' => "success",
            );
            if ($search[0]->password != md5($new_password)) {
                $this->load->library('php_mailer');
                $message = "Se ha producido el cambio de su contraseña: <br>"
                            ."Nueva contraseña: <b>".$new_password."</b>";
                $params = array(
                    'from' => array('noreply@inmobiliariabambu.com', 'NoReply'),
                    'subject' => utf8_decode("Cambio su contraseña de administrador de Bambú"),
                    'message' => utf8_decode($message),
                    'address' => array($datos['correo'], utf8_decode($datos['nombres'])),
                );
                @$this->php_mailer->send($params);
            }
		}
        echo json_encode($response);
	}

	public function confirm() 
	{
		$datos = $this->tools->objeto($this->input->post());

		$message = "Estimado ".$datos->nombres.",<br>"
                  ."Se ha creado una cuenta para que administre el contenido de la página web de Bambú.<br>"
                  ."<br>"
                  ."Estos son los datos ingresados:<br>"
                  ."<b>Correo de inicio de sesión : </b>".$datos->correo."<br>"
                  ."<b>Contraseña de ingreso : </b>".$datos->clave."<br>";

        $params = array(
        	'from' => array("noreply@inmobiliariabambu.com", utf8_decode("No Reply")),
        	'subject' => utf8_decode("Registro administrador Bambú"),
        	'message' => utf8_decode($message),
        	'address' => array($datos->correo, utf8_decode($datos->nombres." ".$datos->apellidos)),
        );
        //Send mail
		$send = $this->load->library('php_mailer', $params);

        $response = array('result' => "error");
        if ($send) {
            $response = array('result' => "success");
        }

        echo json_encode($response);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */