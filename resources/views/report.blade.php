@extends('layouts.app')
@section('content')
    <div id="app">
        <report
            :bendahara_data='{!! json_encode($bendahara) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'>
        </report>
    </div>
@stop
