@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasbosupervisi-create
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :dinasbop_data='{!! json_encode($dinasbop_data) !!}'
                :anggota='{!! json_encode($anggota) !!}'
                :ketua='{!! json_encode($ketua) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbosupervisi-create>
        @else
            <dinasbopsupervisi-update
                :dinasbopsupervisi='{!! json_encode($dinasbopsupervisi) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbopsupervisi-update>
        @endif
    </div>
@stop
