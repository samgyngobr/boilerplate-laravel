<?php

Route::get(  '/login' , 'Auth@login' )->name('login');
Route::post( '/login' , 'Auth@authenticate' );

Route::get( '/forgot-password' , 'Auth@forgotPassword' );

Route::middleware(['auth'])->group(function () {

    Route::get( '/logout' , 'Auth@logout' );

    Route::get( '/' , 'Index@index' );

    Route::resource( '/profile' , 'Profile' );
    Route::resource( '/users'   , 'Users'   );

});
