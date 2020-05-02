@extends('layouts.app')
@section('content')
    <div id="app">
        <irban-skpd-index 
            :access='{!! json_encode($access) !!}'
            :api='{!! json_encode($api) !!}' 
            :irban_data='{!! json_encode($irban) !!}'
            :route='{!! json_encode($route) !!}'
            :skpd_data='{!! json_encode($skpd) !!}'>
        </irban-skpd-index>
    </div>
@stop