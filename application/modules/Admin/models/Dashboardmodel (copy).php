<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboardmodel extends CI_Model {

	public function get_first_cluster(){
		//$query = $this->db->select()->from('clusters')->get();
		$query = $this->db->select()
                          ->from('clusters')
                          ->limit(1)
                          ->order_by("ID", "asc")
                          ->get();
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
	}

    function get_clusters(){
        $query = $this->db->select()->from('clusters')->get();
        return $query->result_array();
    }

    function get_single_cluster($Cluster_ID){
        $query = $this->db->get_where('clusters',array('ID'=>$Cluster_ID ));
        $result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
    }

    public function get_wt_packs_in_cluster($Cluster_ID){
		$query = $this->db->get_where('wt_packs_in_cluster',array('Cluster_ID'=>$Cluster_ID ));
		$result = $query->result_array();
        return $result;
	}

	public function get_cameras_in_cluster(){
		$query = $this->db->get('cameras_in_cluster');
		$result = $query->result_array();
        return $result;
	}

	public function get_cameras_in_cluster_by_clusterid($Cluster_ID){
		$query = $this->db->get_where('cameras_in_cluster',array('Cluster_ID'=>$Cluster_ID));
		$result = $query->result_array();
        return $result;
	}

	public function get_cameras_in_cluster_by_cameraid($Camera_ID){
		$query = $this->db->get_where('cameras_in_cluster',array('Camera_ID'=>$Camera_ID));
		$result = $query->result_array();
        return $result;
	}
	
	
	public function get_cameras(){
		$query = $this->db->get('cameras');
		$result = $query->result_array();
        return $result;
	}

	public function get_camera_detail($Camera_ID){
		$query = $this->db->get_where('cameras',array('ID'=>$Camera_ID));
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
	}

	

	public function get_media_by_wt_pack_id($WT_pack_ID){
		
		$query = $this->db->select()
                          ->from('medias')
                          ->limit(1)
                          ->where('WT_pack_ID',$WT_pack_ID)
                          ->where('Type','Picture')
                          ->order_by("ID", "desc")
                          ->get();
        return $query->result_array();
	}

	
	public function get_media_first_by_wt_pack_id($WT_pack_ID,$limit){
		//$current_date = '2021-12-09';
		//$current_date = date("Y-m-d");

		$query = $this->db->select()
                          ->from('medias')
                          ->limit($limit)
                          ->where('WT_pack_ID',$WT_pack_ID)
                          ->where('Type','Picture')
                          ->order_by("ID", "desc")
                          ->get();
        //$query = $this->db->select('*')->from('medias')->where("File_name LIKE '%$current_date%'")->where('WT_pack_ID',$WT_pack_ID)->order_by("ID", "desc")->limit($limit)->get();

        /*$query = $this->db->select('*')
							->from('medias')
							->where("File_name LIKE '%$current_date%'")
							->where('WT_pack_ID',$WT_pack_ID)
							->order_by("ID", "desc")
							->get();*/


        /*print_r($this->db->last_query());
        die();*/
        return $query->result_array();
	}

	/*public function get_media_by_wt_pack_id01($WT_pack_ID){

		$query = $this->db->select()
                          ->from('medias')
                          ->limit(1)
                          ->where_in('WT_pack_ID',$WT_pack_ID)
                          ->order_by("ID", "desc")
                          ->get();
        return $query->result_array();
	}*/
	
	public function get_wind_turbine_pack_by_wt_pack_id($WT_pack_ID){
		$query = $this->db->get_where('wind_turbine_pack',array('ID'=>$WT_pack_ID));
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
	}


	public function get_medias_test_by_wt_pack_id($WT_pack_ID){
		$query = $this->db->get_where('medias_test',array('ID'=>$WT_pack_ID));
		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
	}


	/*public function get_probird_orders($limit){    
        $query = $this->db->order_by("Time_Stamp", "desc")->get_where('send_to_opc_orders',array('Value !='=> 0),$limit);
        return $query->result_array();
	}*/

	/*public function get_probird_orders_by_camera_id000(){
		$query = $this->db->select('t3.*')
			     ->from('cameras_in_cluster as t1')
			     ->where('Cluster_ID',10)
			     ->join('probird_orders as t3', 't1.id = t2.faq_id', 'LEFT')
			     ->get();
	}*/

	public function get_probird_orders_by_camera_id($camera_id){
		$limit = 5000;
        $query = $this->db->order_by("Time_Stamp", "ASC")->get_where('send_to_opc_orders',array('Value !='=> 0, 'Camera_source' => $camera_id),$limit);

        /*echo $query->num_rows();
        echo "<pre>";
        print_r($this->db->last_query());
        echo "</pre>";
        echo "<br>";*/
        /*$query = $this->db->select()
                          ->from('send_to_opc_orders')
                          ->limit($limit)
                          ->where_in($camera_id)
						  ->where('Value !=', 0)
                          ->order_by("Time_Stamp", "desc")
                          ->get();
        print_r($this->db->last_query());
        die();*/

        return $query->result_array();
	}

	public function get_wind_turbine(){
        $query = $this->db->get_where('wind_turbine',array('ID !='=> 0,'Type'=> 'Wind Turbine'));
        return $query->result_array();
	}

	

	public function get_computers_by_id($turbineID){
        $query = $this->db->get_where('computers',array('Location'=> $turbineID));           
        return $query->result_array();
	}

	public function get_system_status_by_id($computerID,$Current_time,$Before_time){
       	$limit = 100;
        $this->db->select('*');
		$this->db->from('system_status');
		$this->db->limit($limit);
		if($computerID!=''){
			$this->db->where('Device',$computerID);
		}
		if($Current_time!='' AND $Before_time!=''){
			$this->db->where('TimeStamp <=', $Current_time);
			$this->db->where('TimeStamp >=', $Before_time);
		}
		$query = $this->db->get();
		
        return $query->result_array();
	}

	/* Abhishek 17 December 2021 System Status*/
	public function get_wind_farms(){
        $query = $this->db->get_where('wind_farm');
        return $query->result_array();
	}

	public function get_wind_turbine_by_wind_farm_id($wind_farm_id){
        $query = $this->db->get_where('wind_turbine',array('ID !='=> 0,'WF_ID' => $wind_farm_id));
        $results = $query->result_array();
		return $results;
        /*echo "<pre>";
        print_r($result);
        echo "</pre>";
		if($query->num_rows() == 1) {
           return $result[0];
        }*/
	}

	public function get_computers_by_location($Location){
        $query = $this->db->get_where('computers',array('ID !='=> 0,'Location'=> $Location));           
        $result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
	}
	
	public function get_system_status_by_device_id($computerID){
       	$limit = 2;
        
		/*$Current_time = date("Y-m-d H:i:s", strtotime('-1 hours 30 minutes'));
		$Before_time = date("Y-m-d H:i:s", strtotime('-1 hours 25 minutes'));*/

		$Current_time = date("Y-m-d H:i:s");
		$Before_time = date("Y-m-d H:i:s", strtotime('0 hours -5 minutes'));

		$query = $this->db->select()
                          ->from('system_status')
                          ->limit($limit)
                          ->where('Device',$computerID)
                          ->where('TimeStamp <=', $Current_time)
                          ->where('TimeStamp >=', $Before_time)
                          ->order_by("ID", "desc")
                          ->get();
        /*echo "<pre>";
        print_r($this->db->last_query());
        echo "</pre>";*/

        /*die();*/
        return $query->result_array();
	}

	function get_probird_status_by_opc_order_id($opc_order_id){
        $query = $this->db->get_where('send_to_opc_orders',array('ID'=>$opc_order_id ));
        $result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
    }

    function get_camera_by_cameraid($Camera_ID){
        $query = $this->db->get_where('cameras',array('ID'=>$Camera_ID ));
        $result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
    }

    function get_send_to_opc_orders_cameraid_inarray($Camera_ID,$FromDateTime,$ToDateTime){
    	$query = $this->db->select('')
                          ->from('send_to_opc_orders')
                          ->where('Value !=',0)
                          ->where('Time_Stamp BETWEEN "'.$FromDateTime.'" AND "'.$ToDateTime.'"')
                          ->where_in('Camera_source', $Camera_ID)
                          /*->where('Time_Stamp <=', $FromDateTime)
						  ->where('Time_Stamp >=', $ToDateTime)*/
                          ->order_by("ID", "desc")
                          ->get();

        /*echo "<pre>";
		print_r($this->db->last_query());
		echo "</pre>";*/
		//die();
		
        $results = $query->result_array();
		return $results;
    }

    function get_media_by_file_name($file_name){
        $query = $this->db->get_where('medias',array('File_name'=>$file_name ));
        $result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
    }

    function get_cameras_by_wind_turbine_id($wind_turbine_id){
        $query = $this->db->get_where('cameras',array('Wind_turbine'=>$wind_turbine_id ));
        $results = $query->result_array();
		return $results;
    }

    function get_computer_by_wind_turbine_id($wind_turbine_id){
        $query = $this->db->get_where('computers',array('ID !='=> 0,'ID'=> $wind_turbine_id));           
        $result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
    }

    public function get_system_status_by_device_pc($device_pc){
       	$limit = 1;
		$Current_time = date("Y-m-d H:i:s", strtotime('+4 hours 30 minutes'));
		$Before_time = date("Y-m-d H:i:s", strtotime('+4 hours 27 minutes'));

		/*$Current_time = date("Y-m-d H:i:s", strtotime('-3 day +8 hours 30 minutes'));
		$Before_time = date("Y-m-d H:i:s", strtotime('-3 day +8 hours 25 minutes'));*/

		$query = $this->db->select('')
                          ->from('system_status')
                          ->limit($limit)
                          ->where('Device',$device_pc)
                          //->where('TimeStamp BETWEEN "'.$Before_time.'" AND "'.$Current_time.'"')
                          /*->where('TimeStamp >=', $Current_time)
						  ->where('TimeStamp <=', $Before_time)*/
                          ->order_by("ID", "desc")
                          ->get();

        /*echo "<pre>";
		print_r($this->db->last_query());
		echo "</pre>";*/
		//die();
		//return $query->num_rows();

		$result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
	}

	public function get_wind_turbine_by_pdl(){
        $query = $this->db->get_where('wind_turbine',array('Type'=> 'PDL'));
        return $query->result_array();
	}

	public function get_computers_by_pdl($Location){
        $query = $this->db->get_where('computers',array('Location'=> $Location));           
        return $query->result_array();
	}
	
	public function get_latest20_system_status_by_device_pc($device_pc){
       	$limit = 20;
		$query = $this->db->select('')
                          ->from('system_status')
                          ->limit($limit)
                          ->where('Device',$device_pc)
                          ->order_by("ID", "desc")
                          ->get();
		return $query->result_array();
	}

	
	function get_script_by_scriptid($ScriptID){
        $query = $this->db->get_where('scripts',array('ID'=> $ScriptID));           
        $result = $query->result_array();
		if($query->num_rows() == 1) {
           return $result[0];
        }
    }

    public function get_entities(){
        $query = $this->db->get_where('entities');
        return $query->result_array();
	}

	public function get_people_by_EntityID($Entity_id){
        $query = $this->db->get_where('people',array('Entity_id'=> $Entity_id));
        return $query->result_array();
	}

	

}