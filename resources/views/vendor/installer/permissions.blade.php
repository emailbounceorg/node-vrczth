@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.permissions.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-key fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.permissions.title') }}
@endsection

@section('container')
 <div class="box box-primary borderless">
                <div class="skin-box-card">
                    <div class="box-header">
                        <h3 class="box-title">Permissions</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover">

                              
                                @foreach($permissions['permissions'] as $permission)
                                <tr>
                                    <td class="fa fa-fw fa-{{ $permission['isSet'] ? 'check-circle-o' : 'exclamation-circle' }}" > {{ $permission['folder'] }}</td>
                                    <td class="list__item list__item--permissions {{ $permission['isSet'] ? 'success' : 'error' }}" >
                                    {{ $permission['isSet'] ? 'Passed' : 'Failed' }}
                                    </td>
                                    <td> {{ $permission['permission'] }}</td>
                                </tr>

                                @endforeach
                        </tbody>
                    </table>
                               
                        </div>
                        <div class="clearfix"><!-- --></div>      
                    </div>
                    <div class="box-footer">
                        <div class="pull-right mobile-center">                            
                            @if ( ! isset($permissions['errors']))
                                <div class="buttons">
                                    <a class="btn btn-primary btn-flat" href="{{ route('LaravelInstaller::environmentWizard') }}">
                                        {{ trans('installer_messages.permissions.next') }}
                                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="clearfix"><!-- --></div>        
                    </div>       
                </div>
            </div>


@endsection
