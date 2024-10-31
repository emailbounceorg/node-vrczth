<x-main-dashboard>
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ trans('site.finished-list.title') }}</h3>
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
                            <table class="table table-striped" data-urlView="{{ route('FinishedDtatable') }}"
                                id="table1">
                                <thead>
                                    <tr>
                                        <th>{{ trans('site.finished-list.s-n') }}</th>
                                        <th>{{ trans('site.finished-list.name') }}</th>
                                        <th>{{ trans('site.finished-list.processed-on') }}</th>
                                        <th>{{ trans('site.finished-list.date') }}</th>
                                        <th>{{ trans('site.finished-list.total_processed') }}</th>
                                        <th>{{ trans('site.finished-list.clean') }}</th>
                                        <th>{{ trans('site.finished-list.total_invalid') }}</th>
                                        <th>{{ trans('site.finished-list.total') }}</th>
                                        <th>{{ trans('site.finished-list.action') }}</th>
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

    <div class="modal fade text-left modal-borderless modal-lg" data-bs-backdrop="static" id="AutoResponders"
        tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h5 class="modal-title">{{ trans('site.finished-list.modal.title') }}</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FromID" data-urlinsert="{{ route('ResponderEmailSave') }}">
                        <div class="row mt-3">

                            <div class="col-md-3">
                                <label for="first-name-horizontal">{{ trans('site.finished-list.modal.name') }}</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select class="form-control ResponderData" name="Responder_name">
                                </select>
                            </div>

                            <div class="modal-body text-center status-spinner">
                                <div class="spinner-border text-primary">
                                    <span class="sr-only"></span>
                                </div>
                            </div>

                            <div class="col-md-3 showResponderDiv">
                                <label id="status_">{{ trans('site.finished-list.modal.responder-list') }}</label>
                            </div>
                            <div class="col-md-9 form-group showResponderDiv">
                                <select class="form-control showResponder" name="responder_list">
                                </select>
                            </div>
                            <input type="text" class="email_cleaner_id" name="email_cleaner_id" hidden>
                            @csrf
                            <div class="col-sm-12 mt-3 d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary mx-2 me-1 mb-1 modalHide"
                                    data-dismiss="modal">{{ trans('site.finished-list.modal.close') }}</button>
                                <button type="button" id="ResponderEmailSave" class="btn btn-primary me-1 mb-1">
                                    {{ trans('site.finished-list.modal.send') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-main-dashboard>
