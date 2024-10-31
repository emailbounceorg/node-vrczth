@extends('vendor.installer.layouts.master')
@section('template_title')
    {{ trans('installer_messages.purchase_code.templateTitle') }}
@endsection
@section('title')
    {{ trans('installer_messages.purchase_code.title') }}
@endsection
@section('container')
    @if (\Session::has('msg'))
        <div class="alert alert-danger">
            <ul>
                <li>{!! \Session::get('msg') !!}</li>
            </ul>
        </div>
    @endif

    <div class="alert alert-danger alert-block msgStatus d-none" >
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
    <form method="post" action="{{ route('LaravelInstaller::verifyPurchaseCode') }}" class="tabs-wrap">
        @csrf
        <div class="box box-primary borderless">
            <div class="row">
                <div class="col-md-6">
                    <div class="skin-box-card">
                        <!-- section start -->
                        <div class="box-header">
                            <h3 class="box-title">Site Information</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('name') ? ' has-error ' : '' }}">
                                        <label for="name">
                                            {{ trans('installer_messages.purchase_code.buyer_name') }}
                                        </label>
                                        <input type="text" name="name" id="name"
                                            class="form-control has-help-text" value="{{ old('name') }}"
                                            placeholder="{{ trans('installer_messages.purchase_code.buyer_name_placeholder') }}" />
                                        @if ($errors->has('name'))
                                            <span class="error-block">
                                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('email') ? ' has-error ' : '' }}">
                                        <label for="email">
                                            {{ trans('installer_messages.purchase_code.buyer_email') }}
                                        </label>
                                        <input type="text" name="email" id="email" value="{{ old('email') }}"
                                            placeholder="{{ trans('installer_messages.purchase_code.buyer_email_placeholder') }}" />
                                        @if ($errors->has('email'))
                                            <span class="error-block">
                                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('purchase_code') ? ' has-error ' : '' }}">
                                        <label for="purchase_code">
                                            {{ trans('installer_messages.purchase_code.code') }}
                                        </label>
                                        <input type="text" name="purchase_code" id="purchase_code"
                                            placeholder="{{ trans('installer_messages.purchase_code.code') }}" />
                                        @if ($errors->has('purchase_code'))
                                            <span class="error-block">
                                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                {{ $errors->first('purchase_code') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- section end -->
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('installer/img/main-banner.png') }}" width="400" class="img-responsive">
                </div>
            </div>
            <div class="box-footer">
                <div class="pull-left">
                    <div class="form-group {{ $errors->has('terms_condition') ? ' has-error ' : '' }}">
                        I agree with the <a href="https://ommune.com/terms" target="_blank" data-original-title=""
                            title="">Terms and Conditions</a>.
                        <input name="terms_condition" type="checkbox" value="1">
                        <br>
                        @if ($errors->has('terms_condition'))
                            <span class="error-block">
                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ $errors->first('terms_condition') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="pull-right mobile-center">
                    <div class="buttons">
                        <button class="btn btn-primary btn-flat verify-install" type="submit" id="submitbutton">
                            {{ trans('installer_messages.purchase_code.next') }}
                            <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="clearfix">
                    <!-- -->
                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script>
        "use strict";
        document.addEventListener('DOMContentLoaded', function() {
            // Get the purchase_code input element
            var purchaseCodeInput = document.getElementById('purchase_code');
            // Add an onchange event listener to the purchase_code input
            purchaseCodeInput.addEventListener('change', function() {
                var inputValue = purchaseCodeInput.value;
                CheckPurchaseCode(inputValue);
            });
        });

        function CheckPurchaseCode(val) {
            $.ajax({
                type: "POST",
                url: "{{ route('purchasecodeverify') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    purchaseCode: val
                },
                success: function(response) {
                    if (response != '') {
                        // console.log(response);
                        //$('#msgStatus').show();
                        $('.msgStatus').removeClass('d-none');
                        $('.msgStatus').text(response);
                        $('#submitbutton').attr('disabled', "disabled")
                    } else {
                        //$('#msgStatus').hide();
                        $('.msgStatus').addClass('d-none');
                        $('#submitbutton').removeAttr('disabled');
                    }
                }
            });
        }
    </script>
@endsection
