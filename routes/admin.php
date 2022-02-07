<?php

Route::get( '/'                , 'Index@index' );
Route::get( '/login'           , 'Auth@login'  );
Route::get( '/forgot-password' , 'Auth@forgotPassword'  );
