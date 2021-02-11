<?php
Route::group(['middleware' => ['web']], function () {
    Route::get('/authorize/external', 'Julfiker\SingleAuth\ExternalAuthorizeController@redirect')->name('single.login.redirect');
});
