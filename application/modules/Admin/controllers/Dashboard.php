<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->library('session');
        $this
            ->load
            ->model('Dashboardmodel', '', true);
    }
    public function index()
    {
        $validateLogin = $this->validateLogin();
        $data['Name'] = $validateLogin['Name'];
        $data['Surname'] = $validateLogin['Surname'];

        $data['heading_title'] = 'Dashboard';
        $data['active'] = 'dashboard';
        $data['submenuactive'] = '';
        $data['get_clusters'] = $this
            ->Dashboardmodel
            ->get_clusters();

        $get_cameras_in_cluster = $this
            ->Dashboardmodel
            ->get_cameras_in_cluster();

        $camera_arrs = array();
        foreach ($get_cameras_in_cluster as $key => $value) {
            $camera_arr = array();
            $get_camera_detail = $this
                ->Dashboardmodel
                ->get_camera_detail($value['Camera_ID']);
            $camera_arr['Cluster_ID'] = $value['Cluster_ID'];
            $camera_arr['Name'] = $get_camera_detail['Name'];
            //$camera_arr = $get_camera_detail['Name'];
            $camera_arrs[] = $camera_arr;
        }
        $data['get_cameras'] = $camera_arrs;
        $get_all_piform = array();
        $get_first_cluster = $this
            ->Dashboardmodel
            ->get_first_cluster();
        $getitems = array();
        $getitems_first = array();
        $get_wt_packs_in_cluster = $this
            ->Dashboardmodel
            ->get_wt_packs_in_cluster($get_first_cluster['ID']);
        $wt_packs_cluster_count = 1;
        foreach ($get_wt_packs_in_cluster as $key => $value02) {
            if ($wt_packs_cluster_count == 1) {
                $default_limit = 500;
                $get_medias_first = $this
                    ->Dashboardmodel
                    ->get_media_first_by_wt_pack_id($value02['WT_pack_ID'], $default_limit);
                foreach ($get_medias_first as $key => $value) {
                    $get_item_arr_first = array();
                    $get_item_arr_first['WT_pack_ID'] = $value02['WT_pack_ID'];
                    $get_wind_turbine_pack = $this
                        ->Dashboardmodel
                        ->get_wind_turbine_pack_by_wt_pack_id($value02['WT_pack_ID']); // Rishabh (Get Camera Name)
                    $get_item_arr_first['camera_name'] = $get_wind_turbine_pack['camera_name']; // Rishabh (Get Camera Name)
                    $get_item_arr_first['File_name'] = $value['File_name'];
                    $get_item_arr_first['Path'] = $value['Path'];
                    $get_item_arr_first['ID'] = $value['ID'];
                    $getitems_first[] = $get_item_arr_first;
                }
            }
            $get_medias = $this
                ->Dashboardmodel
                ->get_media_by_wt_pack_id($value02['WT_pack_ID']);
            foreach ($get_medias as $key => $value) {
                $get_item_arr = array();
                $get_item_arr['WT_pack_ID'] = $value02['WT_pack_ID'];
                $get_wind_turbine_pack = $this
                    ->Dashboardmodel
                    ->get_wind_turbine_pack_by_wt_pack_id($value02['WT_pack_ID']);
                $get_medias_test = $this
                    ->Dashboardmodel
                    ->get_medias_test_by_wt_pack_id($value02['WT_pack_ID']);
                $get_item_arr['camera_name'] = $get_wind_turbine_pack['camera_name'];
                if ($get_medias_test != '') {
                    $get_item_arr['Type'] = $get_medias_test['Type'];
                }
                $get_item_arr['File_name'] = $value['File_name'];
                $get_item_arr['path'] = $value['Path'];
                $get_item_arr['ID'] = $value['ID'];
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

        $get_cameras_in_cluster_by_clusterid = $this
            ->Dashboardmodel
            ->get_cameras_in_cluster_by_clusterid($get_first_cluster['ID']);
        $probirds_arrs = array();

        if (count($get_cameras_in_cluster_by_clusterid) > 0) {

            $probirds_arr = array();
            $probirds_arr['Time_Stamp'] = '';
            $probirds_arr['birddate'] = '';
            $probirds_arr['birdtime'] = '22.0000';
            $probirds_arr['Value'] = '';
            $probirds_arr['opc_order_id'] = '0';
            $probirds_arr['text'] = ''; 
            $probirds_arr['Wind_Turbine'] = '';
            $probirds_arrs[] = $probirds_arr;

            $probirds_arr = array();
            $probirds_arr['Time_Stamp'] = '';
            $probirds_arr['birddate'] = '';
            $probirds_arr['birdtime'] = '1';
            $probirds_arr['Value'] = '';
            $probirds_arr['text'] = ''; 
            $probirds_arr['opc_order_id'] = '0';
            $probirds_arr['Wind_Turbine'] = '';
            $probirds_arrs[] = $probirds_arr;

            foreach ($get_cameras_in_cluster_by_clusterid as $key => $get_cameras_in_cluster) {

                $get_probird_orders_by_camera_id = $this
                    ->Dashboardmodel
                    ->get_probird_orders_by_camera_id($get_cameras_in_cluster['Camera_ID']);
                if (count($get_probird_orders_by_camera_id) > 0) {
                    foreach ($get_probird_orders_by_camera_id as $key => $get_probird_orders) {
                        $probirds_arr = array();
                        $probirds_arr['Time_Stamp'] = $get_probird_orders['Time_Stamp'];
                        $exp_time = explode(' ', $probirds_arr['Time_Stamp']);
                        $probirds_arr['birddate'] = $exp_time[0];
                        $get_bird_exp_1 = $exp_time[1];
                        $get_bird_exp_2 = explode(':', $get_bird_exp_1);
                        $probirds_arr['birdtime'] = $get_bird_exp_2[0] . '.' . $get_bird_exp_2[1]  . $get_bird_exp_2[2];
                        $probirds_arr['Value'] = $get_probird_orders['Value'];
                        $probirds_arr['text'] = $exp_time[0] . ' ' . $get_bird_exp_2[0] . ':' . $get_bird_exp_2[1] .':' . $get_bird_exp_2[2];
                        $probirds_arr['opc_order_id'] = $get_probird_orders['ID'];
                        $probirds_arr['Wind_Turbine'] = $get_probird_orders['Wind_Turbine'];
                        $probirds_arrs[] = $probirds_arr;
                    }
                }
            }
        }

        $data['get_bird_data'] = $probirds_arrs;

        $get_cameras_list = $this
            ->Dashboardmodel
            ->get_cameras();
        $camera_arrays = array();
        foreach ($get_cameras_list as $key => $get_camera) {
            $camera_arr = array();
            $get_cameras_in_cluster_by_cameraid = $this
                ->Dashboardmodel
                ->get_cameras_in_cluster_by_cameraid($get_camera['ID']);
            $camera_arr['camera_name'] = $get_camera['Name'];
            $camera_arr['camera_id'] = $get_camera['ID'];

            $camera_cluster_arrs = array();
            foreach ($get_cameras_in_cluster_by_cameraid as $key => $values) {
                $camera_cluster_arr = array();
                $get_single_cluster = $this
                    ->Dashboardmodel
                    ->get_single_cluster($values['Cluster_ID']);
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

        $this
            ->load
            ->view('dashboard', $data);
    }

    public function get_wt_packs_in_cluster()
    {

        $data = array();
        $data['error'] = true;

        $getitems = array();
        $getitems_first = array();
        $get_wt_packs_in_cluster = $this
            ->Dashboardmodel
            ->get_wt_packs_in_cluster($_POST['ClusterID']);
        $wt_packs_cluster_count = 1;
        foreach ($get_wt_packs_in_cluster as $key => $value02) {
            $get_medias = $this
                ->Dashboardmodel
                ->get_media_by_wt_pack_id($value02['WT_pack_ID']);
            if ($wt_packs_cluster_count == 1) {
                $default_limit = 50;
                $get_medias_first = $this
                    ->Dashboardmodel
                    ->get_media_first_by_wt_pack_id($value02['WT_pack_ID'], $default_limit);
                foreach ($get_medias_first as $key => $value) {

                    $get_item_arr_first = array();
                    $get_item_arr_first['WT_pack_ID'] = $value02['WT_pack_ID'];
                    $get_wind_turbine_pack = $this
                        ->Dashboardmodel
                        ->get_wind_turbine_pack_by_wt_pack_id($value02['WT_pack_ID']); // Rishabh (Get Camera Name)
                    $get_item_arr_first['camera_name'] = $get_wind_turbine_pack['camera_name']; // Rishabh (Get Camera Name)
                    $get_item_arr_first['File_name'] = $value['File_name'];
                    $get_item_arr_first['Path'] = $value['Path'];
                    $get_item_arr_first['ID'] = $value['ID'];
                    $getitems_first[] = $get_item_arr_first;
                }
            }
            foreach ($get_medias as $key => $value) {
                $get_item_arr = array();
                $get_item_arr['WT_pack_ID'] = $value02['WT_pack_ID'];

                $get_wind_turbine_pack = $this
                    ->Dashboardmodel
                    ->get_wind_turbine_pack_by_wt_pack_id($value02['WT_pack_ID']); // Rishabh (Get Camera Name)
                $get_item_arr['camera_name'] = $get_wind_turbine_pack['camera_name']; // Rishabh (Get Camera Name)
                $get_item_arr['File_name'] = $value['File_name'];
                $get_item_arr['Path'] = $value['Path'];
                $get_item_arr['ID'] = $value['ID'];
                $getitems[] = $get_item_arr;
            }
            $wt_packs_cluster_count++;
        }

        $html_side = '';
        foreach ($getitems as $key => $getitem) {
            $html_side .= '<div class="custom_slide" data-id="' . $getitem['WT_pack_ID'] . '" >';
            $html_side .= '<div class="top_camera_right" data-name="' . $getitem['camera_name'] . '" >' . $getitem['camera_name'] . '</div>';
            $html_side .= '<img src="' . $getitem['Path'] . '">';
            $html_side .= '</div>';
        }

        $html = '';
        $html .= '<div class="content-carousel">';
        $html .= '<div class="owl-carousel">';

        $media_img_count = 1;
        if (count($getitems_first) > 0) {
            foreach ($getitems_first as $key => $value) {
                if($key > 100) break;

                $current = '';
                if ($media_img_count == 1) {
                    $current = 'current';
                }
                $html .= '<div>';
                $html .= '<div class="top-left" data-name="' . $value['camera_name'] . '" >' . $value['camera_name'] . '</div>';
                $html .= '<img src="' . $value['Path'] . '">';
                $html .= '<div class="get_cluster_time">';
                if (!empty(@$value['File_name'])) {
                    $value['File_name'];
                    $expl_un = explode('_', @$value['File_name']);
                    $date = $expl_un[1];

                    $expl_dot = explode('.', $expl_un[2]);
                    $time = $expl_dot[0];

                    $Newtime = $date . ' ' . $time;
                    $html .= $Newtime;
                }
                $html .= '</div>'; //get_cluster_time
                $html .= '</div>';
                $media_img_count++;
            }
            $html .= '<div class="lastslide_item">';
            $html .= '<a href="' . base_url('admin/reporting') . '"> Please use Records page to download more images </a>';
            $html .= '</div>';
        } else {
            $html .= '<div class="lastslide_item">';
            $html .= '<a href="#"> Data Not Found </a>';
            $html .= '</div>';
        }

        $html .= '</div>';
        $html .= '</div>';

        // $data['error'] = false;
        // $data['tab_data'] = $html;
        $data['tab_data_side'] = $html_side;
        $data['tab_data'] = $getitems_first;
        //$data['cluster_graph_data'] = $probirds_arrs;
        echo json_encode($data);
        die;
    }

    public function get_graph_by_cluster()
    {

        $data = array();
        $data['error'] = true;
        $get_cameras_in_cluster_by_clusterid = $this
            ->Dashboardmodel
            ->get_cameras_in_cluster_by_clusterid($_POST['ClusterID']);
        $probirds_arrs = array();

        $upload_filename = '';
        $camera_id_arr = array();
        if (count($get_cameras_in_cluster_by_clusterid) > 0) {

            $probirds_arr = array();
            $probirds_arr['Time_Stamp'] = '';
            $probirds_arr['birddate'] = '';
            $probirds_arr['birdtime'] = '22.0000';
            $probirds_arr['Value'] = '';
            $probirds_arr['text'] = '';
            $probirds_arr['opc_order_id'] = '0';
            $probirds_arr['Wind_Turbine'] = '';
            $probirds_arrs[] = $probirds_arr;

            $probirds_arr = array();
            $probirds_arr['Time_Stamp'] = '';
            $probirds_arr['birddate'] = '';
            $probirds_arr['birdtime'] = '1';
            $probirds_arr['Value'] = '';
            $probirds_arr['text'] = '';
            $probirds_arr['opc_order_id'] = '0';
            $probirds_arr['Wind_Turbine'] = '';
            $probirds_arrs[] = $probirds_arr;

            foreach ($get_cameras_in_cluster_by_clusterid as $key => $get_cameras_in_cluster) {
                //echo $get_cameras_in_cluster['Camera_ID'].'<br>';
                $get_probird_orders_by_camera_id = $this
                    ->Dashboardmodel
                    ->get_probird_orders_by_camera_id($get_cameras_in_cluster['Camera_ID']);
                if (count($get_probird_orders_by_camera_id) > 0) {
                    foreach ($get_probird_orders_by_camera_id as $key => $get_probird_orders) {
                        $probirds_arr = array();
                        $probirds_arr['Time_Stamp'] = $get_probird_orders['Time_Stamp'];
                        $exp_time = explode(' ', $probirds_arr['Time_Stamp']);
                        $probirds_arr['birddate'] = $exp_time[0];
                        $get_bird_exp_1 = $exp_time[1];
                        $get_bird_exp_2 = explode(':', $get_bird_exp_1);
                        $probirds_arr['birdtime'] = $get_bird_exp_2[0] . '.' . $get_bird_exp_2[1] . $get_bird_exp_2[2];
                        $probirds_arr['Value'] = $get_probird_orders['Value'];
                        $probirds_arr['text'] = $exp_time[0] . ' ' . $get_bird_exp_2[0] . ':' . $get_bird_exp_2[1] . ':' . $get_bird_exp_2[2];
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
    }

    public function get_slider_by_wt_pack_id()
    {
        $WT_pack_ID = $_POST['WT_pack_ID'];
        $id = -1;
        if(array_key_exists('ID', $_POST)){
           $id =  $_POST['ID'];
        }
        $default_limit = 50;
        $get_medias_first = $this
            ->Dashboardmodel
            ->get_media_first_by_wt_pack_id($WT_pack_ID, $default_limit, $id);
        $getitems_first = array();
        if (count($get_medias_first) > 0) {
            foreach ($get_medias_first as $key => $value) {
                $get_item_arr_first = array();
                $get_item_arr_first['WT_pack_ID'] = $WT_pack_ID;
                $get_wind_turbine_pack = $this
                    ->Dashboardmodel
                    ->get_wind_turbine_pack_by_wt_pack_id($WT_pack_ID); // Rishabh (Get Camera Name)
                $get_item_arr_first['camera_name'] = $get_wind_turbine_pack['camera_name']; // Rishabh (Get Camera Name)
                $get_item_arr_first['File_name'] = $value['File_name'];
                $get_item_arr_first['Path'] = $value['Path'];
                $get_item_arr_first['ID'] = $value['ID'];
                $getitems_first[] = $get_item_arr_first;
            }
        }

        $html = '';
        $html .= '<div class="content-carousel">';
        $html .= '<div class="owl-carousel">';

        if (count($getitems_first) > 0) {
            $media_img_count = 1;
            foreach ($getitems_first as $key => $value) {
                if($key > 1) break;
                $current = '';
                if ($media_img_count == 1) {
                    $current = 'current';
                }
                $html .= '<div data-id="' . $value['ID'] . '" WT-pack-ID="' . $WT_pack_ID . '"  >';
                $html .= '<div class="top-left" data-name="' . $value['camera_name'] . '" >' . $value['camera_name'] . '</div>';
                $html .= '<img src="' . $value['Path'] . '">';
                $html .= '<div class="get_cluster_time">';
                if (!empty(@$value['File_name'])) {
                    $value['File_name'];
                    $expl_un = explode('_', @$value['File_name']);
                    $date = $expl_un[1];

                    $expl_dot = explode('.', $expl_un[2]);
                    $time = $expl_dot[0];

                    $Newtime = $date . ' ' . $time;
                    $html .= $Newtime;
                }
                $html .= '</div>'; //get_cluster_time
                $html .= '</div>';
                $media_img_count++;
            }
            $html .= '<div class="lastslide_item">';
            $html .= '<a href="' . base_url('admin/reporting') . '"> Please use Records page to download more images </a>';
            $html .= '</div>';
        } else {
            $html .= '<div class="lastslide_item">';
            $html .= '<a href="' . base_url('admin') . '"> Please use Records page to download more images </a>';
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '</div>';

        $data['error'] = false;
        $data['tab_data'] = $getitems_first;
        echo json_encode($data);
        die;
    }

    public function sytemstatus_old_rishabh()
    {
        $validateLogin = $this->validateLogin();
        $data['Name'] = $validateLogin['Name'];
        $data['Surname'] = $validateLogin['Surname'];
        $data['heading_title'] = 'System status';
        $data['active'] = 'sytemstatus';
        $data['submenuactive'] = '';

        $get_wind_turbine = $this
            ->Dashboardmodel
            ->get_wind_turbine();
        $computers = array();
        foreach ($get_wind_turbine as $key => $value) {
            $turbineID = $value['ID'];
            $get_computers_by_id = $this
                ->Dashboardmodel
                ->get_computers_by_id($turbineID);
            if ($get_computers_by_id != '') {
                foreach ($get_computers_by_id as $key => $value1) {
                    $computerID = $value1['ID'];
                    $Current_time = date("Y-m-d H:i:s", strtotime('+4 hours 30 minutes'));
                    // echo "<br>";
                    $Before_time = date("Y-m-d H:i:s", strtotime('+4 hours 25 minutes'));
                    // die;
                    $get_system_status_by_id = $this
                        ->Dashboardmodel
                        ->get_system_status_by_id($computerID, $Current_time, $Before_time);
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
        $this
            ->load
            ->view('sytemstatus', $data);
    }

    public function record()
    {
        $validateLogin = $this->validateLogin();
        $data['Name'] = $validateLogin['Name'];
        $data['Surname'] = $validateLogin['Surname'];
        $data['heading_title'] = 'Records';
        $data['active'] = 'record';
        $data['submenuactive'] = '';
        $this
            ->load
            ->view('record', $data);
    }

    /* Abhishek */
    public function records()
    {
        $validateLogin = $this->validateLogin();
        $data['Name'] = $validateLogin['Name'];
        $data['Surname'] = $validateLogin['Surname'];
        $data['heading_title'] = 'Records';
        $data['active'] = 'record';
        $data['submenuactive'] = '';
        $data['get_clusters'] = $this
            ->Dashboardmodel
            ->get_clusters();
        $default_camera_arrs = array();
        $get_first_cluster = $this
            ->Dashboardmodel
            ->get_first_cluster();

        //$data['get_cameras_list'] = $this->Dashboardmodel->get_cameras();
        $get_cameras_in_cluster_by_clusterid = $this
            ->Dashboardmodel
            ->get_cameras_in_cluster_by_clusterid($get_first_cluster['ID']);


        foreach ($get_cameras_in_cluster_by_clusterid as $key => $get_camera_value) {
            $camera_arr = array();
            $get_camera_detail = $this
                ->Dashboardmodel
                ->get_camera_detail($get_camera_value['Camera_ID']);
            $camera_arr['CameraID'] = $get_camera_detail['ID'];
            $camera_arr['CameraName'] = $get_camera_detail['Name'];
            $default_camera_arrs[] = $camera_arr;
        }
        $data['get_default_cameras'] = $default_camera_arrs;

        $get_wt_packs_in_cluster = $this
            ->Dashboardmodel
            ->get_wt_packs_in_cluster_by_clusterid($get_first_cluster['ID']);

        $get_wind_turbine_pack = $this
            ->Dashboardmodel
            ->get_wind_turbine_pack_by_wt_pack_id($get_wt_packs_in_cluster['WT_pack_ID']);

        $wind_turbine_pack = array();
        $wind_turbine_pack['CameraID'] = $get_wt_packs_in_cluster['WT_pack_ID'];
        $wind_turbine_pack['CameraName'] = $get_wind_turbine_pack['camera_name'];

        $data['get_wind_turbine_pack'] = $wind_turbine_pack;
        $data['file_ext'] = '';
        $data['file_count'] = '';

        $this
            ->load
            ->library('zip');

        if ($this->input->server('REQUEST_METHOD') == 'POST') 
        {

            $response_arr = array();

            $FromDateTime = $_POST['from_date'] . ' ' . $_POST['from_time'];
            $ToDateTime = $_POST['to_date'] . ' ' . $_POST['to_time'];
            

            if (in_array('Excel', $_POST['file_type']) ) {
                if ($_POST['cluster_name'] != '' && array_key_exists('download', $_POST)) {
                    $WT_pack_IDs = $_POST['cluster_name'];
                    $get_wind_turbine_pack_ids = $this->Dashboardmodel->get_multiple_wt_in_wind_turbine_pack_by_WT_pack_IDs($WT_pack_IDs);
                    $wind_turbine_IDs = "";
                    foreach ($get_wind_turbine_pack_ids as $key => $wind_turbine_pack_val) {
                        if($key == 0) $wind_turbine_IDs = "'".$wind_turbine_pack_val['WT_ID']."'"; 
                        else $wind_turbine_IDs = $wind_turbine_IDs.",'".$wind_turbine_pack_val['WT_ID']."'";
                    }
                    $file_name  = "'".$FromDateTime."-".$ToDateTime."'";
                    $fp = $FromDateTime."-".$ToDateTime;
                    $FromDateTime  = "'".$FromDateTime."'";
                    $ToDateTime  = "'".$ToDateTime."'";
                    $wind_turbine_IDs  = "'".$wind_turbine_IDs."'";
                    $command = "python3 /var/www/html/scripts/db2excel.py ".$FromDateTime." ".$ToDateTime." ".$wind_turbine_IDs." ".$file_name." 2>&1";
                    $result = shell_exec($command);
                    $_r['type'] = "excel";
                    if(strpos($result, 'yes') !== false){
                        $_r['fileName'] = base_url.'uploads/'. $fp .'.xlsx';
                        $_r['error'] = false;
                    }
                    else{
                        $_r['error'] = true;
                        $_r['msg'] = "No Data in DB:";
                    }
                    array_push($response_arr, $_r);  
                }
            } 
            if(in_array('Video', $_POST['file_type']) || in_array('Picture', $_POST['file_type'])) {
                $file_type = [];
                $_r['type'] = 'video_picture';
                if(in_array('Video', $_POST['file_type'])) array_push($file_type, 'Video');
                if(in_array('Picture', $_POST['file_type'])) array_push($file_type, 'Picture');

                $fileHashName = str_replace(' ', '', implode('_', $file_type).'_'.$_POST['daterangepicker'].'_'.hash_hmac('md5', implode('_', $_POST['cluster_name']), 'secret'));
                $filePath = "/var/www/html/filelist/".$fileHashName.".txt";
                if (array_key_exists('calculation', $_POST)) {

                    $get_medias = $this->Dashboardmodel->get_media_by_wt_pack_ids($_POST['cluster_name'], $FromDateTime, $ToDateTime, $file_type);
                    if ($get_medias) {
                        $FileSum = 0;
                        $txt = "";
                        foreach ($get_medias as $key => $media_val) {
                            $filepath1 = $media_val['Path'];
                            $txt .= ",".$filepath1;
                        }
                        $myfile = fopen($filePath, "w") or die("Unable to open file!");
                        fwrite($myfile, $txt);
                        fclose($myfile);



                        $command = "python3 /var/www/html/list.py ".$filePath." 2>&1";
                        $result = shell_exec($command);
                        $FileSum = intval($result);
                        $_r['msg'] = $result;

                        $fileSize = $FileSum;
                        if ($FileSum >= 1073741824) {
                            $FileSum = number_format($FileSum / 1073741824, 2) . ' GB';
                        } elseif ($FileSum >= 1048576) {
                            $FileSum = number_format($FileSum / 1048576, 2) . ' MB';
                        } elseif ($FileSum >= 1024) {
                            $FileSum = number_format($FileSum / 1024, 2) . ' KB';
                        } elseif ($FileSum > 1) {
                            $FileSum = $FileSum . ' bytes';
                        } elseif ($FileSum == 1) {
                            $FileSum = $FileSum . ' byte';
                        } else {
                            $FileSum = '0 bytes';
                        }

                        $data['file_ext'] = $FileSum;

                        $_r['file_size_count'] = $FileSum . ' - ' . count($get_medias) . ' File';
                        $_r['error'] = false;
                        $_r['filesize'] = $fileSize;

                    } else {
                        $_r['error'] = true;
                        $_r['msg'] = "No Data Found in this section";
                    }
                }
                
                if(array_key_exists('download', $_POST)){
                    $command = "python3 /var/www/html/zip.py ".$fileHashName." ".$filePath." 2>&1";
                    $result = exec($command);
                    if(strpos($result, 'done') !== false){
                        $_r['fileName'] = base_url.'uploads/'. $fileHashName.'.zip';
                        $_r['error'] = false;
                    }
                    else{
                        $_r['error'] = "true";
                        $_r['msg'] = $result;
                    }
                }
                array_push($response_arr, $_r);  
            }
            echo json_encode($response_arr);
            die();
        }
        $this
            ->load
            ->view('record', $data);
    }

    function ExportFile($get_wind_turbines_excel)
    {

        require_once dirname(__FILE__) . '/../../../../PHPExcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()
            ->setCreator("PROBIRD")
            ->setLastModifiedBy("PROBIRD")
            ->setTitle("ProBird-RecordsExcel")
            ->setSubject("ProBird-RecordsExcel")
            ->setDescription("ProBird-RecordsExcel")
            ->setKeywords("ProBird-RecordsExcel")
            ->setCategory("ProBird-RecordsExcel");

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, 1, 'Time Stamp')
            ->setCellValueByColumnAndRow(1, 1, 'WT (Wind Turbine ID)')
            ->setCellValueByColumnAndRow(2, 1, 'Wind Speed')
            ->setCellValueByColumnAndRow(3, 1, 'RPM')
            ->setCellValueByColumnAndRow(4, 1, 'Status')
            ->setCellValueByColumnAndRow(5, 1, 'Expected Status')
            ->setCellValueByColumnAndRow(6, 1, 'Sub Status')
            ->setCellValueByColumnAndRow(7, 1, 'Temperature')
            ->setCellValueByColumnAndRow(8, 1, 'Rain')
            ->setCellValueByColumnAndRow(9, 1, 'Visibility');

        $row = 2;
        foreach ($get_wind_turbines_excel as $wt_excel_value) {
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(0, $row, $wt_excel_value['Time_Stamp']);
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(1, $row, $wt_excel_value['Wind_Turbine_ID']);
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(2, $row, $wt_excel_value['Wind_Speed']);
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(3, $row, $wt_excel_value['RPM']);
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(4, $row, $wt_excel_value['Status']);
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(5, $row, $wt_excel_value['Expected_Status']);
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(6, $row, $wt_excel_value['Sub_Status']);
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(7, $row, $wt_excel_value['Temperature']);
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(8, $row, $wt_excel_value['Rain']);
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(9, $row, $wt_excel_value['Visibility']);
            $row++;
        }
        $ReportName = 'Capespigne-Excel-' . date("Y-m-d-h-i-sa");
        $objPHPExcel->getActiveSheet()
            ->setTitle('ProBird-RecordsExcel');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $ReportName . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function get_cameras_by_clusterid()
    {

        $response_arr = array();
        $response_arr['error'] = true;
        $Cluster_ID = $_POST['Cluster_ID'];
        $get_cameras_in_cluster_by_clusterid = $this
            ->Dashboardmodel
            ->get_cameras_in_cluster_by_clusterid($Cluster_ID);
        $html_camera = '';
        foreach ($get_cameras_in_cluster_by_clusterid as $key => $get_camera_value) {
            $get_camera_detail = $this
                ->Dashboardmodel
                ->get_camera_detail($get_camera_value['Camera_ID']);
            $html_camera .= '<li>';
            $html_camera .= '<label>';
            $html_camera .= '<input type="checkbox" name="camera_id[]" value="' . $get_camera_value['Camera_ID'] . '" >';
            $html_camera .= '<label>' . $get_camera_detail['Name'] . '</label>';
            $html_camera .= '</label>';
            $html_camera .= '</li>';
        }
        $response_arr['camera_list'] = $html_camera;
        $response_arr['error'] = false;
        echo json_encode($response_arr);
        die();
    }

    public function get_multiple_cameras_by_clusterids()
    {

        $response_arr = array();
        $response_arr['error'] = true;
        $Cluster_IDs = $_POST['ClusterIDs'];
        $get_wt_packs_in_cluster = $this
            ->Dashboardmodel
            ->get_multiple_wt_packs_in_cluster_by_clusterids($Cluster_IDs);

        $html_camera = '';
        foreach ($get_wt_packs_in_cluster as $key => $get_wt_packs_value) {
            $get_camera_detail = $this
                ->Dashboardmodel
                ->get_wind_turbine_pack_by_wt_pack_id($get_wt_packs_value['WT_pack_ID']);
            $html_camera .= '<li>';
            $html_camera .= '<label class="cluster-label" for="camrea-id-' . $get_wt_packs_value['WT_pack_ID'] . '">';
            $html_camera .= '<input type="checkbox" name="cluster_name[]" checked="checked" value="' . $get_wt_packs_value['WT_pack_ID'] . '" id="camrea-id-' . $get_wt_packs_value['WT_pack_ID'] . '" >';
            $html_camera .= '<span>' . $get_camera_detail['camera_name'] . '</span>';
            $html_camera .= '</label>';
            $html_camera .= '</li>';
        }
        $response_arr['camera_list'] = $html_camera;
        $response_arr['error'] = false;
        echo json_encode($response_arr);
        die();
    }

    public function reporting()
    {
        $validateLogin = $this->validateLogin();
        $data['Name'] = $validateLogin['Name'];
        $data['Surname'] = $validateLogin['Surname'];
        $data['heading_title'] = 'Reporting';
        $data['active'] = 'reporting';
        $data['submenuactive'] = '';

        $min_date = date("2021-10-12");
        $end_date = date("Y-m-d");
        $start_date = date('Y-m-d', strtotime('-1 years'));
        if($min_date > $start_date) $start_date = $min_date; 
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        
        $_stats = $this->Dashboardmodel->get_statistics_by_date($start_date, $end_date);
        $data['stats'] = $_stats[0];

        $_r = $this->Dashboardmodel->get_stop_sound_number_from_statistics($start_date, $end_date);
        $data['sound_stop_number'] = $_r;


        $this
            ->load
            ->view('reporting', $data);
    }

    public function cal_power_amount($wind_speed, $type)
    {
        if( $wind_speed > 0){
            $increment = $type == 'S' ? 3600: 60;
            $production = 3346.35 / (1+exp(5.60355-0.68957 * $wind_speed));
            $production = $production / $increment;
        }else
            $production = 0;
        return $production;
    }
    
    public function wt_graph()
    {
        $start_time = $_POST['start'];   
        $end_time = $_POST['end'];   
        $chart_type = $_POST['chart_type'];
        $wt_id_name = 'Wind_Turbine_ID';
        $timestamp_name = 'Time_Stamp';
        if($chart_type == 'minute'){
            $data = $this->Dashboardmodel->get_wind_turbine_data_by_date($start_time, $end_time);
            usort($data, function($a, $b){return $a["Wind_Turbine_ID"] <=> $b["Wind_Turbine_ID"];});
        }
        else{
            $data = $this->Dashboardmodel->get_statistics_by_every_date($start_time, $end_time);
            usort($data, function($a, $b){return $a["wind_turbine_id"] <=> $b["wind_turbine_id"];});
            $wt_id_name = 'wind_turbine_id';
            $timestamp_name = 'date';
        }
        
        $result = [];
        $key = -1;
        $_r = [];
        for($i = 0; $i < count($data); $i++){
            $item = $data[$i];
            if($key == $item[$wt_id_name]){
                array_push( $_r, $item);
            }else{
                if($key != -1){
                    array_push($result, array('wt_id' => $key, 'data' => $_r));
                    $_r = [];
                }
                $key = $item[$wt_id_name];
                array_push( $_r, $item);
            }
        }
        if($key != -1) array_push($result, array('wt_id' => $key, 'data' => $_r));

        for($i = 0; $i < count($result); $i++)
        {
            $_temp = $result[$i]['data'];
            if($chart_type == 'minute'){
                usort($_temp, function($a, $b){return $a["Time_Stamp"] <=> $b["Time_Stamp"];});

                $_tp = [];
                $_date_time = "";
                $_count = 0;
                $_wind_speed = 0;
                $_rpm = 0;
                $_stops = 0;
                $_prod = 0;
                foreach ($_temp as $key => $item) {
                    if($_date_time == substr($item['Time_Stamp'], 0, 16)){
                        $_count++;
                        $_wind_speed += $item['Wind_Speed'];
                        $_rpm += $item['RPM'];
                        $_stops += $item['Status'] == 7? 1:0;
                        $_prod += $item['Status'] != 7? $this->cal_power_amount($item['Wind_Speed'], 'S'):0;
                    }
                    else{
                        if($_date_time != ""){
                            $_wind_speed = $_wind_speed / $_count;
                            $_rpm = $_rpm / $_count;
                            array_push( $_tp, array('Time_Stamp' => $_date_time,
                                        'Wind_Speed' => round($_wind_speed, 2),
                                        'RPM' => round($_rpm, 2),
                                        'Stop_number' => $_stops,
                                        'Prod' => round($_prod, 2),
                                            ));
                            $_count = 0;
                            $_wind_speed = 0;
                            $_rpm = 0;
                            $_stops = 0;
                            $_prod = 0;
                        }
                        $_count++;
                        $_wind_speed += $item['Wind_Speed'];
                        $_rpm += $item['RPM'];
                        $_stops += $item['Status'] == 7? 1:0;
                        $_prod += $item['Status'] != 7? $this->cal_power_amount($item['Wind_Speed'], 'S'):0;
                        $_date_time = substr($item['Time_Stamp'], 0, 16);
                    }
                    if($key == (count($_temp) - 1)){
                        $_wind_speed = $_wind_speed / $_count;
                        $_rpm = $_rpm / $_count;
                        array_push( $_tp, array('Time_Stamp' => $_date_time,
                                    'Wind_Speed' => round($_wind_speed, 2),
                                    'RPM' => round($_rpm, 2),
                                    'Stop_number' => $_stops,
                                    'Prod' => round($_prod, 2),
                                        ));
                    }
                }
                $_temp = $_tp;
            }
            else{
                usort($_temp, function($a, $b){return $a["date"] <=> $b["date"];});
            }
            $result[$i]['data'] = $_temp;
        }
        echo json_encode($result);
    }

    public function upload_reporting()
    {
        $validateLogin = $this->validateLogin();

        if ($this
            ->session
            ->userdata('user_role') == 1
        ) {
            $data['Name'] = $validateLogin['Name'];
            $data['Surname'] = $validateLogin['Surname'];
            $data['heading_title'] = 'Upload Reporting';
            $data['active'] = 'register';
            $data['submenuactive'] = '';

            $errors_msg = array();
            if ($this
                ->input
                ->server('REQUEST_METHOD') == 'POST'
            ) {
                if (isset($_FILES['report_file'])) {
                    $file_name = $_FILES['report_file']['name'];
                    $file_size = $_FILES['report_file']['size'];
                    $file_tmp = $_FILES['report_file']['tmp_name'];
                    $file_type = $_FILES['report_file']['type'];
                    //$file_ext=strtolower(end(explode('.',$_FILES['report_file']['name'])));
                    /*$extensions= array("jpeg","jpg","png");
                    
                    if(in_array($file_ext,$extensions)=== false){
                    $errors['msg']="extension not allowed, please choose a JPEG or PNG file.";
                    }*/

                    if ($file_size > 2097152) {
                        $errors_msg['error'] = 'true';
                        $errors_msg['msg'] = 'File size must be excately 2 MB';
                        $this
                            ->session
                            ->set_flashdata('success', 'File size must be excately 2 MB');
                    }

                    if (empty($errors) == true) {
                        move_uploaded_file($file_tmp, "media/Capespigne/docs/Repport/" . time() . '-' . $file_name);
                        $errors_msg['error'] = 'false';
                        $errors_msg['msg'] = 'Success';
                        $this
                            ->session
                            ->set_flashdata('success', 'File Uploaded Successfully');
                    } else {
                        $this
                            ->session
                            ->set_flashdata('success', 'Technical Error');
                    }

                    redirect('admin/register');
                    exit();
                }
            }
            $data['upload_msg'] = $errors_msg;
            $this
                ->load
                ->view('upload_reporting', $data);
        } else {
            redirect('admin/register/');
        }
    }

    public function register()
    {
        $validateLogin = $this->validateLogin();
        $data['Name'] = $validateLogin['Name'];
        $data['Surname'] = $validateLogin['Surname'];
        $data['heading_title'] = 'Register';
        $data['active'] = 'register';
        $data['submenuactive'] = '';
        $this
            ->load
            ->view('register', $data);
    }

    public function upload_register()
    {
        $validateLogin = $this->validateLogin();

        if ($this
            ->session
            ->userdata('user_role') == 1
        ) {
            $data['Name'] = $validateLogin['Name'];
            $data['Surname'] = $validateLogin['Surname'];
            $data['heading_title'] = 'Upload Register';
            $data['active'] = 'register';
            $data['submenuactive'] = '';

            $errors_msg = array();
            if ($this
                ->input
                ->server('REQUEST_METHOD') == 'POST'
            ) {
                if (isset($_FILES['report_file'])) {
                    $file_name = $_FILES['report_file']['name'];
                    $file_size = $_FILES['report_file']['size'];
                    $file_tmp = $_FILES['report_file']['tmp_name'];
                    $file_type = $_FILES['report_file']['type'];
                    //$file_ext=strtolower(end(explode('.',$_FILES['report_file']['name'])));
                    /*$extensions= array("jpeg","jpg","png");
                    
                    if(in_array($file_ext,$extensions)=== false){
                    $errors['msg']="extension not allowed, please choose a JPEG or PNG file.";
                    }*/

                    if ($file_size > 2097152) {
                        $errors_msg['error'] = 'true';
                        $errors_msg['msg'] = 'File size must be excately 2 MB';
                        $this
                            ->session
                            ->set_flashdata('success', 'File size must be excately 2 MB');
                    }

                    if (empty($errors) == true) {
                        move_uploaded_file($file_tmp, "media/Capespigne/docs/Register/" . time() . '-' . $file_name);
                        $errors_msg['error'] = 'false';
                        $errors_msg['msg'] = 'Success';
                        $this
                            ->session
                            ->set_flashdata('success', 'File Uploaded Successfully');
                    } else {
                        $this
                            ->session
                            ->set_flashdata('success', 'Technical Error');
                    }

                    redirect('admin/register');
                    exit();
                }
            }
            $data['upload_msg'] = $errors_msg;
            $this
                ->load
                ->view('upload_register', $data);
        } else {
            redirect('admin/register/');
        }
    }

    public function contact()
    {
        $validateLogin = $this->validateLogin();
        $data['Name'] = $validateLogin['Name'];
        $data['Surname'] = $validateLogin['Surname'];
        $data['heading_title'] = 'Contact';
        $data['active'] = 'contact';
        $data['submenuactive'] = '';

        $get_wind_farms = $this
            ->Dashboardmodel
            ->get_wind_farms();
        $get_entities = $this
            ->Dashboardmodel
            ->get_entities();

        $get_people_arrs = array();
        foreach ($get_entities as $key => $entity_val) {
            $get_people_arr = array();
            $get_people_arr['ID'] = $entity_val['ID'];
            $get_people_arr['Type'] = $entity_val['Type'];
            $get_people_arr['Name'] = $entity_val['Name'];
            $get_people_arr['get_people'] = $this
                ->Dashboardmodel
                ->get_people_by_EntityID($entity_val['ID']);
            $get_people_arrs[] = $get_people_arr;
        }

        $data['get_contacts'] = $get_people_arrs;
        $this
            ->load
            ->view('contact', $data);
    }

    public function graphtest()
    {
        $validateLogin = $this->validateLogin();
        $data['Name'] = $validateLogin['Name'];
        $data['Surname'] = $validateLogin['Surname'];

        $data['heading_title'] = 'Dashboard';
        $data['active'] = 'dashboard';
        $data['submenuactive'] = '';
        $clusterid = 9;
        $get_cameras_in_cluster_by_clusterid = $this
            ->Dashboardmodel
            ->get_cameras_in_cluster_by_clusterid($clusterid);

        $probirds_arrs = array();
        if (count($get_cameras_in_cluster_by_clusterid) > 0) {
            foreach ($get_cameras_in_cluster_by_clusterid as $key => $get_cameras_in_cluster) {

                $get_probird_orders_by_camera_id = $this
                    ->Dashboardmodel
                    ->get_probird_orders_by_camera_id($get_cameras_in_cluster['Camera_ID']);
                if (count($get_probird_orders_by_camera_id) > 0) {
                    foreach ($get_probird_orders_by_camera_id as $key => $get_probird_orders) {
                        $probirds_arr = array();
                        $probirds_arr['Time_Stamp'] = $get_probird_orders['Time_Stamp'];
                        $exp_time = explode(' ', $probirds_arr['Time_Stamp']);
                        $probirds_arr['birddate'] = $exp_time[0];
                        $get_bird_exp_1 = $exp_time[1];
                        $get_bird_exp_2 = explode(':', $get_bird_exp_1);
                        $probirds_arr['birdtime'] = $get_bird_exp_2[0] . '.' . $get_bird_exp_2[1] . $get_bird_exp_2[2];
                        $probirds_arr['Value'] = $get_probird_orders['Value'];
                        $probirds_arr['opc_order_id'] = $get_probird_orders['ID'];
                        $probirds_arr['Wind_Turbine'] = $get_probird_orders['Wind_Turbine'];
                        $probirds_arrs[] = $probirds_arr;
                    }
                }
            }
        }
        $data['get_bird_data'] = $probirds_arrs;

        $this
            ->load
            ->view('graphdemo', $data);
    }

    public function get_video_by_opc_order_id()
    {
        $response_arr = array();
        $response_arr['error'] = true;
        if ($_POST['opc_order_id'] > 0) {
            $opc_order_id = $_POST['opc_order_id'];
            $cluster_idss = $_POST['cluster_idd'];

            $get_probird_status = $this
                ->Dashboardmodel
                ->get_probird_status_by_opc_order_id($opc_order_id);
            $Time_Stamp = $get_probird_status['Time_Stamp'];
            $Camera_ID = $get_probird_status['Camera_source'];

            $exp_time = explode(' ', $get_probird_status['Time_Stamp']);
            $final_date = $exp_time[0];
            $get_bird_exp_1 = $exp_time[1];
            $get_bird_exp_2 = explode(':', $get_bird_exp_1);
            $final_time = $get_bird_exp_2[0] . 'h' . $get_bird_exp_2[1] . 'm' . $get_bird_exp_2[2] . 'ss';

            $get_clustersss = $this
                ->Dashboardmodel
                ->get_cameras_in_cluster_by_cameraid($Camera_ID);
            $get_camera = $this
                ->Dashboardmodel
                ->get_camera_by_cameraid($Camera_ID);
            $camera_name = $get_camera['Name'];

            $Cluster_id_cnf_with_camera = $get_clustersss[0]['Cluster_ID'];

            $get_wt_packs_in_clusterss = $this
                ->Dashboardmodel
                ->get_wt_packs_in_cluster($Cluster_id_cnf_with_camera);
            $Wt_pack_id_arry = array();

            foreach ($get_wt_packs_in_clusterss as $key => $value) {

                $get_wind_turbine_packs['WT_pck_id'] = $this
                    ->Dashboardmodel
                    ->get_wind_turbine_pack_by_wt_pack_id($value['WT_pack_ID']);

                if (strpos($get_wind_turbine_packs['WT_pck_id']['camera_name'], $camera_name) !== false) {

                    $filepath_ip = str_replace("_", "-", $get_wind_turbine_packs['WT_pck_id']['folder_name']);

                    /*$wt_packid = $get_wind_turbine_packs['WT_pck_id']['ID'];
                    
                    $query = $this->db->get_where('medias',array('WT_pack_ID'=>$wt_packid,'Time_Stamp'=>$Time_Stamp));
                    $result = $query->result_array();*/

                    $file_name = 'CAP-' . $filepath_ip . '_' . $final_date . '_' . $final_time . '.mp4';

                    $final_arrs = array();
                    $directory = '/media/Capespigne';

                    $scanned_directory = array_diff(scandir($directory), array(
                        '..',
                        '.'
                    ));

                    if (in_array($get_wind_turbine_packs['WT_pck_id']['folder_name'], $scanned_directory)) {

                        $directory = '/media/Capespigne/' . $get_wind_turbine_packs['WT_pck_id']['folder_name'];

                        $scanned_directory = array_diff(scandir($directory), array(
                            '..',
                            '.'
                        ));

                        if (in_array($final_date, $scanned_directory)) {
                            $directory = '/media/Capespigne/' . $get_wind_turbine_packs['WT_pck_id']['folder_name'] . '/' . $final_date;

                            $scanned_directory = array_diff(scandir($directory), array(
                                '..',
                                '.'
                            ));

                            if (in_array('Videos', $scanned_directory)) {

                                $directory = '/media/Capespigne/' . $get_wind_turbine_packs['WT_pck_id']['folder_name'] . '/' . $final_date . '/Videos';

                                $scanned_directory = array_diff(scandir($directory), array(
                                    '..',
                                    '.'
                                ));
                                $final_time_remove_h = str_replace("h", ":", $final_time);

                                $final_time_remove_mn = str_replace("m", ":", $final_time_remove_h);

                                $final_time_remove_ss = str_replace("ss", "", $final_time_remove_mn);
                                
                                //echo $final_date.' '.$final_time_remove_ss;
                                $final_time_remove_ss = strtotime($final_date . ' ' . $final_time_remove_ss);
                                //$final_time_remove_ss = strtotime('2021-12-16 09:08:46'); // Just For Test Multiple Videos


                                foreach ($scanned_directory as $key => $value) {
                                    $string_remove1 = str_replace("CAP", "", $value);
                                    $string_remove1 = explode("_", $value);
                                    $string_remove1 = $string_remove1[count($string_remove1)-1];
                                    // $string_remove1 = str_replace("-" . $get_wind_turbine_packs['WT_pck_id']['folder_name'], "", $string_remove1);
                                    // var_dump("-" . $get_wind_turbine_packs['WT_pck_id']['folder_name']);
                                    // var_dump($string_remove1);
                                    // $string_remove1 = str_replace("_" . $final_date . "_", "", $string_remove1);
                                    
                                    $string_remove1 = str_replace(".mp4", "", $string_remove1);
                                    $string_hour = str_replace("h", "", $string_remove1);
                                    $string_minute = str_replace("m", "", $string_hour);
                                    $string_sec = str_replace("ss", "", $string_minute);
                                    //echo mktime((int)$string_hour,(int)$string_minute,(int)$string_sec);
                                    $arr1 = str_split($string_sec, 2);
                                    $arr2 = implode(':', $arr1);
                                    $timestamp = strtotime($final_date . ' ' . $arr2);

                                    //$time = date("Y:m:d h:i:s", time() + 30);
                                    // $timestamp_minus_30 = strtotime("-30 seconds", strtotime($final_date . ' ' . $arr2));
                                    $timestamp_minus_30 = strtotime("-30 seconds", $final_time_remove_ss);

                                    //echo "<br>";
                                    //echo $timestamp_minus_30_final =  date('Y-m-d H:i:s', $timestamp_minus_30);
                                    //echo "<br>";
                                    // $timestamp_plus_5 = strtotime("+10 seconds", strtotime($final_date . ' ' . $arr2));
                                    $timestamp_plus_5 = strtotime("+10 seconds", $final_time_remove_ss);

                                    //echo "<br>";
                                    //echo $timestamp_plus_5_final =  date('Y-m-d H:i:s', $timestamp_plus_5);
                                    //echo "<br>";
                                    //echo date('Y-m-d H:i:s',$final_time_remove_ss)." >= ".date('Y-m-d H:i:s',$timestamp_minus_30) .' && ' .date('Y-m-d H:i:s',$final_time_remove_ss) .' >= '.date('Y-m-d H:i:s',$timestamp_plus_5);
                                    //echo "<br>";
                                    // if ($final_time_remove_ss >= $timestamp_minus_30 && $final_time_remove_ss >= $timestamp_plus_5) {
                                    if ($timestamp >= $timestamp_minus_30 && $timestamp <= $timestamp_plus_5) {
                                        $final_arr = array();
                                        $final_arr['file_path'] = $value;

                                        $file_path = UPLOADMEDIAROOT . 'Capespigne/' . $get_wind_turbine_packs['WT_pck_id']['folder_name'] . '/' . $final_date . '/Videos/' . $value;
                                        $final_arr['file_size'] = filesize($file_path);
                                        $final_arrs[] = $final_arr;
                                    }
                                }
                            }
                        }
                    }
                    $large_file_path = '';
                    $count = count($final_arrs);

                    if (count($final_arrs) > 1) {

                        $max_file_size = 0;

                        foreach ($final_arrs as $key => $video_value) {
                            $max_file_size = max(array(
                                $max_file_size,
                                $video_value['file_size']
                            ));
                        }


                        foreach ($final_arrs as $key => $value) {

                            if (in_array($max_file_size, $value)) {
                                $large_file_path = UPLOADMEDIAROOT . 'Capespigne/' . $get_wind_turbine_packs['WT_pck_id']['folder_name'] . '/' . $final_date . '/Videos/' . $value['file_path'];
                            }
                        }
                        //echo $max_file_size;

                    } else {

                        foreach ($final_arrs as $key => $value) {

                            $large_file_path = UPLOADMEDIAROOT . 'Capespigne/' . $get_wind_turbine_packs['WT_pck_id']['folder_name'] . '/' . $final_date . '/Videos/' . $value['file_path'];
                        }
                    }
                    if($large_file_path == ""){
                        $response_arr['url'] = "";
                        $response_arr['videoName'] = "";
                        $response_arr['error'] = true;
                    }
                    else{
                        $response_arr['url'] = $large_file_path;
                        $response_arr['videoName'] = $value['file_path'];
                        $response_arr['error'] = false;
                    }
                } else {
                }
            }

            $WT_pack_idss = $get_wt_packs_in_clusterss[0]['WT_pack_ID'];
        }
        echo json_encode($response_arr);
        die();
    }

    public function sytemstatus()
    {

        $default_timezone = date_default_timezone_get();
        $date = new DateTime("now", new DateTimeZone($default_timezone));

        $Current_time = $date->format('Y-m-d H:i:s');
        //echo "<br>";
        $before_30_time = strtotime($date->format('Y-m-d H:i:s'));
        $before_30_time = $before_30_time - (10 * 60);
        $Before_time = date("Y-m-d H:i:s", $before_30_time);

        /*$get_wind_turbine_id = 2;
        $get_system_status_last10minutes = $this->Dashboardmodel->get_system_status_last10minutes($get_wind_turbine_id,$Current_time,$Before_time);
        
        echo "<pre>";
        print_r($get_system_status_last10minutes);
        echo "</pre>";*/

        $validateLogin = $this->validateLogin();
        $data['Name'] = $validateLogin['Name'];
        $data['Surname'] = $validateLogin['Surname'];
        $data['heading_title'] = 'System status';
        $data['active'] = 'sytemstatus';
        $data['submenuactive'] = '';
        $main_arrs = array();

        $get_wind_turbines = $this
            ->Dashboardmodel
            ->get_wind_turbine();
        foreach ($get_wind_turbines as $key => $get_wind_turbine) {

            $camera_arrs = array();
            $camera_arrs['wind_turbine_id'] = $get_wind_turbine['ID'];
            $camera_arrs['wind_turbine_name'] = $get_wind_turbine['Name'];
            $get_single_computer = $this
                ->Dashboardmodel
                ->get_computer_by_wind_turbine_id($get_wind_turbine['ID']);
            if ($get_single_computer != '') {
                //echo 'Computer ID ='.$get_single_computer['ID'].'<br>';
                $camera_arrs['computer_name'] = $get_single_computer['Name'];
            } else {
                $camera_arrs['computer_name'] = 'NA';
            }
            $system_status_arrs = array();
            $get_system_status = $this
                ->Dashboardmodel
                ->get_system_status_by_device_pc($get_wind_turbine['ID']);

            /*$get_probird_softwares = $this->Dashboardmodel->get_probirds_softwares_by_computer($get_wind_turbine['ID']);
            $probirds_arrs01 = array();
            if(count($get_probird_softwares) > 0){
            	foreach ($get_probird_softwares as $key => $value) {
            		$probirds_arrs01[] = $value['ID'];
            	}
            }
            
            echo "<pre>";
            print_r($probirds_arrs01);
            echo "</pre>";*/

            $camera_arrs['system_status_count'] = $get_system_status;
            $get_latest20_system_status = $this
                ->Dashboardmodel
                ->get_latest20_system_status_by_device_pc($get_wind_turbine['ID']);
            $latest20_system_status_arrs = array();
            foreach ($get_latest20_system_status as $key => $get_latest20_system_sts) {
                $latest20_system_status = array();
                $latest20_system_status['ScriptID'] = $get_latest20_system_sts['Script'];
                $latest20_system_status['Type'] = $get_latest20_system_sts['Type'];
                $latest20_system_status['TimeStamp'] = $get_latest20_system_sts['TimeStamp'];

                //$get_script = $this->Dashboardmodel->get_script_by_scriptid($get_latest20_system_sts['Script']);
                //$latest20_system_status['ScriptName'] = $get_script['Name'];
                $latest20_system_status_arrs[] = $latest20_system_status;
            }
            $camera_arrs['system_status_scripts'] = $latest20_system_status_arrs;

            $get_cameras = $this
                ->Dashboardmodel
                ->get_cameras_by_wind_turbine_id($get_wind_turbine['ID']);
            $camera_arrs01 = array();
            foreach ($get_cameras as $key => $get_camera) {
                $camera_arr = array();
                $camera_arr['Name'] = $get_camera['Name'];
                $camera_arr['IP'] = $get_camera['IP'];
                $camera_arrs01[] = $camera_arr;
            }
            $camera_arrs['cameras'] = $camera_arrs01;

            //$camera_arrs['get_probirds_softwares'] = $this->Dashboardmodel->get_probirds_softwares_by_wind_turbine($get_wind_turbine['ID']);
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


        $data['get_system_status'] = $main_arrs;

        /*--------------Get PLD Name--------------*/
        $get_wind_turbines_by_pdl = $this
            ->Dashboardmodel
            ->get_wind_turbine_by_pdl();

        $get_pdl_arrs = array();
        foreach ($get_wind_turbines_by_pdl as $key => $wind_turbines_by_pdl) {
            $get_pdl_arr = array();
            $get_pdl_arr['ID'] = $wind_turbines_by_pdl['ID'];
            $get_pdl_arr['PDLName'] = $wind_turbines_by_pdl['Name'];
            $get_pdl_arr['computers_by_pdl'] = $this
                ->Dashboardmodel
                ->get_computers_by_pdl($wind_turbines_by_pdl['ID']);
            $get_pdl_arrs[] = $get_pdl_arr;
        }
        $data['get_pdl_names_new'] = $get_pdl_arrs;
        $this
            ->load
            ->view('systems_tatus', $data);
    }

    public function sytemstatus_()
    {

        $default_timezone = date_default_timezone_get();
        $date = new DateTime("now", new DateTimeZone($default_timezone));

        $Current_time = $date->format('Y-m-d H:i:s');
        //echo "<br>";
        $before_30_time = strtotime($date->format('Y-m-d H:i:s'));
        $before_30_time = $before_30_time - (10 * 60);
        $Before_time = date("Y-m-d H:i:s", $before_30_time);

        $validateLogin = $this->validateLogin();
        $data['Name'] = $validateLogin['Name'];
        $data['Surname'] = $validateLogin['Surname'];
        $data['heading_title'] = 'System status';
        $data['active'] = 'sytemstatus';
        $data['submenuactive'] = '';
        $main_arrs = array();

        // Get Basic data
        $wind_turbines = $this->Dashboardmodel->get_wind_turbines();
        $computers = $this->Dashboardmodel->query_wind_turbine_cominfo_for_systemstatus();
        $status = $this->Dashboardmodel->query_status();
        $com_wt_relation = $this->Dashboardmodel->query_computer_wt_relation();
        $_PDL_scripts = ["REPLICATION", "WATCHDOG", "VISIBILIMETRE"];

        // Active/inActive  as per status of the script
        $_PCs = [];
        $_WT_IDs = [];
        foreach ($status as $st) {
            if (!$st['status']) {
                if (in_array($st['computer_id'], $_PCs)) continue;
                else {
                    array_push($_PCs, $st['computer_id']);
                    foreach ($com_wt_relation as $cwr) {
                        if ($cwr['Computer_ID'] == $st['computer_id']) {
                            array_push($_WT_IDs, $cwr['WT_ID']);
                        }
                    }
                }
            }
        }

        // Get Wind Turbines with computers and PDL
        foreach ($wind_turbines as $key => $wind_turbine) {

            $_computers = [];

            $_active = true;
            if (in_array($wind_turbine['ID'], $_WT_IDs)) $_active = false;

            foreach ($computers as $computer) {
                if ($computer['wt_id'] == $wind_turbine['ID']) {

                    $_status = [];
                    foreach ($status as $st) {
                        if ($st['computer_id'] == $computer['c_id']) {
                            array_push($_status, $st);
                            if ($wind_turbine['Type'] == 'PDL' && in_array($st['sc_name'], $_PDL_scripts)) {
                                $_active  = false;
                            }
                        }
                    }
                    $computer['script'] = $_status;
                    array_push($_computers, $computer);
                }
            }
            $wind_turbines[$key]['computers'] = $_computers;

            $wind_turbines[$key]['active'] = $_active;
        }


        $_wind_turbines = [];
        $_PDLs = [];
        foreach ($wind_turbines as $key => $wind_turbine) {
            if ($wind_turbine['Type'] == 'PDL') {
                array_push($_PDLs, $wind_turbine);
            } else {
                array_push($_wind_turbines, $wind_turbine);
            }
        }
        $wind_turbines = array_merge($_wind_turbines, $_PDLs);
        $data['wind_turbines'] =  $wind_turbines;

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo (json_encode($wind_turbines));
            exit;
        }
        return $this->load->view('systemstatus', $data);
    }



    /* No Used... ONly Backup */
    public function system_status_test()
    {

        /*echo $Current_time = date("Y-m-d H:i:s").'<br>';
         echo $Before_time = date("Y-m-d H:i:s", strtotime('0 hours -5 minutes')).'<br>';*/

        $validateLogin = $this->validateLogin();
        $data['Name'] = $validateLogin['Name'];
        $data['Surname'] = $validateLogin['Surname'];
        $data['heading_title'] = 'System status';
        $data['active'] = 'sytemstatus';
        $data['submenuactive'] = '';

        $main_arrs = array();
        $get_wind_turbines = $this
            ->Dashboardmodel
            ->get_wind_turbine();
        foreach ($get_wind_turbines as $key => $get_wind_turbine) {

            $get_cameras = $this
                ->Dashboardmodel
                ->get_cameras_by_wind_turbine_id($get_wind_turbine['ID']);
            $camera_arrs = array();
            $camera_arrs['wind_turbine_id'] = $get_wind_turbine['ID'];
            $camera_arrs['wind_turbine_name'] = $get_wind_turbine['Name'];
            $get_single_computer = $this
                ->Dashboardmodel
                ->get_computer_by_wind_turbine_id($get_wind_turbine['ID']);
            if ($get_single_computer != '') {
                $camera_arrs['computer_name'] = $get_single_computer['Name'];
            } else {
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
            $get_system_status = $this
                ->Dashboardmodel
                ->get_system_status_by_device_pc($get_wind_turbine['ID']);
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
        $this
            ->load
            ->view('system_status_test', $data);
    }

    private function validateLogin()
    {
        if ($this
            ->session
            ->userdata('logged_in') == false && $this
            ->session
            ->userdata('UserID') == ''
        ) {
            $array_items = array(
                'UserID' => '',
                'logged_in' => false
            );
            $this
                ->session
                ->unset_userdata($array_items);
            redirect('/');
            exit();
        }
        $sess = $this
            ->session
            ->userdata();
        $name = $sess['name'];
        $name_expl = explode(' ', $name);

        $data['Name'] = $name_expl[0];
        $data['Surname'] = $name_expl[1];

        return $data;
    }
}
