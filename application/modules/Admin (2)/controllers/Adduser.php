<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adduser extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->library('session');		
    } 
	public function index(){	
		$this->validateLogin();
		$data['heading_title']='Add User';
		$data['active']='users';
		$data['submenuactive']='adduser';
		$this->load->view('adduser',$data);
	}
	public function adduserAjaxValidation(){
		if (($this->input->server('REQUEST_METHOD') == 'POST')){	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
			/*if (empty($_FILES['image']['name'])) { 
			$this->form_validation->set_rules('image', 'Image', 'required');
			}*/
			$this->form_validation->set_rules('username', 'User Name', 'required|trim|min_length[5]|is_unique[users.username]');
			$this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]');
			$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|matches[password]');
			if ($this->form_validation->run() == FALSE) {
    			$arrayData = array(
				    'firstname' => form_error('firstname'),
				    'lastname' => form_error('lastname'),
				    //'image' => form_error('image'),
				    'username' => form_error('username'),
				    'email' => form_error('email'),
				    'password' => form_error('password'),
				    'confirmpassword' => form_error('confirmpassword'),
			    );
			    $array = array(
				    'error'   => true,
				    'data' => $arrayData,
			    );
			}else{
				$data=$this->input->post();
				

				$password = $this->input->post('password',true);
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				if (empty($_FILES['image']['name'])) {
					$image = '';
				}else{ 
					$config['upload_path']   = 'uploads/UserProfile';
		            $config['allowed_types'] = 'jpg|png';
		            //$config['max_size'] = '3072';
		            $config['file_name'] = time()."".rand(1,1000)."_".trim(preg_replace('/\s+/', ' ', $_FILES['image']['name']));

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if($this->upload->do_upload('image')){
		                $uploadData = $this->upload->data();
		                $this->profileresizeImage($uploadData['file_name']);                
			            $image = $uploadData['file_name'];
					}else{
	              		$image = '';
	            	}
	            }	

				$data=array(
						'firstname'=>  $this->input->post('firstname',true),
						'lastname'=> $this->input->post('lastname',true),
						'username'=>$this->input->post('username',true),	
						'email'=>$this->input->post('email',true),
						'password'=>$hashed_password,
						'image'=>$image,
						'userrole'=>$this->input->post('userrole',true),
						'userstatus'=>$this->input->post('userstatus',true),
					);

				$this->session->set_flashdata('success','User added successfully');
				$last_id = $this->user->insert_user($data);
				$array = array(
				    'error'   => false,
				    'last_id'=>$last_id,
				    'url'=>base_url('admin/users')
			    );
			}
			echo json_encode($array);
			die;
		}
	}

	public function profileresizeImage($filename){
      $source_path = UPLOADROOT . 'UserProfile/' . $filename;
      $target_path = UPLOADROOT . 'UserProfile/thumbnail/';
      $config_manip = array(
          'image_library' => 'gd2',
          'source_image' => $source_path,
          'new_image' => $target_path,
          'maintain_ratio' => TRUE,
          'create_thumb' => TRUE,
          'thumb_marker' => '',
          'width' => 280,
          'height' => 280
      );

      $this->load->library('image_lib', $config_manip);
      if (!$this->image_lib->resize()) {
          echo $this->image_lib->display_errors();
      }
      $this->image_lib->clear();
   	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			$array_items = array('UserID' =>'','logged_in' =>false);
			$this->session->unset_userdata($array_items);
			redirect('/');
			exit();   
		}
	} 	
}
