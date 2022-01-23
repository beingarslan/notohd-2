<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\UploadFile\UploadFileController;
use App\Http\Controllers\User\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('home', function () {
    if (Auth::check()) {
        if (Auth::user()->hasRole(User::ADMIN)) {
            return redirect('/admin/home');
        } else {
            return redirect()->route('user.dashboard');
        }
    } else {
        return redirect()->route('login');
    }
    Auth::logout();
    return redirect()->route('login');
});

Route::group(
    [
        'middleware' => 'admin'
    ],
    function () {
        Route::group(
            [
                'prefix' => 'admin',
                'as' => 'admin.',
            ],
            function () {
                Route::get('/home', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

                Route::group(
                    [
                        'prefix' => 'users',
                        'as' => 'users.'
                    ],
                    function () {

                        Route::get('/manage', [UserController::class, 'manage'])->name('manage');

                        Route::get('/users', [UserController::class, 'users'])->name('users');
                        Route::post('/edit', [UserController::class, 'edit'])->name('edit');
                        Route::post('/save', [UserController::class, 'save'])->name('save');
                        // Route::post('/edit/role', [UserController::class, 'edit_role'])->name('edit.role');
                        Route::post('/remove', [UserController::class, 'remove'])->name('remove');
                    }
                );

                // Categories
                Route::group(
                    [
                        'prefix' => 'categories',
                        'as' => 'categories.'
                    ],
                    function(){
                        Route::get('/manage', [CategoryController::class, 'manage'])->name('manage');
                        Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
                        Route::post('/save', [CategoryController::class, 'save'])->name('save');
                        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
                        Route::post('/update', [CategoryController::class, 'update'])->name('update');
                    }
                );

                // Images
                Route::group(
                    [
                        'prefix' => 'images',
                        'as' => 'images.'
                    ],
                    function(){
                        Route::get('/manage', [UploadFileController::class, 'manage'])->name('manage');
                        Route::get('/upload', [UploadFileController::class, 'upload'])->name('upload');
                        Route::get('/images', [UploadFileController::class, 'images'])->name('images');
                        Route::post('/store', [UploadFileController::class, 'store'])->name('store');
                        Route::get('/edit/{id}', [UploadFileController::class, 'edit'])->name('edit');
                        Route::post('/remove', [UploadFileController::class, 'remove'])->name('remove');
                    }
                );
            }
        );
    }
);

Route::group(
    [
        'middleware' => 'auth'
    ],
    function(){
        Route::post('/upload/image', [ImageFileController::class, 'uploadImage'])->name('upload.image');
    }
);


// Route::group(
//     [

//     ],
//     function(){
//         Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
//     }
// );

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

Auth::routes();

// Route::post('/upload', function(Request $request){
//     $file = $request->file('file');
//     // upload in S3
//     $path = Storage::disk('Wasabi')->put('/notohd', $file, 'private');

// echo $path;

//     // return response()->json(['location' => '/images/' . $name]);
// })->name('upload');



Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
