<?php

use Illuminate\Support\Facades\Route;

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


//----Frontend
Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index']);
Route::get('/sub/{id}/{slug}', [\App\Http\Controllers\Frontend\HomeController::class, 'subcategory'])->name('subcategory');
Route::get('/sub/sub/{id}/{slug}', [\App\Http\Controllers\Frontend\HomeController::class, 'sub_subcategory'])->name('sub.subcategory');
Route::get('/videos/category/{category_id}/{slug}', [\App\Http\Controllers\Frontend\HomeController::class, 'videos_category'])->name('videos');
Route::get('/videos/subcategory/{subcategory_id}/{slug}', [\App\Http\Controllers\Frontend\HomeController::class, 'videos_subcategory'])->name('videos.subcategory');
Route::get('/videos/sub_subcategory/{sub_subcategory_id}/{slug}', [\App\Http\Controllers\Frontend\HomeController::class, 'videos_sub_subcategory'])->name('videos.sub.subcategory');
Route::get('/video/{id}/{slug}', [\App\Http\Controllers\Frontend\HomeController::class, 'video_details'])->name('video.details');

//user login
Route::match(['get', 'post'], '/login', [\App\Http\Controllers\Frontend\UserController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [\App\Http\Controllers\Frontend\UserController::class, 'register'])->name('register');

//user dashboard
Route::group(['middleware' => 'auth', 'prefix' =>'user'], function (){
    Route::get('/logout', [\App\Http\Controllers\Frontend\UserController::class, 'logout'])->name('user.logout');
    Route::get('/dashboard', [\App\Http\Controllers\Frontend\UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/edit/profile', [\App\Http\Controllers\Frontend\UserController::class, 'edit_profile'])->name('user.edit.profile');
    Route::post('/update/profile', [\App\Http\Controllers\Frontend\UserController::class, 'update_profile'])->name('user.update.profile');
    Route::get('/change/password', [\App\Http\Controllers\Frontend\UserController::class, 'change_password'])->name('user.change.password');
    Route::get('/check/password', [\App\Http\Controllers\Frontend\UserController::class, 'check_password'])->name('user.check.password');
    Route::post('/update/password', [\App\Http\Controllers\Frontend\UserController::class, 'update_password'])->name('user.update.password');
    //comment section
    Route::post('/comment/store/{movie_id}', [\App\Http\Controllers\Frontend\CommentController::class, 'comment_store'])->name('user.comment.store');
    Route::post('/comment/reply/store/{movie_id}/{comment_id}', [\App\Http\Controllers\Frontend\CommentController::class, 'comment_reply_store'])->name('user.comment.reply.store');

    //Favorite Post
    Route::get('/favorite/{movie_id}', [\App\Http\Controllers\Frontend\CommentController::class, 'favorite_post'])->name('user.favorite');


});

//------Admin Dashboard----------
Route::match(['get', 'post'], '/admin', [\App\Http\Controllers\Backend\AdminController::class, 'login'])->name('admin');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function (){
    Route::post('/logout', [\App\Http\Controllers\Backend\AdminController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [\App\Http\Controllers\Backend\AdminController::class, 'dashboard'])->name('dashboard');

    //--Profile Routes
    Route::group(['prefix' => 'profile'], function (){
       Route::get('/view', [\App\Http\Controllers\Backend\AdminController::class, 'profile'])->name('profile.view');
       Route::get('/edit', [\App\Http\Controllers\Backend\AdminController::class, 'edit_profile'])->name('profile.edit');
       Route::post('/update/{id}', [\App\Http\Controllers\Backend\AdminController::class, 'update_profile'])->name('profile.update');
    });

    //---root category
    Route::group(['prefix' => 'category'], function (){
        Route::get('/view', [\App\Http\Controllers\Backend\CategoryController::class, 'show'])->name('category.view');
        Route::get('/add', [\App\Http\Controllers\Backend\CategoryController::class, 'add'])->name('category.add');
        Route::post('/store', [\App\Http\Controllers\Backend\CategoryController::class, 'store'])->name('category.store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'update'])->name('category.update');
        Route::post('/destroy/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'destroy'])->name('category.destroy');
        Route::get('/status', [\App\Http\Controllers\Backend\CategoryController::class, 'status'])->name('category.status');
    });

    //---sub category
    Route::group(['prefix' => 'subcategory'], function (){
        Route::get('/view', [\App\Http\Controllers\Backend\SubCategoryController::class, 'show'])->name('subcategory.view');
        Route::get('/add', [\App\Http\Controllers\Backend\SubCategoryController::class, 'add'])->name('subcategory.add');
        Route::post('/store', [\App\Http\Controllers\Backend\SubCategoryController::class, 'store'])->name('subcategory.store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\SubCategoryController::class, 'edit'])->name('subcategory.edit');
        Route::post('/update/{id}', [\App\Http\Controllers\Backend\SubCategoryController::class, 'update'])->name('subcategory.update');
        Route::post('/destroy/{id}', [\App\Http\Controllers\Backend\SubCategoryController::class, 'destroy'])->name('subcategory.destroy');
        Route::get('/status', [\App\Http\Controllers\Backend\SubCategoryController::class, 'status'])->name('subcategory.status');
    });

    //---sub subcategory
    Route::group(['prefix' => 'sub-subcategory'], function (){
        Route::get('/view', [\App\Http\Controllers\Backend\Sub_SubCategoryController::class, 'show'])->name('sub_subcategory.view');
        Route::get('/add', [\App\Http\Controllers\Backend\Sub_SubCategoryController::class, 'add'])->name('sub_subcategory.add');
        Route::post('/store', [\App\Http\Controllers\Backend\Sub_SubCategoryController::class, 'store'])->name('sub_subcategory.store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\Sub_SubCategoryController::class, 'edit'])->name('sub_subcategory.edit');
        Route::post('/update/{id}', [\App\Http\Controllers\Backend\Sub_SubCategoryController::class, 'update'])->name('sub_subcategory.update');
        Route::post('/destroy/{id}', [\App\Http\Controllers\Backend\Sub_SubCategoryController::class, 'destroy'])->name('sub_subcategory.destroy');
        Route::get('/status', [\App\Http\Controllers\Backend\Sub_SubCategoryController::class, 'status'])->name('sub_subcategory.status');
    });

    //---videos
    Route::group(['prefix' => 'video'], function (){
        Route::get('/view', [\App\Http\Controllers\Backend\VideoController::class, 'show'])->name('video.view');
        Route::get('/add', [\App\Http\Controllers\Backend\VideoController::class, 'add'])->name('video.add');
        Route::get('/get/subcategory', [\App\Http\Controllers\Backend\VideoController::class, 'get_subcategory'])->name('video.subcategory');
        Route::get('/get/sub-subcategory', [\App\Http\Controllers\Backend\VideoController::class, 'get_sub_subcategory'])->name('video.sub_subcategory');
        Route::match(['post','delete'],'/upload', [\App\Http\Controllers\Backend\VideoController::class, 'video_upload'])->name('video.upload');
        Route::post('/store', [\App\Http\Controllers\Backend\VideoController::class, 'store'])->name('video.store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\VideoController::class, 'edit'])->name('video.edit');
        Route::post('/update/{id}', [\App\Http\Controllers\Backend\VideoController::class, 'update'])->name('video.update');
        Route::post('/destroy/{id}', [\App\Http\Controllers\Backend\VideoController::class, 'destroy'])->name('video.destroy');
        Route::get('/status', [\App\Http\Controllers\Backend\VideoController::class, 'status'])->name('video.status');
    });

    //---sub subcategory
    Route::group(['prefix' => 'cms'], function (){
        Route::get('/view', [\App\Http\Controllers\Backend\CmsController::class, 'show'])->name('cms.view');
        Route::get('/add', [\App\Http\Controllers\Backend\CmsController::class, 'add'])->name('cms.add');
        Route::post('/store', [\App\Http\Controllers\Backend\CmsController::class, 'store'])->name('cms.store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Backend\CmsController::class, 'edit'])->name('cms.edit');
        Route::post('/update/{id}', [\App\Http\Controllers\Backend\CmsController::class, 'update'])->name('cms.update');
        Route::post('/destroy/{id}', [\App\Http\Controllers\Backend\CmsController::class, 'destroy'])->name('cms.destroy');
        Route::get('/status', [\App\Http\Controllers\Backend\CmsController::class, 'status'])->name('cms.status');
    });
});

Route::get('{slug}', [\App\Http\Controllers\Frontend\HomeController::class, 'cms'])->name('cms');
