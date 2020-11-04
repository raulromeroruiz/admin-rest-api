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
$route['default_controller'] = 'admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

#Admin controllers
$route['admin'] = "admin";
$route['admin/home'] = "administrator/home";
$route['admin/manager/(:any)'] = "administrator/admin/manager/$1";
$route['admin/actions'] = "administrator/admin/actions";
$route['admin/login'] = "administrator/admin/login";
$route['admin/logout'] = "administrator/admin/logout";

$route['admin/banners'] = "administrator/banners";
$route['admin/banners/get/(:num)'] = "administrator/banners/get/$1";
$route['admin/banners/save'] = "administrator/banners/save";

$route['admin/noticias'] = "administrator/noticias";
$route['admin/noticias/get/(:num)'] = "administrator/noticias/get/$1";
$route['admin/noticias/save'] = "administrator/noticias/save";

$route['admin/proyectos'] = "administrator/proyectos";
$route['admin/proyectos/get/(:num)'] = "administrator/proyectos/get/$1";
$route['admin/proyectos/save'] = "administrator/proyectos/save";
$route['admin/proyectos/delete'] = "administrator/proyectos/delete";
$route['admin/proyectos/change_image'] = "administrator/proyectos/change_image";
$route['admin/proyectos/oficinas/(:num)'] = "administrator/proyectos/oficinas/$1";

$route['admin/oficinas/get/(:num)'] = "administrator/proyectos/oficina/$1";
$route['admin/oficinas/save'] = "administrator/proyectos/oficina/save";
$route['admin/oficinas/delete'] = "administrator/proyectos/oficina/delete";

$route['admin/urban/get/(:num)'] = "administrator/proyectos/urban/$1";
$route['admin/urban/save'] = "administrator/proyectos/urban/save";
$route['admin/urban/delete'] = "administrator/proyectos/urban/delete";

$route['admin/banners/delete'] = "administrator/proyectos/banners/delete";

$route['admin/usuarios'] = "administrator/usuarios";
$route['admin/usuarios/get/(:num)'] = "administrator/usuarios/get/$1";
$route['admin/usuarios/save'] = "administrator/usuarios/save";
$route['admin/usuarios/confirm'] = "administrator/usuarios/confirm";

$route['admin/perfil'] = "administrator/perfil";
$route['admin/perfil/get/(:num)'] = "administrator/perfil/get/$1";
$route['admin/perfil/save'] = "administrator/perfil/save";

$route['404_override'] = 'error';