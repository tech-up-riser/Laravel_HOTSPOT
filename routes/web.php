<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Homepage Route
Route::get('/', 'WelcomeController@welcome')->name('welcome');

// Authentication Routes
Auth::routes();

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity']], function () {
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');
});

/********** User accessible routes as a Guest User start **********/

Route::get('business/not_exist', ['as'=> 'business.not_exist', 'uses' => 'Business\UserController@not_exist']);
Route::get('social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

Route::group(['middleware' => ['user.guest']], function () {

    Route::get('business/{bzname}', function($bzname) {
        return redirect()->route('bzuser.login', ['bzname' => $bzname]);
    });

    Route::get('business/{bzname}/login', ['as'=> 'bzuser.login', 'uses' => 'Business\UserController@viewLogin']);
    Route::get('business/{bzname}/register', ['as'=> 'bzuser.register', 'uses' => 'Business\UserController@viewRegister']);
    Route::get('business/{bzname}/login_account', ['as'=> 'bzuser.login.account', 'uses' => 'Business\UserController@viewLoginAccount']);
    Route::post('business/{bzname}/authenticate', ['as'=> 'bzuser.authenticate', 'uses' => 'Business\UserController@authenticate']);
    Route::post('business/{bzname}/register', ['as'=> 'bzuser.register', 'uses' => 'Business\UserController@register']);

    //Mac Address Check
    Route::post('business/{bzname}/mac', ['as'=> 'bzuser.mac.check', 'uses' => 'Business\UserController@checkMacAddress']);
    // Socialite Register Routes
    Route::get('business/{bzname}/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);

});

Route::group(['middleware' => ['user.auth']], function () {

    Route::get('business/{bzname}/home', ['as'=> 'bzuser.home', 'uses' => 'Business\HomeController@index']);
    Route::get('business/{bzname}/user', ['as'=> 'bzuser.addInfo', 'uses' => 'Business\HomeController@addInfo']);
    Route::post('business/{bzname}/store', ['as'=> 'bzuser.store', 'uses' => 'Business\HomeController@store']);

    Route::get('business/{bzname}/logout', ['as'=> 'bzuser.logout', 'uses' => 'Business\UserController@logout']);

});

/********** Business Admin accessible routes as a Guest User start **********/

Route::group(['middleware' => ['business.guest']], function () {

    Route::get('business/{bzname}/admin', function($bzname) {
        return redirect()->route('business.admin.login', ['bzname' => $bzname]);
    });

    Route::get('business/{bzname}/admin/login', ['as'=> 'business.admin.login', 'uses' => 'Business_admin\UserController@viewLogin']);
    Route::post('business/{bzname}/admin/authenticate', ['as'=> 'business.admin.authenticate', 'uses' => 'Business_admin\UserController@authenticate']);

});

Route::group(['middleware' => ['business.auth']], function () {

    Route::get('business/{bzname}/admin/dashboard', ['as'=> 'business.admin.dashboard', 'uses' => 'Business_admin\DashboardController@index']);
    Route::get('business/{bzname}/admin/logout', ['as'=> 'business.admin.logout', 'uses' => 'Business_admin\UserController@logout']);

    //Show All Users
    Route::get('business/{bzname}/admin/users', ['as'=> 'business.admin.users', 'uses' => 'Business_admin\UserController@index']);
    Route::post('business/{bzname}/admin/users', ['as'=> 'business.admin.users', 'uses' => 'Business_admin\UserController@search']);
    Route::put('business/{bzname}/admin/users/{id}', ['as'=> 'business.admin.users.update', 'uses' => 'Business_admin\UserController@update']);
    Route::patch('business/{bzname}/admin/users/{id}', ['as'=> 'business.admin.users.update', 'uses' => 'Business_admin\UserController@update']);
    Route::delete('business/{bzname}/admin/users/{id}', ['as'=> 'business.admin.users.destroy', 'uses' => 'Business_admin\UserController@destroy']);
    Route::get('business/{bzname}/admin/users/{id}', ['as'=> 'business.admin.users.show', 'uses' => 'Business_admin\UserController@show']);
    Route::get('business/{bzname}/admin/users/{id}/edit', ['as'=> 'business.admin.users.edit', 'uses' => 'Business_admin\UserController@edit']);

    //Manage My Businesses
    Route::get('business/{bzname}/admin/business', ['as'=> 'business.admin.business', 'uses' => 'Business_admin\BusinessController@index']);
    Route::put('business/{bzname}/admin/business/{id}', ['as'=> 'business.admin.business.update', 'uses' => 'Business_admin\BusinessController@update']);
    Route::patch('business/{bzname}/admin/business/{id}', ['as'=> 'business.admin.business.update', 'uses' => 'Business_admin\BusinessController@update']);
    Route::get('business/{bzname}/admin/business/edit', ['as'=> 'business.admin.business.edit', 'uses' => 'Business_admin\BusinessController@edit']);
    Route::get('business/{bzname}/admin/business/logo', ['as'=> 'business.admin.business.logo', 'uses' => 'Business_admin\BusinessController@view_logo']);
    Route::get('business/{bzname}/admin/business/login_setting', ['as'=> 'business.admin.business.login_setting', 'uses' => 'Business_admin\BusinessController@view_login_setting']);
    Route::post('business/{bzname}/admin/business/login_setting', ['as'=> 'business.admin.business.login_setting', 'uses' => 'Business_admin\BusinessController@update_setting']);
    Route::post('business/{bzname}/admin/business/logo', ['as'=> 'business.admin.business.logo', 'uses' => 'Business_admin\BusinessController@store_image']);
    Route::get('business/{bzname}/admin/business/promotion', ['as'=> 'business.admin.business.promotion', 'uses' => 'Business_admin\BusinessController@view_promotion']);
    Route::post('business/{bzname}/admin/business/promotion', ['as'=> 'business.admin.business.promotion', 'uses' => 'Business_admin\BusinessController@store_promotion']);
    Route::delete('business/{bzname}/admin/business/promotion/{id}', ['as'=> 'business.admin.business.promotion.destroy', 'uses' => 'Business_admin\BusinessController@destroy_promotion']);
    Route::get('business/{bzname}/admin/business/preview', ['as'=> 'business.admin.business.preview', 'uses' => 'Business_admin\BusinessController@preview']);
    Route::get('business/{bzname}/admin/business/home', ['as'=> 'business.admin.business.home', 'uses' => 'Business_admin\BusinessController@home']);
    Route::get('business/{bzname}/admin/business/setting', ['as'=> 'business.admin.business.setting', 'uses' => 'Business_admin\BusinessController@promotion_setting']);
    Route::post('business/{bzname}/admin/business/setting', ['as'=> 'business.admin.business.setting', 'uses' => 'Business_admin\BusinessController@save_setting']);

    //Show All Promotions
    Route::get('business/{bzname}/admin/promotions', ['as'=> 'business.admin.promotions', 'uses' => 'Business_admin\PromotionController@index']);
    Route::post('business/{bzname}/admin/promotions', ['as'=> 'business.admin.promotions', 'uses' => 'Business_admin\PromotionController@search']);
    Route::put('business/{bzname}/admin/promotions/{id}', ['as'=> 'business.admin.promotions.update', 'uses' => 'Business_admin\PromotionController@update']);
    Route::patch('business/{bzname}/admin/promotions/{id}', ['as'=> 'business.admin.promotions.update', 'uses' => 'Business_admin\PromotionController@update']);
    Route::delete('business/{bzname}/admin/promotions/{id}', ['as'=> 'business.admin.promotions.destroy', 'uses' => 'Business_admin\PromotionController@destroy']);
    Route::get('business/{bzname}/admin/promotions/{id}', ['as'=> 'business.admin.promotions.show', 'uses' => 'Business_admin\PromotionController@show']);
    Route::get('business/{bzname}/admin/promotions/{id}/edit', ['as'=> 'business.admin.promotions.edit', 'uses' => 'Business_admin\PromotionController@edit']);
});

/********** Admin accessible routes as a Guest User start **********/

Route::group(['middleware' => ['admin.guest']], function () {

    Route::get('admin', function() {
        return redirect()->route('admin.login');
    });

    Route::get('admin/login', ['as'=> 'admin.login', 'uses' => 'Admin\UserController@viewLogin']);
    Route::post('admin/authenticate', ['as'=> 'admin.authenticate', 'uses' => 'Admin\UserController@authenticate']);

});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity', 'twostep']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        'ProfilesController', [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@deleteUserAccount',
    ]);

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
        'uses' => 'ProfilesController@userProfileAvatar',
    ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'ProfilesController@upload']);
});

