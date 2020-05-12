@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasbopinspektur-create
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :dinasbop_data='{!! json_encode($dinasbop_data) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbopinspektur-create>
        @else 
            <dinasbopinspektur-update 
                :dinasbopinspektur='{!! json_encode($dinasbopinspektur) !!}'
                :dinasbop_data='{!! json_encode($dinasbop_data) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbopinspektur-update>
        @endif
    </div>
@stop