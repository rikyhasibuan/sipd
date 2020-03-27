@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <user-create 
                :level_data='{{ json_encode($level) }}'
                :pegawai_data='{{ json_encode($pegawai) }}'
                :route='{{ json_encode($route) }}'
                :api='{{ json_encode($api) }}'>
            </user-create>
        @else 
            <user-update 
                :user='{{ json_encode($user) }}'
                :level_data='{{ json_encode($level) }}'
                :pegawai_data='{{ json_encode($pegawai) }}'
                :route='{{ json_encode($route) }}'
                :api='{{ json_encode($api) }}'>
            </user-update>
        @endif
    </div>
@stop