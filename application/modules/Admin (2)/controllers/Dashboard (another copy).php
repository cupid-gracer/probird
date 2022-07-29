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
		$get_first_cluster = $this->Dashboardmodel->get_first_cluster();
		$getitems = array();
		$getitems_first = array();
		$get_wt_packs_in_cluster = $this->Dashboardmodel->get_wt_packs_in_cluster($get_first_cluster['ID']);
		$wt_packs_cluster_count = 1;
		foreach ($get_wt_packs_in_cluster as $key => $value02) {
			if($wt_packs_cluster_count == 1){
				$default_limit = 500;
				$get_medias_first = $this->Dashboardmodel->get_media_first_by_wt_pack_id($value02['WT_pack_ID'],$default_limit);
				foreach ($get_medias_first as $key => $value) {
					$get_item_arr_first = array();
					$get_item_arr_first['WT_pack_ID'] =  $value02['WT_pack_ID'];
					$get_wind_turbine_pack = $this->Dashboardmodel->get_wind_turbine_pack_by_wt_pack_id($value02['WT_pack_ID']); // Rishabh (Get Camera Name)
					$get_item_arr_first['camera_name']  = $get_wind_turbine_pack['camera_name']; // Rishabh (Get Camera Name)
					$get_item_arr_first['File_name'] = $value['File_name'];	
					$get_item_arr_first['Path']  = $value['Path'];
					$get_item_arr_first['ID']  = $value['ID'];
					$getitems_first[] = $get_item_arr_first;
				}			
			}
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
				$get_item_arr['File_name']  = $value['File_name'];	
				$get_item_arr['path']  = $value['Path'];
				$get_item_arr['ID']  = $value['ID'];
				$getitems[] = $get_item_arr;
			}
			$wt_packs_cluster_count++;
		}
		$data['getitems_first_five_images'] = $getitems_first;
		$get_all_piform[$get_first_cluster['ID']] = $getitems;
		$data['get_medias_images'] = $get_all_piform;

		/*$limit = 50000;
		$limit = 10000;
		$get_probird_orders_data = $this->Dashboardmodel->get_probird_orders($limit);
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
		$data['get_bird_data'] = $probirds;*/

		$get_cameras_in_cluster_by_clusterid = $this->Dashboardmodel->get_cameras_in_cluster_by_clusterid($get_first_cluster['ID']);
		$probirds_arrs = array();

		if(count($get_cameras_in_cluster_by_clusterid) > 0){

			$probirds_arr = array();
			$probirds_arr['Time_Stamp'] = '';
			$probirds_arr['birddate'] = '';
			$probirds_arr['birdtime'] = '22.0000';
			$probirds_arr['Value'] = '';
			$probirds_arr['opc_order_id'] = '0';
			$probirds_arr['Wind_Turbine'] = '';
			$probirds_arrs[] = $probirds_arr;

			$probirds_arr = array();
			$probirds_arr['Time_Stamp'] = '';
			$probirds_arr['birddate'] = '';
			$probirds_arr['birdtime'] = '1';
			$probirds_arr['Value'] = '';
			$probirds_arr['opc_order_id'] = '0';
			$probirds_arr['Wind_Turbine'] = '';
			$probirds_arrs[] = $probirds_arr;


			foreach ($get_cameras_in_cluster_by_clusterid as $key => $get_cameras_in_cluster) {
				$get_probird_orders_by_camera_id = $this->Dashboardmodel->get_probird_orders_by_camera_id($get_cameras_in_cluster['Camera_ID']);
				if(count($get_probird_orders_by_camera_id) > 0){
					foreach ($get_probird_orders_by_camera_id as $key => $get_probird_orders) {
						$probirds_arr = array();
						$probirds_arr['Time_Stamp'] = $get_probird_orders['Time_Stamp'];
						$exp_time = explode(' ', $probirds_arr['Time_Stamp']);
						$probirds_arr['birddate'] = $exp_time[0];
						$get_bird_exp_1 = $exp_time[1];
						$get_bird_exp_2 = explode(':', $get_bird_exp_1);
						$probirds_arr['birdtime'] = $get_bird_exp_2[0].'.'.$get_bird_exp_2[1].$get_bird_exp_2[2];
			 			$probirds_arr['Value'] = $get_probird_orders['Value'];
			 			$probirds_arr['opc_order_id'] = $get_probird_orders['ID'];
						$probirds_arr['Wind_Turbine'] = $get_probird_orders['Wind_Turbine'];
						$probirds_arrs[] = $probirds_arr;
						
					}
				}
			}
		}
		

		$data['get_bird_data'] = $probirds_arrs;

		$get_cameras_list = $this->Dashboardmodel->get_cameras();
		$camera_arrays = array();
		foreach ($get_cameras_list as $key => $get_camera) {
			$camera_arr = array();
			$get_cameras_in_cluster_by_cameraid = $this->Dashboardmodel->get_cameras_in_cluster_by_cameraid($get_camera['ID']);
			$camera_arr['camera_name'] = $get_camera['Name'];
			$camera_arr['camera_id'] = $get_camera['ID'];

			$camera_cluster_arrs = array();
			foreach ($get_cameras_in_cluster_by_cameraid as $key => $values) {
				$camera_cluster_arr = array();
				$get_single_cluster = $this->Dashboardmodel->get_single_cluster($values['Cluster_ID']);
				$camera_cluster_arr['cluster_name'] = $get_single_cluster['Name'];
				$camera_cluster_arr['cluster_id'] = $get_single_cluster['ID'];

				/*if($get_camera['ID'] == $values['Cluster_ID'] ){
					$camera_cluster_arr['active_blue_cls'] = 'active_blue_cls';
				}*/
				$camera_cluster_arrs[] = $camera_cluster_arr;
			}
			$camera_arr['clusters'] = $camera_cluster_arrs;
			$camera_arrays[] = $camera_arr;
		}
		$data['get_cameras_list'] = $get_cameras_list;
		$data['get_camera_clusters'] = $camera_arrays;

		$this->load->view('dashboard',$data);
	}

	public function get_wt_packs_in_cluster(){

		$data = array();
		$data['error'] = true;

		$getitems = array();
		$getitems_first = array();
		$get_wt_packs_in_cluster = $this->Dashboardmodel->get_wt_packs_in_cluster($_POST['ClusterID']);
		$wt_packs_cluster_count = 1;
		foreach ($get_wt_packs_in_cluster as $key => $value02) {
			$get_medias = $this->Dashboardmodel->get_media_by_wt_pack_id($value02['WT_pack_ID']);
			if($wt_packs_cluster_count == 1){
				$default_limit = 500;
				$get_medias_first = $this->Dashboardmodel->get_media_first_by_wt_pack_id($value02['WT_pack_ID'],$default_limit);
				foreach ($get_medias_first as $key => $value) {
					$get_item_arr_first = array();
					$get_item_arr_first['WT_pack_ID'] =  $value02['WT_pack_ID'];
					$get_wind_turbine_pack = $this->Dashboardmodel->get_wind_turbine_pack_by_wt_pack_id($value02['WT_pack_ID']); // Rishabh (Get Camera Name)
					$get_item_arr_first['camera_name']  = $get_wind_turbine_pack['camera_name']; // Rishabh (Get Camera Name)
					$get_item_arr_first['File_name'] = $value['File_name'];	
					$get_item_arr_first['Path']  = $value['Path'];
					$get_item_arr_first['ID']  = $value['ID'];
					$getitems_first[] = $get_item_arr_first;
				}			
			}
			foreach ($get_medias as $key => $value) {
				$get_item_arr = array();
				$get_item_arr['WT_pack_ID'] =  $value02['WT_pack_ID'];

				$get_wind_turbine_pack = $this->Dashboardmodel->get_wind_turbine_pack_by_wt_pack_id($value02['WT_pack_ID']); // Rishabh (Get Camera Name)
				$get_item_arr['camera_name']  = $get_wind_turbine_pack['camera_name']; // Rishabh (Get Camera Name)

				$get_item_arr['File_name'] = $value['File_name'];	
				$get_item_arr['Path']  = $value['Path'];
				$get_item_arr['ID']  = $value['ID'];
				$getitems[] = $get_item_arr;
			}
			$wt_packs_cluster_count++;
		}

		$html_side='';
		foreach ($getitems as $key => $getitem) {
			$html_side.='<div class="custom_slide" data-id="'.$getitem['WT_pack_ID'].'" >';
			$html_side.= '<div class="top_camera_right" data-name="'.$getitem['camera_name'].'" >'.$getitem['camera_name'].'</div>';
            $html_side.='<img src="'.$getitem['Path'].'">';
			$html_side.='</div>';
		}
		
		$html='';
		$html.='<div class="content-carousel">';
        $html.='<div class="owl-carousel">';
		
		$media_img_count = 1;
		if(count($getitems_first) > 0){
			foreach ($getitems_first as $key => $value) {
				$current = '';
				if($media_img_count == 1){
					$current = 'current'; 
				}
	            $html.='<div>';
				$html.= '<div class="top-left" data-name="'.$value['camera_name'].'" >'.$value['camera_name'].'</div>';
	            $html.='<img src="'.$value['Path'].'">';
	            $html.='<div class="get_cluster_time">';
	            if (!empty(@$value['File_name'])) {
					 $value['File_name'];
					$expl_un = explode('_', @$value['File_name']);
					$date = $expl_un[1];


					$expl_dot = explode('.', $expl_un[2]);
					$time = $expl_dot[0];
				
					
					$Newtime = $date.' '.$time;
					$html.= $Newtime; 
				}
				$html.='</div>'; //get_cluster_time
	            $html.='</div>';
	            $media_img_count++;
			}
			$html.='<div class="lastslide_item">';
			$html.='<a href="'.base_url('admin/reporting').'"> Please use Records page to download more images </a>';
			$html.='</div>';
		}else{
			$html.='<div class="lastslide_item">';
			$html.='<a href="#"> Data Not Found </a>';
			$html.='</div>';
		}


		$html.='</div>';
		$html.='</div>';

		$data['error'] = false;
		$data['tab_data'] = $html;
		$data['tab_data_side'] = $html_side;
		//$data['cluster_graph_data'] = $probirds_arrs;
		echo json_encode($data);
		die;
	}

	public function get_graph_by_cluster(){
		$data = array();
		$data['error'] = true;
		$get_cameras_in_cluster_by_clusterid = $this->Dashboardmodel->get_cameras_in_cluster_by_clusterid($_POST['ClusterID']);
		$probirds_arrs = array();

		
		$upload_filename = '';
		$camera_id_arr = array();
		if(count($get_cameras_in_cluster_by_clusterid) > 0){

			$probirds_arr = array();
			$probirds_arr['Time_Stamp'] = '';
			$probirds_arr['birddate'] = '';
			$probirds_arr['birdtime'] = '22.0000';
			$probirds_arr['Value'] = '';
			$probirds_arr['opc_order_id'] = '0';
			$probirds_arr['Wind_Turbine'] = '';
			$probirds_arrs[] = $probirds_arr;

			$probirds_arr = array();
			$probirds_arr['Time_Stamp'] = '';
			$probirds_arr['birddate'] = '';
			$probirds_arr['birdtime'] = '1';
			$probirds_arr['Value'] = '';
			$probirds_arr['opc_order_id'] = '0';
			$probirds_arr['Wind_Turbine'] = '';
			$probirds_arrs[] = $probirds_arr;

			foreach ($get_cameras_in_cluster_by_clusterid as $key => $get_cameras_in_cluster) {
				//echo $get_cameras_in_cluster['Camera_ID'].'<br>';
				$get_probird_orders_by_camera_id = $this->Dashboardmodel->get_probird_orders_by_camera_id($get_cameras_in_cluster['Camera_ID']);
				if(count($get_probird_orders_by_camera_id) > 0){
					foreach ($get_probird_orders_by_camera_id as $key => $get_probird_orders) {
						$probirds_arr = array();
						$probirds_arr['Time_Stamp'] = $get_probird_orders['Time_Stamp'];
						$exp_time = explode(' ', $probirds_arr['Time_Stamp']);
						$probirds_arr['birddate'] = $exp_time[0];
						$get_bird_exp_1 = $exp_time[1];
						$get_bird_exp_2 = explode(':', $get_bird_exp_1);
						$probirds_arr['birdtime'] = $get_bird_exp_2[0].'.'.$get_bird_exp_2[1].$get_bird_exp_2[2];
			 			$probirds_arr['Value'] = $get_probird_orders['Value'];
			 			$probirds_arr['opc_order_id'] = $get_probird_orders['ID'];
						$probirds_arr['Wind_Turbine'] = $get_probird_orders['Wind_Turbine'];
						$probirds_arrs[] = $probirds_arr;
					}
				}
				//$camera_id_arr[] = $get_cameras_in_cluster['Camera_ID'];
			}
		}

		//print_r($camera_id_arr);
		/*$Camera_ID = implode(",",$camera_id_arr);

		$get_probird_orders_by_camera_id = $this->Dashboardmodel->get_probird_orders_by_camera_id($camera_id_arr);
		if(count($get_probird_orders_by_camera_id) > 0){
			foreach ($get_probird_orders_by_camera_id as $key => $get_probird_orders) {
				$probirds_arr = array();
				$probirds_arr['Time_Stamp'] = $get_probird_orders['Time_Stamp'];
				$exp_time = explode(' ', $probirds_arr['Time_Stamp']);
				$probirds_arr['birddate'] = $exp_time[0];
				$get_bird_exp_1 = $exp_time[1];
				$get_bird_exp_2 = explode(':', $get_bird_exp_1);
				$probirds_arr['birdtime'] = $get_bird_exp_2[0].'.'.$get_bird_exp_2[1].$get_bird_exp_2[2];
	 			$probirds_arr['Value'] = $get_probird_orders['Value'];
				$probirds_arr['Wind_Turbine'] = $get_probird_orders['Wind_Turbine'];
				$probirds_arrs[] = $probirds_arr;
			}
		}*/

		
		$data['error'] = false;
		$data['cluster_graph_data'] = $probirds_arrs;
		echo json_encode($data);
		die;
	}

	public function get_slider_by_wt_pack_id(){
		$WT_pack_ID = $_POST['WT_pack_ID'];
		$default_limit = 500;
		$get_medias_first = $this->Dashboardmodel->get_media_first_by_wt_pack_id($WT_pack_ID,$default_limit);
		$getitems_first = array();
		if(count($get_medias_first) > 0){
			foreach ($get_medias_first as $key => $value) {
				$get_item_arr_first = array();
				$get_item_arr_first['WT_pack_ID'] =  $WT_pack_ID;
				$get_wind_turbine_pack = $this->Dashboardmodel->get_wind_turbine_pack_by_wt_pack_id($WT_pack_ID); // Rishabh (Get Camera Name)
				$get_item_arr_first['camera_name']  = $get_wind_turbine_pack['camera_name']; // Rishabh (Get Camera Name)
				$get_item_arr_first['File_name'] = $value['File_name'];	
				$get_item_arr_first['Path']  = $value['Path'];
				$get_item_arr_first['ID']  = $value['ID'];
				$getitems_first[] = $get_item_arr_first;
			}
		}

		$html='';
		$html.='<div class="content-carousel">';
        $html.='<div class="owl-carousel">';
		
		if(count($getitems_first) > 0){
			$media_img_count = 1;
			foreach ($getitems_first as $key => $value) {
				$current = '';
				if($media_img_count == 1){
					$current = 'current'; 
				}
	            $html.='<div data-id="'.$value['ID'].'" WT-pack-ID="'.$WT_pack_ID.'"  >';
				$html.= '<div class="top-left" data-name="'.$value['camera_name'].'" >'.$value['camera_name'].'</div>';
	            $html.='<img src="'.$value['Path'].'">';
	            $html.='<div class="get_cluster_time">';
	            if (!empty(@$value['File_name'])) {
					 $value['File_name'];
					$expl_un = explode('_', @$value['File_name']);
					$date = $expl_un[1];


					$expl_dot = explode('.', $expl_un[2]);
					$time = $expl_dot[0];
				
					
					$Newtime = $date.' '.$time;
					$html.= $Newtime; 
				}
				$html.='</div>'; //get_cluster_time
	            $html.='</div>';
	            $media_img_count++;
			}
			$html.='<div class="lastslide_item">';
			$html.='<a href="'.base_url('admin/reporting').'"> Please use Records page to download more images </a>';
			$html.='</div>';
		}else{
			$html.='<div class="lastslide_item">';
			$html.='<a href="'.base_url('admin').'"> Please use Records page to download more images </a>';
			$html.='</div>';
		}
		$html.='</div>';
		$html.='</div>';

		$data['error'] = false;
		$data['tab_data'] = $html;
		echo json_encode($data);
		die;
	}

	public function sytemstatus_old_rishabh(){
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

	/* Abhishek */
	public function records(){
		$validateLogin = $this->validateLogin();
		
		/*$this->load->library('zip');
		$filepath1 = UPLOADMEDIAROOT.'/Capespigne/80/2021-12-16/Videos/CAP-80_2021-12-16_13h52m21ss.mp4';
        $filepath2 = UPLOADMEDIAROOT.'/Capespigne/80/2021-12-16/Pictures/CAP-80_2021-12-16_02h31m52ss.jpg';
        // Add file
        $this->zip->read_file($filepath1);
        $this->zip->read_file($filepath2);
        // Download
        $filename = "test-backup.zip";
        $this->zip->download($filename);*/

		$data['Name']=$validateLogin['Name'];
		$data['Surname']=$validateLogin['Surname'];
		$data['heading_title']='Records';
		$data['active']='record';
		$data['submenuactive']='';
		$data['get_clusters'] =$this->Dashboardmodel->get_clusters();
		$default_camera_arrs = array();
		$get_first_cluster = $this->Dashboardmodel->get_first_cluster();

		//$data['get_cameras_list'] = $this->Dashboardmodel->get_cameras();

		$get_cameras_in_cluster_by_clusterid = $this->Dashboardmodel->get_cameras_in_cluster_by_clusterid($get_first_cluster['ID']);
		foreach($get_cameras_in_cluster_by_clusterid as $key => $get_camera_value) {
			$camera_arr = array();
			$get_camera_detail = $this->Dashboardmodel->get_camera_detail($get_camera_value['Camera_ID']);
			$camera_arr['CameraID'] = $get_camera_detail['ID'];
			$camera_arr['CameraName'] = $get_camera_detail['Name'];
			$default_camera_arrs[] = $camera_arr;
		}
		$data['get_default_cameras'] = $default_camera_arrs;

		if ($this->input->server('REQUEST_METHOD') == 'POST'){

			$this->load->library('zip');
			/*$filepath1 = UPLOADMEDIAROOT.'/Capespigne/80/2021-12-16/Videos/CAP-80_2021-12-16_13h52m21ss.mp4';
	        $filepath2 = UPLOADMEDIAROOT.'/Capespigne/80/2021-12-16/Pictures/CAP-80_2021-12-16_02h31m52ss.jpg';
	        // Add file
	        $this->zip->read_file($filepath1);
	        $this->zip->read_file($filepath2);
	        // Download
	        $filename = "test-backup.zip";
	        $this->zip->download($filename);*/

			$FromDateTime = $_POST['from_date'].' '.$_POST['from_time'];
			$ToDateTime   = $_POST['to_date'].' '.$_POST['to_time'];
			//$get_download_data = $this->Dashboardmodel->get_send_to_opc_orders_cameraid_inarray($_POST['camera_id'],$FromDateTime,$ToDateTime);
			//print_r($_POST['camera_id']);
			$Camera_IDs = $_POST['camera_id'];
			$get_download_data = $this->Dashboardmodel->get_send_to_opc_orders_cameraid_inarray($_POST['camera_id'],$FromDateTime,$ToDateTime);
			
			$final_arrs = array();
			foreach ($get_download_data as $key => $download_data) {
				$get_probird_status = $this->Dashboardmodel->get_probird_status_by_opc_order_id($download_data['ID']);
				
				/*echo "<pre>";
				print_r($get_probird_status);
				echo "</pre>";*/
				
				$Time_Stamp = $get_probird_status['Time_Stamp'];
				$Camera_ID = $get_probird_status['Camera_source'];
				$exp_time = explode(' ', $get_probird_status['Time_Stamp']);
				$final_date= $exp_time[0];
				$get_bird_exp_1 = $exp_time[1];
				$get_bird_exp_2 = explode(':', $get_bird_exp_1);
				$final_time = $get_bird_exp_2[0].'h'.$get_bird_exp_2[1].'m'.$get_bird_exp_2[2].'ss';
				$get_camera = $this->Dashboardmodel->get_camera_by_cameraid($download_data['Camera_source']);
				$file_name = 'Capespigne-'.$get_camera['IP'].'_'.$final_date.'_'.$final_time.'.mp4';

		        
				$directory = '/media/Capespigne';
		        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
		        if(in_array($get_camera['IP'], $scanned_directory)){

		        	$directory = '/media/Capespigne/'.$get_camera['IP'];
		        	$scanned_directory = array_diff(scandir($directory), array('..', '.'));
		        	if(in_array($final_date, $scanned_directory)){
		        		$directory = '/media/Capespigne/'.$get_camera['IP'].'/'.$final_date;
		        		$scanned_directory = array_diff(scandir($directory), array('..', '.'));
		        		if(in_array('Videos', $scanned_directory)){
		        			$directory = '/media/Capespigne/'.$get_camera['IP'].'/'.$final_date.'/Videos';
		        			$scanned_directory = array_diff(scandir($directory), array('..', '.'));
					        $final_time_remove_h = str_replace("h",":",$final_time);
					        $final_time_remove_mn = str_replace("m",":",$final_time_remove_h);
					        $final_time_remove_ss = str_replace("ss","",$final_time_remove_mn);

					        

					        //echo $final_date.' '.$final_time_remove_ss;
					        $final_time_remove_ss = strtotime($final_date.' '.$final_time_remove_ss);
					        //$final_time_remove_ss = strtotime('2021-12-16 09:08:46'); // Just For Test Multiple Videos
					        /*foreach ($scanned_directory as $key => $value) {
						        $string_remove1 = str_replace("CAP","",$value);
						        $string_remove1 = str_replace("-".$get_camera['IP'],"",$string_remove1);
						        $string_remove1 = str_replace("_".$final_date."_","",$string_remove1);
						        $string_remove1 = str_replace(".mp4","",$string_remove1);
						        $string_hour = str_replace("h","",$string_remove1);
						        $string_minute = str_replace("m","",$string_hour);
						        $string_sec = str_replace("ss","",$string_minute);
						        //echo mktime((int)$string_hour,(int)$string_minute,(int)$string_sec);
						        $arr1 = str_split($string_sec,2);
								$arr2 = implode(':', $arr1);
						        $timestamp = strtotime($final_date.' '.$arr2);

						        $timestamp_minus_30 = strtotime("-30 seconds", strtotime($final_date.' '.$arr2));
						        $timestamp_plus_5 = strtotime("+5 seconds", strtotime($final_date.' '.$arr2));
						        //if( $final_time_remove_ss >= $timestamp_minus_30 &&  $final_time_remove_ss <= $timestamp_plus_5 ){
						        	$final_arr = array();
						        	$final_arr['file_path'] = $value;
						        	echo $file_path = UPLOADMEDIAROOT.'Capespigne/'.$get_camera['IP'].'/'.$final_date.'/Videos/'.$value;
						        	echo "<br>";
							        //$this->zip->read_file($file_path);

						        	$final_arr['file_size'] = filesize($file_path);
						        	$final_arrs[] = $final_arr;
						        	
						        //}
					        }*/
		        		}
		        	}
		        }
			}

			/*$filename = "test-backup.zip";
	        $this->zip->download($filename);*/

			/*echo "<pre>";
			print_r($final_arrs);
			echo "</pre>";*/
			die();
		}

		$this->load->view('record',$data);
	}

	public function get_cameras_by_clusterid(){
		$response_arr = array();
		$response_arr['error'] = true;
		$Cluster_ID = $_POST['Cluster_ID'];
		$get_cameras_in_cluster_by_clusterid = $this->Dashboardmodel->get_cameras_in_cluster_by_clusterid($Cluster_ID);
		$html_camera = '';
		foreach($get_cameras_in_cluster_by_clusterid as $key => $get_camera_value) {
			$get_camera_detail = $this->Dashboardmodel->get_camera_detail($get_camera_value['Camera_ID']);
			$html_camera.= '<li>';
            $html_camera.= '<label>';
            $html_camera.= '<input type="checkbox" name="camera_id[]" value="'.$get_camera_value['Camera_ID'].'" >';
            $html_camera.= '<label>'.$get_camera_detail['Name'].'</label>';
            $html_camera.= '</label>';
            $html_camera.= '</li>';
		}
        $response_arr['camera_list'] =  $html_camera;
		$response_arr['error'] = false;
        echo json_encode($response_arr);
        die();
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

	public function upload_reporting(){
		$validateLogin = $this->validateLogin();

		if($this->session->userdata('user_role') == 1){
			$data['Name']=$validateLogin['Name'];
			$data['Surname']=$validateLogin['Surname'];
			$data['heading_title']='Upload Reporting';
			$data['active']='register';
			$data['submenuactive']='';

			$errors_msg= array();
			if ($this->input->server('REQUEST_METHOD') == 'POST'){
				if(isset($_FILES['report_file'])){
			      $file_name = $_FILES['report_file']['name'];
			      $file_size =$_FILES['report_file']['size'];
			      $file_tmp =$_FILES['report_file']['tmp_name'];
			      $file_type=$_FILES['report_file']['type'];
			      //$file_ext=strtolower(end(explode('.',$_FILES['report_file']['name'])));
			      
			      /*$extensions= array("jpeg","jpg","png");
			      
			      if(in_array($file_ext,$extensions)=== false){
			         $errors['msg']="extension not allowed, please choose a JPEG or PNG file.";
			      }*/
			      
			      if($file_size > 2097152){
			         $errors_msg['error']='true';
			         $errors_msg['msg']='File size must be excately 2 MB';
			         $this->session->set_flashdata('success', 'File size must be excately 2 MB');
			      }
			      
			      if(empty($errors)==true){
			         move_uploaded_file($file_tmp,"media/Capespigne/docs/Repport/".time().'-'.$file_name);
			         $errors_msg['error']='false';
			         $errors_msg['msg']='Success';
			         $this->session->set_flashdata('success', 'File Uploaded Successfully');
			      }else{
			         $this->session->set_flashdata('success', 'Technical Error');
			      }

			      redirect('admin/register');
				  exit();

			    }
			}
			$data['upload_msg'] = $errors_msg;
			$this->load->view('upload_reporting',$data);
		}else{
			redirect('admin/register/');
		}
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

	public function upload_register(){
		$validateLogin = $this->validateLogin();

		if($this->session->userdata('user_role') == 1){
			$data['Name']=$validateLogin['Name'];
			$data['Surname']=$validateLogin['Surname'];
			$data['heading_title']='Upload Register';
			$data['active']='register';
			$data['submenuactive']='';

			$errors_msg= array();
			if ($this->input->server('REQUEST_METHOD') == 'POST'){
				if(isset($_FILES['report_file'])){
			      $file_name = $_FILES['report_file']['name'];
			      $file_size =$_FILES['report_file']['size'];
			      $file_tmp =$_FILES['report_file']['tmp_name'];
			      $file_type=$_FILES['report_file']['type'];
			      //$file_ext=strtolower(end(explode('.',$_FILES['report_file']['name'])));
			      
			      /*$extensions= array("jpeg","jpg","png");
			      
			      if(in_array($file_ext,$extensions)=== false){
			         $errors['msg']="extension not allowed, please choose a JPEG or PNG file.";
			      }*/
			      
			      if($file_size > 2097152){
			         $errors_msg['error']='true';
			         $errors_msg['msg']='File size must be excately 2 MB';
			         $this->session->set_flashdata('success', 'File size must be excately 2 MB');
			      }
			      
			      if(empty($errors)==true){
			         move_uploaded_file($file_tmp,"media/Capespigne/docs/Register/".time().'-'.$file_name);
			         $errors_msg['error']='false';
			         $errors_msg['msg']='Success';
			      	 $this->session->set_flashdata('success', 'File Uploaded Successfully');
			      }else{
			         $this->session->set_flashdata('success', 'Technical Error');
			      }

			      redirect('admin/register');
				  exit();

			    }
			}
			$data['upload_msg'] = $errors_msg;
			$this->load->view('upload_register',$data);
		}else{
			redirect('admin/register/');
		}
	}
	

	public function contact(){
		$validateLogin = $this->validateLogin();
		$data['Name']=$validateLogin['Name'];
		$data['Surname']=$validateLogin['Surname'];
		$data['heading_title']='Contact';
		$data['active']='contact';
		$data['submenuactive']='';

		$get_wind_farms = $this->Dashboardmodel->get_wind_farms();
		$get_entities = $this->Dashboardmodel->get_entities();

		$get_people_arrs = array();
		foreach ($get_entities as $key => $entity_val) {
			$get_people_arr = array();
			$get_people_arr['ID'] = $entity_val['ID'];
			$get_people_arr['Type'] = $entity_val['Type'];
			$get_people_arr['Name'] = $entity_val['Name'];
			$get_people_arr['get_people']  = $this->Dashboardmodel->get_people_by_EntityID($entity_val['ID']);
			$get_people_arrs[] = $get_people_arr;
		}
		
		$data['get_contacts'] = $get_people_arrs;
		$this->load->view('contact',$data);
	}

	public function graphtest(){
		$validateLogin = $this->validateLogin();
		$data['Name']=$validateLogin['Name'];
		$data['Surname']=$validateLogin['Surname'];

		$data['heading_title']='Dashboard';
		$data['active']='dashboard';
		$data['submenuactive']='';
		$clusterid = 9;
		$get_cameras_in_cluster_by_clusterid = $this->Dashboardmodel->get_cameras_in_cluster_by_clusterid($clusterid);

		$probirds_arrs = array();
		if(count($get_cameras_in_cluster_by_clusterid) > 0){
			foreach ($get_cameras_in_cluster_by_clusterid as $key => $get_cameras_in_cluster) {
				
				$get_probird_orders_by_camera_id = $this->Dashboardmodel->get_probird_orders_by_camera_id($get_cameras_in_cluster['Camera_ID']);
				if(count($get_probird_orders_by_camera_id) > 0){
					foreach ($get_probird_orders_by_camera_id as $key => $get_probird_orders) {
						$probirds_arr = array();
						$probirds_arr['Time_Stamp'] = $get_probird_orders['Time_Stamp'];
						$exp_time = explode(' ', $probirds_arr['Time_Stamp']);
						$probirds_arr['birddate'] = $exp_time[0];
						$get_bird_exp_1 = $exp_time[1];
						$get_bird_exp_2 = explode(':', $get_bird_exp_1);
						$probirds_arr['birdtime'] = $get_bird_exp_2[0].'.'.$get_bird_exp_2[1].$get_bird_exp_2[2];
			 			$probirds_arr['Value'] = $get_probird_orders['Value'];
			 			$probirds_arr['opc_order_id'] = $get_probird_orders['ID'];
						$probirds_arr['Wind_Turbine'] = $get_probird_orders['Wind_Turbine'];
						$probirds_arrs[] = $probirds_arr;
					}
				}
			}
		}
		$data['get_bird_data'] = $probirds_arrs;

		$this->load->view('graphdemo',$data);
	}

	public function get_video_by_opc_order_id(){
		$response_arr = array();
		$response_arr['error'] = true;
		if($_POST['opc_order_id'] > 0){
			$opc_order_id = $_POST['opc_order_id'];
			$get_probird_status = $this->Dashboardmodel->get_probird_status_by_opc_order_id($opc_order_id);
			$Time_Stamp = $get_probird_status['Time_Stamp'];
			$Camera_ID = $get_probird_status['Camera_source'];
			$exp_time = explode(' ', $get_probird_status['Time_Stamp']);
			$final_date= $exp_time[0];
			$get_bird_exp_1 = $exp_time[1];
			$get_bird_exp_2 = explode(':', $get_bird_exp_1);
			$final_time = $get_bird_exp_2[0].'h'.$get_bird_exp_2[1].'m'.$get_bird_exp_2[2].'ss';
			$get_camera = $this->Dashboardmodel->get_camera_by_cameraid($Camera_ID);
			$file_name = 'CAP-'.$get_camera['IP'].'_'.$final_date.'_'.$final_time.'.mp4';

	        $final_arrs = array();
			$directory = '/media/Capespigne';
	        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
	        if(in_array($get_camera['IP'], $scanned_directory)){
	        	$directory = '/media/Capespigne/'.$get_camera['IP'];
	        	$scanned_directory = array_diff(scandir($directory), array('..', '.'));
	        	if(in_array($final_date, $scanned_directory)){
	        		$directory = '/media/Capespigne/'.$get_camera['IP'].'/'.$final_date;
	        		$scanned_directory = array_diff(scandir($directory), array('..', '.'));
	        		if(in_array('Videos', $scanned_directory)){
	        			$directory = '/media/Capespigne/'.$get_camera['IP'].'/'.$final_date.'/Videos';
	        			$scanned_directory = array_diff(scandir($directory), array('..', '.'));
				        $final_time_remove_h = str_replace("h",":",$final_time);
				        $final_time_remove_mn = str_replace("m",":",$final_time_remove_h);
				        $final_time_remove_ss = str_replace("ss","",$final_time_remove_mn);
				        //echo $final_date.' '.$final_time_remove_ss;
				        $final_time_remove_ss = strtotime($final_date.' '.$final_time_remove_ss);
				        //$final_time_remove_ss = strtotime('2021-12-16 09:08:46'); // Just For Test Multiple Videos
				        foreach ($scanned_directory as $key => $value) {
					        $string_remove1 = str_replace("CAP","",$value);
					        $string_remove1 = str_replace("-".$get_camera['IP'],"",$string_remove1);
					        $string_remove1 = str_replace("_".$final_date."_","",$string_remove1);
					        $string_remove1 = str_replace(".mp4","",$string_remove1);
					        $string_hour = str_replace("h","",$string_remove1);
					        $string_minute = str_replace("m","",$string_hour);
					        $string_sec = str_replace("ss","",$string_minute);
					        //echo mktime((int)$string_hour,(int)$string_minute,(int)$string_sec);
					        $arr1 = str_split($string_sec,2);
							$arr2 = implode(':', $arr1);
					        $timestamp = strtotime($final_date.' '.$arr2);

					        //$time = date("Y:m:d h:i:s", time() + 30);

					        $timestamp_minus_30 = strtotime("-30 seconds", strtotime($final_date.' '.$arr2));
					        //echo "<br>";
					        //echo $timestamp_minus_30_final =  date('Y-m-d H:i:s', $timestamp_minus_30);
					        //echo "<br>";
					        $timestamp_plus_5 = strtotime("+5 seconds", strtotime($final_date.' '.$arr2));
					        //echo "<br>";
            				//echo $timestamp_plus_5_final =  date('Y-m-d H:i:s', $timestamp_plus_5);
					        //echo "<br>";
					        //echo date('Y-m-d H:i:s',$final_time_remove_ss)." >= ".date('Y-m-d H:i:s',$timestamp_minus_30) .' && ' .date('Y-m-d H:i:s',$final_time_remove_ss) .' >= '.date('Y-m-d H:i:s',$timestamp_plus_5);
					        //echo "<br>";
					        if( $final_time_remove_ss >= $timestamp_minus_30 &&  $final_time_remove_ss <= $timestamp_plus_5 ){
					        	$final_arr = array();
					        	$final_arr['file_path'] = $value;
					        	$file_path = UPLOADMEDIAROOT.'Capespigne/'.$get_camera['IP'].'/'.$final_date.'/Videos/'.$value;
					        	$final_arr['file_size'] = filesize($file_path);
					        	$final_arrs[] = $final_arr;
					        	
					        }
				        }
	        		}
	        	}
	        }

	        $large_file_path = '';
	        if(count($final_arrs) > 1){
		        $max_file_size = 0;
		        foreach ($final_arrs as $key => $video_value) {
			        $max_file_size = max( array( $max_file_size, $video_value['file_size'] ) );
		        }
		        foreach ($final_arrs as $key => $value) {
		        	if(in_array($max_file_size, $value)){
		        		$large_file_path = UPLOADMEDIAROOT.'Capespigne/'.$get_camera['IP'].'/'.$final_date.'/Videos/'.$value['file_path'];
		        	}
		        }
			    //echo $max_file_size;
	        }else{
	        	foreach ($final_arrs as $key => $value) {
		        	$large_file_path = UPLOADMEDIAROOT.'Capespigne/'.$get_camera['IP'].'/'.$final_date.'/Videos/'.$value['file_path'];
		        }
	        }
	        $response_arr['url'] = $large_file_path;
	        $response_arr['error'] = false;
		}
        echo json_encode($response_arr);
        die();
	}

	public function sytemstatus(){
		$default_timezone = date_default_timezone_get();
		$date = new DateTime("now", new DateTimeZone($default_timezone) );
		
		/*echo $default_timezone = date_default_timezone_get();
        echo "<br>";
        $date = new DateTime("now", new DateTimeZone($default_timezone) );
        //$Current_time =  $date->format('Y-m-d H:i:s');

        $current_time_after = strtotime($date->format('Y-m-d H:i:s'));
        $current_time_after = $current_time_after + (1 * 60);
        echo $Current_time = date("Y-m-d H:i:s", $current_time_after);
        echo "<br>";
        $before_30_time = strtotime($date->format('Y-m-d H:i:s'));
        $before_30_time = $before_30_time - (2 * 60);
        echo $Before_time = date("Y-m-d H:i:s", $before_30_time);*/

		$validateLogin = $this->validateLogin();
		$data['Name']=$validateLogin['Name'];
		$data['Surname']=$validateLogin['Surname'];
		$data['heading_title']='System status';
		$data['active']='sytemstatus';
		$data['submenuactive']='';
		$main_arrs = array();

		$get_wind_turbines = $this->Dashboardmodel->get_wind_turbine();
        foreach ($get_wind_turbines as $key => $get_wind_turbine) {
            $get_cameras = $this->Dashboardmodel->get_cameras_by_wind_turbine_id($get_wind_turbine['ID']);
            $camera_arrs = array();
            $camera_arrs['wind_turbine_id']   = $get_wind_turbine['ID'];
            $camera_arrs['wind_turbine_name'] = $get_wind_turbine['Name'];
            $get_single_computer = $this->Dashboardmodel->get_computer_by_wind_turbine_id($get_wind_turbine['ID']);
            if($get_single_computer != ''){
            	//echo 'Computer ID ='.$get_single_computer['ID'].'<br>';
                $camera_arrs['computer_name'] = $get_single_computer['Name'];
            }else{
                $camera_arrs['computer_name'] = 'Not Available';
            }
            $system_status_arrs = array();
            $get_system_status = $this->Dashboardmodel->get_system_status_by_device_pc($get_wind_turbine['ID']);
            $camera_arrs['system_status_count'] = $get_system_status;


            $get_latest20_system_status = $this->Dashboardmodel->get_latest20_system_status_by_device_pc($get_wind_turbine['ID']);


            $latest20_system_status_arrs = array();
            foreach ($get_latest20_system_status as $key => $get_latest20_system_sts) {
                $latest20_system_status = array();
                $latest20_system_status['ScriptID'] = $get_latest20_system_sts['Script'];
                $latest20_system_status['Type'] = $get_latest20_system_sts['Type'];
                //$get_script = $this->Dashboardmodel->get_script_by_scriptid($get_latest20_system_sts['Script']);
                //$latest20_system_status['ScriptName'] = $get_script['Name'];
                $latest20_system_status_arrs[] = $latest20_system_status;
            }
            $camera_arrs['system_status_scripts'] = $latest20_system_status_arrs;
            
            $camera_arrs01 = array();
            foreach ($get_cameras as $key => $get_camera) {
                $camera_arr = array();
                $camera_arr['Name'] = $get_camera['Name'];
                $camera_arr['IP'] = $get_camera['IP'];
                $camera_arrs01[] = $camera_arr;
            }
            $camera_arrs['cameras'] = $camera_arrs01;
            

            /*foreach ($get_system_status as $key => $system_status) {
                $system_status_arr = array();
                $system_status_arr['ID'] = $system_status['ID'];
                $system_status_arr['Type'] = $system_status['Type'];
                $system_status_arr['TimeStamp'] = $system_status['TimeStamp'];
                $system_status_arr['Script'] = $system_status['Script'];
                $system_status_arr['Status'] = $system_status['Status'];
                $system_status_arrs[] = $system_status_arr;
            }
            $camera_arrs['system_status'] = $system_status_arrs;*/

            $main_arrs[$get_wind_turbine['ID']] = $camera_arrs;
        }

        /*echo "<pre>";
		print_r($main_arrs);
		echo "</pre>";*/

		$data['get_system_status'] = $main_arrs;

		/*--------------Get PLD Name--------------*/
		$get_wind_turbines_by_pdl = $this->Dashboardmodel->get_wind_turbine_by_pdl();
		foreach ($get_wind_turbines_by_pdl as $key => $wind_turbines_by_pdl) {
			$get_computers_by_pdl = $this->Dashboardmodel->get_computers_by_pdl($wind_turbines_by_pdl['ID']);
			$computer_pdl_arrs = array();
			foreach ($get_computers_by_pdl as $key => $computers_by_pdl) {
				$computer_pdl_arr = array();
				$computer_pdl_arr['Name'] = $computers_by_pdl['Name'];
				$computer_pdl_arrs[] = $computer_pdl_arr;
			}
		}
		$data['get_pdl_names'] = $computer_pdl_arrs;


		$this->load->view('system_status_test',$data);
	}

	/* Not Used ONly Backup */
	public function system_status_test(){

		/*echo $Current_time = date("Y-m-d H:i:s").'<br>';
		echo $Before_time = date("Y-m-d H:i:s", strtotime('0 hours -5 minutes')).'<br>';*/

		$validateLogin = $this->validateLogin();
		$data['Name']=$validateLogin['Name'];
		$data['Surname']=$validateLogin['Surname'];
		$data['heading_title']='System status';
		$data['active']='sytemstatus';
		$data['submenuactive']='';

		$main_arrs = array();
		$get_wind_turbines = $this->Dashboardmodel->get_wind_turbine();
		foreach ($get_wind_turbines as $key => $get_wind_turbine) {
			
			$get_cameras = $this->Dashboardmodel->get_cameras_by_wind_turbine_id($get_wind_turbine['ID']);
			$camera_arrs = array();
			$camera_arrs['wind_turbine_id']   = $get_wind_turbine['ID'];
			$camera_arrs['wind_turbine_name'] = $get_wind_turbine['Name'];
			$get_single_computer = $this->Dashboardmodel->get_computer_by_wind_turbine_id($get_wind_turbine['ID']);
			if($get_single_computer != ''){
				$camera_arrs['computer_name'] = $get_single_computer['Name'];
			}else{
				$camera_arrs['computer_name'] = 'Not Available';
			}

			$camera_arrs01 = array();
			foreach ($get_cameras as $key => $get_camera) {
				$camera_arr = array();
				$camera_arr['Name'] = $get_camera['Name'];
				$camera_arr['IP'] = $get_camera['IP'];
				$camera_arrs01[] = $camera_arr;
			}
			$camera_arrs['cameras'] = $camera_arrs01;
			
			$system_status_arrs = array();
			$get_system_status = $this->Dashboardmodel->get_system_status_by_device_pc($get_wind_turbine['ID']);
			foreach ($get_system_status as $key => $system_status) {
				$system_status_arr = array();
				$system_status_arr['ID'] = $system_status['ID'];
				$system_status_arr['Type'] = $system_status['Type'];
				$system_status_arr['TimeStamp'] = $system_status['TimeStamp'];
				$system_status_arrs[] = $system_status_arr;
			}
			$camera_arrs['system_status'] = $system_status_arrs;

			$main_arrs[$get_wind_turbine['ID']] = $camera_arrs;

		}
			$data['get_system_status'] = $main_arrs;
		/*echo "<pre>";
        print_r($main_arrs);
        echo "</pre>";*/
		/*echo $Current_time = date("Y-m-d H:i:s", strtotime('-2 day +8 hours 30 minutes')).'<br>';
		echo $Before_time = date("Y-m-d H:i:s", strtotime('-2 day +8 hours 25 minutes')).'<br>';*/
		$this->load->view('system_status_test',$data);
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
