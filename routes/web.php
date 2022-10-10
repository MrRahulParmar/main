<?php

use App\Http\Controllers\ImageHandleController;
use App\Http\Controllers\VideoController;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

//for video route - 4
Route::get('/', [ VideoController::class, 'getVideoUploadForm' ])->name('get.video.upload');
Route::post('video-upload', [ VideoController::class, 'uploadVideo' ])->name('store.video');
Route::get('view-upload-video',[VideoController::class,'display'])->name('view.video');
Route::post('get-gif',[VideoController::class,'getGif'])->name('get.gif');

Route::get('test', [ImageHandleController::class, 'addLogoImage']);


Route::get('png-on-png', [ImageHandleController::class, 'pngOnPng']);

Route::get('a', function()
{
    $response = Http::withOptions([
        'debug' => true,
    ])->get('https://fakestoreapi.com/products/20');
    $fakeResponse = Http::withHeaders([
        'X-First' => 'foo',
    ])->post('https://fakestoreapi.com/products', [
        'title' => 'Taylor',
        'image' => '199.99',
    ]);

});




