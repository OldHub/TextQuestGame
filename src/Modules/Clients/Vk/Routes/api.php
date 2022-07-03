<?php

use Illuminate\Support\Facades\Route;
use Modules\Clients\Vk\Http\Controllers\CallbackController;

Route::post('vk/callback', [CallbackController::class, 'execute']);
