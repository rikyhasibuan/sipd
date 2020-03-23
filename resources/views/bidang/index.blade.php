@extends('admin.layouts.app')
@section('content')
    <div id="app">
        <bidang-index 
            :access='{!! json_encode($access) !!}' 
            :route='{!! json_encode($route) !!}' 
            :api='{!! json_encode($api) !!}'>
        </bidang-index>
    </div>
@stop