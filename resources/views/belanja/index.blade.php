@extends('layouts.app')
@section('content')
    <div id="app">
        <belanja-index
            :kegiatan_data='{!! json_encode($kegiatan) !!}'
            :program_data='{!! json_encode($program) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'
            :access='{!! json_encode($access) !!}'>
        </belanja-index>
    </div>
@stop