<?php

$router->group(['prefix' => 'api'], function () use ($router){

    $router->group(['middleware' => 'auth'], function () use ($router){

        $router->post('/pending-tasks/create-from-array', 'Ald\PendingTaskAldController@createFromArray');
        $router->get('/vehicles/ald/unapproved-task', 'Ald\AldController@unapprovedTask');
        $router->get('/vehicles/ald/approved-task', 'Ald\AldController@approvedTask');
        $router->post('/pending-tasks/approved', 'Ald\PendingTaskAldController@updatePendingTask');
        $router->post('/ald/add-pending-task', 'Ald\PendingTaskAldController@createTaskVehiclesAvalible');
    });

});
