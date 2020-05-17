@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasboppengumpuldata-create
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasboppengumpuldata-create>
        @else
            <dinasboppengumpuldata-update
                :dinasboppengumpuldata='{!! json_encode($dinasboppengumpuldata) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasboppengumpuldata-update>
        @endif
    </div>
@stop
