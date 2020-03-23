@extends('layouts.app')
@section('content')
    <div id="app">
        <perangkatdaerah-index 
        	:access='{!! json_encode($access) !!}'
        	:route='{!! json_encode($route) !!}'
        	:api='{!! json_encode($api) !!}'>
       	</perangkatdaerah-index>
    </div>
@stop