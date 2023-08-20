@extends('front-end.layouts.app')

@section('title', 'Login')

@section('content')
<div class="section login-page container-fluid p-60">
  <div class="container">
    <div class="row justify-content-center aligh-item-center">
      <div class="col-sm-8 mb-3">
        <div class="login-extra">
          <img src="{{ asset('images/fire_ring.png') }}" alt="Login image" class="w-100">
          {{-- <img src="https://svgshare.com/i/nDi.svg" alt=""> --}}
        </div>
      </div>
      <div class="col-sm-4 mb-3">
        <div class="login-form">
          <div class="page-heading">
            <h2>Login into your account</h2>
          </div>

          <!-- Session Status -->
          <x-auth-session-status class="mb-4" :status="session('status')" />

          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="login-form-items">
              <div class="items">
                <label for="email">Email Address</label>
                <div class="input">
                  <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
                  <i class="fas fa-envelope"></i>
                </div>
                @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
              <div class="items">
                <label for="">Password</label>
                <div class="input">
                  <input type="password" name="password" class="form-control">
                  <i class="fas fa-lock"></i>
                </div>
              </div>
              <div class="forgot-password d-flex justify-content-between mt-3" required>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="remember" @checked(old('remember')) style="margin-top: 7px;">
                  <label class="form-check-label" for="flexCheckDefault">
                   Remember me
                 </label>
               </div>

               <a href="{{ route('password.request') }}">Forgot Password?</a>
             </div>
             <div class="form-signin">
              <button type="submit" class="btn">Login Now</button>
            </div>
            <div class="or-option">
              <p>or</p>
            </div>
            <div class="form-signup">
              <a href="{{ route('register') }}" class="btn">Signup Now</a>
            </div>
          </div>
        </form>

         {{--  <div class="">
            <img src="{{ asset('images/golden_head.png') }}" alt="Login image" class="w-100 h-100">
          </div> --}}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection