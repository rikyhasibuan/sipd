@extends('layouts.app')
@section('content')
    <div id="app">
        @if($act == 'edit')
            <irban-skpd-update 
                :irban_data='{!! json_encode($irban) !!}'
                :skpd_data='{!! json_encode($skpd) !!}'
                :irbanskpd='{!! json_encode($irbanskpd) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </irban-skpd-update>
        @elseif ($act == 'create')
            <irban-skpd-create
                :irban_data='{!! json_encode($irban) !!}'
                :skpd_data='{!! json_encode($skpd) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </irban-skpd-create>
        @endif
    </div>
@stop