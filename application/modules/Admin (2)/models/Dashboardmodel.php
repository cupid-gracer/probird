<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Dashboardmodel extends CI_Model
{

        public function get_first_cluster()
        {
                //$query = $this->db->select()->from('clusters')->get();
                $query = $this->db->select()
                        ->from('clusters')
                        ->limit(1)
                        ->order_by("ID", "asc")
                        ->get();
                $result = $query->result_array();
                if ($query->num_rows() == 1) {
                        return $result[0];
                }
        }

        function get_clusters()
        {
                $query = $this->db->select()->from('clusters')->get();
                return $query->result_array();
        }

        function get_single_cluster($Cluster_ID)
        {
                $query = $this->db->get_where('clusters', array('ID' => $Cluster_ID));
                $result = $query->result_array();
                if ($query->num_rows() == 1) {
                        return $result[0];
                }
        }

        public function get_wt_packs_in_cluster($Cluster_ID)
        {
                $query = $this->db->get_where('wt_packs_in_cluster', array('Cluster_ID' => $Cluster_ID));
                $result = $query->result_array();
                return $result;
        }

        public function get_cameras_in_cluster()
        {
                $query = $this->db->get('cameras_in_cluster');
                $result = $query->result_array();
                return $result;
        }

        public function get_cameras_in_cluster_by_clusterid($Cluster_ID)
        {
                $query = $this->db->get_where('cameras_in_cluster', array('Cluster_ID' => $Cluster_ID));
                $result = $query->result_array();
                return $result;
        }

        public function get_multiple_wt_packs_in_cluster_by_clusterids($Cluster_IDs)
        {
                /*$query = $this->db->get_where('cameras_in_cluster',array('Cluster_ID'=>$Cluster_ID));
		$result = $query->result_array();
        return $result;*/

                /*$query = $this->db->select()
                          ->from('wt_packs_in_cluster')
                          ->where_in('Cluster_ID',$Cluster_IDs)
                          ->group_by('WT_pack_ID')
                          ->get();*/
                $this->db->select('WT_pack_ID');
                $this->db->where_in('Cluster_ID', $Cluster_IDs);
                $this->db->distinct();
                $query = $this->db->get('wt_packs_in_cluster');
                /*print_r($this->db->last_query());
        die();*/
                return $query->result_array();
        }


        public function get_multiple_wt_in_wind_turbine_pack_by_WT_pack_IDs($WT_pack_IDs)
        {
                $this->db->select('WT_ID');
                $this->db->where_in('WT_pack_ID', $WT_pack_IDs);
                $this->db->distinct();
                $query = $this->db->get('wt_in_wind_turbine_pack');
                return $query->result_array();
        }


        public function get_wind_turbine_data_by_Wind_Turbine_IDs($Wind_Turbine_IDs, $FromDateTime, $ToDateTime)
        {

                $query = $this->db->select()
                        ->from('wind_turbine_data')
                        ->where('Time_Stamp BETWEEN "' . $FromDateTime . '" AND "' . $ToDateTime . '"')
                        ->where_in('Wind_Turbine_ID', $Wind_Turbine_IDs)
                        ->order_by("ID", "desc")
                        ->get();
                return $query->result_array();
        }



        public function get_wt_packs_in_cluster_by_clusterid($Cluster_ID)
        {
                $query = $this->db->get_where('wt_packs_in_cluster', array('Cluster_ID' => $Cluster_ID));
                $result = $query->result_array();
                if ($query->num_rows() >= 1) {
                        return $result[0];
                }
        }

        public function get_cameras_in_cluster_by_cameraid($Camera_ID)
        {
                $query = $this->db->get_where('cameras_in_cluster', array('Camera_ID' => $Camera_ID));
                $result = $query->result_array();
                return $result;
        }


        public function get_cameras()
        {
                $query = $this->db->get('cameras');
                $result = $query->result_array();
                return $result;
        }

        public function get_camera_detail($Camera_ID)
        {
                $query = $this->db->get_where('cameras', array('ID' => $Camera_ID));
                $result = $query->result_array();
                if ($query->num_rows() == 1) {
                        return $result[0];
                }
        }



        public function get_media_by_wt_pack_id($WT_pack_ID)
        {

                $query = $this->db->select()
                        ->from('medias')
                        ->limit(1)
                        ->where('WT_pack_ID', $WT_pack_ID)
                        ->where('Type', 'Picture')
                        ->order_by("ID", "desc")
                        ->get();
                return $query->result_array();
        }


        public function get_media_first_by_wt_pack_id($WT_pack_ID, $limit, $id = -1)
        {
                //$current_date = '2021-12-09';
                //$current_date = date("Y-m-d");
                if($id >= 0){
                        $query = $this->db->select()
                                ->from('medias')
                                ->limit($limit)
                                ->where('WT_pack_ID', $WT_pack_ID)
                                ->where('ID <', $id)
                                ->where('Type', 'Picture')
                                ->order_by("ID", "desc")
                                ->get();
                }else {

                        $query = $this->db->select()
                                ->from('medias')
                                ->limit($limit)
                                ->where('WT_pack_ID', $WT_pack_ID)
                                ->where('Type', 'Picture')
                                ->order_by("ID", "desc")
                                ->get();
                }
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

        public function get_wind_turbine_pack_by_wt_pack_id($WT_pack_ID)
        {
                $query = $this->db->get_where('wind_turbine_pack', array('ID' => $WT_pack_ID));
                $result = $query->result_array();
                if ($query->num_rows() == 1) {
                        return $result[0];
                }
        }


        public function get_medias_test_by_wt_pack_id($WT_pack_ID)
        {
                // $query = $this->db->get_where('medias_test',array('ID'=>$WT_pack_ID));
                $query = $this->db->get_where('medias', array('ID' => $WT_pack_ID));
                $result = $query->result_array();
                if ($query->num_rows() == 1) {
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

        public function get_probird_orders_by_camera_id($camera_id)
        {
                $limit = 7000;
                $query = $this->db->order_by("Time_Stamp", "DESC")->get_where('send_to_opc_orders', array('Value !=' => 0, 'Camera_source' => $camera_id), $limit);

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

        public function get_wind_turbine()
        {
                $query = $this->db->get_where('wind_turbine', array('ID !=' => 0, 'Type' => 'Wind Turbine'));
                return $query->result_array();
        }

        public function get_wind_turbines()
        {
                $query = $this->db->select()->from('wind_turbine')->get();
                return $query->result_array();
        }
        public function query_wind_turbine_cominfo_for_systemstatus()
        {
                $query = $this->db
                        ->select('wt.ID as wt_id, wt.Type, wt.Reference, wt.Model, wt.WF_ID, wt.cluster, wt.Name as wt_name, c.ID as c_id, c.Name as c_name')
                        // ->select('wt.ID as wt_id, wt.Type, wt.Reference, wt.Model, wt.WF_ID, wt.cluster, wt.Name as wt_name, c.Name as c_name, sc.Name as sc_name')
                        ->from('wind_turbine as wt')
                        ->join('computers as c', 'c.Location = wt.ID')
                        // ->join('scripts as sc', 'sc.Device_PC = wt.ID')
                        ->order_by('wt.ID', 'ASC')
                        ->get();

                $result = $query->result_array();
                return $result;
        }

        public function query_status()
        {
                $query = $this->db
                        ->select('c.ID as computer_id, c.Name as computer_name,  sc.ID as sc_id, sc.Name as sc_name')
                        ->from('computers as c')
                        ->join('scripts as sc', 'sc.Device_PC = c.ID')
                        ->get();

                $result = $query->result_array();

                foreach ($result as $key => $item) {
                        $script = $item['sc_id'];

                        $q = $this->db
                                ->select()
                                ->from('system_status')
                                ->where('Script', $script)
                                ->order_by('ID', 'DESC')
                                ->limit(1, 0)
                                ->get();

                        $timestamp = count($q->result_array()) > 0 ? $q->result_array()[0]['TimeStamp'] : "";

                        $default_timezone = date_default_timezone_get();
                        $date = new DateTime("now", new DateTimeZone($default_timezone));

                        $Current_time = $date->format('Y-m-d H:i:s');
                        $difference_in_seconds = strtotime($Current_time) - strtotime($timestamp);
                        $result[$key]['status'] = $difference_in_seconds > INTERVAL_TIME * 60 ? 0 : 1;
                }
                return $result;
        }

        public function query_computer_wt_relation()
        {
                $query = $this->db
                        ->select()
                        ->from('computer_wt_pack as cw')
                        ->join('wt_in_wind_turbine_pack  as wp', 'wp.WT_pack_ID = cw.WT_pack_ID')
                        ->get();

                $result = $query->result_array();

                return $result;
        }


        public function get_computers_by_id($turbineID)
        {
                $query = $this->db->get_where('computers', array('Location' => $turbineID));
                return $query->result_array();
        }

        public function get_system_status_by_id($computerID, $Current_time, $Before_time)
        {
                $limit = 100;
                $this->db->select('*');
                $this->db->from('system_status');
                $this->db->limit($limit);
                if ($computerID != '') {
                        $this->db->where('Device', $computerID);
                }
                if ($Current_time != '' and $Before_time != '') {
                        $this->db->where('TimeStamp <=', $Current_time);
                        $this->db->where('TimeStamp >=', $Before_time);
                }
                $query = $this->db->get();

                return $query->result_array();
        }

        /* Abhishek 17 December 2021 System Status*/
        public function get_wind_farms()
        {
                $query = $this->db->get_where('wind_farm');
                return $query->result_array();
        }

        public function get_wind_turbine_by_wind_farm_id($wind_farm_id)
        {
                $query = $this->db->get_where('wind_turbine', array('ID !=' => 0, 'WF_ID' => $wind_farm_id));
                $results = $query->result_array();
                return $results;
                /*echo "<pre>";
        print_r($result);
        echo "</pre>";
		if($query->num_rows() == 1) {
           return $result[0];
        }*/
        }

        public function get_computers_by_location($Location)
        {
                $query = $this->db->get_where('computers', array('ID !=' => 0, 'Location' => $Location));
                $result = $query->result_array();
                if ($query->num_rows() == 1) {
                        return $result[0];
                }
        }

        public function get_system_status_by_device_id($computerID)
        {
                $limit = 2;

                /*$Current_time = date("Y-m-d H:i:s", strtotime('-1 hours 30 minutes'));
		$Before_time = date("Y-m-d H:i:s", strtotime('-1 hours 25 minutes'));*/

                $Current_time = date("Y-m-d H:i:s");
                $Before_time = date("Y-m-d H:i:s", strtotime('0 hours -5 minutes'));

                $query = $this->db->select()
                        ->from('system_status')
                        ->limit($limit)
                        ->where('Device', $computerID)
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

        /*function get_wt_packs_in_cluster($cluster_idss){

        $query = $this->db->get_where('wt_packs_in_cluster',array('Cluster_ID'=>$cluster_idss ));
        $result = $query->result_array();

		if($query->num_rows() == 1) {
           return $result[0];
        }
    }*/

        function get_probird_status_by_opc_order_id($opc_order_id)
        {
                $query = $this->db->get_where('send_to_opc_orders', array('ID' => $opc_order_id));
                $result = $query->result_array();

                if ($query->num_rows() == 1) {
                        return $result[0];
                }
        }

        function get_camera_by_cameraid($Camera_ID)
        {
                $query = $this->db->get_where('cameras', array('ID' => $Camera_ID));
                $result = $query->result_array();

                if ($query->num_rows() == 1) {
                        return $result[0];
                }
        }

        function get_send_to_opc_orders_cameraid_inarray($Camera_ID, $FromDateTime, $ToDateTime)
        {
                $query = $this->db->select('')
                        ->from('send_to_opc_orders')
                        ->where('Value !=', 0)
                        ->where('Time_Stamp BETWEEN "' . $FromDateTime . '" AND "' . $ToDateTime . '"')
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

        function get_media_by_file_name($file_name)
        {
                $query = $this->db->get_where('medias', array('File_name' => $file_name));
                $result = $query->result_array();
                if ($query->num_rows() == 1) {
                        return $result[0];
                }
        }

        function get_cameras_by_wind_turbine_id($wind_turbine_id)
        {
                $query = $this->db->get_where('cameras', array('Wind_turbine' => $wind_turbine_id));
                $results = $query->result_array();
                return $results;
        }

        function get_computer_by_wind_turbine_id($wind_turbine_id)
        {
                $query = $this->db->get_where('computers', array('ID !=' => 0, 'Location' => $wind_turbine_id));
                $result = $query->result_array();
                if ($query->num_rows() == 1) {
                        return $result[0];
                }
        }

        public function get_system_status_by_device_pc($device_pc)
        {
                $limit = 1;
                $query = $this->db->select('')
                        ->from('system_status')
                        ->limit($limit)
                        ->where('Device', $device_pc)
                        ->order_by("ID", "desc")
                        ->get();
                $result = $query->result_array();
                if ($query->num_rows() == 1) {
                        return $result[0];
                }
        }

        public function get_system_status_last10minutes($device_pc, $FromDateTime, $ToDateTime)
        {
                $limit = 10;
                $query = $this->db->select('')
                        ->from('system_status')
                        ->limit($limit)
                        ->where('Device', $device_pc)
                        ->where('TimeStamp BETWEEN "' . $ToDateTime . '" AND "' . $FromDateTime . '"')
                        /*->where('TimeStamp >=', $ToDateTime)
						  ->where('TimeStamp <=', $FromDateTime)*/
                        ->order_by("ID", "desc")
                        ->get();
                $result = $query->result_array();
                return $result;
        }

        public function get_system_status_by_scriptids($Scriptids)
        {
                $query = $this->db->select('')
                        ->from('system_status')
                        ->where_in('Script', $Scriptids)
                        ->get();
                $results = $query->result_array();
                return $results;
        }


        public function get_script_by_scriptids($Scriptids)
        {
                $query = $this->db->select('')
                        ->from('scripts')
                        ->where_in('ID', $Scriptids)
                        ->get();
                /*echo "<pre>";
		print_r($this->db->last_query());
		echo "</pre>";
		die();*/

                $results = $query->result_array();
                return $results;
        }

        public function get_wt_in_wind_turbine_pack_by_wind_turbineID($WT_ID)
        {
                $query = $this->db->select('')
                        ->from('wt_in_wind_turbine_pack')
                        ->where_in('WT_ID', $WT_ID)
                        ->get();
                return $query->result_array();
        }

        public function get_wind_turbine_pack_by_wind_turbineIDs($wind_turbineIDs)
        {
                $query = $this->db->select('')
                        ->from('wind_turbine_pack')
                        ->where_in('ID', $wind_turbineIDs)
                        ->get();
                return $query->result_array();
        }

        public function get_probirds_softwares_Wind_turbineIDs($wind_turbineIDs)
        {
                $query = $this->db->select('')
                        ->from('probirds_softwares')
                        ->where_in('Wind_turbine', $wind_turbineIDs)
                        ->get();
                return $query->result_array();
        }


        public function get_wind_turbine_by_pdl()
        {
                $query = $this->db->get_where('wind_turbine', array('Type' => 'PDL'));
                return $query->result_array();
        }

        public function get_computers_by_pdl($Location)
        {
                $query = $this->db->get_where('computers', array('Location' => $Location));
                return $query->result_array();
        }

        public function get_latest20_system_status_by_device_pc($device_pc)
        {
                $limit = 10;
                $query = $this->db->select('')
                        ->from('system_status')
                        ->limit($limit)
                        ->where('Device', $device_pc)
                        ->order_by("ID", "desc")
                        ->get();
                return $query->result_array();
        }


        function get_script_by_scriptid($ScriptID)
        {
                $query = $this->db->get_where('scripts', array('ID' => $ScriptID));
                $result = $query->result_array();
                if ($query->num_rows() == 1) {
                        return $result[0];
                }
        }

        public function get_entities()
        {
                $query = $this->db->get_where('entities');
                return $query->result_array();
        }

        public function get_people_by_EntityID($Entity_id)
        {
                $query = $this->db->get_where('people', array('Entity_id' => $Entity_id));
                return $query->result_array();
        }

        function get_media_by_wt_pack_ids($WT_pack_ID, $FromDateTime, $ToDateTime, $file_type)
        {
                $query = $this->db->select('')
                        ->from('medias')
                        ->where_in('Type', $file_type)
                        ->where('Time_Stamp BETWEEN "' . $FromDateTime . '" AND "' . $ToDateTime . '"')
                        ->where_in('WT_pack_ID', $WT_pack_ID)
                        /*->where('Time_Stamp <=', $FromDateTime)
						  ->where('Time_Stamp >=', $ToDateTime)*/
                        ->order_by("ID", "desc")
                        ->get();

                $results = $query->result_array();
                return $results;
        }


        public function get_probirds_softwares_by_wind_turbine($wind_turbine_id)
        {
                $query = $this->db->get_where('probirds_softwares', array('Wind_turbine' => $wind_turbine_id));
                return $query->result_array();

                /*$query = $this->db->select('')
                          ->from('probirds_softwares')
                          ->where_in('Type', $wind_turbine_id)
                          ->order_by("ID", "desc")
                          ->get();
		
        $results = $query->result_array();
		return $results;*/
        }


        public function get_probirds_softwares_by_computer($wind_turbine_id)
        {
                $query = $this->db->get_where('probirds_softwares', array('Computer' => $wind_turbine_id));
                return $query->result_array();
        }
}
