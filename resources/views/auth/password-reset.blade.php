@section('title', $title)
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
                    <h2>{{$title}} </h2>

                    <span class="d-none d-lg-block saprator mt-5"></span>

                    <form id="FromID" method="POST" data-urlinsert="{{ route('passwordResetSave') }}">
                        <div class="form-group position-relative has-icon-left mb-4 mt-5">
                            <input type="hidden" name="id" value="{{ $id }}">

                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" class="form-control form-control-xl" id="NewPassword"
                                    placeholder="Password" name="NewPassword" />
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock ps-2"></i>
                                </div>
                                <span class="text-danger error-text NewPassword_error"></span>
                            </div>

                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" class="form-control form-control-xl" id="password"
                                    placeholder="Confirm Password" name="password" />
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock ps-2"></i>
                                </div>
                                <span class="text-danger error-text password_error"></span>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="show-password">
                                    <span id="passmsg">{{ trans('site.login.show-password') }}</span>
                                </div>
                            </div>

                        </div>

                        @csrf
                        <center><span id="loginSuccess"></span></center>
                        <button type="button" id="UpdatePassword" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">
                            {{$title}}
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
