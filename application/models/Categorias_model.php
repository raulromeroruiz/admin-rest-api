<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Categorias_model extends CI_Model
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
        ->select('*')
        ->from('categorias c');
        $query = $this->db->get();
        return $query->result();
    }

    function get_categorias($condicion=1)
    {
        $this->db
        ->select('c.id, c.nombre, c.tipo, c.descripcion, c.estado')
        ->from('categorias c')
        ->where('estado', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function get_categoria($id)
    {
        $this->db
        ->select("
            c.id, 
            c.nombre, 
            c.icono  
            ")
        // ->select("(SELECT REPLACE(archivo, 'full','small') FROM archivos WHERE seccion=c.id AND grupo='lista' limit 1) as lista", FALSE)
        // ->select("(SELECT id FROM archivos WHERE seccion=c.id AND grupo='lista' limit 1) as id_lista", FALSE)
        ->from('categorias c')
        ->where('c.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_categoriabyurl($url)
    {
        $this->db
        ->select("
            c.id, 
            c.nombre, 
            c.categoria, 
            c.descripcion, 
            c.caracteristicas, 
            c.ubicacion, 
            c.direccion, 
            c.oficinas, 
            c.ano, 
            ")
        ->select("(SELECT REPLACE(archivo, 'full','small') FROM archivos WHERE seccion=c.id AND grupo='lista' limit 1) as imagen", FALSE)
        ->from('categorias c')
        ->where('c.url', urldecode($url));
        $query = $this->db->get();
        return $query->row();
    }

    function get_banners($id)
    {
        $this->db
        ->select("
            a.id, 
            a.archivo, 
            ")
        ->select("REPLACE(archivo, 'full', 'small') as foto", FALSE)
        ->from('archivos a')
        //->join('clientes c', 'c.id=c.cliente', 'left')
        ->where('a.seccion', $id)
        ->where('a.grupo', 'banner');
        $query = $this->db->get();
        return $query->result();
    }

    function save_photos($fotos=array(), $datos=array())
    {
        foreach ($fotos as $key => $foto) {
            if ($foto!="") {
                $data = array(
                    'seccion' => $datos['id'],
                    'grupo'   => $key,
                    'tipo'    => $datos['tipo'],
                    'archivo' => $foto,
                    'orden'   => 1,
                    'estado'  => 1,
                );
                $this->db->insert('archivos', $data);
            }
        }
    }

    function save_banners($fotos=array(), $datos=array())
    {
        foreach ($fotos as $foto) {
            $data = array(
                'seccion' => $datos['id'],
                'grupo'   => 'banner',
                'tipo'    => $datos['tipo'],
                'archivo' => $foto,
                'orden'   => 1,
                'estado'  => 1,
            );
            $this->db->insert('archivos', $data);
        }
    }

    function get_images($id, $view="small")
    {
        $this->db
        ->select('id')
        ->select("REPLACE(foto, 'full', '".$view."') as foto", FALSE);
        $query = $this->db->get_where('fotos_categorias', array('categoria'=>$id));
        return $query->result();
    }

    function get_bannerss($id, $view="small")
    {
        $this->db
        ->select('id')
        ->select("REPLACE(foto, 'full', '".$view."') as foto", FALSE);
        $query = $this->db->get_where('archivos', array('categoria'=>$id, 'grupo'=>"banner"));
        return $query->result();
    }

    function get_categoriashome($params)
    {
        $this->db
        ->select('c.id, c.nombre, c.categoria, c.descripcion, c.ubicacion, c.oficinas, c.url')
        ->select("(SELECT archivo FROM archivos WHERE seccion=c.id AND grupo='lista' limit 1) as imagen", FALSE)
        ->where('entrega', 1)
        ->limit($params['limit'])
        ->order_by('id', 'DESC')
        //->group_by('c.id')
        ->from('categorias c');
        $query = $this->db->get();
        return $query->result();
    }

    function get_idbyurl($url)
    {
        $this->db
        ->select("c.id")
        ->from('categorias c')
        ->where('c.url', urldecode($url));
        $query = $this->db->get();
        $row = $query->row();
        return $row->id;
    }

}