@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.final.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.final.title') }}
@endsection

@section('container')
    <form method="post">
        <div class="box box-primary borderless">
            <div class="skin-box-card">
                <div class="box-header">
                    <h3 class="box-title">Edit laravel-worker.conf file using following command:</h3>
                </div>
                <div class="box-body">
                    <div class="alert alert-info">
                        If you run into issues when settingS up the cron jobs, please read <a target="_blank"
                            href="https://ommune.com/mailtidy-documentation/worker-setup.html"><em>this</em></a> article for
                        solutions.<br />
                    </div>

                    <pre>sudo vim /etc/supervisor/conf.d/laravel-worker.conf</pre>

                    <h4>And then insert the following code:</h4>
                    <pre> [program:laravel-worker]
            process_name=%(program_name)s_%(process_num)02d
            command=php /var/www/html/yourdomain.com/artisan queue:work
            autostart=true
            autorestart=true
            stopasgroup=true
            killasgroup=true
            user=root
            numprocs=8
            redirect_stderr=true
            stdout_logfile=/var/www/html/yourdomain.com/worker.log
            stopwaitsecs=3600</pre>
                    <pre>

        <h4>Don't forget to change your domain name and other paths as per your OS (above code is for Ubuntu). After this, run following commands in the terminal:</h4>

<pre>   sudo supervisorctl reread
    sudo supervisorctl update
    sudo supervisorctl start laravel-worker:*</pre>

                    <p> That's it.</p>
                    <div class="clearfix"><!-- --></div>
                </div>
                <div class="box-footer">
                    <div class="pull-right mobile-center">
                        <a href="{{ route('LaravelInstaller::finish') }}"
                            class="btn btn-primary btn-flat">{{ trans('Cron jobs are installed, continue.') }}</a>
                    </div>
                    <div class="clearfix"><!-- --></div>
                </div>
            </div>
        </div>
    </form>
@endsection
