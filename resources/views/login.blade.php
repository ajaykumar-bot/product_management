@extends('app', ['title' => 'Login'])

@section('content')
    
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mt-3" id="loginMessage"></div>
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                
                <div class="card-body">

                    <form id="loginForm">
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" required autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    
    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '/api/login',
                method: 'POST',
                data: {
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                success: function(response) {
                    localStorage.setItem('token', response._token);
                    
                    $('#loginMessage').html(`<div class="alert alert-success">Login successful. Redirecting...</div>`);
                    setTimeout(() => window.location.href = '/products', 1000);
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Something Went Wrong.';
                    $('#loginMessage').html(`<div class="alert alert-danger">${msg}</div>`);
                }
            });
        });
    </script>
@endsection

