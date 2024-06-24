<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Banner
    Route::post('banners/media', 'BannerApiController@storeMedia')->name('banners.storeMedia');
    Route::apiResource('banners', 'BannerApiController');

    // Walkthrough
    Route::post('walkthroughs/media', 'WalkthroughApiController@storeMedia')->name('walkthroughs.storeMedia');
    Route::apiResource('walkthroughs', 'WalkthroughApiController');
});
