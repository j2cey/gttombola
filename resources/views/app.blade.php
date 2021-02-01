@extends('layouts.core.app02')

@section('content')

    <!-- Navbar -->
    @include('layouts.admin02.nav.nav')
    <!-- /.navbar -->

    <div class="content-wrapper" style="min-height: 346px;">
        <div class="container">
            @yield('app_content')
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    @include('layouts.admin02.controlbar')
    <!-- /.control-sidebar -->

    <!-- Admin Footer -->
    @include('layouts.admin02.footer')

@endsection
