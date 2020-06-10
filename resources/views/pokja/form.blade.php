@extends('layouts.app')
@section('content')
    <div id="app">
        @if($act == 'edit')
            <pokja-update 
                :irban_data='{{ json_encode($irban) }}'
                :pegawai_data='{{ json_encode($pegawai) }}'
                :pokja='{{ json_encode($pokja) }}'
                :route='{{ json_encode($route) }}'
                :api='{{ json_encode($api) }}'>
            </pokja-update>
        @elseif ($act == 'create')
            <pokja-create
                :irban_data='{{ json_encode($irban) }}'
                :pegawai_data='{{ json_encode($pegawai) }}'
                :route='{{ json_encode($route) }}'
                :api='{{ json_encode($api) }}'>
            </pokja-create>
        @endif
    </div>
@stop