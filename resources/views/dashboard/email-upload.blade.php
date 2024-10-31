<x-main-dashboard>
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
