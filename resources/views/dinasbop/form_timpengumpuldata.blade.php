@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasboptimpengumpuldata-create
                :irban_data='{!! json_encode($irban) !!}'
                :pengumpuldata='{!! json_encode($pengumpuldata) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :auditan_data='{!! json_encode($auditan) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasboptimpengumpuldata-create>
        @else
            <dinasboptimpengumpuldata-update
                :dinasboptimpengumpuldata='{!! json_encode($dinasboptimpengumpuldata) !!}'
                :pengumpuldata='{!! json_encode($pengumpuldata) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :irban_data='{!! json_encode($irban) !!}'
                :auditan_data='{!! json_encode($auditan) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasboptimpengumpuldata-update>
        @endif
    </div>
@stop
