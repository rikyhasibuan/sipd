@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasboptim-create
                :irban_data='{!! json_encode($irban) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :dinasbop_data='{!! json_encode($dinasbop_data) !!}'
                :auditan_data='{!! json_encode($auditan) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasboptim-create>
        @else
            <dinasboptim-update
                :dinasboptim='{!! json_encode($dinasboptim) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :irban_data='{!! json_encode($irban) !!}'
                :auditan_data='{!! json_encode($auditan) !!}'
                :dinasbop_data='{!! json_encode($dinasbop_data) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasboptim-update>
        @endif
    </div>
@stop
