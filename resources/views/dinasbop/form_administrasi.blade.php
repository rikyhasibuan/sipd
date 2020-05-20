@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasbopadministrasi-create
                :route='{!! json_encode($route) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbopadministrasi-create>
        @else
            <dinasbopadministrasi-update
                :dinasbopadministrasi='{!! json_encode($dinasbopadministrasi) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbopadministrasi-update>
        @endif
    </div>
@stop
