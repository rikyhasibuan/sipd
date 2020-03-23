@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasbop-create 
                :program_data='{!! json_encode($program) !!}'
                :kegiatan_data='{!! json_encode($kegiatan) !!}'
                :belanja_data='{!! json_encode($belanja) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbop-create>
        @else 
            <dinasbop-update
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :program_data='{!! json_encode($program) !!}'
                :kegiatan_data='{!! json_encode($kegiatan) !!}'
                :belanja_data='{!! json_encode($belanja) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasbop-update>
        @endif
    </div>
@stop