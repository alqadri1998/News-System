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
*/

use Illuminate\Support\Facades\Route;

//****************** WEBSITE *********************//
Route::view('', 'website.index')->name('website.home');
Route::view('contact', 'website.contact')->name('website.contact');

//****************** CMS-ADMIN *******************//
Route::prefix('cms/admin/')->namespace('Auth')->group(function () {
    Route::get('login', 'AdminAuthController@showLoginView')->name('cms.admin.login_view');
    Route::post('login', 'AdminAuthController@login')->name('cms.admin.login');
    Route::view('blocked', 'cms.blocked')->name('cms.admin.blocked');

    Route::get('forgot-password', 'AdminAuthController@showForgetPassword')->name('cms.admin.forgot_password_view');
    Route::post('forgot-password', 'AdminAuthController@requestNewPassword')->name('cms.admin.forgot_password');
});

Route::prefix('cms/admin/')->namespace('CMS')->middleware('auth:admin,author')->group(function () {
    Route::get('', 'AdminDashboardController@dashboard')->name('cms.admin.dashboard');
});

Route::prefix('cms/admin')->namespace('CMS')->middleware('auth:admin')->group(function (){
    Route::resource('admins', 'AdminController');
    Route::resource('authors', 'AuthorController');
    Route::resource('categories', 'CategoryController');
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('contact-requests', 'ContactRequestController');
});

Route::prefix('cms/admin/')->namespace('CMS')->middleware('auth:admin')->group(function () {
    Route::get('roles/{id}/edit-permissions', 'RoleController@editRolePermissions')->name('roles.edit-permissions');
    Route::post('roles/{id}/update-permissions', 'RoleController@updateRolePermissions')->name('roles.update-permissions');
    Route::get('{id}/edit-permissions', [App\Http\Controllers\CMS\AdminController::class,'editPermissions'])->name('admins.edit-permissions');
    Route::post('{id}/update-permissions', [App\Http\Controllers\CMS\AdminController::class,'updatePermissions'])->name('admins.update-permissions');
});

Route::prefix('cms/admin/')->namespace('CMS')->middleware('auth:admin')->group(function () {
    Route::get('categories/{id}/articles', 'CategoryController@showArticles')->name('category.articles');
    Route::get('categories/{id}/authors', 'CategoryController@showAuthors')->name('category.authors');

    Route::get('authors/{id}/articles', 'AuthorController@showArticles')->name('author.articles');
    Route::get('authors/{id}/categories', 'AuthorController@showCategories')->name('author.categories');
});

Route::prefix('cms/admin')->namespace('CMS')->middleware('auth:admin,author')->group(function (){
    Route::resource('articles', 'ArticleController');
});

Route::prefix('cms/admin/')->namespace('Auth')->middleware('auth:admin')->group(function () {
    Route::get('password/reset', 'AdminAuthController@showResetPasswordView')->name('cms.admin.password_reset_view');
    Route::post('password/reset', 'AdminAuthController@resetPassword')->name('cms.admin.password_reset');
    Route::get('logout', 'AdminAuthController@logout')->name('cms.admin.logout');
});

//****************** CMS-AUTHOR ******************//
Route::prefix('cms/author/')->namespace('Auth')->group(function () {
    Route::get('login', 'AuthorAuthController@showLoginView')->name('cms.author.login_view');
    Route::post('login', 'AuthorAuthController@login')->name('cms.author.login');
});

Route::prefix('cms/author/')->middleware('auth:author')->group(function () {
    Route::get('logout', 'Auth\AuthorAuthController@logout')->name('cms.author.logout');
});

//****************** TEMP ******************//
Route::get('mailable', function () {
    $student = App\Admin::where('email', 'momen.sisalem@gmail.com')->first();
    return new App\Mail\AdminPasswordReset($student, '123123');
});

Route::view('err','cms.blocked');
