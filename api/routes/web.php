<?php

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
    // return "heel";//view('welcome');
    return view('welcome');
});
/*
  Accessing uploaded files
*/
Route::get('file/icon/{filename}', function ($filename)
{
  $path = storage_path('/icons/' . $filename);
  if (!File::exists($path)) {
      abort(404);
  }
  $file = File::get($path);
  $type = File::mimeType($path);
  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);
  return $response;
});
Route::get('file/company/{filename}', function ($filename)
{
  $path = storage_path('/company/' . $filename);
  if (!File::exists($path)) {
      abort(404);
  }
  $file = File::get($path);
  $type = File::mimeType($path);
  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);
  return $response;
});
Route::get('file/q_card/{filename}', function ($filename)
{
  $path = storage_path('/qcards/' . $filename);
  if (!File::exists($path)) {
      abort(404);
  }
  $file = File::get($path);
  $type = File::mimeType($path);
  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);
  return $response;
});
Route::get('file/account_profiles/{filename}', function ($filename)
{
  $path = storage_path('/account_profiles/' . $filename);
  if (!File::exists($path)) {
      abort(404);
  }
  $file = File::get($path);
  $type = File::mimeType($path);
  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);
  return $response;
});
Route::get('/cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'hey'.$exitCode;

    //
});
Route::get('/clear', function () {
    $exitCode = Artisan::call('config:cache');
    return 'hey'.$exitCode;

    //
});
Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'hey'.$exitCode;

    //
});

/*sa
  @Bot Routessa
*/
Route::get("/bot/hook","IlinyaController@hook")->middleware("verify");
Route::post("/bot/hook","IlinyaController@hook");
Route::post("/bot/persistent","IlinyaController@persistent");
Route::post("/bot/get_started","IlinyaController@getStarted");
Route::get("/bot/broadcast/{message}","IlinyaController@broadcast");
Route::get("/bot/paging/{recipientId}/{message}/{surveyMode}","IlinyaController@paging");
Route::get("/bot/reminder/{recipientId}/{message}/{surveyMode}","IlinyaController@reminder");
Route::get("/bot/image","IlinyaController@createImage");
Route::get("/bot/test/{size}","IlinyaController@test");

$route = env('PACKAGE_ROUTE', '').'/authenticate';
Route::resource($route, 'AuthenticateController', ['only' => ['index']]);
Route::post($route, 'AuthenticateController@authenticate');
Route::post($route.'/user', 'AuthenticateController@getAuthenticatedUser');
Route::post($route.'/refresh', 'AuthenticateController@refreshToken');
Route::post($route.'/invalidate', 'AuthenticateController@deauthenticate');
Route::post($route.'/auth', function () {
    return true;
});

$route = env('PACKAsaGE_ROUTE', '').'/page_template';
Route::post($route.'/create', "PageTemplateController@create");
Route::post($route.'/retrieve', "PageTemplateController@retrieve");
Route::post($route.'/update', "PageTemplateController@update");
Route::post($route.'/delete', "PageTemplateController@delete");

$route = env('PACKAGE_ROUTE', '').'/bot_template';
Route::post($route.'/create', "BotTemplateController@create");
Route::post($route.'/retrieve', "BotTemplateController@retrieve");
Route::post($route.'/update', "BotTemplateController@update");
Route::post($route.'/delete', "BotTemplateController@delete");

$route = env('PACKAGE_ROUTE', '').'/setup_page';
Route::post($route.'/create', "SetupFacebookController@create");
Route::post($route.'/retrieve', "SetupFacebookController@retrieve");
Route::post($route.'/update', "SetupFacebookController@update");
Route::post($route.'/delete', "SetupFacebookController@delete");

$route = env('PACKAGE_ROUTE', '').'/facebook_page';
Route::post($route.'/get_fb_page', "facebookController@getFacebookPage");

/**
 * @Webview Routes
 */

Route::get("/webview/packages" ,"WebViewController@packageForm");
Route::get('/home', 'HomeController@index')->name('home');
