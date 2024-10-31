<x-main-dashboard>
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">

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
                        <form id="FromID" data-url="{{ route('TermsAndConditionsUpdate') }}">
                            <div class="row mt-3">
                                <input type="hidden" name="id" value="{{ $settings->id ?? '' }}">
                                <h3>{{ trans('site.settings.terms-conditions') }}</h3>
                                <textarea name="terms_and_conditions" class="summernote" cols="30" rows="10">{{ $settings->terms_and_conditions ?? '' }}</textarea>
                                <h3 class="mb-4 mt-4">{{ trans('site.settings.privacy-policy') }}</h3>
                                <textarea name="privacy_policy" class="summernote" cols="30" rows="10">{{ $settings->privacy_policy ?? '' }}</textarea>
                                @csrf
                                <center>
                                    <button type="button" id="TermsAndConditionsUpdate" class="btn btn-primary me-1 mb-1 mt-5">
                                        {{ trans('site.curd-name.update') }}
                                    </button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-main-dashboard>
