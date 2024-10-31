@section('title', 'Register')
@extends('layouts.app')
@section('content')
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-5">
                        <center>
                            <img src="{{ getLogo()['logo'] }}" class="logoSize" alt="Logo" />
                        </center>
                    </div>
                    <span class="d-none d-lg-block saprator"></span>
                    <h1>{{ trans('site.registration.title') }}</h1>
                    <form id="FromID" data-urlinsert="{{ route('register.custom') }}">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl"
                                placeholder="{{ trans('site.registration.name') }}" name="name" />
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <span class="text-danger error-text name_error"></span>

                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl"
                                placeholder="{{ trans('site.registration.email') }}" name="email" />
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <span class="text-danger error-text email_error"></span>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" id="password"
                                placeholder="{{ trans('site.registration.password') }}" name="password" />
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <span class="text-danger error-text password_error"></span>
                            <div class="row px-3 mt-2">
                                <div class="col-12 pe-0 form-check form-switch mt-2">
                                    <input class="form-check-input me-2" type="checkbox" id="show-password">
                                    <span id="passmsg">{{ trans('site.login.show-password') }}</span>
                                </div>
                                <span class="text-danger error-text password_error"></span>

                                <div class="col-12 form-check form-check-lg d-flex flex-nowrap align-items-center">
                                    <input class="form-check-input termscondition me-2" type="checkbox"
                                        name="terms_and_conditions_privacy_policy" id="flexCheckDefault">
                                    <label class="form-check-label fs-7 text-gray-600" for="flexCheckDefault">
                                        I agree to {{ env('APP_NAME') }} <a href="javascript:vad(0)" data-bs-toggle="modal"
                                            class="TermsPrivacy" data-bs-target="#TermsPrivacy" data-name="terms"
                                            data-urlinsert="{{ route('TermsAndConditionsGet') }}">Terms &
                                            Conditions</a> and <a href="javascript:vad(0)" class="TermsPrivacy"
                                            data-bs-toggle="modal" data-bs-target="#TermsPrivacy" data-name="privacy"
                                            data-urlinsert="{{ route('TermsAndConditionsGet') }}">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                            <span class="text-danger error-text terms_and_conditions_privacy_policy_error"></span>
                        </div>
                        @csrf
                        <button type="button" id="register" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                            {{ trans('site.registration.registration-button') }}
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
            <div class="col-lg-7 my-auto">
                <div class="row col-lg-5 mx-auto">
                    <h5 class="validation-heading mb-4">Give it a shot. Validate an email address!
                    </h5>
                    <form id="FromIDs" data-urlinsert="{{ route('VerifyEmailAddress') }}">
                        <center>
                            <input type="email" name="CheckEmail"
                                class="form-control form-control-xl email-verification-demo shadow-sm mb-2">
                            <span class="fs-6 text-de" id="msgCheckMail"></span>
                        </center>
                        <center>
                            <button type="submit" id="VerifyEmail"
                                class="btn btn-primary btn-block btn-lg shadow-lg mt-3 w-fc mx-auto mb-5">Validate
                            </button>
                        </center>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('auth.terms-and-conditions-privacy-modal')
@endsection
