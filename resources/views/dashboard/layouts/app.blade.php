@extends('front-end.layouts.app')

@section('content')
<section id="dashbord" class="bg-sand p-5">
    <div class="container">
        <div class="row position-relative">
            <div class="col-2 col-md-3 nav-col">
                @include('dashboard.layouts.sidenav')
            </div>
            <div class="col-10 col-md-9 mt-4 mt-md-0 main-content">
                @yield('homeContent')
            </div>
        </div>
    </div>
</div>
</section>
@endsection