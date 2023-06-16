<?php

use App\Models\ReplyComment;
use Illuminate\Http\Request;
use App\Http\Controllers\socialLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminPermision;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\TypeController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ArticalController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AppversionController;
use App\Http\Controllers\ReplyCommentController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\OriginController;
use App\Http\Controllers\SubCategoryController;


Route::group(['middleware' => ['auth:sanctum']], function () {
    /* Admin */
    Route::group(['middleware' => ['admin']], function () {

        /* Delete user if you're admin */
        Route::delete('admin/user/delete/{id}', [AdminController::class, 'adminDeleteUser']);

        /* Role */
        Route::post('/role/create', [RoleController::class, 'create']);
        Route::get('/role', [RoleController::class, 'index']);
        Route::post('/admin/add/user/{id}', [AuthController::class, 'addRole']);
    });
});
/* User */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/auth/google', [AuthController::class, 'redirectToProvider'])->name('auth.google');
//refrsh token route
Route::get('/refresh', [AuthController::class, 'refresh']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user/add/avatar', [AuthController::class, 'addAvatar']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user/info', [AuthController::class, 'userinfo']);
    Route::group(['middleware' => ['user']], function () {
        Route::put('/user/update', [AuthController::class, 'updateOwnUser']);
        Route::delete('/user/delete/', [AuthController::class, 'deleteOwnUser']);



        /* like */
        Route::get('/like', [LikeController::class, 'index']);
        Route::post('/like/create/', [LikeController::class, 'create']);
        Route::delete('/like/delete/{id}', [LikeController::class, 'unlike']);
        Route::get('/like/find/{id}', [LikeController::class, 'findLike']);
    });
});

/* Editor */
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['middleware' => ['editor']], function () {
        Route::get('/all/user', [AuthController::class, 'index']);
        Route::post('/role/create', [RoleController::class, 'create']);
        Route::get('/role', [RoleController::class, 'index']);
    });
});

/* Artical */
Route::get('/artical', [ArticalController::class, 'index']);
Route::get('/artical/{id}', [ArticalController::class, 'show']);
Route::get('/version', [AppversionController::class, 'GetfirstApp']);
// group auth sanctum
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['middleware' => ['postpermission']], function () {
        Route::post('/artical/create', [ArticalController::class, 'create']);
        Route::put('/artical/update/{id}', [ArticalController::class, 'edit']);
        Route::delete('/artical/delete/{id}', [ArticalController::class, 'delete']);
        Route::get('/category/show/{id}', [ArticalController::class, 'shortArticalByCategory']);
        Route::post('/app/version/create/', [AppversionController::class, 'create']);
        Route::put('/app/version/edit/{id}', [AppversionController::class, 'edit']);
        Route::Delete('/app/version/delete/{id}', [AppversionController::class, 'destroy']);
    });
});


/* Category */
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/app/version', [AppversionController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['middleware' => ['postpermission']], function () {
        Route::post('/category/create', [CategoryController::class, 'create']);
        Route::PATCH('/category/edit/{id}', [CategoryController::class, 'update']);
        Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);
    });
});


/* Tags */
Route::get('/tags', [TagsController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['middleware' => ['postpermission']], function () {
        Route::post('/tags/create', [TagsController::class, 'create']);
        Route::put('/tags/edit/{id}', [TagsController::class, 'update']);
        Route::delete('/tags/delete/{id}', [TagsController::class, 'destroy']);
    });
});

/* Type */

Route::get('/type', [TypeController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['middleware' => ['postpermission']], function () {
        Route::post('/type/create', [TypeController::class, 'create']);
        Route::put('/type/edit/{id}', [TypeController::class, 'update']);
        Route::delete('/type/delete/{id}', [TypeController::class, 'destroy']);
    });
});

/* Feature */
Route::get('/feature', [FeatureController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['middleware' => ['postpermission']], function () {
        Route::post('/feature/create', [FeatureController::class, 'create']);
        Route::put('/feature/edit/{id}', [FeatureController::class, 'update']);
        Route::delete('/feature/delete/{id}', [FeatureController::class, 'destroy']);
    });
});

/* Origin */

Route::get('/origin', [OriginController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['middleware' => ['postpermission']], function () {
        Route::post('/origin/create', [OriginController::class, 'create']);
        Route::put('/origin/edit/{id}', [OriginController::class, 'update']);
        Route::delete('/origin/delete/{id}', [OriginController::class, 'destroy']);
    });
});

/* Sub Category */
Route::get('/sub-category', [SubCategoryController::class, 'index']);
Route::get('/sub_category/showartical/{id}', [SubCategoryController::class, 'showartical']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['middleware' => ['postpermission']], function () {
        Route::post('/sub-category/create', [SubCategoryController::class, 'create']);
        Route::put('/sub-category/edit/{id}', [SubCategoryController::class, 'update']);
        Route::delete('/sub-category/delete/{id}', [SubCategoryController::class, 'destroy']);
    });
});

/* Comment */

Route::get('/comment', [CommentController::class, 'index']);
Route::get('/comment/reply/{id}', [CommentController::class, 'showreply']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['middleware' => ['user']], function () {
        Route::post('/comment/create/', [CommentController::class, 'create']);
        Route::put('/comment/update/{id}', [CommentController::class, 'update']);
        Route::delete('/comment/delete/{id}', [CommentController::class, 'delete']);


        /* Reply Comment */

        Route::post('/reply/create/{id}', [ReplyCommentController::class, 'create']);
        Route::get('/reply', [ReplyCommentController::class, 'index']);
        Route::put('/reply/update/{id}', [ReplyCommentController::class, 'update']);
    });
});


Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();

    // $user->token
});

Route::get('/artical/test/{id}', [ArticalController::class, 'showArticalHasComment']);



/* artist */
Route::get('/artist', [ArtistController::class, 'index']);
Route::get('/artist/{id}', [ArtistController::class, 'show']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['middleware' => ['postpermission']], function () {
        Route::post('/artist/create', [ArtistController::class, 'create']);
        Route::put('/artist/edit/{id}', [ArtistController::class, 'update']);
        Route::delete('/artist/delete/{id}', [ArtistController::class, 'destroy']);
    });
});

/* Country */
Route::get('/country', [CountryController::class, 'index']);
