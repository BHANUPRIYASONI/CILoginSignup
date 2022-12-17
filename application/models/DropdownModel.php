<?php

class DropdownModel extends CI_Model{


    public function insert_item($table,$data)
    {    
        
        return $this->db->insert($table, $data);
    }


    public function getCountry(){ 

        $this->db->select('*');
        $this->db->from('countries');
        
        $query = $this->db->get();
        //print_r( $query);
        return $query->result_array();
    }

    public function getState($country_id){ 

        $this->db->select('*');
        $this->db->from('states');

        $this->db->where('country_id',$country_id);
        $query = $this->db->get();
       
        return $query->result_array();
        
    }

    public function getCity($state_id){ 

        $this->db->select('*');
        $this->db->from('cities');

        $this->db->where('state_id',$state_id);
        $query = $this->db->get();
        
        return $query->result_array();
    }

    public function getData($session_id)
    {
        $this->db->select('user_id,userName,countryName,stateName,cityName');
        $this->db->from('dynamicdependency1');
        
        $this->db->join('countries','dynamicdependency1.country = countries.id');
        $this->db->join('states','dynamicdependency1.state = states.id');
        $this->db->join('cities','dynamicdependency1.city = cities.id');
        $this->db->where('session_id',$session_id);
        $query = $this->db->get();
        
    //     "SELECT tdl.user_id,tdl.heading,tdl.detail,c.countryName,s.stateName,cy.cityName FROM todolist tdl 
    //   INNER JOIN countries c ON tdl.country = c.id 
    //   INNER JOIN states s ON tdl.state = s.id
    //   INNER JOIN cities cy ON tdl.city = cy.id WHERE main_id = '$main_id'";

// $this->db->select('BookID, BookName, CategoryName, AuthorName, ISBN');
// $this->db->from('Books');
// $this->db->join('Category', 'Category.CategoryID = Books.CategoryID');
// $this->db->join('Author', 'Author.AuthorID = Books.AuthorID');
    //print_r($this->db->last_query());
        return $query->result_array();
    }


    public function getInfoById($user_id)
    {
        $this->db->select('*');
        $this->db->from('dynamicdependency1');

        $this->db->where('user_id',$user_id);
        $query = $this->db->get();
       
        return $query->row_array();
         
    }

    public function updateData($data,$user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update('dynamicdependency1', $data);    
    }

    public function deleteData($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('dynamicdependency1'); 
    }
}?>

