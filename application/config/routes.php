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


/*$route['default_controller'] = 'belajar';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
*/
//$route['belajar/(:any)'] = 'view/$1';
//$route['belajar'] = 'belajar';
//$route['(:any)'] = 'belajar/view/$1';
$route['default_controller'] = 'seller/seller';
$route['panel/login'] = 'login/login';
$route['panel/register'] = 'login/register';
$route['panel/reseller/(:any)/server'] = 'seller/seller/$1';
$route['panel/reseller/(:any)/addsaldo-via-hp'] = 'seller/addsaldo_hp';
$route['panel/reseller/(:any)/addsaldo-via-req'] = 'seller/addsaldo_req';
$route['panel/(:any)/setting'] = 'login/setting';
$route['panel/(:any)/logout'] = 'login/logout';
$route['panel/seller/(:any)'] = 'seller/seller/$1';
$route['panel/admin/(:any)'] = 'admin/admin/$1';
$route['panel/administrator/edit/(:any)/(:any)/(:any)'] = 'admin/lock/$2/$3';
$route['panel/seller/(:any)/(:any)/(:any)/(:any)'] = 'seller/buy/$4';
$route['panel/administrator/edit/(:any)/(:any)'] = 'admin/edit/$2';
$route['panel/administrator/(:any)/(:any)'] = 'admin/server/$2';
$route['join'] = 'seller/seller';
$route['panel/reseller/cek_account/(:any)'] = 'seller/cek_account/$1';
