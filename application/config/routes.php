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
$route['home'] = "administrator/home";
$route['manager/(:any)'] = "administrator/admin/manager/$1";
$route['actions'] = "administrator/admin/actions";
$route['login'] = "administrator/admin/login";
$route['logout'] = "administrator/admin/logout";

$route['categorias'] = "administrator/categorias";
$route['categorias/get/(:num)'] = "administrator/categorias/get/$1";
$route['categorias/save'] = "administrator/categorias/save";
$route['categorias/delete'] = "administrator/categorias/delete";
$route['categorias/change_image'] = "administrator/categorias/change_image";

$route['productos'] = "administrator/productos";
$route['productos/get/(:num)'] = "administrator/productos/get/$1";
$route['productos/save'] = "administrator/productos/save";
$route['productos/delete'] = "administrator/productos/delete";
$route['productos/change_image'] = "administrator/productos/change_image";

$route['combos'] = "administrator/combos";
$route['combos/get/(:num)'] = "administrator/combos/get/$1";
$route['combos/save'] = "administrator/combos/save";
$route['combos/delete'] = "administrator/combos/delete";
$route['combos/change_image'] = "administrator/combos/change_image";

$route['banners'] = "administrator/banners";
$route['banners/get/(:num)'] = "administrator/banners/get/$1";
$route['banners/save'] = "administrator/banners/save";
$route['banners/delete'] = "administrator/proyectos/banners/delete";

$route['noticias'] = "administrator/noticias";
$route['noticias/get/(:num)'] = "administrator/noticias/get/$1";
$route['noticias/save'] = "administrator/noticias/save";

$route['proyectos'] = "administrator/proyectos";
$route['proyectos/get/(:num)'] = "administrator/proyectos/get/$1";
$route['proyectos/save'] = "administrator/proyectos/save";
$route['proyectos/delete'] = "administrator/proyectos/delete";
$route['proyectos/change_image'] = "administrator/proyectos/change_image";
$route['proyectos/oficinas/(:num)'] = "administrator/proyectos/oficinas/$1";

$route['oficinas/get/(:num)'] = "administrator/proyectos/oficina/$1";
$route['oficinas/save'] = "administrator/proyectos/oficina/save";
$route['oficinas/delete'] = "administrator/proyectos/oficina/delete";

$route['urban/get/(:num)'] = "administrator/proyectos/urban/$1";
$route['urban/save'] = "administrator/proyectos/urban/save";
$route['urban/delete'] = "administrator/proyectos/urban/delete";

$route['usuarios'] = "administrator/usuarios";
$route['usuarios/get/(:num)'] = "administrator/usuarios/get/$1";
$route['usuarios/save'] = "administrator/usuarios/save";
$route['usuarios/confirm'] = "administrator/usuarios/confirm";

$route['perfil'] = "administrator/perfil";
$route['perfil/get/(:num)'] = "administrator/perfil/get/$1";
$route['perfil/save'] = "administrator/perfil/save";

$route['configuracion'] = "administrator/configuracion";
$route['configuracion/save'] = "administrator/configuracion/save";
$route['configuracion/get/(:any)/(:num)'] = "administrator/configuracion/get/$1/$2";
$route['configuracion/set'] = "administrator/configuracion/set";

// $route['404_override'] = 'error';