@extends('front-end.layouts.app')

@section('title', 'Email verification')

@section('content')
<div class="section container-fluid p-60">
  <div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center aligh-item-center">

               <div class="mb-4 text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-weight-normal text-success">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
            @endif

            <div class="mt-4 d-flex justify-content-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <x-primary-button>
                            {{ __('Resend Verification Email') }}
                        </x-primary-button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-lock"></i> {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection