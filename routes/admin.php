<?php

Route::get(  '/login' , 'Authentication@login' )->name('login');
Route::post( '/login' , 'Authentication@authenticate' );

Route::get( '/forgot-password' , 'Authentication@forgotPassword' );

Route::middleware(['auth'])->name('admin.')->group(function () {

    Route::get( '/logout' , 'Authentication@logout' );

    Route::get( '/' , 'Index@index' );

    Route::resource( '/profile' , 'Profile' );
    Route::resource( '/users'   , 'Users'   );

});
