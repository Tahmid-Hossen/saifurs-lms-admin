<!DOCTYPE html>
<html>
<head>
    @include('backend.layouts.partials.head')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <div class="loader"></div>
    <header class="main-header">
        @include('backend.layouts.partials.header')
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        @include('backend.layouts.partials.sidebar')
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @include('backend.layouts.partials.content-header')
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        @include('backend.layouts.partials.footer')
    </footer>

{{--    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        @include('backend.layouts.partials.control-sidebar')
    </aside>--}}
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
@include('backend.layouts.partials.page-footer')
</body>
</html>

