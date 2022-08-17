<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


// Route::post('import-users', function (Request $request) {
//     $validated = $request->validate([
//         'file' => 'required|mimes:xlsx|max:5000'
//     ]);

//     $file = $request->file('file');

//     Excel::import(new UsersImport, $file);

//     return response()->json(['success' => true, 'message' => 'import processing in background'], 200);
// });
