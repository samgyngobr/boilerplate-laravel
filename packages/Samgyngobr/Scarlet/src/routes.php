<?php

$url = ( Config::get('app.sk_url') ) ? Config::get('app.sk_url') : '/admin/sk/';

Route::resource($url . 'config'          , 'Samgyngobr\Scarlet\Controllers\ConfigController'        )->name('*', 'sk-config');
Route::get($url . 'config/enable/{url}'  , 'Samgyngobr\Scarlet\Controllers\ConfigController@enable' );
Route::get($url . 'config/disable/{url}' , 'Samgyngobr\Scarlet\Controllers\ConfigController@disable');

Route::get( $url . '{url}' , 'Samgyngobr\Scarlet\Controllers\AdminController@index'        )->name('sk-admin');
Route::post($url . '{url}' , 'Samgyngobr\Scarlet\Controllers\AdminController@updateUnique' )->name('sk-admin');

Route::get( $url . '{url}/new' , 'Samgyngobr\Scarlet\Controllers\AdminController@new'     )->name('sk-admin-new');
Route::post($url . '{url}/new' , 'Samgyngobr\Scarlet\Controllers\AdminController@newSave' );

Route::get( $url . '{url}/edit/{id}' , 'Samgyngobr\Scarlet\Controllers\AdminController@edit'   )->name('sk-admin-edit');
Route::post($url . '{url}/edit/{id}' , 'Samgyngobr\Scarlet\Controllers\AdminController@update' )->name('sk-admin-update');

Route::get($url . '{url}/unpublish/{id}' , 'Samgyngobr\Scarlet\Controllers\AdminController@unpublish');
Route::get($url . '{url}/publish/{id}'   , 'Samgyngobr\Scarlet\Controllers\AdminController@publish'  );

Route::get($url . '{url}/delete/{id}' , 'Samgyngobr\Scarlet\Controllers\AdminController@delete' );

Route::get( $url . '{url}/gallery/{id}/delete/{did}' , 'Samgyngobr\Scarlet\Controllers\GalleryController@delete' );
Route::get( $url . '{url}/gallery/{id}'              , 'Samgyngobr\Scarlet\Controllers\GalleryController@index' );
Route::post($url . '{url}/gallery/{id}'              , 'Samgyngobr\Scarlet\Controllers\GalleryController@new' );
