<x-main-dashboard>
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ trans('site.settings.title') }}</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">{{ pageTitle()[1] }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ pageTitle()[2] }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form id="FromID" data-urlInsert="{{ route('CreateUpdate') }}"
                                enctype="multipart/form-data">
                                <div class="row mt-5">
                                    <input type="hidden" name="id" value="{{ $arraySettings['id'] ?? '' }}">

                                    <div class="col-md-2">
                                        <h5>TimeZone</h5>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <select class="form-control" name="timezones">
                                            <option value="">--Select--</option>
                                            @php
                                                $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                                            @endphp
                                            @foreach ($timezones as $val)
                                                <option {{ $val == $arraySettings['timezones'] ? 'selected' : '' }}>
                                                    {{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- end  --}}

                                    <div class="col-md-12">
                                        <h5>Razorpay</h5>
                                        <div class="form-check form-switch">
                                            <label>{{ trans('site.settings.Razorpay-e-d') }}</label>
                                            <input class="form-check-input" type="checkbox" name="razorpay_on_off"
                                                {{ $arraySettings['razorpay_on_off'] == 'on' ? 'checked' : '' }}>
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <label
                                            for="first-name-horizontal">{{ trans('site.settings.Razorpay-key') }}</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="razorpay_key"
                                            value="{{ $arraySettings['razorpay_key'] ?? '' }}" placeholder="">
                                    </div>


                                    <div class="col-md-2">
                                        <label
                                            for="first-name-horizontal">{{ trans('site.settings.Razorpay-secret') }}</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="razorpay_secret"
                                            value="{{ $arraySettings['razorpay_secret'] ?? '' }}" placeholder="">
                                    </div>


                                    {{-- Stripe --}}

                                    <div class="col-md-12 mt-5">
                                        <h5>Stripe</h5>
                                        <label>{{ trans('site.settings.Stripe-e-d') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="stripe_on_off"
                                                {{ $arraySettings['stripe_on_off'] == 'on' ? 'checked' : '' }}>
                                        </div>
                                    </div>



                                    <div class="col-md-2">
                                        <label
                                            for="first-name-horizontal">{{ trans('site.settings.Stripe-client') }}</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="stripe_client_id"
                                            value="{{ $arraySettings['stripe_client_id'] ?? '' }}" placeholder="">
                                    </div>


                                    <div class="col-md-2">
                                        <label
                                            for="first-name-horizontal">{{ trans('site.settings.Stripe-secret') }}</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="stripe_client_secret"
                                            value="{{ $arraySettings['stripe_client_secret'] ?? '' }}" placeholder="">
                                    </div>



                                    {{-- Paypal --}}

                                    <div class="col-md-3 mt-5">
                                        <h5>Paypal</h5>
                                        <label>{{ trans('site.settings.paypal-e-d') }}</label>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="paypal_on_off"
                                                {{ $arraySettings['paypal_on_off'] == 'on' ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    <div class="col-md-9 mb-3 mt-5">
                                        <div class="form-check">
                                            <label class="cslabel">Live</label>
                                            <input class="csradio" type="radio" name="paypal_type" value="live"
                                                {{ $arraySettings['paypal_type'] == 'live' ? 'checked' : '' }}>
                                            <label class="cslabel">Sandbox</label>
                                            <input class="csradio" type="radio" name="paypal_type" value="sandbox"
                                                {{ $arraySettings['paypal_type'] == 'sandbox' ? 'checked' : '' }}>
                                        </div>
                                        <br />
                                    </div>

                                    <div class="col-md-2">
                                        <label
                                            for="first-name-horizontal">{{ trans('site.settings.paypal-client') }}</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="paypal_client_id"
                                            value="{{ $arraySettings['paypal_client_id'] ?? '' }}" placeholder="">
                                    </div>


                                    <div class="col-md-2">
                                        <label
                                            for="first-name-horizontal">{{ trans('site.settings.paypal-secret') }}</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="paypal_client_secret"
                                            value="{{ $arraySettings['paypal_client_secret'] ?? '' }}"
                                            placeholder="">
                                    </div>

                                    {{-- google --}}

                                    <div class="col-md-12 mt-5">
                                        <h5>Google API KEY</h5>
                                        <label>{{ trans('site.settings.Stripe-e-d') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="google_on_off"
                                                {{ $arraySettings['google_on_off'] ?? '' == 'on' ? 'checked' : '' }}>
                                        </div>
                                    </div>



                                    <div class="col-md-2">
                                        <label
                                            for="first-name-horizontal">{{ trans('site.settings.Stripe-client') }}</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="google_client_id"
                                            value="{{ $arraySettings['google_client_id'] ?? '' }}" placeholder="">
                                    </div>

                                    <div class="col-md-2">
                                        <label
                                            for="first-name-horizontal">{{ trans('site.settings.Stripe-client') }}</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="google_secret"
                                            value="{{ $arraySettings['google_secret'] ?? '' }}" placeholder="">
                                    </div>

                                    <div class="col-md-2"><label for="first-name-horizontal">Redirect URL</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="google_redirect"
                                            value="{{ route('google.callback') }}" placeholder="">
                                    </div>

                                    <div class="col-md-2 mt-5 mb-3">
                                        <label for="first-name-horizontal">Support Email</label>
                                    </div>
                                    <div class="col-md-10 form-group mt-5 mb-4">
                                        <input type="text" class="form-control" name="helpEmail"
                                            value="{{ $arraySettings['helpEmail'] ?? '' }}" placeholder="">
                                    </div>

                                    <div class="col-md-2">
                                        <h5 class="mb-4">Email Used For Handshake
                                            <span class="badge bg-default-theme notehelp lh-sm mt-1"
                                                data-bs-toggle="modal" data-bs-target="#note">Note <i
                                                    class="bi bi-asterisk"></i></span>
                                        </h5>

                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="emailCleaner"
                                            value="{{ $arraySettings['emailCleaner'] ?? '' }}" placeholder="">
                                    </div>
                                    {{--  --}}
                                    <div class="col-md-2">
                                        <h5 class="mb-5">Pay as you go credit rate $ (USD)
                                        </h5>

                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="number" class="form-control" name="default_credit_rate"
                                            value="{{ $arraySettings['default_credit_rate'] ?? '' }}" placeholder="">
                                    </div>
                                    {{--  --}}
                                    @include('dashboard.email-cleaner-modal')
                                </div>

                                <div class="row">

                                    <div class="col-md-2">
                                        <h5 for="first-name-horizontal">{{ trans('site.settings.free-email-credit') }}
                                            <i class="bi bi-info-circle" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-original-title="{{ trans('site.settings.tooltip') }}"></i>
                                        </h5>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="freeMail"
                                            value="{{ $arraySettings['freeMail'] ?? '' }}" placeholder="100">
                                    </div>


                                    <h5 class="col-md-2 mb-5 mt-4">Main Color</h5>
                                    <div class="col-md-3 form-group mt-4">
                                        <input type="color" name="themes_color"
                                            value="{{ $arraySettings['themes_color'] ?? '' }}"
                                            class="form-control color-input colorSet">
                                    </div>

                                    <div class="col-md-3 form-group mt-4">
                                        <button type="button" class="btn btn-primary btn-sm theme-reset-color">
                                            <i class="bi bi-arrow-counterclockwise fs-4 text-white "></i>
                                        </button>
                                    </div>


                                    <h5 class="mb-5">{{ trans('site.settings.logo') }}</h5>

                                    <div class="col-md-4 col-12">
                                        <img src="{{ asset('img/logo/') . '/' . $arraySettings['favicon'] }}"
                                            height="100" alt="">
                                    </div>

                                    <div class="col-md-8 col-12">
                                        <div class="fv-row mb-4 col-md-12 fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="required fw-semibold mb-2"
                                                id="price">{{ trans('site.settings.Favicon') }}</label>
                                            <input type="file" name="favicon" id="favicon"
                                                class="form-control mb-lg-0" accept=".png" />
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                            <!--end::Input-->
                                            <input type="hidden" name="faviconOLD"
                                                value="{{ $arraySettings['favicon'] }}">
                                        </div>

                                    </div>

                                    <div class="col-md-4 col-12">
                                        <img src="{{ asset('img/logo/') . '/' . $arraySettings['logo'] }}"
                                            height="100%" width="100%" alt="">
                                    </div>

                                    <div class="col-md-8 col-12">

                                        <div class="fv-row mb-4 col-md-12 fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="required fw-semibold mb-2"
                                                id="price">{{ trans('site.settings.logo') }}</label>
                                            <input type="file" name="logo" id="logo"
                                                class="form-control mb-lg-0" accept=".png" />
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                            <!--end::Input-->
                                            <input type="hidden" name="logoOLD"
                                                value="{{ $arraySettings['logo'] }}">
                                        </div>
                                    </div>

                                    @csrf
                                    <div class="col-sm-12 mt-3 d-flex justify-content-end">
                                        <button type="button" id="CreateUpdate" class="btn btn-primary me-1 mb-1">
                                            {{ trans('site.settings.submit') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-main-dashboard>
