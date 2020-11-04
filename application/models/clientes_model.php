<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Clientes_model extends CI_Model
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
        ->select('c.id, c.nombre, c.logo, c.cliente')
        ->from('clientes c');
        $query = $this->db->get();
        return $query->result();
    }

    function get_cliente($id)
    {
        $this->db
        ->select("c.id, c.nombre, c.cliente")
        ->select("REPLACE(logo, 'medium', 'small') as logo", FALSE)
        ->from('clientes c')
        ->where('c.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_clientes() 
    {
        $this->db
        ->select('nombre')
        ->select("REPLACE(logo, 'full', 'medium') as logo", FALSE)
        ->from('clientes')
        ->where('cliente',1);
        $query = $this->db->get();
        return $query->result();
    }

}