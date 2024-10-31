<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @if (trim($__env->yieldContent('template_title')))
            @yield('template_title') |
        @endif {{ trans('installer_messages.title') }}
    </title>
    <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-16x16.png') }}" sizes="16x16" />
    <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-32x32.png') }}"
        sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-96x96.png') }}"
        sizes="96x96" />
    <link href="{{ asset('installer/css/adminlte.css') }}" rel="stylesheet" />

    @yield('style')
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>

<body class="skin-blue menubar">
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <aside class="row main-header-top">
            <ul class="steps">
                <li class="step ">
                    <span class="step__icon"></span>
                    <span class="step__label">Welcome</span>
                </li>
                <li class="step ">
                    <span class="step__icon"></span>
                    <span class="step__label">Requirements</span>
                </li>
                <li class="step ">
                    <span class="step__icon"></span>
                    <span class="step__label">File system checks</span>
                </li>
                <li class="step ">
                    <span class="step__icon"></span>
                    <span class="step__label">Database import</span>
                </li>
                <li class="step ">
                    <span class="step__icon"></span>
                    <span class="step__label">Admin account</span>
                </li>
                <li class="step ">
                    <span class="step__icon"></span>
                    <span class="step__label">Cron jobs</span>
                </li>
                <li class="step ">
                    <span class="step__icon"></span>
                    <span class="step__label">Finish</span>
                </li>
            </ul>
        </aside>
        <aside class="row">
            <section class="content-header-breadcrume">
                <div class="breadcrumb">
                    <a class="breadcrumb__step breadcrumb__step--active" href="index.php?route=welcome">Install</a>
                    <li><a class="breadcrumb__step" href=""></a></li>
                </div>
            </section>
            <section class="content">
                @yield('container')
            </section>
        </aside>
    </div>
    @yield('scripts')

</body>

</html>
