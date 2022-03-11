<?php

Route::get(  '/login' , 'Authentication@login' )->name('login');
Route::post( '/login' , 'Authentication@authenticate' );

Route::get( '/forgot-password' , 'Authentication@forgotPassword' );

Route::middleware(['auth'])->name('admin.')->group(function () {

    Route::get( '/logout' , 'Authentication@logout' );

    Route::get( '/' , 'Index@index' );

    Route::get( '/profile'          , 'Profile@index'          );
    Route::put( '/profile'          , 'Profile@update'         );
    Route::put( '/profile/password' , 'Profile@changePassword' );

    Route::resource( '/users'                      , 'Users'                );
    Route::get(      '/users/{id}/delete'          , 'Users@destroy'        );
    Route::put(      '/users/{id}/change-password' , 'Users@changePassword' );

});
