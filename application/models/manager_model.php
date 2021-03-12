<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Manager_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $db = $this->load->database();
    }

    function all($table="")
    {
        $query = $this->db->get($table);
        return $query->result();
    }

    function get($table="", $id="")
    {
        $query = $this->db->get_where($table, array('id' => $id));
        return $query->row();
    }
 
    function where($table="", $filter=array())
    {
        $query = $this->db->get_where($table, $filter);
        return $query->result();
    }
 
    function insert($table="", $data="")
    {
        return $this->db->insert($table, $data);
    }

    function update($table="", $data="", $id="")
    {
        return $this->db->update($table, $data, "id = ".$id);
    }

    function delete($table="", $id="")
    {
        return $this->db->delete($table, array('id' => $id)); 
    }

    function last($table="", $limit=3)
    {
        $this->db->limit($limit);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($table);
        return $query->result();
    }

    function status($table="", $estado="", $id="")
    {
      return $this->db->update($table, array('estado' => $estado), "id = ".$id); 
    }

    function orden($table="")
    {
        $query = $this->db->query("SELECT MAX(orden) as orden FROM ".$table);
        $query = $query->row();
        return $query->orden + 1;
    }

    function login($data)
    {
        $q = $this->db->get_where('usuarios', array('correo'=>$data['correo']));
        $user = $q->row();
        if ($user) {
            if (password_verify($data['password'], $user->password)) {
                return array(TRUE, $user);
            }
            else {
                return array(FALSE, "Cotraseña incorrecta.");
            }
        }
        else {
            return array(FALSE, "Nombre de usuario o correo no existe.");
        } 
    }

    function get_fields($table, $fields=array()) {
        $fields = implode(",", $fields);
        $this->db->select($fields);
        $query = $this->db->get($table);
        return $query->result();
    }

    function get_simplebyfield($table, $fields=array(), $where) {
        $fields = implode(",", $fields);
        $this->db->select($fields);
        $query = $this->db->get_where($table, $where);
        if ($query->num_rows()>1) {
            return $query->result();
        }
        else {
            return $query->row();
        }
    }

    function search_field($table, $data) {
        $query = $this->db->get_where($table, $data);
        return $query->result();
    }

}