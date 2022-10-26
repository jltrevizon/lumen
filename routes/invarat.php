<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api'], function () use ($router){

    $router->group(['middleware' => 'auth'], function () use ($router){

        $router->get('/invarat', 'Invarat\InvaratController@test');
        $router->post('/invarat/create-order', 'Invarat\InvaratOrderController@create');
        $router->get('/invarat/order-filter', 'Invarat\InvaratOrderController@orderFilter');
        $router->get('/invarat/getVehiclesForIdGspOrder', 'Invarat\InvaratOrderController@getVehiclesForIdGspOrder');
        $router->post('/invarat/budgets', 'Invarat\InvaratBudgetController@create');
        $router->put('/invarat/update-budgets', 'Invarat\InvaratBudgetController@update');
        $router->get('/invarat/vehicles-by-channel', 'Invarat\InvaratVehicleController@vehiclesByChannel');
        $router->get('/invarat/vehicles-results', 'Invarat\InvaratVehicleController@getVehicleResults');
        $router->get('/invarat/vehicles-details', 'Invarat\InvaratVehicleController@getVehicleDetails');
        $router->put('/invarat/vehicle-update/{id}', 'Invarat\InvaratVehicleController@update');
        $router->post('/invarat/createChecklistEmpty', 'Invarat\InvaratVehicleController@createChecklistEmpty');

        // Los metodos actuales tienen un control de estados que no es necesario para notroso.
        $router->post('/invarat/start-pending-task', 'Invarat\InvaratPendingTaskController@startPendingTask');
        $router->post('/invarat/finish-pending-task', 'Invarat\InvaratPendingTaskController@finishPendingTask');
        $router->post('/invarat/cancel-pending-task', 'Invarat\InvaratPendingTaskController@cancelPendingTask');
        $router->post('/invarat/addPendingTaskReacondicionamiento', 'Invarat\InvaratPendingTaskController@addPendingTaskReacondicionamiento');
        $router->post('/invarat/next-pending-task', 'Invarat\InvaratPendingTaskController@nextPendingTask');
        $router->post('/invarat/updateOrCreateBudgetPengingTaskGtWeb', 'Invarat\InvaratPendingTaskController@updateOrCreateBudgetPengingTaskGtWeb');
        $router->put('/invarat/updatePendingTaskReacondicionamiento', 'Invarat\InvaratPendingTaskController@updatePendingTaskReacondicionamiento');
    });


    // Sin middlewaere auth, ya que entra mediante GSP20. (TODO -> Falta generar token auth)
    $router->post('/invarat/gsp20/create-order', 'Invarat\GspController@createVehicle');
    $router->get('/invarat/gsp20/getVehicleForPlate', 'Invarat\GspController@getVehicleForPlate');
    $router->post('/invarat/gsp20/createBudgeForType', 'Invarat\GspController@createBudgeForType');
    $router->post('/invarat/gsp20/falloCheckVehicle', 'Invarat\GspController@falloCheckVehicle');





});
