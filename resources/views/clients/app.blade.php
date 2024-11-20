@include('clients.layouts.header')
@include('clients.layouts.side-bar')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>
@include('admin.layouts.footer')
