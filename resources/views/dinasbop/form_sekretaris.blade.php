@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasbopsekretaris-create
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbopsekretaris-create>
        @else 
            <dinasbopsekretaris-update 
                :dinasbopsekretaris='{!! json_encode($dinasbopsekretaris) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbopsekretaris-update>
        @endif
    </div>
@stop