<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/hello', 'Hello::index');
//输入login网址，跳转到controller Login index
$routes->get('/login', 'Login::index');
$routes->post('/login/check_login', 'Login::check_login');
$routes->get('/login/logout', 'Login::logout');
$routes->get('/register', 'Register::index');
$routes->post('/register/check_register', 'Register::check_register');
$routes->get('/reset','Reset::index');
$routes->post('reset/reset_password','Reset::reset_password');
$routes->get('verify_email','Register::verify_email');
$routes->post('register/check_email_code','Register::check_email_code');
$routes->get('/user','Login::profile_index');
$routes->get('/add_phone','Login::add_phone_index');
$routes->post('/login/add_phone_action','Login::add_phone_action');
$routes->get('change_email','Login::change_email_index');
$routes->post('login/change_email_action','Login::change_email_action');
$routes->get('change_email_ver','Login::change_email_ver_index');
$routes->post('/login/change_email_ver_action','Login::change_email_ver_action');
$routes->get('forget_password','Forget::index');
$routes->post('forget/email_action','Forget::email_action');
$routes->get('forget_password_email','Forget::email_check_index');
$routes->post('forget/email_check','Forget::email_check');
$routes->get('new_password','Forget::new_password_index');
$routes->post('forget/new_password','Forget::new_password');
$routes->get('add_photo','Login::add_photo_index');
$routes->post('login/add_photo','Login::add_photo');
$routes->get('location','Login::location_index');
$routes->get('ver_phone','Login::ver_phone_index');
$routes->post('login/ver_phone_action','Login::ver_phone_action');
$routes->get('/file_uploads','Login::file_uploads');
$routes->post('/login/file_uploads_action','Login::file_uploads_action');
$routes->get('timetable','Login::timetable');
$routes->post('timetable','Login::timetable_action');
$routes->get('add_event','Login::add_event');
$routes->post('login/add_event_action','Login::add_event_action');
$routes->get('delete_event','Login::delete_event');
$routes->post('login/delete_event_action','Login::delete_event_action');
$routes->get('post','Login::post');
$routes->post('login/post_action','Login::post_action');
$routes->get('home','Login::home');
$routes->post('login/home_action','Login::home_action');
$routes->get('rank','Login::rank');
$routes->get('search','Login::search');
$routes->get('Login/search_action','Login::search_action');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
