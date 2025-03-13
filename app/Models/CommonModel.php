<?php

namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

    //  Common Get All Data
    public function get_all_data($table)
    {
        $query = $this->db->table($table)->get();
        return $query->getResult();
    }

    public function get_all_data_array($table)
    {
        $query = $this->db->table($table)->get();
        return $query->getResultArray();
    }

    //  Common Insert Data
    public function common_insert_data($table,$data = array())
    {
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }

    //  Common Update Data
    public function common_update_data($table,$id, $data = array())
    {        
        $this->db->table($table)->update($data, array( "id" => $id ));
        $flag = $this->db->affectedRows();

        if($flag)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //  Common Update Data With Filter
    public function update_data($table, $data = array(),$filter= array())
    {        
        return $this->db->table($table)->update($data, $filter);
    }

    //  Common Delete
    public function common_delete_data($table, $id)
    {
        // print_r($table); die; 
        return $this->db->table($table)->delete(array( "id" => $id ));
    }
    
    //  Common Delete
    public function delete_data($table, $filter)
    {
        // print_r($table); die; 
        return $this->db->table($table)->delete($filter);
    }

    //  Multiple Delete
    public function multiple_delete_data($table, $id)
    {
        return $this->db->table($table)->delete($id);
    }

    // Common Get Data By Condition
    public function get_by_condition($table,$filter)
    {
       /* if($order == "")
        {
            $data = $this->db->table($table)->where($filter)->orderBy('id', 'desc')->get();
        }
        else
        {
            $data = $this->db->table($table)->where($filter)->orderBy($order[0], $order[1])->get();

        }*/
        
        $data = $this->db->table($table)->where($filter)->orderBy('id', 'desc')->get();
        
        return $data->getResult();
    }

    public function get_single($table, $filter)
    {
        $data = $this->db->table($table)->where($filter)->get();
        return $data->getRow(0);
    }

    
    public function randomval($table,$limit)
    {
        $data = $this->db->table($table)->limit($limit)->orderBy('id', 'RANDOM')->get();

        return $data->getResult();
    }

    public function randomvalsinglerecord($table)
    {
        $data = $this->db->table($table)->limit(1)->orderBy('id', 'RANDOM')->get();

        return $data->getRow(0);
    }

    public function get_single_record($table, $filter)
    {
        $query = $this->db->table($table)->getWhere($filter);

        if($query->getNumRows() > 0)
        {
            return $query->getResult();
        }
        else
        {
            return false;
        }
    }

    public function get_by_limit_without_filter($table, $limit ,$order="")
    {
        $query = $this->db->table($table)->limit($limit)->get();
        return $query->getResult();
    }

    function get_by_limit($table, $filter, $limit,$order="")
    {
        $query = $this->db->table($table)->limit($limit)->where($filter)->get();
        return $query->getResult();
    }

    public function get_by_limit_without_filter_order_by($table, $limit, $order="ASC")
    {
        $query = $this->db->table($table)->limit($limit)->orderBy($order, 'DESC')->get();
        return $query->getResult();
    }

    function get_by_limit_order_by($table, $filter, $limit,$order)  // 'ASC'/'DESC'
    {
        $query = $this->db->table($table)->limit($limit)->where($filter)->orderBy($order, 'DESC')->get();
        return $query->getResult();
    }

    function custome_query($query)
    {
        return  $this->db->query($query)->getResult();
    }
    
    function custome_query_single_record($query)
    {
        return  $this->db->query($query)->getRow(0);
    }
    
    function custom_update($query)
    {
        return  $this->db->query($query);
    }

}

?>



