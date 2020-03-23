@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasregular-create 
                :program_data='{!! json_encode($program) !!}'
                :kegiatan_data='{!! json_encode($kegiatan) !!}'
                :belanja_data='{!! json_encode($belanja) !!}'
                :irban_data='{!! json_encode($irban) !!}'
                :auditan_data='{!! json_encode($auditan)!!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasregular-create>
        @else 
            <dinasregular-update
                :dinasregular='{!! json_encode($dinasregular) !!}'
                :program_data='{!! json_encode($program) !!}'
                :kegiatan_data='{!! json_encode($kegiatan) !!}'
                :belanja_data='{!! json_encode($belanja) !!}'
                :irban_data='{!! json_encode($irban) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasregular-update>
        @endif
    </div>
@stop