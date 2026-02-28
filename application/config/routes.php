<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

$route['default_controller'] = 'Home_Controller';

// Authentication & User
$route['login'] = 'Login_Controller/login';
$route['signup'] = 'Login_Controller/register';
$route['logout'] = 'Login_Controller/logout';
$route['profile'] = 'User_Controller/profile';
$route['dashboard'] = 'User_Controller';

// Password Reset
$route['login/forgot_password'] = 'Login_Controller/forgot_password';
$route['login/send_reset_link'] = 'Login_Controller/send_reset_link';
$route['login/reset_password/(:any)'] = 'Login_Controller/reset_password/$1';
$route['login/update_password'] = 'Login_Controller/update_password';

// Static pages
$route['about'] = 'About_Controller';
$route['help'] = 'Help_Controller';

// Search
$route['search'] = 'Search_Controller';

// Project resourceful routes
$route['projects/new'] = 'Project_Controller/new_project';
$route['projects/(:num)'] = 'Project_Controller/open/$1';
$route['projects/(:num)/edit'] = 'Project_Controller/edit/$1';
$route['projects/(:num)/planning'] = 'Project_Controller/planning/$1';
$route['projects/(:num)/conducting'] = 'Project_Controller/conducting/$1';
$route['projects/(:num)/reporting'] = 'Project_Controller/reporting/$1';
$route['projects/(:num)/study-selection'] = 'Project_Controller/study_selection/$1';
$route['projects/(:num)/quality-assessment'] = 'Project_Controller/quality_assessment/$1';
$route['projects/(:num)/data-extraction'] = 'Project_Controller/data_extraction/$1';
$route['projects/(:num)/add-member'] = 'Project_Controller/add_member/$1';
$route['projects/(:num)/study-selection-admin'] = 'Project_Controller/review_study_selection/$1';
$route['projects/(:num)/quality-admin'] = 'Project_Controller/review_qa/$1';
$route['projects/(:num)/export'] = 'Project_Controller/export/$1';


// Project Export (explicit RESTful endpoints)
$route['projects/(:num)/export/doc']    = 'Project_Export_Controller/export_doc';
$route['projects/(:num)/export/latex']  = 'Project_Export_Controller/export_latex';
$route['projects/(:num)/export/bib']    = 'Project_Export_Controller/export_bib';

// Legacy direct access (for AJAX/JS)
$route['project_export/export_doc']   = 'Project_Export_Controller/export_doc';
$route['project_export/export_latex'] = 'Project_Export_Controller/export_latex';
$route['project_export/export_bib']   = 'Project_Export_Controller/export_bib';

// Project Conducting
$route['projects/conducting/import-studies'] = 'Project_Conducting_Controller/conducting_import_studies';
$route['projects/conducting/study-selection'] = 'Project_Conducting_Controller/conducting_study_selection';
$route['projects/conducting/quality-assessment'] = 'Project_Conducting_Controller/conducting_quality_assessment';
$route['projects/conducting/data-extraction'] = 'Project_Conducting_Controller/conducting_data_extraction';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
