@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <kegiatan-create 
                :program_data='{!! json_encode($program) !!}'
                :bendahara_data='{!! json_encode($bendahara) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </kegiatan-create>
        @else 
            <kegiatan-update 
                :kegiatan='{!! json_encode($kegiatan) !!}'
                :bendahara_data='{!! json_encode($bendahara) !!}'
                :program_data='{!! json_encode($program) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </kegiatan-update>
        @endif
    </div>
@stop