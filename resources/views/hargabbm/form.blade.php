@extends('layouts.app')
@section('content')
    <div id="app">
        <hargabbm-update 
            :hargabbm='{!! json_encode($hargabbm) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'>
        </hargabbm-update>
    </div>
@stop