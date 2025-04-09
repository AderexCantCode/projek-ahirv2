<?php

use App\Http\Controllers\TransactionController;

Route::post('/midtrans/callback', [TransactionController::class, 'callback']);
