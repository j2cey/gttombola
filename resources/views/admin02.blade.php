@extends('layouts.core.app02')

@section('content')

    <!-- Navbar -->
    @include('layouts.admin02.nav.nav')
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    @include('layouts.admin02.content')
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    @include('layouts.admin02.controlbar')
    <!-- /.control-sidebar -->

    <!-- Admin Footer -->
    @include('layouts.admin02.footer')

@endsection
