<!DOCTYPE html>
<html lang="en">
@include('admin.body.head')
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include('admin.body.sidebar')
</div>
<div class="content-wrapper">
    <div class="page-content-wrapper">
        @yield('dashboard')
    </div>
</div>


@include('admin.body.footer')
@yield('scripts')
</body>
</html>

