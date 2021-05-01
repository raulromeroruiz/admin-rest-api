<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Configuracion_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $db = $this->load->database();
    }

    function fields() 
    {
        $this->db->select("c.id, c.nombre, c.campo1, c.campo2, c.campo3, c.campo4, ca.nombre as categoria");
        $this->db->from('categorias ca');
        $this->db->join('campos_personalizados c', 'c.categoria=ca.id');
        $query = $this->db->get();
        return $query->result();
    }

    function nofields()
    {
        $q = $this->db->query("SELECT categoria FROM campos_personalizados");
        $datos = $q->result();
        $ctgs = "";
        foreach ($datos as $dato) {
            $ctgs .= $dato->categoria.",";
        }
        $ctgs = substr($ctgs, 0, -1);

        $query = $this->db->query("SELECT * FROM categorias WHERE id NOT IN (".$ctgs.")");
        return $query->result();
    }

}