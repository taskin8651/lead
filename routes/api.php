<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Leads Module
    Route::apiResource('leads-modules', 'LeadsModuleApiController');

    // Services
    Route::apiResource('services', 'ServicesApiController');
});
