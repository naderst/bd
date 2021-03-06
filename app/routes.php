<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before' => 'auth'), function()
{
    Route::get('/', function()
    {
        return View::make('torneos.index', array(
            'torneos' => Torneo::orderBy('fecha_inicio', 'desc')->paginate(10)
        ));
    });

    Route::controller('asociaciones', 'AsociacionesController');
    Route::controller('clubes', 'ClubesController');
    Route::controller('atletas', 'AtletasController');
    Route::controller('torneos', 'TorneosController');
    Route::controller('enfrentamientos', 'EnfrentamientosController');
    Route::controller('sets', 'SetsController');
    Route::controller('ranking', 'RankingController');
});

Route::get('/login', array('as' => 'login',function()
{
    return View::make('login');
}))->before('guest');

Route::post('/login', function()
{
    $user = array(
        'username' => Input::get('username'),
        'password' => Input::get('password')
    );

    if(Input::has('remember'))
        $remember = true;
    else
        $remember = false;

    if (Auth::attempt($user, $remember)) {
        return Redirect::intended('/');
    }

    return Redirect::route('login')
        ->with('login_message', 'Nombre de usuario y/o contraseña incorrecta')
        ->withInput();
});

Route::get('/logout', function()
{
    Auth::logout();
    return Redirect::to('/login');
})->before('auth');
