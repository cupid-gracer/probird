<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->library('session');	
		$this->load->model('Dashboardmodel','',TRUE);	
    } 
	public function index(){
		$validateLogin = $this->validateLogin();
		$data['Name']=$validateLogin['Name'];
		$data['Surname']=$validateLogin['Surname'];

		$data['heading_title']='Dashboard';
		$data['active']='dashboard';
		$data['submenuactive']='';
		$data['get_clusters'] =$this->Dashboardmodel->get_clusters();

		$get_cameras_in_cluster =$this->Dashboardmodel->get_cameras_in_cluster();

		$camera_arrs = array();
		foreach ($get_cameras_in_cluster as $key => $value) {
			$camera_arr = array();
			$get_camera_detail = $this->Dashboardmodel->get_camera_detail($value['Camera_ID']);
			$camera_arr['Cluster_ID'] = $value['Cluster_ID'];
			$camera_arr['Name'] = $get_camera_detail['Name'];
			//$camera_arr = $get_camera_detail['Name'];
			$camera_arrs[] = $camera_arr;
		}
		$data['get_cameras'] = $camera_arrs;

		$get_all_piform = array();
		$get_clusters_data = $this->Dashboardmodel->get_clusters();
		foreach ($get_clusters_data as $key => $value01) {
			$getitems = array();
			$get_wt_packs_in_cluster = $this->Dashboardmodel->get_wt_packs_in_cluster($value01['ID']);
			foreach ($get_wt_packs_in_cluster as $key => $value02) {
				$get_medias = $this->Dashboardmodel->get_media_by_wt_pack_id($value02['WT_pack_ID']);
				foreach ($get_medias as $key => $value) {
					$get_item_arr = array();
					$get_item_arr['WT_pack_ID'] =  $value02['WT_pack_ID'];
						$get_wind_turbine_pack = $this->Dashboardmodel->get_wind_turbine_pack_by_wt_pack_id($value02['WT_pack_ID']);
						
						$get_medias_test = $this->Dashboardmodel->get_medias_test_by_wt_pack_id($value02['WT_pack_ID']);
					
						$get_item_arr['camera_name']  = $get_wind_turbine_pack['camera_name'];
						if ($get_medias_test!='') {
							$get_item_arr['Type']  = $get_medias_test['Type'];
						}
					$get_item_arr['path']  = $value['Path'];
					$get_item_arr['ID']  = $value['ID'];
					$getitems[] = $get_item_arr;
				}
			}
			$get_all_piform[$value01['ID']] = $getitems;
		}
		$data['get_medias_images'] = $get_all_piform;

		$value_arr = ['1','2','3','4','5','6','7'];
		$limit = 50000;
		$get_probird_orders_data = $this->Dashboardmodel->get_probird_orders($limit,$value_arr);
		$probirds = array();
		foreach ($get_probird_orders_data as $key => $value) {
			$get_bird['Time_Stamp'] = $value['Time_Stamp'];
			$exp_time = explode(' ', $get_bird['Time_Stamp']);
			$get_bird['birddate'] = $exp_time[0];
			$get_bird_exp_1 = $exp_time[1];
			$get_bird_exp_2 = explode(':', $get_bird_exp_1);
			$get_bird['birdtime'] = $get_bird_exp_2[0].'.'.$get_bird_exp_2[1].$get_bird_exp_2[2];
			

 			$get_bird['Value'] = $value['Value'];
			$get_bird['Wind_Turbine'] = $value['Wind_Turbine'];
			$probirds[] = $get_bird;
		}
		$data['get_bird_data'] = $probirds;


		$this->load->view('dashboard',$data);
	}

	public function get_wt_packs_in_cluster(){


		$data = array();
		$data['error'] = true;

		$getitems = array();
		$get_wt_packs_in_cluster = $this->Dashboardmodel->get_wt_packs_in_cluster($_POST['ClusterID']);
		foreach ($get_wt_packs_in_cluster as $key => $value02) {
			$get_medias = $this->Dashboardmodel->get_media_by_wt_pack_id($value02['WT_pack_ID']);
			foreach ($get_medias as $key => $value) {
				$get_item_arr = array();
				$get_item_arr['WT_pack_ID'] =  $value02['WT_pack_ID'];
					$get_wind_turbine_pack = $this->Dashboardmodel->get_wind_turbine_pack_by_wt_pack_id($value02['WT_pack_ID']);
					$get_item_arr['camera_name']  = $get_wind_turbine_pack['camera_name'];
					$get_medias_test = $this->Dashboardmodel->get_medias_test_by_wt_pack_id($value02['WT_pack_ID']);
					if ($get_medias_test!='') {
						$get_item_arr['Type']  = $get_medias_test['Type'];
					}
				$get_item_arr['Path']  = $value['Path'];
				$get_item_arr['ID']  = $value['ID'];
				$getitems[] = $get_item_arr;
			}


		}
		
		
		
		$html='';
		$html.='<div class="content-carousel">';
        $html.='<div class="owl-carousel">';
		
		$media_img_count = 1;
		foreach ($getitems as $key => $value) {
			$current = '';
			if($media_img_count == 1){
				$current = 'current'; 
			}
            $html.='<div>';
			$html.= '<div class="top-left" data-name="'.$value['camera_name'].'" >'.$value['camera_name'].'</div>';
            $html.='<img src="'.$value['Path'].'">';
            $html.='</div>';
            //$html.='</li>';
            $media_img_count++;
		}
		$html.='</div>';
		$html.='</div>';
		//$html.='</ul>';


		$html01='';
		$media_count = 1;	
		foreach ($getitems as $key => $value) {
			if (!empty(@$value['Type'])) {
				$expl_time = explode('.', @$value['Type']);
				$expl_time1 = $expl_time[0];
				$expl_time2 = explode('_', $expl_time1);
				
				$Newtime = $expl_time2[0].' '.@$expl_time2[1];
				if($media_count == 1){
					$html01.= $Newtime; 
				}
			}
			 $media_count++;
		}

		$data['error'] = false;
		$data['tab_data'] = $html;
		$data['tab_data_img'] = $html01;
		echo json_encode($data);
		die;

	}



	public function sytemstatus(){
		$validateLogin = $this->validateLogin();
		$data['Name']=$validateLogin['Name'];
		$data['Surname']=$validateLogin['Surname'];
		$data['heading_title']='System status';
		$data['active']='sytemstatus';
		$data['submenuactive']='';

		$get_wind_turbine = $this->Dashboardmodel->get_wind_turbine();
		$computers = array();
		foreach ($get_wind_turbine as $key => $value) {
			$turbineID = $value['ID'];
			$get_computers_by_id = $this->Dashboardmodel->get_computers_by_id($turbineID);
			if ($get_computers_by_id!='') {
				foreach ($get_computers_by_id as $key => $value1) {
					$computerID = $value1['ID'];
					$Current_time = date("Y-m-d H:i:s", strtotime('+4 hours 30 minutes'));
					// echo "<br>"; 
					$Before_time = date("Y-m-d H:i:s", strtotime('+4 hours 25 minutes'));
					// die;
					$get_system_status_by_id = $this->Dashboardmodel->get_system_status_by_id($computerID,$Current_time,$Before_time);
					// echo "<pre>"; 
					// print_r($get_system_status_by_id);
					// echo "</pre>";
					$datas = array();
					foreach ($get_system_status_by_id as $key => $value2) {
						 $datas['test'] = $value2['Device'];
						// $Devices[] = $datas;
					}
					$computer = $datas;
					$computers[] = $computer;
				}	

			}
		}
		$data['computers'] = $computers;	
		$data['get_wind_turbine'] = $get_wind_turbine;
		$this->load->view('sytemstatus',$data);
	}

	public function record(){
		$validateLogin = $this->validateLogin();
		$data['Name']=$validateLogin['Name'];
		$data['Surname']=$validateLogin['Surname'];
		$data['heading_title']='Records';
		$data['active']='record';
		$data['submenuactive']='';
		$this->load->view('record',$data);
	}

	public function reporting(){
		$validateLogin = $this->validateLogin();
		$data['Name']=$validateLogin['Name'];
		$data['Surname']=$validateLogin['Surname'];
		$data['heading_title']='Reporting';
		$data['active']='reporting';
		$data['submenuactive']='';
		$this->load->view('reporting',$data);
	}

	public function register(){
		$validateLogin = $this->validateLogin();
		$data['Name']=$validateLogin['Name'];
		$data['Surname']=$validateLogin['Surname'];
		$data['heading_title']='Register';
		$data['active']='register';
		$data['submenuactive']='';
		$this->load->view('register',$data);
	}

	public function contact(){
		$validateLogin = $this->validateLogin();
		$data['Name']=$validateLogin['Name'];
		$data['Surname']=$validateLogin['Surname'];
		$data['heading_title']='Contact';
		$data['active']='contact';
		$data['submenuactive']='';
		$this->load->view('contact',$data);
	}


	private function validateLogin(){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			$array_items = array('UserID' =>'','logged_in' =>false);
			$this->session->unset_userdata($array_items);
			redirect('/');
			exit();   
		}
		$sess = $this->session->userdata();
		$name = $sess['name'];
		$name_expl = explode(' ', $name);
		
		$data['Name'] = $name_expl[0];
		$data['Surname'] = $name_expl[1];

		return $data;
		
	} 
}
