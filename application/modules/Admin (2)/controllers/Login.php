<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->library('session');		
    } 
	public function index(){
		$this->validateLogin();
		if (($this->input->server('REQUEST_METHOD') == 'POST')){	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'User Name', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');
			if ($this->form_validation->run() == FALSE) {
				$arrayData = array(
				    'username' => form_error('username'),
				    'password' => form_error('password'),
			    );
			    $array = array(
				    'error'   => true,
				    'data' => $arrayData,
			    );
			}else{
				$username=$this->input->post('username',true);
				$password=$this->input->post('password',true);			
				$result = $this->user->login($username,$password);

				/*echo "<pre>";
				print_r($result);
				echo "</pre>";*/

				if($result){
					$array = array(
					    'error'   => false,
					    'url'=> base_url('admin'),
				    );
				}else{
					$arrayData = array(
				    	'usernamepassword' => 'Your email or password is incorrect.',
				    );
				    $array = array(
					    'error'   => true,
					    'data' => $arrayData,
				    );
				}    
			} 

			echo json_encode($array);
			die;   
		}
		$data['heading_title']='Login';
		$data['body_class']='login-page';
		$this->load->view('login',$data);
	}
	public function logout(){
		$newdata = array('userid' =>'','logged_in' =>false);
		$this->session->unset_userdata($newdata);
		$this->session->sess_destroy();
		redirect('/');
	}

	private function validateLogin(){
        if($this->session->userdata('logged_in') == true && $this->session->userdata('UserID') != ''){
            redirect('admin');
            exit();   
        }
    } 
}
