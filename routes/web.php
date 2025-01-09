<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // not implemented
    http_response_code(501);
    exit;
});
