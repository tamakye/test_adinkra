<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{url('/')}}">
                <img class="logo" src="{{asset('images/logo-white.svg')}}" alt="">
            </a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg"><b class="h3">Admin</b>, login to your dashboard</p>

                <form action="{{ route('admin.login')}} " method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="username" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        {{-- <div class="col-6 text-right align-items-center d-flex">
                            <a class="ml-auto" href="#">I forgot my password</a>
                        </div> --}}
                        <div class="col-12 my-3">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>

</body>

</html>