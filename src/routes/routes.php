<?php

Route::group(['prefix' => 'v1', 'namespace' => 'V1', 'as' => 'v1.'], function () {

    Route::group(['as' => 'register.'], function () {
        Route::post('/issue-token', "RegisterController@issueToken")->name('issue-token');
        Route::post('/check-code', "RegisterController@checkCodeIsValid")->name('check-code');
        Route::post('/check-username', "RegisterController@checkUsernameIsValid")
            ->name('check-username');
        Route::post('/register', "RegisterController@register")->name('success');
    });
    Route::group(['prefix' => 'login', 'as' => 'login.'], function () {
        Route::post('/issue-token', "LoginController@issueToken")->name('issue-token');
        Route::post('/', "LoginController@login")->name('success');


    });


});
