<?php

Route::middleware(['auth'])->name('admin.')->group(function () {

    Route::resource('/admin/sk/config'          , 'Samgyngobr\Scarlet\Controllers\ConfigController'        )->name('*', 'sk-config');
    Route::get('/admin/sk/config/enable/{url}'  , 'Samgyngobr\Scarlet\Controllers\ConfigController@enable' );
    Route::get('/admin/sk/config/disable/{url}' , 'Samgyngobr\Scarlet\Controllers\ConfigController@disable');

    Route::get( '/admin/sk/{url}' , 'Samgyngobr\Scarlet\Controllers\AdminController@index'        )->name('sk-admin');
    Route::post('/admin/sk/{url}' , 'Samgyngobr\Scarlet\Controllers\AdminController@updateUnique' )->name('sk-admin');

    Route::get( '/admin/sk/{url}/new' , 'Samgyngobr\Scarlet\Controllers\AdminController@new'     )->name('sk-admin-new');
    Route::post('/admin/sk/{url}/new' , 'Samgyngobr\Scarlet\Controllers\AdminController@newSave' );

    Route::get( '/admin/sk/{url}/edit/{id}' , 'Samgyngobr\Scarlet\Controllers\AdminController@edit'   )->name('sk-admin-edit');
    Route::post('/admin/sk/{url}/edit/{id}' , 'Samgyngobr\Scarlet\Controllers\AdminController@update' )->name('sk-admin-update');

    Route::get('/admin/sk/{url}/unpublish/{id}' , 'Samgyngobr\Scarlet\Controllers\AdminController@unpublish');
    Route::get('/admin/sk/{url}/publish/{id}'   , 'Samgyngobr\Scarlet\Controllers\AdminController@publish'  );

    Route::get('/admin/sk/{url}/delete/{id}' , 'Samgyngobr\Scarlet\Controllers\AdminController@delete' );

    Route::get( '/admin/sk/{url}/gallery/{id}/delete/{did}' , 'Samgyngobr\Scarlet\Controllers\GalleryController@delete' );
    Route::get( '/admin/sk/{url}/gallery/{id}'              , 'Samgyngobr\Scarlet\Controllers\GalleryController@index' );
    Route::post('/admin/sk/{url}/gallery/{id}'              , 'Samgyngobr\Scarlet\Controllers\GalleryController@new' );

});
