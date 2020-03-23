@extends('layouts.app')
@section('content')
    <div id="app">
        <dashboard :api='{!! json_encode($api) !!}'></dashboard>
    </div>
@stop