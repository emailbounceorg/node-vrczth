<x-main-dashboard>
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ trans('site.price.title') }}</h3>
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
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <a href="JavaScript:void(0)" id="create" data-bs-toggle="modal"
                                data-bs-target="#createEdit" class="btn icon btn-primary btn-sm p-1 px-2 mb-2 createEditcs">
                                <i class="bi bi-plus-circle-fill fs-6 pe-2"></i> {{ trans('site.price.create')}}
                            </a>

                            <table class="table table-striped" data-urlView="{{ route('PricingDatatable') }}"
                                id="table1">
                                <thead>
                                    <tr>
                                        <th>{{ trans('site.price.sn') }}</th>
                                        <th>{{ trans('site.price.name') }}</th>
                                        <th>{{ trans('site.price.credit') }}</th>
                                        <th>{{ trans('site.price.price') }}</th>
                                        <th>{{ trans('site.price.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
    <!--BorderLess Modal Modal -->
    <div class="modal fade text-left modal-borderless modal-lg" data-bs-backdrop="static" id="createEdit" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h5 class="modal-title">{{ trans('site.price.create')}}</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FromID" data-urlInsert="{{ route('PricingCreateUpdate') }}">
                        <div class="row mt-3">

                            <input type="hidden" name="id">

                            <div class="col-md-2">
                                <label for="first-name-horizontal">{{ trans('site.price.form.pricing-name')}}</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <input type="text" id="first-name-horizontal" class="form-control" name="name"
                                    placeholder="{{ trans('site.price.form.pricing-name')}}">
                                <span class="text-danger error-text name_error"></span>
                            </div>

                            <div class="col-md-2">
                                <label for="first-name-horizontal">{{ trans('site.price.form.credit')}}</label>
                                <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="{{ trans('site.settings.tooltip') }}"></i>

                            </div>
                            <div class="col-md-10 form-group">
                                <input type="text" id="first-name-horizontal" class="form-control" name="credit"
                                    placeholder="{{ trans('site.price.form.credit')}}">
                                <span class="text-danger error-text credit_error"></span>

                            </div>

                            <div class="col-md-2">
                                <label for="first-name-horizontal">{{ trans('site.price.form.price')}}</label>

                            </div>
                            <div class="col-md-10 form-group">
                                <input type="text" id="first-name-horizontal" class="form-control" name="price"
                                    placeholder="{{ trans('site.price.form.price')}}">
                                <span class="text-danger error-text price_error"></span>

                            </div>

                            @csrf
                            <div class="col-sm-12 mt-3 d-flex justify-content-end">
                                <button type="button" id="CreateUpdate" class="btn btn-primary me-1 mb-1">
                                    {{ trans('site.price.form.submit')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-main-dashboard>
