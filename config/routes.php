<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//$route['default_controller'] = "news";
//$route['404_override'] = '';

$route['news/create'] = 'news/create';
$route['ads/create'] = 'ads/create';
$route['alerts/create'] = 'alerts/create';
$route['ads/delete'] = 'ads/delete';
$route['alerts/delete/(:any)'] = 'alerts/delete/$1';
$route['ads/delete/(:any)'] = 'ads/delete/$1';
$route['ads/single/(:any)'] = 'ads/single/$1';
$route['alerts/index'] = 'alerts/index';
$route['scraper/index'] = 'scraper/index';
$route['scraper/run'] = 'scraper/run';
$route['adsearch/index'] = 'adsearch/index';
$route['notifications/(:any)'] = 'notifications/$1';
$route['statistics/index'] = 'statistics/index';
$route['statistics/(:any)'] = 'statistics/$1';
$route['ads/index'] = 'ads/index';
$route['ads/index/(:any)'] = 'ads/index/$1';
$route['news/(:any)'] = 'news/view/$1';
$route['alerts/operations/(:any)'] = 'alerts/operations/$1';
$route['news'] = 'news';
$route['(:any)'] = 'pages/view/$1';
$route['default_controller'] = 'pages/view';

/* End of file routes.php */
/* Location: ./application/config/routes.php */