<?php


Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    //Admin Routes without permission
    Route::get('/user_profile/{id}', 'UserController@profile');
    Route::get('/edit_profile/{id}', 'UserController@editProfile');
    Route::put('/edit_profile/{id}', 'UserController@updateProfile');
    Route::get('/change_password/{id}', 'UserController@changePassword');
    Route::put('/change_password/{id}', 'UserController@updatePassword');
    Route::get('/app_settings', 'AppSettingsController@appInfo');
    Route::get('/app_settings_edit', 'AppSettingsController@appSettingsEdit');
    Route::post('/app_settings/{id}', 'AppSettingsController@appSettingsUpdate');

    // Admin Routes with check_permission
    Route::group(['middleware' => 'check_permission'], function () {
        Route::get('/home', 'HomeController@index');
        Route::get('/dashboard', 'HomeController@index');

        Route::get('/check', 'MenuOrderController@index');
        Route::get('/menu_order', 'MenuOrderController@index');
        Route::post('menu_order', 'MenuOrderController@updateOrder');
        Route::get('/setpermission', 'SetPermissionController@index');
        Route::get('setpermission/json', 'SetPermissionController@getMenuJson');
        Route::get('setpermission/{role_id}', 'SetPermissionController@getPermission');
        Route::post('status/{id}', 'UserManagementController@status');
        Route::post('setpermission', 'SetPermissionController@savePermission');
        Route::resources([
            "roles" => 'RoleManagementController',
            "users" => 'UserManagementController',
            "menus" => 'MenuController',
        ]);
        Route::get('retrieve/roles', 'RoleManagementController@retrieveData');
        Route::get('retrieve/users', 'UserManagementController@retrieveData');
        Route::get('retrieve/menus', 'MenuController@retrieveData');

    });
});
