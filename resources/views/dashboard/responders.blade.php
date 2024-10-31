<x-main-dashboard>
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ trans('site.responders.title') }}</h3>
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

            <div class="row">
                @foreach ($nameTitileImg as $responder)
                    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6">
                        <div class="card border-success mb-3 shadow">
                            <div class="card-header border-success text-white bg-primary">{{ $responder['title'] }}
                            </div>
                            <div class="card-body text-success text-center">
                                <img class="card-img-bottom" src="{{ $responder['icon'] }}" alt="Card image cap">

                                <button class="btn btn-sm btn-secondary btn-block responderBtn"
                                    data-bs-toggle="modal" data-bs-target="#configuration-modal"
                                   data-GetInputsURL="{{ route('respondersGetInput') }}" data-whatever="{{ $responder['title'] }}" data-key="{{ $responder['key'] }}">

                                   {{ trans('site.responders.submit-button') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="modal fade text-left modal-borderless modal-lg" data-bs-backdrop="static" id="configuration-modal"
        tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalTitle">Modal title</h5>
                    <button type="button"class="modalHide btn btn-sm btn-light close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>

                <form data-urlinsert="{{ route('RespondersConfigSave') }}" id="FromID" method="post">
                    <div class="modal-body text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only"></span>
                        </div>
                        <div class="row ShowInputs"></div>
                    </div>
                    @csrf
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary modalHide"
                            data-dismiss="modal">Close</button>
                        <button type="button" id="saveConfig" class="btn btn-sm btn-primary">Save Configuration</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-main-dashboard>
