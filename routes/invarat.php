<?php

$router->group(['prefix' => 'api'], function () use ($router){

    $router->group(['middleware' => 'auth'], function () use ($router){

        $router->get('/invarat', 'Invarat\InvaratController@test');
        $router->post('/invarat/create-order', 'Invarat\InvaratOrderController@create');
        $router->get('/invarat/order-filter', 'Invarat\InvaratOrderController@orderFilter');
    });

});
