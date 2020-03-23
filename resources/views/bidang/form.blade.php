@extends('admin.layouts.app')
@section('content')
    <div id="app">
        @if($act == 'edit')
            <bidang-update 
                :bidang='{!! json_encode($bidang) !!}'
                :route='{!! json_encode($route) !!}'
                :api='{!! json_encode($api) !!}'>
            </bidang-update>
        @elseif ($act == 'create')
            <bidang-create
                :api='{!! json_encode($api) !!}'
                :route='{!! json_encode($route) !!}'>
            </bidang-create>
        @endif
    </div>
@stop