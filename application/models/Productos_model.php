<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Productos_model extends CI_Model
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
        ->select("(SELECT nombre FROM categorias WHERE id=p.categoria) as categoria", FALSE)
        ->from('productos p');
        $query = $this->db->get();
        return $query->result();
    }

    function get_productos($condicion=1)
    {
        $this->db
        ->select('p.id, p.nombre, p.tipo, p.descripcion, p.estado')
        // ->select("(SELECT archivo FROM archivos WHERE seccion=p.id AND grupo='lista' limit 1) as imagen", FALSE)
        // ->order_by('oficinas', 'DESC')
        ->from('productos p')
        ->where('estado', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function get_producto($id)
    {
        $this->db
        ->select("
            p.id, 
            p.nombre, 
            p.tipo, 
            p.descripcion,
            p.precio,
            p.compartir,
            p.categoria
            ")
        ->select("(SELECT REPLACE(archivo, 'full','small') FROM archivos WHERE seccion=p.id AND grupo='foto' limit 1) as foto", FALSE)
        ->select("(SELECT id FROM archivos WHERE seccion=p.id AND grupo='foto' limit 1) as id_foto", FALSE)
        ->from('productos p')
        ->where('p.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_productobyurl($url)
    {
        $this->db
        ->select("
            p.id, 
            p.nombre, 
            p.producto, 
            p.descripcion, 
            p.caracteristicas, 
            p.ubicacion, 
            p.direccion, 
            p.oficinas, 
            p.ano, 
            ")
        ->select("(SELECT REPLACE(archivo, 'full','small') FROM archivos WHERE seccion=p.id AND grupo='lista' limit 1) as imagen", FALSE)
        ->from('productos p')
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
        //->join('clientes c', 'p.id=p.cliente', 'left')
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
        ->where('i.producto', $id);
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
        ->where('i.producto', $id)
        ->where('i.estado', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function get_detailoffice($id)
    {
        $this->db
        ->select("i.id, i.nombre, i.producto, i.tipo")
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

    function save_file($params)
    {
        $data = array(
            'seccion' => $params['seccion'],
            'grupo'   => $params['grupo'],
            'tipo'    => $params['tipo'],
            'archivo' => $params['archivo'],
            'orden'   => 1,
            'estado'  => 1,
        );
        if (!empty($params['id'])){
            $this->db->where('id', $params['id']);
            return $this->db->update('archivos', $data);
        }
        return $this->db->insert('archivos', $data);;
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
        $query = $this->db->get_where('fotos_productos', array('producto'=>$id));
        return $query->result();
    }

    function get_bannerss($id, $view="small")
    {
        $this->db
        ->select('id')
        ->select("REPLACE(foto, 'full', '".$view."') as foto", FALSE);
        $query = $this->db->get_where('archivos', array('producto'=>$id, 'grupo'=>"banner"));
        return $query->result();
    }

    function get_inmuebles($id)
    {
        $this->db
        ->select('*')
        ->select("(SELECT nombre FROM tipo_inmuebles WHERE id=i.tipo) as tipo", FALSE)
        ->where('i.producto', $id)
        ->order_by('orden')
        ->from('inmuebles i');
        $query = $this->db->get();
        return $query->result();
    }

    function get_productoshome($params)
    {
        $this->db
        ->select('p.id, p.nombre, p.producto, p.descripcion, p.ubicacion, p.oficinas, p.url')
        ->select("(SELECT archivo FROM archivos WHERE seccion=p.id AND grupo='lista' limit 1) as imagen", FALSE)
        ->where('entrega', 1)
        ->limit($params['limit'])
        ->order_by('id', 'DESC')
        //->group_by('p.id')
        ->from('productos p');
        $query = $this->db->get();
        return $query->result();
    }

    function get_idbyurl($url)
    {
        $this->db
        ->select("p.id")
        ->from('productos p')
        ->where('p.url', urldecode($url));
        $query = $this->db->get();
        $row = $query->row();
        return $row->id;
    }

    function get_geolocations($proyect)
    {
        if ($proyect=='all') {
            $this->db
            ->select("CONCAT(p.producto,' ',p.nombre) as proyect", FALSE)
            ->select("p.id, p.mapa as map")
            ->from('productos p');
            $query = $this->db->get();
            return $query->result();
        }
        else {
            $this->db
            ->select("CONCAT(p.producto,' ',p.nombre) as proyect", FALSE)
            ->select("p.id, p.mapa as map")
            ->where('p.url', urldecode($proyect))
            ->from('productos p');
            $query = $this->db->get();
            return $query->row();
        }
    }

    function get_equipment($id)
    {
        $this->db
        ->select("e.id, e.establecimiento, e.mapa, e.tipo as id_tipo", FALSE)
        ->select("(SELECT nombre FROM tipo_establecimiento WHERE id=e.tipo) as tipo", FALSE)
        ->where('e.producto', $id)
        ->from('establecimientos e');
        $query = $this->db->get();
        return $query->result();
    }

    function get_offices_available($params)
    {
        $this->db
        ->select('p.id, p.nombre, p.producto, p.oficinas, p.url')
        ->select("(SELECT archivo FROM archivos WHERE seccion=p.id AND grupo='lista' limit 1) as imagen", FALSE)
        ->where('p.oficinas', 0)
        ->order_by('rand()')
        ->limit($params['limit'])
        ->from('productos p');
        $query = $this->db->get();
        return $query->result();
    }

}