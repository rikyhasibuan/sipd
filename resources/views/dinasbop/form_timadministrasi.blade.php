@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <dinasboptimadministrasi-create
                :administrasi='{!! json_encode($administrasi) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :auditan_data='{!! json_encode($auditan) !!}'
                :anggota='{!! json_encode($anggota) !!}'
                :ketua='{!! json_encode($ketua) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasboptimadministrasi-create>
        @else
            <dinasboptimadministrasi-update
                :dinasboptimadministrasi='{!! json_encode($dinasboptimadministrasi) !!}'
                :administrasi='{!! json_encode($administrasi) !!}'
                :dinasbop='{!! json_encode($dinasbop) !!}'
                :anggota='{!! json_encode($anggota) !!}'
                :ketua='{!! json_encode($ketua) !!}'
                :auditan_data='{!! json_encode($auditan) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </dinasboptimadministrasi-update>
        @endif
    </div>
@stop
