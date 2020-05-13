@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasbopreviu-create 
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :dinasbop_data='{!! json_encode($dinasbop_data) !!}'
                :anggota='{!! json_encode($anggota) !!}'
                :ketua='{!! json_encode($ketua) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbopreviu-create>
        @else 
            <dinasbopreviu-update 
                :dinasbopreviu='{!! json_encode($dinasbopreviu) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbopreviu-update>
        @endif
    </div>
@stop