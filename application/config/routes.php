<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

$route['default_controller'] = "index";
$route['404_override'] = 'index/index';
 
$route['welcome/(:any)'] = "welcome/$1";
$route['welcome'] = "welcome";
$route['registerlocation'] = "index/main";
$route['auth/(:any)'] = "auth/$1";
$route['auth'] = "auth";
$route['admin/(:any)'] = "admin/$1";
$route['admin'] = "admin";
$route['api/(:any)'] = "api/$1";
$route['favourite/(:any)'] = "favourite/$1";
$route['favourite'] = "favourite";
$route['index/(:any)'] = "index/$1";
$route['friends/(:any)'] = "friends/$1";
$route['friends/*'] = "friends/index";
$route['mobile/(:any)'] = "mobile/$1";
$route['mobile'] = "mobile";
$route['location/(:any)'] = "location/$1";
$route['qr/(:any)'] = "qr/$1";
$route['user/(:any)'] = "user/$1";
$route['user'] = "user";
$route['report/(:any)'] = "report/$1";
$route['search/(:any)'] = "search/$1";
$route['sitemap\.xml'] = "seo";
$route['page/about'] = "index/about";
$route['page/api'] = "index/api";
$route['page/apidemo'] = "index/apidemo";
$route['page/partner'] = "index/partner";
$route['page/terms'] = "index/terms";
$route['page/privacy'] = "index/privacy";
$route['page/(:any)'] = "index/page/$1";
$route['notifications/(:any)'] = "notifications/$1";
$route['notifications'] = "notifications";
$route['searchloc'] = "searchloc/index";
$route['(:any)'] = "location/view/$1";
/* End of file routes.php */
/* Location: ./application/config/routes.php */ ?>