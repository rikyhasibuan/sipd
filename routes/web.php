<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', 'Web\LoginController@login');

Route::get('login', 'Web\LoginController@login');
Route::get('logout', 'Web\LoginController@logout');
Route::get('logout', 'Web\LoginController@logout');

Route::get('dashboard', 'Web\DashboardController@index');

// program
Route::get('program', 'Web\ProgramController@index');
Route::get('program/create', 'Web\ProgramController@create');
Route::get('program/edit', 'Web\ProgramController@edit');

// kegiatan
Route::get('kegiatan', 'Web\KegiatanController@index');
Route::get('kegiatan/create', 'Web\KegiatanController@create');
Route::get('kegiatan/edit', 'Web\KegiatanController@edit');

// belanja
Route::get('belanja', 'Web\BelanjaController@index');
Route::get('belanja/create', 'Web\BelanjaController@create');
Route::get('belanja/edit', 'Web\BelanjaController@edit');

// harian
Route::get('harian', 'Web\HarianController@index');
Route::get('harian/edit', 'Web\HarianController@edit');

// akomodasi
Route::get('akomodasi', 'Web\AkomodasiController@index');
Route::get('akomodasi/edit', 'Web\AkomodasiController@edit');

// bbm
Route::get('bbm', 'Web\BbmController@index');
Route::get('bbm/edit', 'Web\BbmController@edit');

// hargabbm
Route::get('hargabbm', 'Web\HargaBbmController@index');

// bop
Route::get('bop', 'Web\BopController@index');
Route::get('bop/edit', 'Web\BopController@edit');

// pegawai
Route::get('pegawai', 'Web\PegawaiController@index');
Route::get('pegawai/create', 'Web\PegawaiController@create');
Route::get('pegawai/edit', 'Web\PegawaiController@edit');

// perangkat daerah
Route::get('perangkatdaerah', 'Web\PerangkatDaerahController@index');
Route::get('perangkatdaerah/create', 'Web\PerangkatDaerahController@create');
Route::get('perangkatdaerah/edit', 'Web\PerangkatDaerahController@edit');

// anggaran
Route::get('anggaran', 'Web\AnggaranController@index');
Route::get('anggaran/create', 'Web\AnggaranController@create');
Route::get('anggaran/edit', 'Web\AnggaranController@edit');

// dinas bop
Route::get('dinasbop', 'Web\DinasBopController@index');
Route::get('dinasbop/create', 'Web\DinasBopController@create');
Route::get('dinasbop/edit', 'Web\DinasBopController@edit');
Route::get('dinasbop/detail', 'Web\DinasBopController@detail');

Route::get('dinasbop/tim/create', 'Web\DinasBopController@create_tim');
Route::get('dinasbop/tim/edit', 'Web\DinasBopController@edit_tim');

// dinas regular
Route::get('dinasregular', 'Web\DinasRegularController@index');
Route::get('dinasregular/create', 'Web\DinasRegularController@create');
Route::get('dinasregular/edit', 'Web\DinasRegularController@edit');
Route::get('dinasregular/detail', 'Web\DinasRegularController@detail');
Route::get('dinasregular/transportasi', 'Web\DinasRegularController@transportasi');
