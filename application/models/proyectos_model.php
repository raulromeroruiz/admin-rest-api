<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Proyectos_model extends CI_Model
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
        ->select('p.id, p.nombre, p.proyecto, p.descripcion, p.ubicacion, p.oficinas, p.ano, p.area, p.condicion, p.url, p.estado')
        ->select("(SELECT nombre FROM tipo_proyectos WHERE id=p.tipo) as tipo", FALSE)
        ->from('proyectos p');
        $query = $this->db->get();
        return $query->result();
    }

    function get_proyectos($condicion=1)
    {
        $this->db
        ->select('p.id, p.nombre, p.proyecto, p.descripcion, p.ubicacion, p.oficinas, p.ano, p.area, p.url, p.estado')
        ->select("(SELECT archivo FROM archivos WHERE seccion=p.id AND grupo='lista' limit 1) as imagen", FALSE)
        //->select("(SELECT nombre FROM tipo_proyectos WHERE id=p.tipo) as tipo", FALSE)
        ->order_by('oficinas', 'DESC')
        ->from('proyectos p')
        ->where('estado', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function get_proyecto($id)
    {
        $this->db
        ->select("
            p.id, 
            p.nombre, 
            p.proyecto, 
            p.descripcion, 
            p.caracteristicas, 
            p.ubicacion, 
            p.direccion as dire, 
            p.oficinas, 
            p.ano, 
            p.area, 
            p.condicion, 
            p.tipo, 
            p.cliente,
            p.entrega
            ")
        ->select("(SELECT REPLACE(archivo, 'full','small') FROM archivos WHERE seccion=p.id AND grupo='lista' limit 1) as lista", FALSE)
        //->select("(SELECT REPLACE(archivo, 'full','small') FROM archivos WHERE seccion=p.id AND grupo='banner') as banner", FALSE)
        //->select("(SELECT REPLACE(archivo, 'full','small') FROM archivos WHERE seccion=p.id AND grupo='imagen3d') as imagen3d", FALSE)
        //->select("(SELECT REPLACE(archivo, 'full','small') FROM archivos WHERE seccion=p.id AND grupo='plano') as plano", FALSE)
        ->select("(SELECT id FROM archivos WHERE seccion=p.id AND grupo='lista' limit 1) as id_lista", FALSE)
        //->select("(SELECT id FROM archivos WHERE seccion=p.id AND grupo='banner') as id_banner", FALSE)
        //->select("(SELECT id FROM archivos WHERE seccion=p.id AND grupo='imagen3d') as id_imagen3d", FALSE)
        //->select("(SELECT id FROM archivos WHERE seccion=p.id AND grupo='plano') as id_plano", FALSE)
        ->from('proyectos p')
        //->join('clientes c', 'c.id=p.cliente', 'left')
        ->where('p.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_proyectobyurl($url)
    {
        $this->db
        ->select("
            p.id, 
            p.nombre, 
            p.proyecto, 
            p.descripcion, 
            p.caracteristicas, 
            p.ubicacion, 
            p.direccion, 
            p.oficinas, 
            p.ano, 
            ")
        ->select("(SELECT REPLACE(archivo, 'full','small') FROM archivos WHERE seccion=p.id AND grupo='lista' limit 1) as imagen", FALSE)
        ->from('proyectos p')
        ->where('p.url', urldecode($url));
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
        //->join('clientes c', 'c.id=p.cliente', 'left')
        ->where('a.seccion', $id)
        ->where('a.grupo', 'banner');
        $query = $this->db->get();
        return $query->result();
    }

    function get_offices_admin($id)
    {
        $this->db
        ->select("
            i.id, 
            i.nombre, 
            i.tipo, 
            i.area, 
            i.estado
            ")
        ->select("(SELECT nombre FROM tipo_inmuebles WHERE id=i.tipo) as tipo", FALSE)
        ->select("IF(i.precio IS NULL or i.precio=0,'No Disponible', CONCAT('$ ',FORMAT(i.precio,2))) as precio", FALSE)
        ->select("IF(i.precio IS NULL or i.precio=0,'No Disponible', 'Disponible') as disponible", FALSE)
        ->select("IF(i.area IS NULL or i.area=0,'No Disponible', i.area) as area", FALSE)
        ->select("(SELECT archivo FROM archivos WHERE seccion=i.id AND grupo='imagen3d' limit 1) as imagen3d", FALSE)
        ->select("(SELECT archivo FROM archivos WHERE seccion=i.id AND grupo='plano' limit 1) as plano", FALSE)
        ->from('inmuebles i')
        ->order_by('i.nombre')
        ->where('i.proyecto', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_offices($id)
    {
        $this->db
        ->select("
            i.id, 
            i.nombre, 
            i.tipo, 
            i.area, 
            ")
        ->select("(SELECT nombre FROM tipo_inmuebles WHERE id=i.tipo) as tipo", FALSE)
        // ->select("IF(i.precio IS NULL or i.precio=0,'No Disponible', CONCAT('$ ',FORMAT(i.precio,2))) as precio", FALSE)
        ->select("IF(i.precio IS NULL or i.precio=0,'No Disponible', 'Disponible') as disponible", FALSE)
        ->select("IF(i.area IS NULL or i.area=0,'No Disponible', i.area) as area", FALSE)
        ->select("(SELECT archivo FROM archivos WHERE seccion=i.id AND grupo='imagen3d' limit 1) as imagen3d", FALSE)
        ->select("(SELECT archivo FROM archivos WHERE seccion=i.id AND grupo='plano' limit 1) as plano", FALSE)
        ->from('inmuebles i')
        ->order_by('i.nombre')
        ->where('i.proyecto', $id)
        ->where('i.estado', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function get_detailoffice($id)
    {
        $this->db
        ->select("i.id, i.nombre, i.proyecto, i.tipo")
        // ->select("IF(i.precio IS NULL or i.precio=0,'No Disponible', i.precio) as precio", FALSE)
        ->select("IF(i.area IS NULL or i.area=0,'No Disponible', i.area) as area", FALSE)
        ->select("(SELECT archivo FROM archivos WHERE seccion=i.id AND grupo='imagen3d' limit 1) as imagen3d", FALSE)
        ->select("(SELECT REPLACE(archivo, 'full','small') FROM archivos WHERE seccion=i.id AND grupo='imagen3d' limit 1) as thumb_imagen3d", FALSE)
        ->select("(SELECT archivo FROM archivos WHERE seccion=i.id AND grupo='plano' limit 1) as plano", FALSE)
        ->select("(SELECT REPLACE(archivo, 'full','small') FROM archivos WHERE seccion=i.id AND grupo='plano' limit 1) as thumb_plano", FALSE)
        ->select("(SELECT id FROM archivos WHERE seccion=i.id AND grupo='imagen3d') as id_imagen3d", FALSE)
        ->select("(SELECT id FROM archivos WHERE seccion=i.id AND grupo='plano') as id_plano", FALSE)
        ->from('inmuebles i')
        ->where('i.id', $id);
        $query = $this->db->get();
        return $query->row();
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
        $query = $this->db->get_where('fotos_proyectos', array('proyecto'=>$id));
        return $query->result();
    }

    function get_bannerss($id, $view="small")
    {
        $this->db
        ->select('id')
        ->select("REPLACE(foto, 'full', '".$view."') as foto", FALSE);
        $query = $this->db->get_where('archivos', array('proyecto'=>$id, 'grupo'=>"banner"));
        return $query->result();
    }

    function get_inmuebles($id)
    {
        $this->db
        ->select('*')
        ->select("(SELECT nombre FROM tipo_inmuebles WHERE id=i.tipo) as tipo", FALSE)
        ->where('i.proyecto', $id)
        ->order_by('orden')
        ->from('inmuebles i');
        $query = $this->db->get();
        return $query->result();
    }

    function get_proyectoshome($params)
    {
        $this->db
        ->select('p.id, p.nombre, p.proyecto, p.descripcion, p.ubicacion, p.oficinas, p.url')
        ->select("(SELECT archivo FROM archivos WHERE seccion=p.id AND grupo='lista' limit 1) as imagen", FALSE)
        ->where('entrega', 1)
        ->limit($params['limit'])
        ->order_by('id', 'DESC')
        //->group_by('p.id')
        ->from('proyectos p');
        $query = $this->db->get();
        return $query->result();
    }

    function get_idbyurl($url)
    {
        $this->db
        ->select("p.id")
        ->from('proyectos p')
        ->where('p.url', urldecode($url));
        $query = $this->db->get();
        $row = $query->row();
        return $row->id;
    }

    function get_geolocations($proyect)
    {
        if ($proyect=='all') {
            $this->db
            ->select("CONCAT(p.proyecto,' ',p.nombre) as proyect", FALSE)
            ->select("p.id, p.mapa as map")
            ->from('proyectos p');
            $query = $this->db->get();
            return $query->result();
        }
        else {
            $this->db
            ->select("CONCAT(p.proyecto,' ',p.nombre) as proyect", FALSE)
            ->select("p.id, p.mapa as map")
            ->where('p.url', urldecode($proyect))
            ->from('proyectos p');
            $query = $this->db->get();
            return $query->row();
        }
    }

    function get_equipment($id)
    {
        $this->db
        ->select("e.id, e.establecimiento, e.mapa, e.tipo as id_tipo", FALSE)
        ->select("(SELECT nombre FROM tipo_establecimiento WHERE id=e.tipo) as tipo", FALSE)
        ->where('e.proyecto', $id)
        ->from('establecimientos e');
        $query = $this->db->get();
        return $query->result();
    }

    function get_offices_available($params)
    {
        $this->db
        ->select('p.id, p.nombre, p.proyecto, p.oficinas, p.url')
        ->select("(SELECT archivo FROM archivos WHERE seccion=p.id AND grupo='lista' limit 1) as imagen", FALSE)
        ->where('p.oficinas', 0)
        ->order_by('rand()')
        ->limit($params['limit'])
        ->from('proyectos p');
        $query = $this->db->get();
        return $query->result();
    }

}