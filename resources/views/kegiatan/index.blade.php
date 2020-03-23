@extends('layouts.app')
@section('content')
    <div id="app">
        <kegiatan-index
            :program_data='{!! json_encode($program) !!}'
            :bendahara_data='{!! json_encode($bendahara) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'
            :access='{!! json_encode($access) !!}'>
        </kegiatan-index>
    </div>
@stop