<?php

use Illuminate\Support\Facades\Route;
use App\Imports\UsersImport;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $files = \Storage::allFiles();
    foreach ($files as $key => $value) {
        \Excel::import(new UsersImport, $value, 'local');

    }
});