Route::group(['middleware' => ['admin.auth']], function () {
    Route::get('admin/dashboard', ['as'=> 'admin.dashboard', 'uses' => 'Admin\DashboardController@index']);
    Route::get('admin/logout', ['as'=> 'admin.logout', 'uses' => 'Admin\UserController@logout']);

    //Admin Manage Users
    Route::get('admin/users', ['as'=> 'admin.users.index', 'uses' => 'Admin\UserController@index']);
    Route::post('admin/users', ['as'=> 'admin.users.store', 'uses' => 'Admin\UserController@store']);
    Route::get('admin/users/create', ['as'=> 'admin.users.create', 'uses' => 'Admin\UserController@create']);
    Route::put('admin/users/{id}', ['as'=> 'admin.users.update', 'uses' => 'Admin\UserController@update']);
    Route::patch('admin/users/{id}', ['as'=> 'admin.users.update', 'uses' => 'Admin\UserController@update']);
    Route::delete('admin/users/{id}', ['as'=> 'admin.users.destroy', 'uses' => 'Admin\UserController@destroy']);
    Route::get('admin/users/{id}', ['as'=> 'admin.users.show', 'uses' => 'Admin\UserController@show']);
    Route::get('admin/users/{id}/edit', ['as'=> 'admin.users.edit', 'uses' => 'Admin\UserController@edit']);

    //Admin Manage Businesses
    Route::get('admin/business', ['as'=> 'admin.business.index', 'uses' => 'Admin\BusinessController@index']);
    Route::post('admin/business', ['as'=> 'admin.business.store', 'uses' => 'Admin\BusinessController@store']);
    Route::get('admin/business/create', ['as'=> 'admin.business.create', 'uses' => 'Admin\BusinessController@create']);
    Route::put('admin/business/{business}', ['as'=> 'admin.business.update', 'uses' => 'Admin\BusinessController@update']);
    Route::patch('admin/business/{business}', ['as'=> 'admin.business.update', 'uses' => 'Admin\BusinessController@update']);
    Route::delete('admin/business/{business}', ['as'=> 'admin.business.destroy', 'uses' => 'Admin\BusinessController@destroy']);
    Route::get('admin/business/{business}', ['as'=> 'admin.business.show', 'uses' => 'Admin\BusinessController@show']);
    Route::get('admin/business/{business}/edit', ['as'=> 'admin.business.edit', 'uses' => 'Admin\BusinessController@edit']);
    Route::post('admin/business_admin', ['as'=> 'admin.business_admin.store', 'uses' => 'Admin\BusinessController@storeUser']);
    Route::put('admin/business_admin/{business}', ['as'=> 'admin.business_admin.update', 'uses' => 'Admin\BusinessController@updateUser']);
    Route::patch('admin/business_admin/{business}', ['as'=> 'admin.business_admin.update', 'uses' => 'Admin\BusinessController@updateUser']);

    //Admin Setting
    Route::post('admin/business/settings', ['as'=> 'admin.setting.update', 'uses' => 'Admin\BusinessController@update_setting']);
});

