<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/bcseo'], function (Router $router) {
    $router->bind('seo', function ($id) {
        return app('Modules\Bcseo\Repositories\SeoRepository')->find($id);
    });
    $router->get('seos', [
        'as' => 'admin.bcseo.seo.index',
        'uses' => 'SeoController@index',
        'middleware' => 'can:bcseo.index'
    ]);
    $router->get('seos/create', [
        'as' => 'admin.bcseo.seo.create',
        'uses' => 'SeoController@create',
        'middleware' => 'can:bcseo.index'
    ]);
    $router->post('seos', [
        'as' => 'admin.bcseo.seo.store',
        'uses' => 'SeoController@store',
        'middleware' => 'can:bcseo.index'
    ]);
    $router->get('seos/{seo}/edit', [
        'as' => 'admin.bcseo.seo.edit',
        'uses' => 'SeoController@edit',
        'middleware' => 'can:bcseo.index'
    ]);
    $router->put('seos/{seo}', [
        'as' => 'admin.bcseo.seo.update',
        'uses' => 'SeoController@update',
        'middleware' => 'can:bcseo.index'
    ]);
    $router->delete('seos/{seo}', [
        'as' => 'admin.bcseo.seo.destroy',
        'uses' => 'SeoController@destroy',
        'middleware' => 'can:bcseo.index'
    ]);
// append

});
