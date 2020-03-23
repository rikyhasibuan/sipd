@extends('layouts.app')
@section('content')
    <div id="app">
        <harian-index
            :kabkota_data='{!! json_encode($kabkota) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'
            :access='{!! json_encode($access) !!}'>
        </harian-index>
    </div>
@stop