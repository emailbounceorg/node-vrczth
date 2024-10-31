<x-main-dashboard>
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ trans('site.pricingDetails.title') }}</h3>
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

            <div class="container-fluid mt-85">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row" data-default_credit_rate="{{ $arraySettings['default_credit_rate'] ?? '' }}">
                                @foreach ($ArPricing as $val)
                                    <div class="col-lg-4 widthauto">
                                        <div class="card shadow-sm myDiv" data-name="{{ $val->name }}"
                                            data-credit="{{ $val->credit }}" data-price="{{ $val->price }}" >
                                            <div class="card-body pricing-card-body">
                                                <div class="price-div-main">
                                                    <div class="row">
                                                        <i class="bi bi-envelope-check fs-2"
                                                        style="color: var(--color)"></i>
                                                    </div>
                                                    <div class="row price-row">
                                                        <span class="creditPoint">
                                                            {{ $val->credit }} {{ trans('site.pricingDetails.credit') }}
                                                            <i class="bi bi-info-circle" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                data-bs-original-title="{{ trans('site.settings.tooltip') }}">
                                                            </i>
                                                        </span>
                                                        <span class="text-price">$ {{ $val->price }} USD</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <p class="fw-bold"><i class="bi bi-asterisk"></i> {{ trans('site.pricingDetails.credit-footer-title') }}</p>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p class="fw-bold">Note: Pay as you go rate is ${{ $arraySettings['default_credit_rate'] ?? '0' }} USD per credit.</p>
                                    </div>
                                    <div class="col-lg-6 text-end mb-3">
                                        <a href="mailto:{{ $arraySettings['helpEmail'] ?? '' }}"
                                            class="btn btn-white border shadow-sm rounded text-white p-1 px-2">
                                       {{ trans('site.pricingDetails.need-help') }}     <i class="bi bi-question-circle-fill text-white fs-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <center><span class="title-price-card">{{ trans('site.pricingDetails.payTitle') }}</span></center>
                                    <center><span class="title-price-second">{{ trans('site.pricingDetails.enter-your-credits') }}</span></center>
                                    <center> <input type="number"
                                            class="priceInput">
                                    </center>

                                    <h5 class="text-center mt-5">{{ trans('site.pricingDetails.total-cost') }}</h5>
                                    <center>
                                        <span class="payType">$</span>
                                        <span class="priceShow"></span>
                                        <span class="priceShowType"> USD</span>
                                    </center>
                                    <center>
                                        <button class="btn icon btn-primary p-2 px-4" id="PayMethod" data-bs-toggle="modal"
                                            data-bs-target="#pay"> &nbsp;
                                            {{ trans('site.pricingDetails.pay-now-button') }} <i class="bi bi-arrow-up-circle-fill fs-5 ps-2"></i>
                                        </button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--BorderLess Modal Modal -->
    <div class="modal fade text-left modal-borderless" data-bs-backdrop="static" id="pay" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('site.pricingDetails.payModal.payment-method') }}</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FromID" data-urlInsert="{{ route('PricingCreateUpdate') }}">
                        <div class="row mt-3">
                            <input type="hidden" id="APP_NAME" value="{{ env('APP_NAME') }}">
                            <input type="hidden" id="email" value="{{ auth()->user()->email }}">
                            <input type="hidden" id="logo" value="{{ asset('img/icon.png') }}">

                            <center>
                                <h2>{{ trans('site.pricingDetails.payModal.Congratulations') }}!</h2>
                            </center>
                            <span class="text-center mb-3">{{ trans('site.pricingDetails.payModal.We-are') }}</span>
                            <center>
                                <span class="showdarkprice showpriceinlinedollar">$</span>
                                <span class="showdarkprice showpriceinlinePrice" id="popPrice"></span>
                                <span>(USD)</span>
                            </center>

                            <center>
                                <span class="font-20" id="popCredit"></span>
                                <span class="font-20">{{ trans('site.pricingDetails.payModal.credits') }}</span>
                            </center>

                            @if ($arraySettings['razorpay_on_off'] == 'on')
                                <input type="hidden" id="rzpKEY"
                                    value="{{ $arraySettings['razorpay_key'] ?? '' }}">
                                <div class="col-md-12 mb-2 mt-3">
                                    <center>
                                        <div class="method-pay razorpay">
                                            {{ trans('site.pricingDetails.payModal.checkout-with') }}
                                            <img src="{{ asset('img/pay.png') }}" alt="">
                                        </div>
                                    </center>
                                </div>
                                @if ($arraySettings['stripe_on_off'] == 'on')
                                    <center>
                                        <h6> {{ trans('site.pricingDetails.payModal.or') }}</h6>
                                    </center>
                                @endif
                            @endif

                            @if ($arraySettings['stripe_on_off'] == 'on')
                                <div class="col-md-12 mb-2">
                                    <center>
                                        <div class="method-pay stripepay">
                                            {{ trans('site.pricingDetails.payModal.checkout-with') }}
                                            <img src="{{ asset('img/stripe.png') }}" alt="">
                                        </div>
                                    </center>
                                </div>
                                @if ($arraySettings['paypal_on_off'] == 'on')
                                    <center>
                                        <h6>{{ trans('site.pricingDetails.payModal.or') }}</h6>
                                    </center>
                                @endif
                            @endif

                            @if ($arraySettings['paypal_on_off'] == 'on')
                                <div class="col-md-12">
                                    <center>
                                        <div class="method-pay paypalpay">
                                            {{ trans('site.pricingDetails.payModal.checkout-with') }}
                                            <img src="{{ asset('img/paypal.png') }}" alt="">
                                        </div>
                                    </center>
                                </div>
                            @endif

                            <center><img src="{{ asset('img/PaymentMode.png') }}" class="img-fluid mt-5"
                                    height="40px">
                            </center>

                            @csrf

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-main-dashboard>
