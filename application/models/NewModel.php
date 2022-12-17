<?php

class NewModel extends CI_Model{

    public function insert_item($table,$data)
    {    
        
        return $this->db->insert($table, $data);
    }

    public function insert_item1($table,$data)
    {    
        
        return $this->db->insert($table, $data);
    }

    public function userLogin($data){ 

        $this->db->select('*');
        $this->db->from('signup1');

        $this->db->where($data);
        $query = $this->db->get();
        
        return $query->row_array();
    }

    

}?>

