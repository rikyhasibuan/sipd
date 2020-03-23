@extends('layouts.app')
@section('content')
    <div id="app">
        <dinasregular-index
            :kegiatan_data='{!! json_encode($kegiatan) !!}'
            :program_data='{!! json_encode($program) !!}'
            :belanja_data='{!! json_encode($belanja) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'
            :access='{!! json_encode($access) !!}'>
        </dinasregular-index>
    </div>
@stop