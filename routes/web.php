<?php

use Illuminate\Support\Facades\Route;
use App\Imports\UsersImport;
use App\Http\Controllers\LectorXMLController;

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
   /*  set_time_limit(7200);
    $files = \Storage::allFiles("RegistrosAntes2020");
    foreach ($files as $key => $value) {
        try {
            \Excel::import(new UsersImport, $value, 'local');
            \Storage::move($value, "finalizaAntes2020/$value");

        } catch (\Throwable $th) {
            \Log::error($value." ".$th->getMessage()." ".$th->getFile().' linea '.$th->getLine());
            continue;

        }       
    } */
    //\Excel::import(new UsersImport, "Registros2021/rc152.xls", 'local');
});
 
Route::get('/readxml', function(){
    set_time_limit(7200);
    $files = \Storage::allFiles("FEBRERO2020");
    //dd($files);
    foreach ($files as $key => $value) {
        try {
            $foo = \File::extension(storage_path("app/$value"));
            if ($foo == "xml") {
                $xml = new LectorXMLController;
                $xml = $xml->LectorXML(\File::get( storage_path("app/$value") ));
                //\Storage::move($value, "finalizado/$value");

                //DD($xml);
            }else {
                continue;
            }
           
        } catch (\Throwable $th) {
            dd($th);
        }       
    }
});