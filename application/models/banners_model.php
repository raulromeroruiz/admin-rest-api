<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Banners_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $db = $this->load->database();
    }

    function all($paginate=array(0,10), $filters=array())
    {
        $this->db->limit($paginate[1], $paginate[0]);
        if (!empty($filters)) {
            //filters
        }
        $this->db
        ->select('id, nombre, contenido');
        $query = $this->db->get('banners');
        return $query->result();
    }

    function get_banner($id)
    {
        $this->db
        ->select('id, nombre, contenido, imagen, enlace')
        ->select("REPLACE(imagen, 'full', 'medium') as imagen", FALSE)
        ->from('banners')
        ->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_bannershome()
    {
        #$this->db
        #->where('estado', 1);
        $query = $this->db->get('banners');
        return $query->result();
    }

}