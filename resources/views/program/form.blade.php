@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <program-create
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </program-create>
        @else 
            <program-update 
                :program='{!! json_encode($program) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </program-update>
        @endif
    </div>
@stop