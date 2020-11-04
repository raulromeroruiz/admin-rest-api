<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Noticias_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $db = $this->load->database();
    }

    function all($params)
    {
        $start = (isset($params['start'])) ? $params['start']:0;
        $limit = (isset($params['limit'])) ? $params['limit']:10;

        if ($params['all']==false) 
            $this->db->limit($limit, $start);
        if ($params['publish']!='all') 
            $this->db->where('publicado', $params['publish']);

        $this->db
        ->select('n.id, n.titulo, n.contenido, n.publicado, n.autor')
        ->select("DATE_FORMAT(fecha_creacion, '%d/%m/%y') as fecha_redaccion", FALSE)
        ->select("DATE_FORMAT(fecha_modificacion, '%d/%m/%y') as fecha_modificacion", FALSE)
        ->select("CONCAT(u.nombres,' ', u.apellidos) as usuario", FALSE)
        ->from('noticias n')
        ->join('usuarios u', 'u.id=n.usuario', 'left')
        ->order_by('fecha_creacion', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_noticia($id)
    {
        $this->db
        ->select("n.id, n.titulo, n.contenido, n.imagen, n.publicado, n.autor, n.tipo, n.enlace")
        ->select("REPLACE(imagen, 'full', 'medium') as thumb", FALSE)
        ->select("DATE_FORMAT(fecha_creacion, '%d/%m/%Y') as fecha_creacion", FALSE)
        ->select("DATE_FORMAT(fecha_modificacion, '%d/%m/%y') as fecha_modificacion", FALSE)
        ->select("DATE_FORMAT(fecha_creacion, '%Y') as anio_creacion", FALSE)
        ->select("DATE_FORMAT(fecha_creacion, '%c') as mes_creacion", FALSE)
        ->select("DATE_FORMAT(fecha_creacion, '%d') as dia_creacion", FALSE)
        ->select("CONCAT(u.nombres,' ', u.apellidos) as usuario", FALSE)
        ->from('noticias n')
        ->join('usuarios u', 'u.id=n.usuario', 'left')
        ->where('n.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_news($params)
    {
        $start = (isset($params['start'])) ? $params['start']:0;
        $limit = (isset($params['limit'])) ? $params['limit']:10;

        if ($params['all']==false) 
            $this->db->limit($limit, $start);
        if (!empty($params['filters']['categoria'])) 
            $this->db->where('tipo', $params['filters']['categoria']);

        $this->db
        ->select('n.id, n.titulo, n.contenido, n.fecha_creacion, n.url, n.imagen')
        ->select("DATE_FORMAT(fecha_creacion, '%d/%m/%Y') as fecha_creacion", FALSE)
        ->select("DATE_FORMAT(fecha_creacion, '%d') as dia_creacion", FALSE)
        ->select("DATE_FORMAT(fecha_creacion, '%c') as mes_creacion", FALSE)
        //->select("(SELECT nombre FROM tipo_noticia WHERE id=n.tipo) as tipo", FALSE)
        ->select("REPLACE(n.imagen, 'full', 'medium') as thumb", FALSE)
        ->where('publicado', 1)
        ->order_by('n.fecha_creacion', 'desc');
        $query = $this->db->get('noticias n');
        return $query->result();
    }

    function get_newshome($params)
    {
        $this->db
        ->select('n.id, n.titulo, n.contenido, n.fecha_creacion, n.url, n.imagen')
        ->select("DATE_FORMAT(fecha_creacion, '%d/%m/%Y') as fecha_creacion", FALSE)
        ->select("REPLACE(n.imagen, 'full', 'medium') as thumb", FALSE)
        ->order_by('n.fecha_creacion', 'DESC')
        ->limit($params['limit']);
        $query = $this->db->get('noticias n');
        return $query->result();
    }

    function get_newsrandom($params)
    {
        $this->db
        ->select('n.id, n.titulo, n.url')
        ->select("REPLACE(n.imagen, 'full', 'medium') as thumb", FALSE)
        ->order_by('rand()')
        ->limit($params['limit']);
        $query = $this->db->get('noticias n');
        return $query->result();
    }

}