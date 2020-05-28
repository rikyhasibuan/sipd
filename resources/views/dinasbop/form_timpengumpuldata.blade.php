@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasboptimpengumpuldata-create
                :dinasboppengumpuldata='{!! json_encode($dinasboppengumpuldata) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :auditan_data='{!! json_encode($auditan) !!}'
                :anggota='{!! json_encode($anggota) !!}'
                :ketua='{!! json_encode($ketua) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasboptimpengumpuldata-create>
        @else
            <dinasboptimpengumpuldata-update
                :dinasboptimpengumpuldata='{!! json_encode($dinasboptimpengumpuldata) !!}'
                :dinasboppengumpuldata='{!! json_encode($pengumpuldata) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :anggota='{!! json_encode($anggota) !!}'
                :ketua='{!! json_encode($ketua) !!}'
                :auditan_data='{!! json_encode($auditan) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasboptimpengumpuldata-update>
        @endif
    </div>
@stop
