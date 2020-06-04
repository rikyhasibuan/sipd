@extends('layouts.app')
@section('content')
    <div id="app">
        <dinasbop-detail
            :dinasbop = '{{ json_encode($dinasbop) }}'
            :dinasboptim = '{{ json_encode($dinasboptim) }}'
            :dinasbopdriver = '{{ json_encode($dinasbopdriver) }}'
            :dinasbopinspektur = '{{ json_encode($dinasbopinspektur) }}'
            :dinasbopsekretaris = '{{ json_encode($dinasbopsekretaris) }}'
            :dinasbopreviu = '{{ json_encode($dinasbopreviu) }}'
            :dinasbopsupervisi = '{{ json_encode($dinasbopsupervisi) }}'
            :dinasboppengumpuldata = '{{ json_encode($dinasboppengumpuldata) }}'
            :dinasboptimpengumpuldata = '{{ json_encode($dinasboptimpengumpuldata) }}'
            :dinasbopadministrasi = '{{ json_encode($dinasbopadministrasi) }}'
            :dinasboptimadministrasi = '{{ json_encode($dinasboptimadministrasi) }}'
            :dinasbopcustom = '{{ json_encode($dinasbopcustom) }}'
            :dinasbopapproval = '{{ json_encode($dinasbopapproval) }}'
            :route = '{{ json_encode($route) }}'
            :lock = '{{ json_encode($lock) }}'
            :access = '{{ json_encode($access) }}'
            :api = '{{ json_encode($api) }}'>
        </dinasbop-detail>
    </div>
@stop
