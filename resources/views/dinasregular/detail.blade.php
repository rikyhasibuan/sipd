@extends('layouts.app')
@section('content')
    <div id="app">
        <dinasregular-detail
            :dinasregular='{{ json_encode($dinasregular) }}'
            :dinasregularapproval='{{ json_encode($dinasregularapproval) }}'
            :jenis_transportasi='{{ json_encode($jenistransportasi) }}'
            :takaran_liter='{{ json_encode($takaranliter) }}'
            :route='{{ json_encode($route) }}'
            :access='{{ json_encode($access) }}'
            :api='{{ json_encode($api) }}'>
        </dinasregular-detail>
    </div>
@stop
