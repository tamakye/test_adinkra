@extends('front-end.layouts.app')

@section('title', 'Register for an account')

@section('content')
<div class="section login-page container-fluid p-60">
  <div class="container">
    <div class="row justify-content-center aligh-item-center">
      <div class="col-sm-7 mb-3">
        <div class="login-extra pt-5">
          <img src="{{ asset('images/maksim.png') }}" alt="Login image" class="w-100">
          {{-- <img src="https://svgshare.com/i/nDi.svg" alt=""> --}}
      </div>
  </div>
  <div class="col-sm-5 mb-3">
    <div class="login-form">
      <div class="page-heading">
        <h2>Register for an account</h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('First name')" />
            <x-text-input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name')" required autofocus />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <!-- Last Name -->
            <div class="mt-2">
                <x-input-label for="last_name" :value="__('Last name')" />
                <x-text-input id="last_name" class="form-control" type="text" name="last_name" :value="old('last_name')" required autofocus />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div class="mt-2">
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" class="form-control" type="tel" name="phone" :value="old('phone')" required />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-2">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="row">
                            <!-- Password -->
                            <div class="col-sm-6 mt-2">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="form-control"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-sm-6 mt-2">
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                    <x-text-input id="password_confirmation" class="form-control"
                                    type="password"
                                    name="password_confirmation" required />

                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center flex-column mt-2">
                                    <x-primary-button class="btn btn-primary bg-dark">
                                        {{ __('Register') }}
                                    </x-primary-button>
                                    <hr>
                                    <a class="underline text-sand text-sm text-center" href="{{ route('login') }}">
                                        {{ __('Already registered?') }}
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endsection