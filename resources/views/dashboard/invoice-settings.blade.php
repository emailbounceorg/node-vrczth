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
                            <form id="FromID"  data-urlInsert="{{ route('updateInvoiceSettings') }}"
                                enctype="multipart/form-data" method="post">
                                <div class="row mt-5">
                                    <input type="hidden" name="id" value="{{ $settings->id  ?? ''}}">
                                    <div class="col-md-2">
                                        <h5>Address</h5>
                                    </div>

                                    <div class="col-md-10 form-group">
                                       <textarea name="address" id="address" class="form-control" cols="5" rows="3">{{ $settings->address ?? '' }}</textarea>
                                        <span class="text-danger error-text address_error invalid-feedback"></span>
                                    </div>

                                    <div class="col-md-2">
                                        <h5>Mobile</h5>
                                    </div>

                                    <div class="col-md-10 form-group">
                                        <input type="number" name="mobile" value="{{ $settings->mobile ?? '' }}" class="form-control">
                                        <span class="text-danger error-text mobile_error invalid-feedback"></span>
                                        <input type="submit" id="invoicesettings" class="btn btn-primary me-1 mt-5" value="{{ trans('site.settings.submit') }}">
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
