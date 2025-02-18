<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Product
    Route::apiResource('products', 'ProductApiController');

    // User Info
    Route::apiResource('user-infos', 'UserInfoApiController');

    // Year Contract
    Route::post('year-contracts/media', 'YearContractApiController@storeMedia')->name('year-contracts.storeMedia');
    Route::apiResource('year-contracts', 'YearContractApiController');

    // Unit Measurement
    Route::apiResource('unit-measurements', 'UnitMeasurementApiController');

    // Year Contract Product
    Route::apiResource('year-contract-products', 'YearContractProductApiController');

    // Week Contract
    Route::post('week-contracts/media', 'WeekContractApiController@storeMedia')->name('week-contracts.storeMedia');
    Route::apiResource('week-contracts', 'WeekContractApiController');
    
    // Week Contract Products
    Route::apiResource('week-contract-products', 'WeekContractProductsApiController');
});