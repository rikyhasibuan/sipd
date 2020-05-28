@extends('layouts.app')
@section('content')
    <div id="app">
        <log-index :api='{!! json_encode($api) !!}'></log-index>
    </div>
@stop