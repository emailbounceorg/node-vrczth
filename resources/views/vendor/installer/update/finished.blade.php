@extends('vendor.installer.layouts.master-update')

@section('title', trans('installer_messages.updater.final.title'))
@section('container')

 <div class="box box-primary borderless">
    <div class="skin-box-card">
        <div class="box-header">
		    <p class="paragraph text-center">{{ session('message')['message'] }}</p>
		    <div class="buttons">
		        <a href="{{ url('/') }}" class="button">{{ trans('installer_messages.updater.final.exit') }}</a>
		    </div>
		</div>
	</div>
</div>
@stop
