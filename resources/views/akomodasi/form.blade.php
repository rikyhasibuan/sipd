@extends('layouts.app')
@section('content')
    <div id="app">
        <akomodasi-update 
            :akomodasi='{!! json_encode($akomodasi) !!}'
            :kabkota_data='{!! json_encode($kabkota) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'>
        </akomodasi-update>
    </div>
@stop