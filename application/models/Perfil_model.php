<?php
session_start();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Perfil_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $db = $this->load->database();
    }

    function all()
    {
        $this->db
        ->select('u.*, t.nombre as tipo_usuario')
        ->select("CONCAT(u.nombres,' ', u.apellidos) as usuario", FALSE)
        ->from('usuarios u')
        ->join('tipo_usuarios t', 't.id=u.tipo', 'left');
        if ($_SESSION['login']->tipo!=1) {
            $this->db->where('tipo > 1');
        }
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

}