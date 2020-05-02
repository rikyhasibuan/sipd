@extends('layouts.app')
@section('content')
    <div id="app">
        @if($act == 'edit')
            <irban-update 
                :api='{!! json_encode($api) !!}' :route='{!! json_encode($route) !!}' :irban='{!! json_encode($irban) !!}'>
            </irban-update>
        @elseif ($act == 'create')
            <irban-create
                :api='{!! json_encode($api) !!}' :route='{!! json_encode($route) !!}'>
            </irban-create>
        @endif
    </div>
@stop