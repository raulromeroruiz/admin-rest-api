<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Testimonios_model extends CI_Model
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
        ->select('t.id, t.nombre, t.cargo, t.contenido')
        ->from('testimonios t');
        $query = $this->db->get();
        return $query->result();
    }

    function get_testimonio($id)
    {
        $this->db
        ->select("t.id, t.nombre, t.cargo, t.contenido")
        ->select("REPLACE(imagen, 'full', 'small') as imagen", FALSE)
        ->from('testimonios t')
        ->where('t.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_testimonioshome()
    {
        $this->db
        ->select("t.id, t.nombre, t.cargo, t.contenido")
        ->select("REPLACE(imagen, 'full', 'small') as imagen", FALSE)
        ->from('testimonios t')
        ->order_by('t.id', 'DESC')
        ->limit(3);
        $query = $this->db->get();
        return $query->result();
    }

}