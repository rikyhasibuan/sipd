<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIPD | {!! $title !!}</title>
    <link href="{!! asset(mix('css/app.css')) !!}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed sidebar-collapse">
    <div class="wrapper">
        @include('layouts.topmenu')
        @include('layouts.sidebar')
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6"><h2>{!! $title !!}</h2></div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php
                                $total = count($breadcrumb);
                                $i = 1;
                                ?>
                                @foreach($breadcrumb as $key=>$val)
                                    @if ($i == $total)
                                        <li class="breadcrumb-item active"><span>{!! $val !!}</span></li>
                                    @else
                                        <li class="breadcrumb-item">{!! $val !!}</li>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        @include('layouts.footer')
    </div>
    <script src="{!! asset(mix('js/manifest.js')) !!}"></script>
    <script src="{!! asset(mix('js/vendor.js')) !!}"></script>
    <script src="{!! asset(mix('js/app.js')) !!}"></script>
    <script src="{!! asset(mix('js/adminlte.js')) !!}"></script>
</body>
</html>
