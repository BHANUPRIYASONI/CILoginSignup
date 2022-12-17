<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class DashboardController extends CI_Controller {
    public function __construct() {
        parent::__construct(); 

      $this->load->library('session');
      
      if(!$this->session->userdata('userid')){
      redirect(base_url('NewController'));
      }

    }

 public function dashboard()
 {
    if($this->session->userdata('userid') !=""){  
          $this->load->view('newView/dashboard');      
       } 
     else{
    redirect(base_url('NewController'));
  }
}

public function getUserProfile()
{
  $data = array(
    'user_id' => $this->session->userdata('userid'),
);
$this->load->model('NewModel');
  $result = $this->NewModel->userLogin($data);
  //print_r($result);
    if($result){
        //print_r($result['userName']);die;
        $userName= $result['userName'];
        $message= "Welcome to dashboard";
        $status= 200;
    }else{
      $userName="not found";
      $message="failed";
      $status= 400;
 
}
$data['userName']=$userName;
$data['message']=$message;
$data['status']=$status;
//print_r($data);
echo json_encode($data);

}

 
}
