<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\AdminPermision;
use App\Http\Controllers\ArticalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyCommentController;
use App\Http\Controllers\LikeController;
use App\Models\ReplyComment;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AppversionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['auth:sanctum']], function(){
     /* Admin */
 Route::group(['middleware' => ['admin']], function () {
    
    /* Delete user if you're admin */
    Route::delete('admin/user/delete/{id}', [AdminController::class, 'adminDeleteUser']);

    /* Role */
    Route::post('/role/create', [RoleController::class, 'create']);
    Route::get('/role', [RoleController::class,'index']);
    Route::post('/admin/add/user/{id}', [AuthController::class,'addRole']);

});
});
 /* User */
 Route::post('/register', [AuthController::class, 'register']);
 Route::post('/login', [AuthController::class, 'login']);
 Route::post('/login', [AuthController::class, 'login']);
 Route::get('/auth/google', [AuthController::class, 'redirectToProvider'])->name('auth.google');
 
 Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/user/add/avatar', [AuthController::class, 'addAvatar']) ;
    Route::get('/user/info', [AuthController::class, 'userinfo']);
    Route::group(['middleware'=> ['user']], function(){
        Route::put('/user/update', [AuthController::class, 'updateOwnUser']);
        Route::delete('/user/delete/', [AuthController::class, 'deleteOwnUser']);
        
       
        /* like */
           Route::get('/like', [LikeController::class, 'index']);
           Route::post('/like/create/', [LikeController::class, 'create']);
           Route::delete('/like/delete/{id}', [LikeController::class, 'unlike']);
       
        });
});

    /* Editor */
   Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::group(['middleware' => ['editor']], function(){
        Route::get('/all/user', [AuthController::class, 'index']);
        Route::post('/role/create', [RoleController::class, 'create']);
        Route::get('/role', [RoleController::class,'index']);
       
    });
   });

/* Artical */
    Route::get('/artical', [ArticalController::class, 'index']);
    Route::get('/artical/{id}', [ArticalController::class, 'show']);
    Route::get('/version', [AppversionController::class, 'GetfirstApp']);
// group auth sanctum
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::group(['middleware' => ['postpermission']], function(){
    Route::post('/artical/create', [ArticalController::class, 'create']);
    Route::put('/artical/update/{id}', [ArticalController::class, 'edit']);
    Route::delete('/artical/delete/{id}', [ArticalController::class, 'delete']);
    Route::get('/category/show/{id}',[ArticalController::class, 'shortArticalByCategory']);
    Route::post('/app/version/create/', [AppversionController::class, 'create']);
    Route::put('/app/version/edit/{id}', [AppversionController::class, 'edit']);
    Route::Delete('/app/version/delete/{id}', [AppversionController::class, 'destroy']);
   
});
});


/* Category */
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/app/version', [AppversionController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::group(['middleware' => ['postpermission']], function(){ 
        Route::post('/category/create', [CategoryController::class, 'create']);
        Route::PATCH('/category/edit/{id}', [CategoryController::class, 'update']);
        Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);
        });
});


/* Tags */
Route::get('/tags', [TagsController::class, 'index']);
Route::group(['middleware' =>['auth:sanctum']], function(){
    Route::group(['middleware' => ['postpermission']], function(){
        Route::post('/tags/create', [TagsController::class, 'create']);
        Route::put('/tags/edit/{id}', [TagsController::class, 'update']);
        Route::delete('/tags/delete/{id}', [TagsController::class, 'destroy']);
        });
});

/* Type */

Route::get('/type', [TypeController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::group(['middleware' => ['postpermission']], function(){
        Route::post('/type/create', [TypeController::class, 'create']);
        Route::put('/type/edit/{id}', [TypeController::class, 'update']);
        Route::delete('/type/delete/{id}', [TypeController::class, 'destroy']);
        });
});

/* Comment */

Route::get('/comment',[CommentController::class, 'index']);
Route::get('/comment/reply/{id}',[CommentController::class,'showreply']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::group(['middleware' => ['user']], function(){
        Route::post('/comment/create/', [CommentController::class, 'create']);
        Route::put('/comment/update/{id}', [CommentController::class, 'update']);
        Route::delete('/comment/delete/{id}', [CommentController::class, 'delete']);
       
    
        /* Reply Comment */
    
        Route::post('/reply/create/{id}', [ReplyCommentController::class,'create']);
        Route::get('/reply',[ReplyCommentController::class,'index']);
        Route::put('/reply/update/{id}', [ReplyCommentController::class, 'update']);
       
    });
});

Route::get('/artical/test/{id}', [ArticalController::class, 'showArticalHasComment']);




    
   
