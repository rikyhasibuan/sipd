@extends('layouts.app')
@section('content')
<div id="app">
    <dinasregular-transportasi :dinasregular='{!! json_encode($dinasregular) !!}' :jenistransportasi='{!! json_encode($jenistransportasi) !!}' :route='{!! json_encode($route) !!}' :api='{!! json_encode($api) !!}'>
        </dinasregulartim-transportasi>
</div>
@stop