@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasbopdriver-create
                :driver_data='{!! json_encode($driver) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbopdriver-create>
        @else 
            <dinasbopdriver-update 
                :dinasbopdriver='{!! json_encode($dinasbopdriver) !!}'
                :driver_data='{!! json_encode($driver) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbopdriver-update>
        @endif
    </div>
@stop