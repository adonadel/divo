<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group( function() {
    Route::controller(AuthController::class)->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::get('/me', 'me');

            Route::post('/logout', 'logout');
        });

        Route::middleware('api')->group(function () {
            Route::post('/login', 'login');
            Route::post('/refresh', 'refreshToken');
        });
    });
});

Route::prefix('users')->group( function() {
    Route::controller(UserController::class)->group( function() {
        Route::middleware('auth:api')->group(function () {
            Route::get('/', 'getUsers');
            Route::get('/{id}', 'getUserById');
            Route::get('/logged-user', 'getLoggedUser');

            Route::put('/{id}', 'update');

            Route::patch('/{id}/enable', 'enable');
            Route::patch('/{id}/disable', 'disable');

            Route::delete('/{id}/delete', 'delete');
        });

        Route::middleware('api')->group(function () {
            Route::post('/', 'create');
            Route::post('/forgot-password', 'forgotPassword');
            Route::post('/reset-password', 'resetPassword');
        });
    });
});

Route::prefix('establishments')->group( function() {
    Route::controller(EstablishmentController::class)->group( function() {
        Route::middleware('auth:api')->group(function () {
            Route::post('/', 'create');
            Route::post('/with-medias', 'createWithMedias');

            Route::put('/{id}', 'update');
            Route::put('/{id}/favorite/{user_id}', 'favoriteEstablishment');
            Route::put('/{id}/unfavorite/{user_id}', 'unfavoriteEstablishment');
            Route::put('/{id}/rating', 'rateEstablishment');

            Route::delete('/{id}', 'delete');

            Route::get('/', 'getEstablishments');
            Route::get('/{id}', 'getEstablishmentById');
            Route::get('/{user_id}/favorites', 'getMyFavorites');
            Route::get('/{id}/products', 'getProducts');
        });
    });
});

Route::prefix('medias')->group( function() {
    Route::controller(MediaController::class)->group( function() {
        Route::middleware('auth:api')->group(function () {
            Route::post('/', 'create');
            Route::post('/bulk', 'bulkCreate');

            Route::post('/{id}', 'update');

            Route::delete('/{id}', 'delete');
        });
    });
});

Route::prefix('products')->group( function() {
    Route::controller(ProductController::class)->group( function() {
        Route::middleware('auth:api')->group(function () {
            Route::post('/', 'create');
            Route::post('/with-medias', 'createWithMedias');
            Route::post('/{id}/promotion', 'createPromotion');

            Route::put('/{id}', 'update');

            Route::delete('/{id}', 'delete');
            Route::delete('/{id}/promotion/{promotion_id}', 'deletePromotion');

            Route::get('/', 'getProducts');
            Route::get('/{id}', 'getProductById');
            Route::get('/promotions/all', 'getPromotions');
        });
    });
});
