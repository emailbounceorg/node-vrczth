@section('title', 'Forgot Password')
@extends('layouts.app')
@section('content')
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mt-5 mb-5">
                        <center>
                            <a>
                                <img src="{{ getLogo()['logo'] }}" class="logoSize" alt="Logo" />
                            </a>
                        </center>
                    </div>
                    <h2>Forgot Password</h2>

                    <p>
                        Input your email and we will send you reset password link.
                    </p>

                    <span class="d-none d-lg-block saprator mt-5"></span>

                    <form id="FromID" method="POST" data-urlinsert="{{ route('SendLink') }}">
                        <div class="form-group position-relative has-icon-left mb-4 mt-5    ">
                            <input type="text" class="form-control form-control-xl"
                                placeholder="{{ trans('site.login.email') }}" name="email" />
                            <div class="form-control-icon">
                                <i class="bi bi-envelope ps-2"></i>
                            </div>
                            <span class="text-danger error-text email_error"></span>

                        </div>

                        @csrf
                        <center><span id="loginSuccess"></span></center>
                        <button type="button" id="ForgotPassword" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">
                            Forgot Password
                        </button>
                    </form>

                    <div class="text-center mt-5 text-lg fs-6">
                        <p class="text-gray-600">
                            {{ trans('site.registration.registration-info') }}
                            <a href="{{ route('login') }}"
                                class="font-bold">{{ trans('site.registration.registration-link') }}</a>
                        </p>

                        {{ trans('site.Version') }} {{ getLogo()['version'] }}
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right" class="login.bg"></div>
            </div>
        </div>
    </div>
    <style type="text/css">
        #auth #auth-right {
            background: url({{ asset('img/mailtidy_register_2.svg') }});
            background-size: contain, cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
@endsection
