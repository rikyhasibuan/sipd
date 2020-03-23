@extends('layouts.app')
@section('content')
    <div id="app">
        <dinasbop-index
            :kegiatan_data='{!! json_encode($kegiatan) !!}'
            :program_data='{!! json_encode($program) !!}'
            :belanja_data='{!! json_encode($belanja) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'
            :access='{!! json_encode($access) !!}'>
        </dinasbop-index>
    </div>
@stop