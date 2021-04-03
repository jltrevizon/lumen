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

        /**
         * Pending task
         */
        $router->get('/pending-tasks/getall', 'PendingTaskController@getall');
        $router->get('/pending-tasks/{id}', 'PendingTaskController@getById');
        $router->post('/pending-tasks', 'PendingTaskController@create');
        $router->put('/pending-tasks/update/{id}', 'PendingTaskController@update');
        $router->delete('/pending-tasks/delete/{id}', 'PendingTaskController@delete');

        /**
         * Purchase operations
         */
        $router->get('/purchase-operations/getall', 'PurchaseOperationController@getall');
        $router->get('/purchase-operations/{id}', 'PurchaseOperationController@getById');
        $router->post('/purchase-operations', 'PurchaseOperationController@create');
        $router->put('/purchase-operations/update/{id}', 'PurchaseOperationController@update');
        $router->delete('/purchase-operations/delete/{id}', 'PurchaseOperationController@delete');

        /**
         * Requests
         */
        $router->get('/requests/getall', 'RequestController@getall');
        $router->get('/requests/{id}', 'RequestController@getById');
        $router->post('/requests', 'RequestController@create');
        $router->put('/requests/update/{id}', 'RequestController@update');
        $router->delete('/requests/delete/{id}', 'RequestController@delete');

        /**
         * States
         */
        $router->get('/states/getall', 'StateController@getall');
        $router->get('/states/{id}', 'StateController@getById');
        $router->post('/states', 'StateController@create');
        $router->put('/states/update/{id}', 'StateController@update');
        $router->delete('/states/delete/{id}', 'StateController@delete');

        /**
         * States pending tasks
         */
        $router->get('/states-pending-tasks/getall', 'StatePendingTaskController@getall');
        $router->get('/states-pending-tasks/{id}', 'StatePendingTaskController@getById');
        $router->post('/states-pending-tasks', 'StatePendingTaskController@create');
        $router->put('/states-pending-tasks/update/{id}', 'StatePendingTaskController@update');
        $router->delete('/states-pending-tasks/delete/{id}', 'StatePendingTaskController@delete');
    });
});
