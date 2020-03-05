<?php

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth'])
    ->namespace('ConfrariaWeb\Integration\Controllers')
    ->group(function () {

        Route::resource('integrations', 'IntegrationController');

    });
