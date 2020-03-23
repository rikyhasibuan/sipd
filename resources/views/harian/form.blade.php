@extends('layouts.app')
@section('content')
    <div id="app">
        <harian-update 
            :harian='{!! json_encode($harian) !!}'
            :kabkota_data='{!! json_encode($kabkota) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'>
        </harian-update>
    </div>
@stop