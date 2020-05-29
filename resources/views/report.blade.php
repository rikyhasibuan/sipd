@extends('layouts.app')
@section('content')
    <div id="app">
        <report :kegiatan_data='{!! json_encode($kegiatan) !!}' :belanja_data='{!! json_encode($belanja) !!}' :route='{!! json_encode($route) !!}' :api='{!! json_encode($api) !!}'></report>
    </div>
@stop
