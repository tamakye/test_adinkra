@extends('dashboard.layouts.app')
@section('title','Account details')

@section('accountActive','active bg-sand')

@section('homeContent')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>My address</h5>
    </div>
    <div class="card-body">
        <div class="max-w-xl">
            @include('dashboard.partials.update-profile-information-form')
        </div>

        <hr>
        <div class="mt-5">
            @include('dashboard.partials.update-password-form')
        </div>
        <hr>
        <div class="mt-5">
            @include('dashboard.partials.delete-user-form')
        </div>
    </div>
</div>

@endsection

@section('scripts')
@if($errors->userDeletion->get('password'))
<script>
    var myModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
        backdrop: true,
    });

    myModal.show();
</script>
@endif
@endsection