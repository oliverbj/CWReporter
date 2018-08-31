<?php

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/reports', 'HomeController@index');
});
