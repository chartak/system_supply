<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Product Category
    Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/media', 'ProductCategoryController@storeMedia')->name('product-categories.storeMedia');
    Route::post('product-categories/ckmedia', 'ProductCategoryController@storeCKEditorImages')->name('product-categories.storeCKEditorImages');
    Route::resource('product-categories', 'ProductCategoryController');

    // Product Tag
    Route::delete('product-tags/destroy', 'ProductTagController@massDestroy')->name('product-tags.massDestroy');
    Route::resource('product-tags', 'ProductTagController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::resource('products', 'ProductController');

    // User Info
    Route::delete('user-infos/destroy', 'UserInfoController@massDestroy')->name('user-infos.massDestroy');
    Route::resource('user-infos', 'UserInfoController');

    // Year Contract
    Route::delete('year-contracts/destroy', 'YearContractController@massDestroy')->name('year-contracts.massDestroy');
    Route::post('year-contracts/media', 'YearContractController@storeMedia')->name('year-contracts.storeMedia');
    Route::post('year-contracts/ckmedia', 'YearContractController@storeCKEditorImages')->name('year-contracts.storeCKEditorImages');
    Route::resource('year-contracts', 'YearContractController');

    // Rewrewr
    Route::delete('rewrewrs/destroy', 'RewrewrController@massDestroy')->name('rewrewrs.massDestroy');
    Route::resource('rewrewrs', 'RewrewrController');

    // Unit Measurement
    Route::delete('unit-measurements/destroy', 'UnitMeasurementController@massDestroy')->name('unit-measurements.massDestroy');
    Route::resource('unit-measurements', 'UnitMeasurementController');

    // Year Contract Product
    Route::delete('year-contract-products/destroy', 'YearContractProductController@massDestroy')->name('year-contract-products.massDestroy');
    Route::resource('year-contract-products', 'YearContractProductController');

    // Week Contract
    Route::delete('week-contracts/destroy', 'WeekContractController@massDestroy')->name('week-contracts.massDestroy');
    Route::post('week-contracts/media', 'WeekContractController@storeMedia')->name('week-contracts.storeMedia');
    Route::post('week-contracts/ckmedia', 'WeekContractController@storeCKEditorImages')->name('week-contracts.storeCKEditorImages');
    Route::resource('week-contracts', 'WeekContractController');

    // Week Contract Products
    Route::delete('week-contract-products/destroy', 'WeekContractProductsController@massDestroy')->name('week-contract-products.massDestroy');
    Route::resource('week-contract-products', 'WeekContractProductsController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Product Category
    Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/media', 'ProductCategoryController@storeMedia')->name('product-categories.storeMedia');
    Route::post('product-categories/ckmedia', 'ProductCategoryController@storeCKEditorImages')->name('product-categories.storeCKEditorImages');
    Route::resource('product-categories', 'ProductCategoryController');

    // Product Tag
    Route::delete('product-tags/destroy', 'ProductTagController@massDestroy')->name('product-tags.massDestroy');
    Route::resource('product-tags', 'ProductTagController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::resource('products', 'ProductController');

    // User Info
    Route::delete('user-infos/destroy', 'UserInfoController@massDestroy')->name('user-infos.massDestroy');
    Route::resource('user-infos', 'UserInfoController');

    // Year Contract
    Route::delete('year-contracts/destroy', 'YearContractController@massDestroy')->name('year-contracts.massDestroy');
    Route::post('year-contracts/media', 'YearContractController@storeMedia')->name('year-contracts.storeMedia');
    Route::post('year-contracts/ckmedia', 'YearContractController@storeCKEditorImages')->name('year-contracts.storeCKEditorImages');
    Route::resource('year-contracts', 'YearContractController');

    // Rewrewr
    Route::delete('rewrewrs/destroy', 'RewrewrController@massDestroy')->name('rewrewrs.massDestroy');
    Route::resource('rewrewrs', 'RewrewrController');

    // Unit Measurement
    Route::delete('unit-measurements/destroy', 'UnitMeasurementController@massDestroy')->name('unit-measurements.massDestroy');
    Route::resource('unit-measurements', 'UnitMeasurementController');

    // Year Contract Product
    Route::delete('year-contract-products/destroy', 'YearContractProductController@massDestroy')->name('year-contract-products.massDestroy');
    Route::resource('year-contract-products', 'YearContractProductController');

    // Week Contract
    Route::delete('week-contracts/destroy', 'WeekContractController@massDestroy')->name('week-contracts.massDestroy');
    Route::post('week-contracts/media', 'WeekContractController@storeMedia')->name('week-contracts.storeMedia');
    Route::post('week-contracts/ckmedia', 'WeekContractController@storeCKEditorImages')->name('week-contracts.storeCKEditorImages');
    Route::resource('week-contracts', 'WeekContractController');

    // Week Contract Products
    Route::delete('week-contract-products/destroy', 'WeekContractProductsController@massDestroy')->name('week-contract-products.massDestroy');
    Route::resource('week-contract-products', 'WeekContractProductsController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
});