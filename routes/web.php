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
    return view('welcome');
});

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id'     => '3',
        'redirect_uri'  => 'http://lar-passport.loc/oauth/callback',
        'response_type' => 'code',
        'scope'         => '',
    ]);

    return redirect('http://lar-passport.loc/oauth/authorize?' . $query);
});

Route::get('/oauth/callback', function () {

    $http = new GuzzleHttp\Client;

    if (request('code')) {
        $response = $http->post('http://lar-passport.loc/oauth/token', [
            'form_params' => [
                'grant_type'    => 'authorization_code',
                'client_id'     => '3',
                'client_secret' => 'AK4SbyDYDnhErHUAF0W8Pyfp0QohDyNyeSpkagc5',
                'redirect_uri'  => 'http://lar-passport.loc/oauth/callback',
                'code'          => request('code'),
            ],
        ]);

        return json_decode((string)$response->getBody(), TRUE);
    } else {
        return response()->json(['error' => request('error')]);
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
