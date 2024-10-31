<x-main-dashboard>
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ trans('site.clean-details-list.title') }}</h3>
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
                <div class="card">
                    <div class="card-header">
                        <span>{{ trans('site.clean-details-list.date') }}: {{ $data['date'] }}</span>
                        <h3 class="card-title">{{ trans('site.clean-details-list.total-emails') }}:
                            {{ $data['Total_Emails'] }}
                        </h3>
                        <div id="toggleButton">
                            <button type="button" class="btn btn-sm icon icon-left btn-primary p-2 px-4"><i
                                    class="bi bi-check-circle-fill fs-6"></i>
                                {{ trans('site.clean-details-list.select-all') }}</button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="row">
                <div class="col-12 col-lg-12">
                    <form id="FromID" data-urlInsert="{{ route('downloadCsv') }}" data-id="{{ $data['row'] }}"
                        enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-12 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4> <i class="bi bi-envelope-check-fill"></i>
                                            {{ trans('site.clean-details-list.clean') }} </h4>
                                        <span class="fw-semibold fs-1">{{ $data['Clean'] }}</span>
                                        <p class="fw-semibold">
                                            @php
                                                echo ($data['Clean'] / $data['Total_Emails']) * 100 . '%';
                                            @endphp
                                        </p>
                                        <span>Working Email addresses.</span>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                class="form-check-input form-check-success CleanValid" name="down[]"
                                                value="Valid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4> <i class="bi bi-envelope-check-fill"></i> Suspected </h4>
                                        <span class="fw-semibold fs-1">{{ $data['Suspected'] }}</span>
                                        <p class="fw-semibold">
                                            @php
                                                echo ($data['Suspected'] / $data['Total_Emails']) * 100 . '%';
                                            @endphp
                                        </p>
                                        <span> Email addresses that can be valid or invalid. We didn't get proper
                                            response from the corresponding email provider.</span>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-success Suspected"
                                                name="down[]" value="Suspected Email">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4> <i class="bi bi-envelope-check-fill"></i> Invalid Format </h4>
                                        <span class="fw-semibold fs-1">{{ $data['Invalid_Format'] }}</span>
                                        <p class="fw-semibold">
                                            @php
                                                echo ($data['Invalid_Format'] / $data['Total_Emails']) * 100 . '%';
                                            @endphp
                                        </p>
                                        <span>Emails are invalid as their format is invalid</span>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                class="form-check-input form-check-success Invalid_Format"
                                                name="down[]" value="Invalid Email">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4> <i class="bi bi-person-fill"></i> Bounce </h4>
                                        <span class="fw-semibold fs-1">{{ $data['Bounce'] }}</span>
                                        <p class="fw-semibold">
                                            @php
                                                echo ($data['Bounce'] / $data['Total_Emails']) * 100 . '%';
                                            @endphp
                                        </p>
                                        <span>Emails that have either full inboxes. </span>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-success"
                                                name="down[]" value="Bounce">
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="col-12 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4> <i class="bi bi-person-fill"></i> Invalid </h4>
                                        <span class="fw-semibold fs-1">{{ $data['Invalid'] }}</span>
                                        <p class="fw-semibold">
                                            @php
                                                echo ($data['Invalid'] / $data['Total_Emails']) * 100 . '%';
                                            @endphp
                                        </p>
                                        <span>Invalid emails.</span>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-success"
                                                name="down[]" value="Invalid">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4> <i class="bi bi-person-fill"></i> Disposable </h4>
                                        <span class="fw-semibold fs-1">{{ $data['Disposable'] }}</span>
                                        <p class="fw-semibold">
                                            @php
                                                echo ($data['Disposable'] / $data['Total_Emails']) * 100 . '%';
                                            @endphp
                                        </p>
                                        <span> Emails used for one time use only.</span>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-success"
                                                name="down[]" value="disposable">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4> <i class="bi bi-person-fill"></i> Bad MX </h4>
                                        <span class="fw-semibold fs-1">{{ $data['Bad_MX'] }}</span>
                                        <p class="fw-semibold">
                                            @php
                                                echo ($data['Bad_MX'] / $data['Total_Emails']) * 100 . '%';
                                            @endphp
                                        </p>
                                        <span>Emails with Bad MX records.</span>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-success"
                                                name="down[]" value="BadMX">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-12 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4> <i class="bi bi-person-fill"></i> No-replies </h4>
                                        <span class="fw-semibold fs-1">{{ $data['No_replies'] }}</span>
                                        <p class="fw-semibold">
                                            @php
                                                echo ($data['No_replies'] / $data['Total_Emails']) * 100 . '%';
                                            @endphp
                                        </p>
                                        <span>No-replies emails.</span>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-success"
                                                name="down[]" value="no-reply">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4> <i class="bi bi-person-fill"></i> Invalid Domain </h4>
                                        <span class="fw-semibold fs-1">{{ $data['invalid_domain'] }}</span>
                                        <p class="fw-semibold">
                                            @php
                                                echo ($data['invalid_domain'] / $data['Total_Emails']) * 100 . '%';
                                            @endphp
                                        </p>
                                        <span>Invalid Domain </span>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-success"
                                                name="down[]" value="Invalid Domain">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4> <i class="bi bi-person-fill"></i> Role-Based </h4>
                                        <span class="fw-semibold fs-1">{{ $data['Role_Based'] }}</span>
                                        <p class="fw-semibold">
                                            @php
                                                echo ($data['Role_Based'] / $data['Total_Emails']) * 100 . '%';
                                            @endphp
                                        </p>
                                        <span>Role-Based emails like hr@domain.com</span>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input form-check-success"
                                                name="down[]" value="role-base">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="type-select-download d-flex flex-wrap justify-content-center my-3 mx-auto">
                                <div class="form-check mx-2">
                                    <input class="form-check-input" type="radio" name="typeDownload[]"
                                        id="csv" value=".csv" checked>
                                    <label class="form-check-label" for="csv">
                                        .csv
                                    </label>
                                </div>
                                <div class="form-check mx-2">
                                    <input class="form-check-input" type="radio" name="typeDownload[]"
                                        id="xlsx" value=".xls">
                                    <label class="form-check-label" for="xlsx">
                                        .xls
                                    </label>
                                </div>
                                <div class="form-check mx-2">
                                    <input class="form-check-input" type="radio" name="typeDownload[]"
                                        id="txt" value=".txt">
                                    <label class="form-check-label" for="txt">
                                        .txt </label>
                                </div>
                            </div>
                            <center>
                                <button type="button" id="CSVdownload"
                                    class="btn btn-primary">{{ trans('site.clean-details-list.download-selected-lists') }}
                                    <i class="bi bi-cloud-arrow-down-fill fs-4"></i></button>
                            </center>
                        </div>
                        @csrf
                    </form>
                </div>
            </section>

            <div class="row mt-5">
                <div class="col-md-6">
                    <h3>{{ trans('site.clean-details-list.list-statistic') }}</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <table class="dataTable">
                                <thead>
                                    <tr role="row">
                                        <th rowspan="1" colspan="1" class="th-with-277">
                                            {{ trans('site.clean-details-list.Type') }}</th>
                                        <th rowspan="1" colspan="1" class="th-with-57">
                                            {{ trans('site.clean-details-list.Records') }}</th>
                                    </tr>
                                </thead>

                                <tbody id="domainTR1">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>{{ trans('site.clean-details-list.free-emails') }}</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="pi_domain"></canvas>
                        </div>
                        <div class="col-md-6">
                            <table class="dataTable">
                                <thead>
                                    <tr role="row">
                                        <th rowspan="1" colspan="1" class="th-with-277">
                                            {{ trans('site.clean-details-list.Type') }}</th>
                                        <th rowspan="1" colspan="1" class="th-with-57">
                                            {{ trans('site.clean-details-list.Records') }}</th>
                                    </tr>
                                </thead>

                                <tbody id="domainTR">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-dashboard>
