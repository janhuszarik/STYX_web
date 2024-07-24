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

    $route['default_controller'] 			= 'app';
    $route['404_override'] 					= 'app/error404';
    $route['404'] 							= 'app/error404';
    $route['error404'] 						= 'app/error404';
	$route['generate_data'] 				= 'Generate_data/index';
	$route['auth/login'] 					= 'auth/login';
    $route['login'] 						= 'auth/login';
	$route['register'] 						= '/auth/register';
	$route['auth/register'] 				= '/auth/register';
    $route['auth/logout'] 					= 'auth/logout';
    $route['logout'] 						= 'auth/logout';
    $route['auth/activate'] 				= 'auth/activate';
    $route['auth/forgot_password'] 			= 'auth/forgot_password';
	$route['change_password'] 				= 'auth/change_password';
	$route['auth/change_password'] 			= 'auth/change_password';
	$route['auth'] 							= 'auth';
	$route['xml/sitemap'] 					= 'xml/sitemap';
	$route['error404only'] 					= 'app/error404only';
	$route['sitemap'] 						= 'xml/sitemap';
    $route['sitemap.xml'] 					= 'xml/sitemap';
	$route['translate_uri_dashes'] 			= FALSE;
// administrator

    
    $route['admin'] 						= 'admin';
    $route['admin/menu'] 					= 'admin/menuSave';
    $route['admin/menuSave']				= 'admin/menuSave';
    $route['admin/menu/edit/:num'] 			= 'admin/menuSave';
    $route['admin/menu/del/:num'] 			= 'admin/menuSave';
    $route['admin/articles'] 				= 'admin/articles';
    $route['admin/articlesDelete'] 			= 'admin/articlesDelete';


	$route['admin/slider'] 					= 'admin/sliderSave';
	$route['admin/sliderSave'] 				= 'admin/sliderSave';
	$route['admin/sliderSave/(:num)'] 		= 'admin/sliderSave/$1';
	$route['admin/delete_slider/(:num)'] 	= 'admin/delete_slider/$1';

	$route['admin/news'] 					= 'admin/newsSave';
	$route['admin/newsSave'] 				= 'admin/newsSave';
	$route['admin/news/edit/:num'] 			= 'admin/newsSave';
	$route['admin/news/del/:num']			= 'admin/newsSave';

	$route['admin/bestProduct'] 			= 'admin/bestProductSave';
	$route['admin/bestProductSave'] 		= 'admin/bestProductSave';
	$route['admin/bestProduct/edit/:num'] 	= 'admin/bestProductSave';
	$route['admin/bestProduct/del/:num']	= 'admin/bestProductSave';

	$route['admin/commentar'] 					= 'admin/commentarSave';
	$route['admin/commentarSave'] 				= 'admin/commentarSave';
	$route['admin/commentar/edit/:num'] 		= 'admin/commentarSave';
	$route['admin/commentar/del/:num']			= 'admin/commentarSave';

	$route['Unternehmen/AboutStyx']			= 'App/aboutStyx';
	$route['Naturkosmetik']					= 'App/naturkosmetik';
	$route['app/naturkosmetik']				= 'App/naturkosmetik';
	$route['Aroma-Derm']					= 'App/aromaDerm';
	$route['app/aromaDerm']					= 'App/aromaDerm';
	$route['Schokoladen']					= 'App/schokoladen';
	$route['app/schokoladen']				= 'App/schokoladen';
	$route['Schokolade/figuren']			= 'App/figuren';
	$route['Private-labeling']				= 'App/privateLabeling';
	$route['app/Private-labeling']			= 'App/privateLabeling';
	$route['Werbegeschenke']				= 'App/werbegeschenke';
	$route['app/werbegeschenke']			= 'App/werbegeschenke';
	$route['Company/About-Styx']			= 'App/contact';


























	$route['set-cookie-consent'] 			= 'app/set_cookie_consent';
	$route['decline-cookie-consent'] 		= 'app/decline_cookie_consent';




	$route[':any/:any'] = 'app/routes';


//	$route['^en/(.+)$'] = "$1";
//	$route['^de/(.+)$'] = "$1";
//
//	$route['^en$'] = $route['default_controller'];
//	$route['^de$'] = $route['default_controller'];



