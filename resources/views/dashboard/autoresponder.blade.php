<x-main-dashboard>
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ trans('site.settings.autoresponder') }}</h3>
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

                            <div class="modal-body text-center status-spinner" style="display: none;">
                                <div class="spinner-border text-primary">
                                    <span class="sr-only"></span>
                                </div>
                            </div>

                            <form action="{{ route('autoresponder.setting.save') }}" id="responder-setting-form"
                                enctype="multipart/form-data">

                                <input type="hidden" name="id" value="{{ $setting->id }}">

                                <div class="row mt-5">

                                    <div class="col-md-2">
                                        <label
                                            for="first-name-horizontal">{{ trans('site.default-autoresponder.user-name') }}</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <select class="form-control ResponderData" name="user_id"
                                            data-source="{{ route('getAutoResponders') }}">
                                            <option value=""> Select User </option>
                                            @forelse ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ $setting->user_id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}</option>
                                            @empty
                                                <option value=""> No User Available </option>
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label
                                            for="first-name-horizontal">{{ trans('site.default-autoresponder.responder-name') }}</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <select class="form-control ResponderData" name="Responder_name">
                                            @forelse ($responders as $responder)
                                                <option value="{{ $responder->key }}"
                                                    data-url="{{ route('DataResponder') }}">{{ $responder->title }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label
                                            for="first-name-horizontal">{{ trans('site.default-autoresponder.responder-list') }}</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <select class="form-control showResponder" name="responder_list">
                                        </select>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10 form-group">
                                        <p><span class="text-danger">Note <i class="bi bi-asterisk"></i></span> The email of users who will create
                                            account on this application, will be saved in the above email list. You can
                                            use this for sending notifications or email newsletters i.e. for email
                                            marketing.</p>
                                    </div>
                                </div>

                                @csrf
                                <center>
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        {{ trans('site.settings.submit') }}
                                    </button>
                                </center>

                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>


</x-main-dashboard>
