@extends('front-end.layouts.app')

@section('title', 'Forgotten Password')

@section('content')
<div class="section login-page container-fluid p-60">
    <div class="container">
        <div class="row justify-content-center aligh-item-center">
          <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted">Enter a new password to reset your account.</h5>
                    <hr>
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="form-control mt-1" type="email" name="email" :value="old('email', $request->email)" readonly required autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="mt-4">
                                    <x-input-label for="password" :value="__('Password')" />
                                    <x-text-input id="password" class="form-control mt-1" type="password" name="password" required />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mt-4">
                                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                        <x-text-input id="password_confirmation" class="form-control mt-1"
                                        type="password"
                                        name="password_confirmation" required />

                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                        </div>

                                        <div class="flex items-center justify-end mt-4">
                                            <x-primary-button>
                                                {{ __('Reset Password') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endsection