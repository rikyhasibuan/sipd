@extends('layouts.app')
@section('content')
    <div id="app">
        @if($act == 'edit')
            <irban-kabkota-update 
                :irban_data='{!! json_encode($irban) !!}'
                :kabkota_data='{!! json_encode($kabkota) !!}'
                :irbankabkota='{!! json_encode($irbankabkota) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </irban-kabkota-update>
        @elseif ($act == 'create')
            <irban-kabkota-create
                :irban_data='{!! json_encode($irban) !!}'
                :kabkota_data='{!! json_encode($kabkota) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </irban-kabkota-create>
        @endif
    </div>
@stop