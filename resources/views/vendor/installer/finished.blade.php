@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.final.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.final.title') }}
@endsection

@section('container')

<div class="box box-primary borderless">
    <div class="skin-box-card">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">    
                    <div class="box-header">
                        <h3 class="box-title">Congratulations, you've successfully installed MailTidy App!</h3>
                    </div>                
                        You can login in the <a href="{{ url('/') }}">backend</a> and configure your new system.
                        <br /><br />

                        If you are having problems or suggestions, please visit <a href="https://www.Ommune.com" target="_blank">Ommune.com official website</a>.
                        <br /><br />
                        That's all, <br />
                        Thank you for choosing Ommune EMA.
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('installer/img/succes-2.gif') }}" width="150px">
                    <h2 class="col-12 text-success"><strong>Success !</strong></h2>
                </div>
                <div class="buttons">
			        <a href="{{ url('/') }}" class="button">{{ trans('installer_messages.final.exit') }}</a>
			    </div>

            </div>
            <div class="clearfix"><!-- --></div>      
        </div>
    </div>
</div>

    
@endsection
