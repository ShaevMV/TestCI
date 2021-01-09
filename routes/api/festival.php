<?php

Route::group(['prefix' => '/v1/festival', 'as' => 'api.*', 'namespace' => 'Api\v1'], function () {
    // Вывести список фестивалей
    Route::post('/getList/{page}/{limit}','FestivalAdminController@getList');
});
