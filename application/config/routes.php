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
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = 'CI_visualizacao';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------

$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
*/

/* --------------------------------------------------------------
 * Ambientes
 * ------------------------------------------------------------ */
$route['api/ambientes'] = 'api/ambientes';
$route['api/ambiente/(:num)'] = 'api/ambientes/id/$1';

/* --------------------------------------------------------------
 * Publicações
 * ------------------------------------------------------------ */
$route['api/publicacoes'] = 'api/publicacoes';
$route['api/publicacao/(:num)'] = 'api/publicacoes/id/$1';

/* --------------------------------------------------------------
 * Sensores
 * ------------------------------------------------------------ */
$route['api/sensores'] = 'api/sensores';
$route['api/sensor/(:num)'] = 'api/sensores/id/$1';

/* --------------------------------------------------------------
 * Gateway
 * ------------------------------------------------------------ */
$route['api/gateways'] = 'api/gateways';
$route['api/gateway/(:num)'] = 'api/gateways/id/$1';

/* --------------------------------------------------------------
 * Regras
 * ------------------------------------------------------------ */
$route['api/regras'] = 'api/regras';
$route['api/regra/(:num)'] = 'api/regras/id/$1';

/* --------------------------------------------------------------
 * Contexto de Interesse
 * ------------------------------------------------------------ */
$route['api/contextosinteresse'] = 'api/contextointeresse';
$route['api/contextointeresse/(:num)'] = 'api/contextointeresse/id/$1';

/* --------------------------------------------------------------
 * Servidor de Borda
 * ------------------------------------------------------------ */
$route['api/servidoresborda'] = 'api/servidorborda';
$route['api/servidorborda/(:num)'] = 'api/servidorborda/id/$1';

/* --------------------------------------------------------------
 * Servidor de Contexto
 * ------------------------------------------------------------ */
$route['api/servidorescontexto'] = 'api/servidorcontexto';
$route['api/servidorcontexto/(:num)'] = 'api/servidorcontexto/id/$1';
