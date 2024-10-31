<x-main-dashboard>
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ trans('site.users.title') }}</h3>
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

            <section class="section users-section">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <a href="JavaScript:void(0)" data-bs-toggle="modal" data-bs-target="#edit"
                            class="btn icon btn-primary btn-sm p-1 px-2 mb-2 edit-button" data-id="" data-name=""
                            data-email="" data-credit="" data-title="{{ trans('site.curd-name.create') }}"
                            data-btn-text="{{ trans('site.curd-name.create') }}">
                            {{ trans('site.curd-name.create') }} <i class="bi bi-plus-circle-fill fs-6 pe-2"></i>
                        </a>
                        <div class="table-responsive">
                            <table class="table table-striped" data-urlView="{{ route('UsersDatatable') }}"
                                id="table1">
                                <thead>
                                    <tr>
                                        <th>{{ trans('site.users.s-n') }}</th>
                                        <th>{{ trans('site.users.name') }}</th>
                                        <th>{{ trans('site.users.email') }}</th>
                                        <th>{{ trans('site.users.role') }}</th>
                                        <th>{{ trans('site.users.credit') }}</th>
                                        <th>{{ trans('site.users.action') }}</th>
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

    <div class="modal fade text-left modal-borderless modal-lg" data-bs-backdrop="static" id="edit" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('site.users.modal.title') }}</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FromID" data-urlInsert="{{ route('UserUpdate') }}">
                        <div class="row mt-3">

                            <input type="hidden" name="id">

                            <div class="col-md-2">
                                <label for="first-name-horizontal">{{ trans('site.users.modal.name') }}</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <input type="text" class="form-control" name="name"
                                    placeholder="{{ trans('site.users.modal.name') }}">
                            </div>

                            <div class="col-md-2">
                                <label for="first-name-horizontal">{{ trans('site.users.modal.email') }}</label>
                            </div>
                            <div class="col-md-10 form-group">
                                <input type="email" class="form-control" name="email"
                                    placeholder="{{ trans('site.users.modal.email') }}">
                            </div>

                            <div class="col-md-2">
                                <label for="first-name-horizontal">{{ trans('site.users.modal.credit') }}</label>
                            </div>

                            <div class="col-md-10 form-group">
                                <input type="text" class="form-control" name="credit"
                                    placeholder="{{ trans('site.users.modal.credit') }}">
                            </div>

                            <div class="col-md-2">
                                <label for="first-name-horizontal">{{ trans('site.users.modal.pass') }}</label>
                            </div>

                            <div class="col-md-10 form-group">
                                <input type="password" class="form-control" name="password"
                                    placeholder="{{ trans('site.users.modal.pass') }}">
                                <span class="text-danger error-text password_error"></span>
                            </div>
                            <div class="col-md-2 mt-3">Role</div>
                            <div class="col-md-10 mt-3">
                                <label for="status">
                                    <div class="form-check form-check-inline mx-2">
                                        <label class="form-check-label" for="inlineRadio1">Admin</label>
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            value="admin">
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineRadio2">Client</label>
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            value="user" checked="">
                                    </div>
                                </label>
                            </div>

                            @csrf
                            <div class="col-sm-12 mt-3 d-flex justify-content-end">
                                <button type="button" id="Update" class="btn btn-primary me-1 mb-1">
                                    {{ trans('site.users.modal.button') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-main-dashboard>
