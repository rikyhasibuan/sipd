@extends('layouts.app')
@section('content')
    <div id="app">
        <dashboard 
        :api='{!! json_encode($api) !!}'
        :tahun_data='{!! json_encode($tahun) !!}'
        :bulan_data='{!! json_encode($bulan) !!}'>
        </dashboard>
    </div>
@stop