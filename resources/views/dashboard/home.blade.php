<x-main-dashboard>
    @section('title', $title)
    <script src="{{ asset('js/npm_chart.js') }}"></script>
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ trans('site.dashboard.dashboard-title') }}</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">{{ pageTitle()[1] }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ pageTitle()[2] }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="row">
                    <div class="col-12 col-xl-3">
                        <div class="card p-4 shadow-sm d-flex align-item-center">
                            <div class="card-header">
                                <h4>
                                    <i class="bi icon-color pe-2 fs-5 bi-credit-card-2-back"></i>
                                   {{ trans('site.dashboard.credits-available') }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <span class="fw-semibold fs-1">{{ $data['CreditAvailable'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-3">
                        <div class="card p-4 shadow-sm d-flex align-item-center">
                            <div class="card-header">
                                <h4>
                                    <i class="bi icon-color pe-2 fs-5 bi-file-earmark-break-fill"></i>
                                  {{ trans('site.dashboard.uploaded-file') }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <span class="fw-semibold fs-1">{{ $data['UploadFile'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-3">
                        <div class="card p-4 shadow-sm d-flex align-item-center">
                            <div class="card-header">
                                <h4>
                                    <i class="bi icon-color pe-2 fs-5 bi-ev-front"></i>
                                    {{ trans('site.dashboard.active-auto-responders') }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <span class="fw-semibold fs-1">{{ $data['AutoResponders'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-3">
                        <div class="card p-4 shadow-sm d-flex align-item-center">
                            <div class="card-header">
                                <h4>
                                    <i class="bi icon-color pe-2 fs-5 bi-currency-dollar"></i>
                                    {{ trans('site.dashboard.payment-received') }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <span class="fw-semibold fs-1">{{ $data['Payment'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
	
            @if (Auth::user()->role == 'admin')
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="paymentAnalysisChart" style="max-width: 600px;"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="userChart"></canvas>
                        </div>
                    </div>
                </div>
                <script>
                    function chartjs() {
                        var colortheme = $('body').attr('data-theme-color');
                        // Retrieve the user data from the view
                        var userDataJson = {!! $data['userAnalysisChart'] !!};
                        // Retrieve the user data from the view
                        var roles = userDataJson.roles;
                        var userCountByRole = userDataJson.userCountByRole;

                        // Prepare chart data
                        var chartData = {
                            labels: roles,
                            datasets: [{
                                data: Object.values(userCountByRole),
                                backgroundColor: [colortheme,
                                '#607080'], // Set the desired colors here for user and admin respectively
                                borderWidth: 1
                            }]
                        };

                        // Set the width and height of the chart
                        var chartWidth = 600; // Set the desired width here
                        var chartHeight = 400; // Set the desired height here

                        // Create the chart
                        var ctx = document.getElementById('userChart').getContext('2d');
                        ctx.canvas.width = chartWidth; // Set the canvas width
                        ctx.canvas.height = chartHeight; // Set the canvas height
                        var chart = new Chart(ctx, {
                            type: 'pie',
                            data: chartData,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'bottom',
                                        labels: {
                                            font: {
                                                size: 18
                                            }
                                        }
                                    }
                                },
                                animation: {
                                    animateRotate: true, // Enable rotation animation
                                    animateScale: true, // Enable scale animation
                                    duration: 1000, // Set the animation duration in milliseconds
                                    easing: 'easeOutQuart' // Set the easing function for the animation
                                }
                            }
                        });

                        //
                        $.ajax({
                            type: "post",
                            url: "{{ route('paymentAnalysis') }}",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function(response) {
                                var paymentData = response;

                                const dates = paymentData.map(item => item.created_at);
                                const totalPayments = paymentData.map(item => item.amt);

                                var backgroundColors = dates.map(() =>
                                colortheme); // Set the desired color here for payment analysis
                                var borderColors = dates.map(() =>
                                colortheme); // Set the desired color here for payment analysis

                                var ctx = document.getElementById('paymentAnalysisChart').getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: dates,
                                        datasets: [{
                                            label: 'Total Payment',
                                            data: totalPayments,
                                            backgroundColor: backgroundColors,
                                            borderColor: borderColors,
                                            pointBorderColor: '#151d3d',
                                            pointBackgroundColor: '#607080',
                                            pointHoverBackgroundColor: '#fff',
                                            pointHoverBorderColor: 'rgba(220,220,220,1)',
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            x: {
                                                display: true,
                                                title: {
                                                    display: true,
                                                    text: 'Date',
                                                    color: '#151d3d' // Set the color for the title
                                                },
                                                ticks: {
                                                    color: '#151d3d', // Set the color for the tick labels
                                                }
                                            },
                                            y: {
                                                display: true,
                                                title: {
                                                    display: true,
                                                    text: 'Total Payment',
                                                    color: '#151d3d' // Set the color for the title
                                                },
                                                ticks: {
                                                    beginAtZero: true,
                                                    callback: function(value, index, values) {
                                                        return '$' + value; // Add currency symbol
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }
                    setTimeout(chartjs, 1000);
                </script>
            @endif
        </div>
    </div>
  @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ trans('site.Emailupload.title') }}</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">{{ pageTitle()[1] }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ pageTitle()[2] }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form id="FromID" data-urlInsert="{{ route('email-upload') }}"
                                data-urlMapping="{{ route('email-mapping') }}" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="container">
                                        @csrf
                                        <div class="container mt-3">
                                            <div class="Thing-container">
                                                <div class="Thing-dash"></div>
                                                <div class="Thing">
                                                    <div class="Thing-step alert-warning shadow-sm">1</div>
                                                    <span>{{ trans('site.Emailupload.step1') }}</span>
                                                    <h5 class="stepText">{{ trans('site.Emailupload.title1') }}</h5>
                                                </div>

                                                <div class="Thing">
                                                    <div class="Thing-step alert-info shadow-sm">2</div>
                                                    <span>{{ trans('site.Emailupload.step2') }}</span>
                                                    <h5 class="stepText">{{ trans('site.Emailupload.title2') }}</h5>
                                                </div>

                                                <div class="Thing">
                                                    <div class="Thing-step alert-success shadow-sm">3</div>
                                                    <span>{{ trans('site.Emailupload.step3') }}</span>
                                                    <h5 class="stepText">{{ trans('site.Emailupload.title3') }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 px-120 mt-3">
                                        <label for="formFileLg"
                                            class="form-label">{{ trans('site.Emailupload.labal') }}</label>
                                        <input class="form-control" name="file" id="file" type="file"
                                            accept=".csv, .xlsx, .txt">
                                    </div>
                                </div>
                                
                                <center>
                                    <button type="button" id="UploadFile"
                                        class="btn btn-primary me-1 mb-3 mt-4 p-2 px-4">
                                        {{ trans('site.Emailupload.button') }}
                                    </button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
                <form id="FromID2" data-urlInsert="{{ route('email-cleaner') }}" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Email</label>
                                        <textarea class="form-control" name="mail" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12 ValidEmailsRow d-none">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <label class="form-label">Invalid
                                                Emails</label>
                                            <i class="bi bi-clipboard-check fs-5 copy-mail-Invalid"></i>
                                        </div>
                                        <textarea class="form-control" id="invalid" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12 ValidEmailsRow d-none">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <label class="form-label">Valid
                                                Emails</label>
                                            <i class="bi bi-clipboard-check fs-5 copy-mail"></i>
                                        </div>
                                        <textarea class="form-control" id="Valid" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center>
                            <button type="button" id="SubmitEmailcleaner"
                                class="btn btn-primary me-1 mb-3 p-2 px-4 w-fc">
                                {{ trans('site.Emailupload.button') }}
                            </button>
                        </center>
                    </div>
                    @csrf
                </form>
            </section>
        </div>
    </div>




</x-main-dashboard>
