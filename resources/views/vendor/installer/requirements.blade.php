    @extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.requirements.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-list-ul fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.requirements.title') }}
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
                            @foreach($requirements['requirements'] as $type => $requirement)
                              <!--   <tr>
                                    <td>{{ ucfirst($type) }}</td>
                                    @if($type == 'php')
                                    <td class="list__item list__title {{ $phpSupportInfo['supported'] ? 'success' : 'error' }}" >
                                    Passed                            </td>
                                    <td>(version {{ $phpSupportInfo['minimum'] }} required)</td>
                                    @endif
                                </tr> -->
                                <tr>
                                @foreach($requirements['requirements'][$type] as $extention => $enabled)
                                <tr>
                                    <td>{{ ucfirst($type) }}</td>
                                    <td>{{ $extention }}</td>
                                    <td class="list__item list__title {{ $enabled ? 'success' : 'error' }}" >
                                    Passed                            </td>
                                    <td>(version {{ $phpSupportInfo['minimum'] }} required)</td>
                                </tr>

                                @endforeach
                            @endforeach 
                        </tbody>
                    </table>
                              
                        </div>
                        <div class="clearfix"><!-- --></div>      
                    </div>
                    <div class="box-footer">
                        <div class="pull-right mobile-center">                            
                            @if ( ! isset($requirements['errors']) && $phpSupportInfo['supported'] )
                                <div class="buttons">
                                    <a class="btn btn-primary btn-flat" href="{{ route('LaravelInstaller::permissions') }}">
                                        {{ trans('installer_messages.requirements.next') }}
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