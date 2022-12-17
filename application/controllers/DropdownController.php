<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class  DropdownController extends CI_Controller { 
    public $Signup;
 
 
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct(); 
 
 
       $this->load->library('form_validation');
       $this->load->library('session');
       $this->load->model('DropdownModel');

    }
 

    function userSignupDashboard()
    {
        $this->form_validation->set_rules('name', 'userName', 'required');
        $this->form_validation->set_rules('country', 'country', 'required');
        $this->form_validation->set_rules('state', 'state', 'required');
        $this->form_validation->set_rules('city', 'city', 'required');
 
 
        if ($this->form_validation->run() == FALSE){
         //print_r($this);
            $this->session->set_flashdata('errors', validation_errors());
            //redirect(base_url('dashboard'));
        }else{
         $data = array(
             'session_id' => $this->session->userdata('userid'),
             'userName' => $this->input->post('name'),
             'country' => $this->input->post('country'),
             'state' => $this->input->post('state'),
             'city' => $this->input->post('city'),

         );
         //$user_id=$_POST['user_id'];
         $user_id = $this->input->post('userId');
         //print_r($user_id);
         if($user_id)
         {
             $result=$this->DropdownModel->updateData($data,$user_id);
             //print_r($result);
            $message= "data updated successfully";
            $status= 200;
         }
         else{
           $result=$this->DropdownModel->insert_item('dynamicDependency1', $data);
           if($result)
           {
           $message= "data inserted successfully";
           $status= 200;
           }
           else{
             $message="failed";
             $status= 400;
           }
        }
    }
        $data['message']=$message;
        $data['status']=$status;
        echo json_encode($data);
  
    }

    function getCountry()
    {
        $data['country'] =  $this->DropdownModel->getCountry();
        //print_r($data);
        if($data)
        {
            $message= "success";
            $status= 200;
            
        }else{
                $message="failed";
                $status= 400;
            
       } 
       $data['message']=$message;
       $data['status']=$status;
    //print_r($data);
       echo json_encode($data);     
    } 
    
    
    public function getState(){
        $country_id = $this->input->get('country_id');
        if($country_id){
            $data['state'] =  $this->DropdownModel->getState($country_id);
             if($data)
            {
                $message= "success";
                $status= 200;
                
            }else{
                    $message="failed";
                    $status= 400;
                
            }   
            $data['message']=$message;
            $data['status']=$status;
        echo json_encode($data);
        }
    }
    
    public function getCity(){
       
        $state_id = $this->input->get('state_id');
        if($state_id){
        $data['city'] = $this->DropdownModel->getCity($state_id);
        if($data)
            {
                $message= "success";
                $status= 200;
                
            }else{
                    $message="failed";
                    $status= 400;
                
            } 
            $data['message']=$message;
            $data['status']=$status;
            echo json_encode($data);
        }
    }

    function getData()
    {
        $session_id = $this->session->userdata('userid');
        $result = $this->DropdownModel->getData($session_id);
        //$data=$result;
       $response['userData'] = $result;
       echo json_encode($response); 
    }

    function getInfoById()
    {
        $user_id = $this->input->get('user_id');
        //print_r($user_id);
        $result = $this->DropdownModel->getInfoById($user_id);
        $response['userData'] = $result;
        //print_r($response);
        echo json_encode($response);    

    }

    function deleteData()
    {
        $data = array();
        $user_id = $this->input->post('user_id');
        //print_r($user_id);
        $this->DropdownModel->deleteData($user_id);
        $message= "deleted successfully";
        $status= 200;
        
        $data['message']=$message;
        $data['status']=$status;
        echo json_encode($data);
        
    }
       
    }
?>