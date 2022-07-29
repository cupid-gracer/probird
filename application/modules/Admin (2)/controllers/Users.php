<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    } 
	public function index(){
		$this->validateLogin();		
		$data['heading_title']='Users';
		$data['active']='users';
		$data['submenuactive']='users';
		/*$users = $this->user->get_users();
		$data['users']= $users;		*/

		$config = array();
		$config['base_url'] = base_url() .'admin/users/';
		$config['total_rows'] = $this->user->get_users_count();
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		//$config['num_links'] = 2;
		$config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data["users"] = $this->user->get_users($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('users',$data);
	}

	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			$array_items = array('UserID' =>'','logged_in' =>false);
			$this->session->unset_userdata($array_items);
			redirect('/');
			exit();   
		}
	} 

	public function deleteuser()
	{
		$UserID = $this->uri->segment(3);
		$UserID = $this->user->delete_user($UserID);
		if($UserID)
		{
			$this->session->set_flashdata('success', 'User have been Deleted successfully.');
			redirect('admin/users');
			exit();
		}
	}
}
