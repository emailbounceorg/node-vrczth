@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.welcome.templateTitle') }}
@endsection

@section('title')
    {{ trans('installer_messages.welcome.title') }}
@endsection

@section('container')
        <div class="box box-primary borderless">
                <div class="skin-box-card">
                    <div class="box-header">
                        <h3 class="box-title">Requirements</h3>
                    </div>
                    <div class="box-body">                      
                      <p class="text-center">
                        {{ trans('installer_messages.welcome.message') }}
                      </p>

                          <p class="text-center">
                            
                          </p>
                        </div>
                         <div class="box-footer">
                          <div class="pull-left">
                             
                          </div>
                          <div class="pull-right mobile-center">
                            <div class="buttons">
                             <a href="{{ route('LaravelInstaller::requirements') }}" class="btn btn-primary btn-flat">
                                {{ trans('installer_messages.welcome.next') }}
                                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                              </a>
                            </div>
                          </div>
                          <div class="clearfix"><!-- --></div>        
                      </div>
                      </div>
                    </div>

@endsection
