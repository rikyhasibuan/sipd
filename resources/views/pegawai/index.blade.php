@extends('layouts.app')
@section('content')
    <div id="app">
        <pegawai-index
            :golongan_data='{!! json_encode($golongan) !!}'
            :pangkat_data='{!! json_encode($pangkat) !!}'
            :jabatan_data='{!! json_encode($jabatan) !!}'
            :eselon_data='{!! json_encode($eselon) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'
            :access='{!! json_encode($access) !!}'>
        </pegawai-index>
    </div>
@stop