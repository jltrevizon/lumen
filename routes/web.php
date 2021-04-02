<?php

/** @var \Laravel\Lumen\Routing\Router $router */
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return '<h2>API CarFlex</h2>';
});


$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('/auth/signup', 'AuthController@register');
    $router->post('/auth/signin', 'AuthController@login');

    $router->group(['middleware' => 'auth'], function () use ($router) {

        /**
         * Users
         */
        $router->get('/users/getall', 'UserController@getAll');
        $router->get('/users/{id}', 'UserController@getById');
        $router->post('/users/create-without-password', 'UserController@createUserWithoutPassword');
        $router->put('/users/update/{id}', 'UserController@update');
        $router->delete('/users/delete/{id}', 'UserController@delete');

        /**
         * Roles
         */
        $router->get('/roles/getall', 'RoleController@getAll');
        $router->get('/roles/{id}', 'RoleController@getById');
        $router->post('/roles', 'RoleController@create');
        $router->put('/roles/update/{id}', 'RoleController@update');
        $router->delete('/roles/delete/{id}', 'RoleController@delete');

        /**
         * Campas
         */
        $router->get('/campas/getall', 'CampaController@getall');
        $router->get('/campas/{id}', 'CampaController@getById');
        $router->post('/campas', 'CampaController@create');
        $router->put('/campas/update/{id}', 'CampaController@update');
        $router->delete('/campas/delete/{id}', 'CampaController@delete');

        /**
         * Categories
         */
        $router->get('/categories/getall', 'CategoryController@getall');
        $router->get('/categories/{id}', 'CategoryController@getById');
        $router->post('/categories', 'CategoryController@create');
        $router->put('/categories/update/{id}', 'CategoryController@update');
        $router->delete('/categories/delete/{id}', 'CategoryController@delete');

        /**
         * Companies
         */
        $router->get('/companies/getall', 'CompanyController@getall');
        $router->get('/companies/{id}', 'CompanyController@getById');
        $router->post('/companies', 'CompanyController@create');
        $router->put('/companies/update/{id}', 'CompanyController@update');
        $router->delete('/companies/delete/{id}', 'CompanyController@delete');

        /**
         * Customers
         */
        $router->get('/customers/getall', 'CustomerController@getall');
        $router->get('/customers/{id}', 'CustomerController@getById');
        $router->post('/customers', 'CustomerController@create');
        $router->put('/customers/update/{id}', 'CustomerController@update');
        $router->delete('/customers/delete/{id}', 'CustomerController@delete');

        /**
         * Group Tasks
         */
        $router->get('/grouptasks/getall', 'GroupTaskController@getall');
        $router->get('/grouptasks/{id}', 'GroupTaskController@getById');
        $router->post('/grouptasks', 'GroupTaskController@create');
        $router->put('/grouptasks/update/{id}', 'GroupTaskController@update');
        $router->delete('/grouptasks/delete/{id}', 'GroupTaskController@delete');

        /**
         * Incidences
         */
        $router->get('/incidences/getall', 'IncidenceController@getall');
        $router->get('/incidences/{id}', 'IncidenceController@getById');
        $router->post('/incidences', 'IncidenceController@create');
        $router->put('/incidences/update/{id}', 'IncidenceController@update');
        $router->delete('/incidences/delete/{id}', 'IncidenceController@delete');

        /**
         * Regions
         */
        $router->get('/regions/getall', 'RegionController@getall');
        $router->get('/regions/{id}', 'RegionController@getById');
        $router->post('/regions', 'RegionController@create');
        $router->put('/regions/update/{id}', 'RegionController@update');
        $router->delete('/regions/delete/{id}', 'RegionController@delete');

         /**
         * Provinces
         */
        $router->get('/provinces/getall', 'ProvinceController@getall');
        $router->get('/provinces/{id}', 'ProvinceController@getById');
        $router->post('/provinces', 'ProvinceController@create');
        $router->put('/provinces/update/{id}', 'ProvinceController@update');
        $router->delete('/provinces/delete/{id}', 'ProvinceController@delete');
    });
});
