<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends MX_Controller {
	function __construct()   {		
    } 
	public function index(){
		$data['title']='Home';
		$this->load->view('home',$data);
	}
}
