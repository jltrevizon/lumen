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

    $router->post('/auth/signin', 'AuthController@login');

    $router->group(['middleware' => ['auth']], function () use ($router) {

        /**
         * Users
         */
        $router->get('/users/getall', 'UserController@getAll');
        $router->get('/users/{id}', 'UserController@getById');
        $router->post('/users', 'UserController@create');
        $router->post('/users/create-without-password', 'UserController@createUserWithoutPassword');
        $router->put('/users/update/{id}', 'UserController@update');
        $router->delete('/users/delete/{id}', 'UserController@delete');
        $router->get('/users/campa/{campa_id}', 'UserController@getUsersByCampa');
        $router->post('/users/role/{role_id}', 'UserController@getUsersByRole');
        $router->post('/users/active', 'UserController@getActiveUsers');
        $router->post('/users/by-email', 'UserController@getUserByEmail');

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
        $router->post('/campas/by-region', 'CampaController@getCampasByRegion');
        $router->post('/campas/by-province', 'CampaController@getCampasByProvince');
        $router->post('/campas/by-company', 'CampaController@getByCompany');
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
        $router->post('/customers/by-company', 'CustomerController@getUserByCompany');
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
        $router->post('/provinces/by-region', 'ProvinceController@provinceByRegion');
        $router->post('/provinces', 'ProvinceController@create');
        $router->put('/provinces/update/{id}', 'ProvinceController@update');
        $router->delete('/provinces/delete/{id}', 'ProvinceController@delete');

        /**
         * Pending task
         */
        $router->get('/pending-tasks/getall', 'PendingTaskController@getall');
        $router->get('/pending-tasks/{id}', 'PendingTaskController@getById');
        $router->get('/pending-tasks', 'PendingTaskController@getPendingOrNextTask');
        $router->post('/pending-tasks', 'PendingTaskController@create');
        $router->put('/pending-tasks/update/{id}', 'PendingTaskController@update');
        $router->delete('/pending-tasks/delete/{id}', 'PendingTaskController@delete');
        $router->post('/pending-tasks/create-from-array', 'PendingTaskController@createFromArray');
        $router->post('/pending-tasks/start-pending-task', 'PendingTaskController@startPendingTask');
        $router->post('/pending-tasks/finish-pending-task', 'PendingTaskController@finishPendingTask');
        $router->post('/pending-tasks/incidence', 'PendingTaskController@createIncidence');
        $router->post('/pending-tasks/resolved', 'PendingTaskController@resolvedIncidence');
        $router->post('/pending-tasks/by-state', 'PendingTaskController@getPendingTaskByState');
        $router->post('/pending-tasks/by-state/by-campa', 'PendingTaskController@getPendingTaskByStateCampa');
        $router->post('/pending-tasks/by-plate', 'PendingTaskController@getPendingTaskByPlate');
        $router->post('/pending-tasks/by-vehicle', 'PendingTaskController@getPendingTasksByPlate');
        $router->post('/pending-task/order', 'PendingTaskController@orderPendingTask');
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
        $router->post('/requests/defleet/requested', 'RequestController@vehiclesRequestedDefleet');
        $router->post('/requests/reserve/requested', 'RequestController@vehiclesRequestedReserve');
        $router->post('/requests/confirm', 'RequestController@confirmedRequest');
        $router->post('/requests/decline', 'RequestController@declineRequest');
        $router->post('/requests/confirmed', 'RequestController@getConfirmedRequest');
        $router->get('/requests/defleet/app','RequestController@getRequestDefleetApp');
        $router->get('/requests/reserve/app','RequestController@getRequestReserveApp');

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

        /**
         * States request
         */
        $router->get('/state-requests/getall', 'StateRequestController@getall');
        $router->get('/state-requests/{id}', 'StateRequestController@getById');
        $router->post('/state-requests', 'StateRequestController@create');
        $router->put('/state-requests/update/{id}', 'StateRequestController@update');
        $router->delete('/state-requests/delete/{id}', 'StateRequestController@delete');

        /**
         * Sub states
         */
        $router->get('/sub-states/getall', 'SubStateController@getall');
        $router->get('/sub-states/{id}', 'SubStateController@getById');
        $router->post('/sub-states', 'SubStateController@create');
        $router->put('/sub-states/update/{id}', 'SubStateController@update');
        $router->delete('/sub-states/delete/{id}', 'SubStateController@delete');

        /**
         * Tasks
         */
        $router->get('/tasks/getall', 'TaskController@getall');
        $router->get('/tasks/{id}', 'TaskController@getById');
        $router->post('/tasks', 'TaskController@create');
        $router->put('/tasks/update/{id}', 'TaskController@update');
        $router->delete('/tasks/delete/{id}', 'TaskController@delete');

        /**
         * Transports
         */
        $router->get('/transports/getall', 'TransportController@getall');
        $router->get('/transports/{id}', 'TransportController@getById');
        $router->post('/transports', 'TransportController@create');
        $router->put('/transports/update/{id}', 'TransportController@update');
        $router->delete('/transports/delete/{id}', 'TransportController@delete');

        /**
         * TypeRequest
         */
        $router->get('/types-requests/getall', 'TypeRequestController@getall');
        $router->get('/types-requests/{id}', 'TypeRequestController@getById');
        $router->post('/types-requests', 'TypeRequestController@create');
        $router->put('/types-requests/update/{id}', 'TypeRequestController@update');
        $router->delete('/types-requests/delete/{id}', 'TypeRequestController@delete');

        /**
         * TypeTasks
         */
        $router->get('/types-tasks/getall', 'TypeTaskController@getall');
        $router->get('/types-tasks/{id}', 'TypeTaskController@getById');
        $router->post('/types-tasks', 'TypeTaskController@create');
        $router->put('/types-tasks/update/{id}', 'TypeTaskController@update');
        $router->delete('/types-tasks/delete/{id}', 'TypeTaskController@delete');

        /**
         * Vehicles
         */
        $router->get('/vehicles/getall', 'VehicleController@getall');
        $router->post('/vehicles/by-company', 'VehicleController@getByCompany');
        $router->post('/vehicles/all-by-company', 'VehicleController@getAllByCompany');
        $router->post('/vehicles/by-campa', 'VehicleController@getByCampaWithoutReserve');
        $router->post('/vehicles', 'VehicleController@create');
        $router->post('/vehicles/verify-plate', 'VehicleController@verifyPlate');
        $router->put('/vehicles/update/{id}', 'VehicleController@update');
        $router->delete('/vehicles/delete/{id}', 'VehicleController@delete');
        $router->post('/vehicles/defleet', 'VehicleController@vehicleDefleet');
        $router->get('/vehicles/defleeted', 'VehicleController@vehiclesDefleeted');
        $router->get('/vehicles/reserved', 'VehicleController@vehiclesReserved');
        $router->get('/vehicles/{id}', 'VehicleController@getById');

        /**
         * Vehicle Picture
         */
        $router->post('/vehicle-pictures', 'VehiclePictureController@create');
        $router->post('/vehicle-pictures/by-vehicle', 'VehiclePictureController@getPicturesByVehicle');

        /**
         * Variables defleet
         */
        $router->get('/defleet-variables', 'DefleetVariableController@getVariables');
        $router->put('/defleet-variables', 'DefleetVariableController@updateVariables');
        $router->post('/defleet-variables', 'DefleetVariableController@createVariables');

        /**
         * Questions
         */
        $router->get('/questions/getall', 'QuestionController@getAll');
        $router->post('/questions', 'QuestionController@create');
        $router->delete('/questions/{id}', 'QuestionController@delete');

        /**
         *
         */
        $router->post('/reservation-time', 'ReservationTimeController@getByCompany');
        $router->post('/reservation-time/create', 'ReservationTimeController@create');
        $router->post('/reservation-time/update', 'ReservationTimeController@update');

        /**
         * Questions answer
         */
        $router->post('/question-answers', 'QuestionAnswerController@create');

        /**
         * Manual Questionnaire
         */
        $router->post('/manual-questionnaire', 'ManualQuestionnaireController@create');

        /**
         * Reservation
         */
        $router->post('/get-reservations', 'ReservationController@getReservationActive');
        $router->post('/get-reservations/by-campa', 'ReservationController@getReservationActiveByCampa');
        $router->post('/reservations/update', 'ReservationController@update');

        /**
         * Chat
         */
        $router->post('/chat', 'ChatController@createMessage');
        $router->post('/get-message', 'ChatController@getMessage');
        $router->post('/read-messages', 'ChatController@readMessages');

    });
});
