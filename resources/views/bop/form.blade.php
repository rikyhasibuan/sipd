@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <bop-create
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </bop-create>
        @else 
            <bop-update 
                :bop='{!! json_encode($bop) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </bop-update>
        @endif
    </div>
@stop