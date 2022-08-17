<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'Front/Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//$route['admin/login'] = 'Admin/Login';
$route['default_controller'] = 'Admin/Login';

$route['admin'] = 'Admin/Dashboard';
$route['admin/logout'] = 'Admin/Login/logout';

// $route['admin/sytemstatus'] = 'Admin/Dashboard/sytemstatus';
$route['admin/sytemstatus'] = 'Admin/Dashboard/sytemstatus_';
$route['admin/record'] = 'Admin/Dashboard/record';
$route['admin/reporting'] = 'Admin/Dashboard/reporting';
$route['admin/reporting/wt_graph'] = 'Admin/Dashboard/wt_graph';

$route['admin/upload/reporting'] = 'Admin/Dashboard/upload_reporting';
$route['admin/register'] = 'Admin/Dashboard/register';
$route['admin/upload/register'] = 'Admin/Dashboard/upload_register';
$route['admin/contact'] = 'Admin/Dashboard/contact';
$route['admin/get_wt_packs_in_cluster'] = 'Admin/Dashboard/get_wt_packs_in_cluster';
$route['admin/get_slider_by_wt_pack_id'] = 'Admin/Dashboard/get_slider_by_wt_pack_id';
$route['admin/get_graph_by_cluster'] = 'Admin/Dashboard/get_graph_by_cluster';
$route['admin/graphtest'] = 'Admin/Dashboard/graphtest';
//$route['admin/systemstatustest'] = 'Admin/Dashboard/system_status_test';
$route['admin/records'] = 'Admin/Dashboard/records';
$route['admin/get_cameras_by_clusterid'] = 'Admin/Dashboard/get_cameras_by_clusterid';
$route['admin/get_multiple_cameras_by_clusterids'] = 'Admin/Dashboard/get_multiple_cameras_by_clusterids';

$route['admin/exportFile'] = 'Admin/Dashboard/ExportFile';

$route['admin/exportzipFile'] = 'Admin/Dashboard/ExportZipFile';



$route['admin/get_video_by_opc_order_id'] = 'Admin/Dashboard/get_video_by_opc_order_id';


/*==== Admin Users ====
$route['admin/users'] = 'Admin/Users';
$route['admin/users/(:num)'] = 'Admin/Users';
$route['admin/deleteuser/:num'] = 'Admin/Users/deleteuser';
$route['admin/adduser'] = 'Admin/Adduser';
$route['admin/adduservalidation'] = 'Admin/Adduser/adduserAjaxValidation';
$route['admin/edituser/:num'] = 'Admin/Edituser';
$route['admin/edituser/updateuservalidation'] = 'Admin/Edituser/updateuserAjaxValidation';*/

