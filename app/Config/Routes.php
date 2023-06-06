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
use App\Controllers\Ajax;
use App\Controllers\Movies;
use App\Controllers\Account;
use App\Controllers\Apis;
use App\Controllers\Map;

$routes->get('map',[Map::class, 'map']);

$routes->get('apis/movie/(:num)',[Apis::class,'movieapi']);
$routes->get('apis/movie',[Apis::class,'movieapi']);

$routes->get('logout',[Account::class, 'logout']);
$routes->match(['get', 'post'],'login', [Account::class, 'login']);
$routes->match(['get', 'post'],'signup', [Account::class, 'signUp']);

$routes->get('ajax/user/(:segment)',[Ajax::class, 'user']);
$routes->get('ajax/get/(:segment)',[Ajax::class, 'get']);

$routes->get('movies/reviews/(:segment)/(:segment)/(:num)', [Movies::class, 'viewReviews']);
$routes->get('movies/reviews/(:segment)/(:segment)', [Movies::class, 'viewReviews']);
$routes->match(['get', 'post'], 'movies/createReview/(:segment)/(:segment)', [Movies::class, 'createReview']);
$routes->get('movies/deleteReview/(:segment)/(:segment)/(:segment)', [Movies::class, 'deleteReview']);
$routes->match(['get','post'], 'movies/editReview/(:segment)/(:segment)/(:segment)', [Movies::class, 'editReview']);

$routes->match(['get','post'], 'movies/edit/(:segment)', [Movies::class, 'edit']);
$routes->match(['get', 'post'], 'movies/create', [Movies::class, 'create']);
$routes->get('movies/delete/(:segment)', [Movies::class, 'delete']);
$routes->get('movies/(:num)', [Movies::class, 'index']);
$routes->get('movies/(:segment)', [Movies::class, 'view']);
$routes->get('movies', [Movies::class, 'index']);

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
