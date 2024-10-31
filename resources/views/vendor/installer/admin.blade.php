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
    <form method="post" action="{{ route('LaravelInstaller::saveAdmin') }}" class="tabs-wrap" >
      @csrf
      <div class="box box-primary borderless">
        <div class="row">
            <div class="col-md-12">
                <div class="skin-box-card">
                    <!-- section start -->
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('installer_messages.admin.title') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group {{ $errors->has('name') ? ' has-error ' : '' }}">
                                <label for="name">
                                    {{ trans('First name *') }}
                                </label>
                                <input type="text" name="name" id="name" class="form-control has-help-text" value="{{ old('name') }}" placeholder="{{ trans('installer_messages.purchase_code.buyer_name_placeholder') }}"  />
                                @if ($errors->has('name'))
                                    <span class="error-block">
                                        <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group {{ $errors->has('last_name') ? ' has-error ' : '' }}">
                                <label for="name">
                                    {{ trans('Last name *') }}
                                </label>
                                <input type="text" name="last_name" id="last_name" class="form-control has-help-text" value="{{ old('last_name') }}" placeholder="{{ trans('installer_messages.purchase_code.buyer_name_placeholder') }}"  />
                                @if ($errors->has('last_name'))
                                    <span class="error-block">
                                        <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                        {{ $errors->first('last_name') }}
                                    </span>
                                @endif
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group {{ $errors->has('email') ? ' has-error ' : '' }}">
                                <label for="email">
                                    {{ trans('Email *') }}
                                </label>
                                <input type="text" name="email" id="email"  value="{{ old('email') }}" placeholder="{{ trans('installer_messages.purchase_code.buyer_email_placeholder') }}"  />
                                @if ($errors->has('email'))
                                    <span class="error-block">
                                        <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group {{ $errors->has('password') ? ' has-error ' : '' }}">
                                <label for="password">
                                    {{ trans('Password *') }}
                                </label>
                                <input type="text" name="password" onchange="CheckPurchaseCode(this.value)" id="password" placeholder="{{ trans('password') }}"   />
                                @if ($errors->has('password'))
                                    <span class="error-block">
                                        <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                              </div>
                            </div>
                          </div>
                    </div>
                    <!-- section end -->
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-left">
               
            </div>
            <div class="pull-right mobile-center">
              <div class="buttons">
                <button class="btn btn-primary btn-flat" type="submit" id="submitbutton">
                  {{ trans('installer_messages.purchase_code.next') }}
                  <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                </button>
              </div>
            </div>
            <div class="clearfix"><!-- --></div>
        </div>
    </div>
    </form>
@endsection
