<?php

use WpStarter\Support\Facades\Route;

Route::get('/', function () {
    return ws_view('welcome');
});
