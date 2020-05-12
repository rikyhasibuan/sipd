@extends('layouts.app')
@section('content')
    <div id="app">
        <dinasbop-detail 
            :dinasbop='{{ json_encode($dinasbop) }}'
            :dinasboptim='{{ json_encode($dinasboptim) }}'
            :dinasbopdriver='{{ json_encode($dinasbopdriver) }}'
            :dinasbopinspektur='{{ json_encode($dinasbopinspektur) }}'
            :dinasbopsekretaris='{{ json_encode($dinasbopsekretaris) }}'
            :route='{{ json_encode($route) }}'
            :api='{{ json_encode($api) }}'>
        </dinasbop-detail>
    </div>
@stop