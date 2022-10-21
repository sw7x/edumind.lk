
@include('admin-panel.includes.header')
@include('admin-panel.includes.side-nav')

<div id="page-wrapper" class="gray-bg">
    @include('admin-panel.includes.top-nav')


    <!-- page heading -->
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $title ?? 'Default Title' }}</h2>
			{!!(\App\Utils\Breadcrumb::createBreadcrumb())!!}
        </div>
    </div>

    <div class="wrapper wrapper-content  animated fadeInRight">
        @yield('content')
        <!-- content -->
    </div>

@include('admin-panel.includes.footer')
