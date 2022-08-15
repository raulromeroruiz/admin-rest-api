<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Usuarios_model extends CI_Model
{
    private $login = null;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $db = $this->load->database();
        $this->login = $this->session->login;
    }

    function all()
    {
        $this->db
        ->select('u.*, t.nombre as tipo_usuario')
        ->select("CONCAT(u.nombres,' ', u.apellidos) as usuario", FALSE)
        ->from('usuarios u')
        ->join('tipo_usuarios t', 't.id=u.tipo', 'left');
        if ($this->login->tipo!=1) {
            $this->db->where('tipo > 1');
        }
        $this->db->where('u.id <> '.$this->login->id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_usuario($id)
    {
        $this->db
        ->select("u.*")
        ->from('usuarios u')
        ->where('u.id', $id);
        $query = $this->db->get('usuarios');
        return $query->row();
    }

    function search_usuario($filtros=array()){
        foreach ($filtros as $key => $filtro) {
            switch ($key) {
                case 'correo':
                    $query = $this->db->get_where('usuarios', array('correo'=> $filtro));
                    return $query->result();
                    break;
                
                default:
                    # code...
                    break;
            }
        }
    }

    function tipos()
    {
        if ($this->login->tipo!=1) {
            $this->db->where('id > 1');
        }
        $query = $this->db->get('tipo_usuarios');
        return $query->result();
    }

    function search($correo, $filtro)
    {
        if (!empty($filtro)) {
            $this->db->where_not_in('correo', $filtro);
        }
        $this->db->where('correo', $correo);
        $query = $this->db->get('usuarios');
        return $query->result();
    }

}