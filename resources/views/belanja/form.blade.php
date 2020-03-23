@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <belanja-create 
                :program_data='{!! json_encode($program) !!}'
                :kegiatan_data='{!! json_encode($kegiatan) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </belanja-create>
        @else 
            <belanja-update 
                :belanja='{!! json_encode($belanja) !!}'
                :program_data='{!! json_encode($program) !!}'
                :kegiatan_data='{!! json_encode($kegiatan) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </belanja-update>
        @endif
    </div>
@stop