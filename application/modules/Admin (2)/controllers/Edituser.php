<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edituser extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->library('session');		
    } 
	
	public function index(){	
		$this->validateLogin();
		$data['heading_title']='Edit User';
		$data['active']='users';
		$data['submenuactive']='';
		$user_id = $this->uri->segment(3);
		$get_user_detail = $this->user->get_user_detail($user_id);
		$data['user']['UserID'] = $get_user_detail['UserID'];
		$data['user']['firstname'] = $get_user_detail['firstname'];
		$data['user']['lastname'] = $get_user_detail['lastname'];
		$data['user']['username'] = $get_user_detail['username'];
		$data['user']['email'] = $get_user_detail['email'];
		if($get_user_detail['image']!=''){
			$data['user']['image'] = $get_user_detail['image'];
		}else{
			$data['user']['image'] = '';
		}
		$data['user']['userrole'] = $get_user_detail['userrole'];
		$data['user']['userstatus'] = $get_user_detail['userstatus'];
		$data['current_user'] = $this->session->userdata('UserID'); 
		$this->load->view('edituser',$data);
	}

	public function updateuserAjaxValidation(){

		$UserID = $this->input->post('UserID');
		$userprofile_data = $this->user->get_userprofile($UserID);
		$data['image'] = $userprofile_data->image;


		if (($this->input->server('REQUEST_METHOD') == 'POST')){	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');

			$check_password =$this->input->post('check_password');

			$arrayData = array();
			if(!empty($check_password)){
				$this->form_validation->set_rules('check_password', 'Check Password', 'required|trim');
				$this->form_validation->set_rules('oldpassword', 'Old Password', 'required|trim');
				$this->form_validation->set_rules('newpassword', 'New Password', 'required|trim|min_length[8]');
				$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|trim|matches[newpassword]');

			}

			if ($this->form_validation->run() == FALSE) {
			    if(form_error('firstname')){
			    	$arrayData['firstname'] = form_error('firstname');
				}
				if(form_error('lastname')){
			    	$arrayData['lastname'] = form_error('lastname');
				}
				if(form_error('check_password')){
		    		$arrayData['check_password'] = form_error('check_password');
				}
				
				if(form_error('oldpassword')){
			    	$arrayData['oldpassword'] = form_error('oldpassword');
				}elseif(form_error('newpassword')){
			    	$arrayData['newpassword'] = form_error('newpassword');
				}elseif(form_error('confirmpassword')){
			    	$arrayData['confirmpassword'] = form_error('confirmpassword');
				}
			    $array = array(
				    'error'   => true,
				    'data' => $arrayData,
			    );
			}else{
				$UserID =$this->input->post('UserID');
				if(!empty($check_password)){
					$oldpassword = $this->input->post('oldpassword');
					$oldpasswordresult = $this->user->checkpassword($UserID,$oldpassword);
					if($oldpasswordresult){

					}else{
						$arrayData['oldpassword'] ='<p>Old password does not match</p>';
						$array = array(
						    'error'   => true,
						    'data' => $arrayData,
					    );
					    echo json_encode($array);
						die;
					}
				}
				if(@$_FILES["image"]["name"] != '')
		        {	
		        	$this->user->delete_profile_image_only($UserID);
		        	$config['upload_path']   = 'uploads/UserProfile';
		            $config['allowed_types'] = 'jpg|png';
		            //$config['max_size'] = '3072';
		            $config['file_name'] = time()."".rand(1,1000)."_".trim(preg_replace('/\s+/', ' ', $_FILES['image']['name']));

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if($this->upload->do_upload('image')){
		                $uploadData = $this->upload->data();
		                $this->profileresizeImage($uploadData['file_name']);                
			            $profile_image = $uploadData['file_name'];
					}else{
	              		$data = 'Sorry, there was an error uploading your file.';
	            	}
		        }
		        else
		        {
		        	$profile_image = $userprofile_data->image;
		        }

				$data=array();			
				$data['firstname'] = $this->input->post('firstname',true);
				$data['lastname'] = $this->input->post('lastname',true);
				$data['userrole'] = $this->input->post('userrole',true);
				$data['userstatus'] = $this->input->post('userstatus',true);
				$data['image'] = $profile_image ;

				
				if(!empty($check_password)){
					$password = $this->input->post('newpassword',true);
					$hashed_password = password_hash($password, PASSWORD_DEFAULT);	
					$data['password'] = $hashed_password;
				}
				$this->session->set_flashdata('success','User Updated successfully');
				$this->user->update_user($data,$UserID);
				$array = array(
				    'error'   => false,
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
