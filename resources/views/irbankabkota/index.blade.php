@extends('layouts.app')
@section('content')
    <div id="app">
        <irban-kabkota-index 
            :access='{!! json_encode($access) !!}'
            :api='{!! json_encode($api) !!}' 
            :irban_data='{!! json_encode($irban) !!}'
            :route='{!! json_encode($route) !!}'
            :kabkota_data='{!! json_encode($kabkota) !!}'>
        </irban-kabkota-index>
    </div>
@stop