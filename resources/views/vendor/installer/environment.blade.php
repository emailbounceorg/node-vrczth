@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.menu.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-cog fa-fw" aria-hidden="true"></i>
    {!! trans('installer_messages.environment.menu.title') !!}
@endsection

@section('container')
 <div class="box box-primary borderless">
    <div class="skin-box-card">
        <div class="box-header">
            <h3 class="box-title">Permissions</h3>
        </div>
        <div class="box-body">

            <p class="text-center">
                {!! trans('installer_messages.environment.menu.desc') !!}
            </p>
        </div>
         <div class="box-footer">
            <div class="pull-right">  
                <a href="{{ route('LaravelInstaller::environmentWizard') }}" class="btn btn-primary btn-flat button-wizard">
                    <i class="fa fa-sliders fa-fw" aria-hidden="true"></i> {{ trans('installer_messages.environment.menu.wizard-button') }}
                </a>
               <!--  <a href="{{ route('LaravelInstaller::environmentClassic') }}" class="btn btn-primary btn-flat button-classic">
                    <i class="fa fa-code fa-fw" aria-hidden="true"></i> {{ trans('installer_messages.environment.menu.classic-button') }}
                </a>  -->
            </div>
            <div class="clearfix"><!-- --></div>        
        </div>     
    </div>
</div>

@endsection
