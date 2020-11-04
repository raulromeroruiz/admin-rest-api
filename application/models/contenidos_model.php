<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Contenidos_model extends CI_Model
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
        ->select('c.id, c.nombre, c.titulo, c.banner, c.contenido')
        ->from('contenidos c');
        $query = $this->db->get();
        return $query->result();
    }

    function get_seccion($id)
    {
        $this->db
        ->select("*")
        ->select("IF (tipo='img', REPLACE(contenido, 'full', 'medium'), contenido)  as contenido", FALSE)
        ->from('contenidos c')
        ->where('c.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

}