@extends('layouts.app')
@section('content')
    <div id="app">
        @if ($act == 'create')
            <anggaran-create 
                :program_data='{!! json_encode($program) !!}'
                :kegiatan_data='{!! json_encode($kegiatan) !!}'
                :belanja_data='{!! json_encode($belanja) !!}'
                :tahun_data='{!! json_encode($tahun) !!}'
                :bulan_data='{!! json_encode($bulan) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </anggaran-create>
        @else 
            <anggaran-update 
                :anggaran='{!! json_encode($anggaran) !!}'
                :program_data='{!! json_encode($program) !!}'
                :kegiatan_data='{!! json_encode($kegiatan) !!}'
                :belanja_data='{!! json_encode($belanja) !!}'
                :tahun_data='{!! json_encode($tahun) !!}'
                :bulan_data='{!! json_encode($bulan) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </anggaran-update>
        @endif
    </div>
@stop