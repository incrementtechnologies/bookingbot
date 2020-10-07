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

$route = env('PACKAGE_ROUTE', '').'/bot';
Route::get($route."/hook","IlinyaController@hook")->middleware("verify");
Route::post($route."/hook","IlinyaController@hook");
Route::post($route."/persistent","IlinyaController@persistent");
Route::post($route."/get_started","IlinyaController@getStarted");
Route::get($route."/broadcast/{message}","IlinyaController@broadcast");
Route::get($route."/paging/{recipientId}/{message}/{surveyMode}","IlinyaController@paging");
Route::get($route."/reminder/{recipientId}/{message}/{surveyMode}","IlinyaController@reminder");
Route::get($route."/image","IlinyaController@createImage");
Route::get($route."/test/{size}","IlinyaController@test");

$route = env('PACKAGE_ROUTE', '').'/authenticate';
Route::resource($route, 'AuthenticateController', ['only' => ['index']]);
Route::post($route, 'AuthenticateController@authenticate');
Route::post($route.'/user', 'AuthenticateController@getAuthenticatedUser');
Route::post($route.'/refresh', 'AuthenticateController@refreshToken');
Route::post($route.'/invalidate', 'AuthenticateController@deauthenticate');
Route::post($route.'/auth', function () {
    return true;
});

$route = env('PACKAGE_ROUTE', '').'/page_template';
//Emails Controller
$route = env('PACKAGE_ROUTE', '').'/emails';
Route::post($route.'/create', "EmailController@create");
Route::post($route.'/retrieve', "EmailController@retrieve");
Route::post($route.'/update', "EmailController@update");
Route::post($route.'/delete', "EmailController@delete");
Route::post($route.'/reset_password', 'EmailController@resetPassword');
Route::post($route.'/verification', 'EmailController@verification');
Route::post($route.'/changed_password', 'EmailController@changedPassword');
Route::post($route.'/referral', 'EmailController@referral');
Route::post($route.'/trial', 'EmailController@trial');
Route::post($route.'/test_sms', 'EmailController@testSMS');

//Notification Settings Controller
$route = env('PACKAGE_ROUTE', '').'/notification_settings/';
$controller = 'NotificationSettingController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update_otp', $controller."generateOTP");
Route::post($route.'block_account', $controller."blockedAccount");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller.'test');

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
Route::post($route.'/save', "BotTemplateController@save");
Route::post($route.'/retrieve_content', "BotTemplateController@retrieve_content");
/**
 * @Webview Routes
 */

Route::get("/webview/packages" ,"WebViewController@packageForm");
Route::get('/home', 'HomeController@index')->name('home');


$image_route = env('PACKAGE_ROUTE', '');
Route::get($image_route.'/storage/image/{filename}', function ($filename)
{
    $path = storage_path('/app/images/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
