<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.loan-applications.index')->with('status', session('status'));
    }

    return redirect()->route('admin.loan-applications.index');
});

Route::get('/index', 'Front\FrontendController@index')->name('index');
Route::get('/about', 'Front\FrontendController@about')->name('about');
Route::get('/team', 'Front\FrontendController@team')->name('team');
Route::get('/contact', 'Front\FrontendController@contact')->name('contact');
Route::get('/portfolio', 'Front\FrontendController@portfolio')->name('portfolio');
Route::get('/services', 'Front\FrontendController@services')->name('services');
Route::get('/pricing', 'Front\FrontendController@pricing')->name('pricing');

Auth::routes();
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Statuses
    Route::delete('statuses/destroy', 'StatusesController@massDestroy')->name('statuses.massDestroy');
    Route::resource('statuses', 'StatusesController');

    // Loan Applications
    Route::delete('loan-applications/destroy', 'LoanApplicationsController@massDestroy')->name('loan-applications.massDestroy');
    Route::get('loan-applications/{loan_application}/analyze', 'LoanApplicationsController@showAnalyze')->name('loan-applications.showAnalyze');
    Route::post('loan-applications/{loan_application}/analyze', 'LoanApplicationsController@analyze')->name('loan-applications.analyze');
    Route::get('loan-applications/{loan_application}/send', 'LoanApplicationsController@showSend')->name('loan-applications.showSend');
    Route::post('loan-applications/{loan_application}/send', 'LoanApplicationsController@send')->name('loan-applications.send');
    Route::resource('loan-applications', 'LoanApplicationsController');

    // Comments
    Route::delete('comments/destroy', 'CommentsController@massDestroy')->name('comments.massDestroy');
    Route::resource('comments', 'CommentsController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
});
