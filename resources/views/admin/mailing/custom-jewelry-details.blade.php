@extends('admin.layouts.app')
@section('title', 'Custom Jewelry | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('mailing_menu_open','menu-open')
@section('custom_active','active')


@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/ekko-lightbox/ekko.min.css') }}">
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Custom jewelry </h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $customjewelry->full_name }} </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p>First name: <span class="text-muted">{{ $customjewelry->first_name }} </span></p>
                                <p>Last name: <span class="text-muted">{{ $customjewelry->last_name }} </span></p>
                                <p>Phone: <span class="text-muted">{{ $customjewelry->phone }} </span></p>
                                <p>Country: <span class="text-muted">{{ $customjewelry->countries->name }} </span></p>
                            </div>
                            <div class="col-md-6">
                                <p>Appointment: <br>
                                    @empty($customjewelry->appointment)
                                    <span class="text-muted">No appointment booked</span>
                                    @else
                                    <span class="text-muted">Booked for {{ $customjewelry->appointment->format('d-m-y H:i') }} </span>
                                    @endif
                                </p>
                                <p>Other details: <br>
                                    @empty($customjewelry->other_details)
                                    <span class="text-muted">-</span>
                                    @else
                                    <span class="text-muted"> {{ $customjewelry->other_details}} </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <hr>
                        <h5>Uploaded images:</h5><br>
                        <div class="row justify-content-center">
                            @empty($customjewelry->images))
                            <div class="col-md-6">
                                <h5 class="text-muted">No images attached</h5>
                            </div>
                            @else
                            @foreach(json_decode($customjewelry->images) as $image)
                            <div class="col-sm-3">
                                <a href="{{ asset(get_custom_jewelry_photo($image)) }}" data-toggle="lightbox" data-title="Image {{ $loop->index + 1 }}" data-gallery="gallery">
                                    <img src="{{ asset(get_custom_jewelry_photo($image)) }}" class="img-fluid mb-2" alt="Image {{ $loop->index + 1 }}">
                                </a>
                            </div>
                            @endforeach
                            
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/ekko-lightbox/ekko.min.js') }}"></script>
<script>
 $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
    });
  });
})
</script>
@endsection