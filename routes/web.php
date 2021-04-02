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
    });
});
