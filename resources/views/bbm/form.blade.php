@extends('layouts.app')
@section('content')
    <div id="app">
        <bbm-update 
            :bbm='{!! json_encode($bbm) !!}'
            :kabkota_data='{!! json_encode($kabkota) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'>
        </bbm-update>
    </div>
@stop