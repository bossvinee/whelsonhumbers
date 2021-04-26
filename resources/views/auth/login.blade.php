<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="{{ asset('as_login/css/style.css') }}">

</head>

<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
						<div class="icon d-flex align-items-center justify-content-center">
							<span class="fa fa-user-o"></span>
						</div>

						<form action="{{ route('login') }}" method="POST" class="login-form">
                            @csrf
							<div class="form-group">
								<input id="email" type="email" class="form-control rounded-left @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="form-group d-flex">
								<input type="password" class="form-control rounded-left @error('password') is-invalid @enderror" placeholder="Password" name="password" id="password" autocomplete="current-password"
									required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							<div class="form-group d-md-flex">
								<div class="w-50">
									<label class="checkbox-wrap checkbox-primary">Remember Me
										<input type="checkbox" checked name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
										<span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                    @endif

								</div>
							</div>
							<div class="form-group d-flex">
								<button type="submit" class="btn btn-primary btn-block ">{{ __('Login') }}</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="{{ asset('as_login/js/jquery.min.js') }}"></script>
	<script src="{{ asset('as_login/js/popper.js') }}"></script>
	<script src="{{ asset('as_login/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('as_login/js/main.js') }}"></script>

</body>

</html>
