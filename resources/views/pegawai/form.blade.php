@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <pegawai-create 
                :golongan_data='{!! json_encode($golongan) !!}'
                :pangkat_data='{!! json_encode($pangkat) !!}'
                :jabatan_data='{!! json_encode($jabatan) !!}'
                :eselon_data='{!! json_encode($eselon) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </pegawai-create>
        @else 
            <pegawai-update 
                :pegawai='{!! json_encode($pegawai) !!}'
                :golongan_data='{!! json_encode($golongan) !!}'
                :pangkat_data='{!! json_encode($pangkat) !!}'
                :jabatan_data='{!! json_encode($jabatan) !!}'
                :eselon_data='{!! json_encode($eselon) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </pegawai-update>
        @endif
    </div>
@stop