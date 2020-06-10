@extends('layouts.app')
@section('content')
    <div id="app">
        <pokja-index 
            :access='{!! json_encode($access) !!}'
            :api='{!! json_encode($api) !!}' 
            :irban_data='{!! json_encode($irban) !!}'
            :route='{!! json_encode($route) !!}'>
        </pokja-index>
    </div>
@stop