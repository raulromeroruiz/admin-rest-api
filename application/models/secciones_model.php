<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Secciones_model extends CI_Model
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
        ->select('s.id, s.nombre, s.titulo, s.banner, s.contenido')
        ->from('secciones s');
        $query = $this->db->get();
        return $query->result();
    }

    function get_seccion($id)
    {
        $this->db
        ->select("s.id, s.nombre, s.titulo, s.contenido")
        ->select("REPLACE(banner, 'full', 'small') as imagen", FALSE)
        ->from('secciones s')
        ->where('s.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

}