<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class NewController extends CI_Controller { 
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
       $this->load->model('NewModel');

    }
 
    public function index()  
    {  
        if($this->session->userdata('userid')){
            redirect(base_url('dashboard'));
            }
            else{
                $this->load->view('newView/login');  
            }
    }  
        
    public function signup(){
        if($this->session->userdata('userid')){  
            redirect(base_url('dashboard'));      
         } 
         else{
        $this->load->view('newView/signup');  
         }
    }


    /**
    * Store Data from this method.
    *
    * @return Response
   */

   public function validateEmail()
   {
    $data = array(
        'email' => $this->input->post('email'),
    );
    $result =$this->NewModel->userLogin($data);
    if($result==0)
    {
        //print_r($result);
        $this->session->set_flashdata('errors', validation_errors());
        echo 'true';
    }
    else
    {
		echo 'false';
	}
}

  public function userSignup()
  {

       $this->form_validation->set_rules('username', 'userName', 'required');
       $this->form_validation->set_rules('email', 'email', 'required');
       $this->form_validation->set_rules('password', 'password', 'required');


       if ($this->form_validation->run() == FALSE){
        //print_r($this);
           $this->session->set_flashdata('errors', validation_errors());
           redirect(base_url('signup'));
       }else{
        $data = array(
            'userName' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password')
        );
        //print_r($this);
          $result=$this->NewModel->insert_item('signup1', $data);
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
       $data['message']=$message;
       $data['status']=$status;
       echo json_encode($data);
   }
 
    public function userLogin() 
    {
       $this->form_validation->set_rules('email', 'email', 'required');
       $this->form_validation->set_rules('password', 'password', 'required');


       if ($this->form_validation->run() == FALSE){
           $this->session->set_flashdata('errors', validation_errors());
           redirect(base_url());
       }else{
        $data = array(
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password')
        );
        $result = $this->NewModel->userLogin($data);
        if($result){
            //print_r($result);die;
            $this->session->set_userdata('userid', $result['user_id']);
            $message= "Logined successfully";
          $status= 200;
            //redirect(base_url('dashboard'));
        }else{
                $message="failed";
                $status= 400;
            //redirect(base_url());
        }
       } 
       $data['message']=$message;
       $data['status']=$status;
       echo json_encode($data);     
    }
 
    function logout()
    {
    $this->session->unset_userdata('userid');
    $this->session->sess_destroy();
    redirect('');
    }

    
}
?>