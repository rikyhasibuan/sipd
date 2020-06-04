@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasbopcustom-create
                :dinasbop='{{ json_encode($dinasbop) }}'
                :dinasbop_data='{{ json_encode($dinasbop_data) }}'
                :personil_data='{{ json_encode($personil) }}'
                :auditan_data='{{ json_encode($auditan) }}'
                :route='{{ json_encode($route) }}'
                :api='{{ json_encode($api) }}'>
            </dinasbopcustom-create>
        @else
            <dinasbopcustom-update
                :dinasbopcustom='{{ json_encode($dinasbopcustom) }}'
                :dinasbop='{{ json_encode($dinasbop) }}'
                :personil_data='{{ json_encode($personil) }}'
                :auditan_data='{{ json_encode($auditan) }}'
                :dinasbop_data='{{ json_encode($dinasbop_data) }}'
                :route='{{ json_encode($route) }}'
                :api='{{ json_encode($api) }}'>
            </dinasbopcustom-update>
        @endif
    </div>
@stop
