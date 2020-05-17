<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', 'Web\LoginController@login');
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('login', 'Web\LoginController@login');
Route::get('logout', 'Web\LoginController@logout');
Route::get('logout', 'Web\LoginController@logout');

Route::get('dashboard', 'Web\DashboardController@index');

Route::get('profile', 'Web\ProfileController@index');

// irban
Route::get('irban', 'Web\IrbanController@index');
Route::get('irban/create', 'Web\IrbanController@create');
Route::get('irban/edit', 'Web\IrbanController@edit');

// irbanskpd
Route::get('irbanskpd', 'Web\IrbanSkpdController@index');
Route::get('irbanskpd/create', 'Web\IrbanSkpdController@create');
Route::get('irbanskpd/edit', 'Web\IrbanSkpdController@edit');

// irbankabkota
Route::get('irbankabkota', 'Web\IrbanKabkotaController@index');
Route::get('irbankabkota/create', 'Web\IrbanKabkotaController@create');
Route::get('irbankabkota/edit', 'Web\IrbanKabkotaController@edit');

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

// user
Route::get('user', 'Web\UserController@index');
Route::get('user/create', 'Web\UserController@create');
Route::get('user/edit', 'Web\UserController@edit');

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

Route::get('dinasbop/driver/create', 'Web\DinasBopController@create_driver');
Route::get('dinasbop/driver/edit', 'Web\DinasBopController@edit_driver');

Route::get('dinasbop/inspektur/create', 'Web\DinasBopController@create_inspektur');
Route::get('dinasbop/inspektur/edit', 'Web\DinasBopController@edit_inspektur');

Route::get('dinasbop/sekretaris/create', 'Web\DinasBopController@create_sekretaris');
Route::get('dinasbop/sekretaris/edit', 'Web\DinasBopController@edit_sekretaris');

Route::get('dinasbop/reviu/create', 'Web\DinasBopController@create_reviu');
Route::get('dinasbop/reviu/edit', 'Web\DinasBopController@edit_reviu');

Route::get('dinasbop/supervisi/create', 'Web\DinasBopController@create_supervisi');
Route::get('dinasbop/supervisi/edit', 'Web\DinasBopController@edit_supervisi');

Route::get('dinasbop/pengumpuldata/create', 'Web\DinasBopController@create_pengumpuldata');
Route::get('dinasbop/pengumpuldata/edit', 'Web\DinasBopController@edit_pengumpuldata');

Route::get('dinasbop/timpengumpuldata/create', 'Web\DinasBopController@create_pengumpuldata_tim');
Route::get('dinasbop/timpengumpuldata/edit', 'Web\DinasBopController@edit_pengumpuldata_tim');


// dinas regular
Route::get('dinasregular', 'Web\DinasRegularController@index');
Route::get('dinasregular/create', 'Web\DinasRegularController@create');
Route::get('dinasregular/edit', 'Web\DinasRegularController@edit');
Route::get('dinasregular/detail', 'Web\DinasRegularController@detail');
Route::get('dinasregular/transportasi', 'Web\DinasRegularController@transportasi');
