<x-main-dashboard>
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ $title }}</h3>
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
                            <form id="FromID" data-urlInsert="{{ route('updateTimezone') }}"
                                enctype="multipart/form-data">
                                <div class="row mt-5">
                                    <input type="hidden" name="id" value="{{ auth()->user()->id ?? '' }}">
                                    <div class="col-md-2">
                                        <h5>TimeZone</h5>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <select class="form-control" name="timezones">
                                            <option value="">--Select--</option>
                                            @php
                                                $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                                            @endphp
                                            @foreach ($timezones as $val)
                                                <option {{ $val == auth()->user()->timezones ? 'selected' : '' }}>
                                                    {{ $val }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text timezones_error invalid-feedback"></span>
                                        <button type="button" id="timezonesUpdate" class="btn btn-primary me-1 mt-5">
                                            {{ trans('site.settings.submit') }}
                                        </button>
                                    </div>


                                    @csrf

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-main-dashboard>
