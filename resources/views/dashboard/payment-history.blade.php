<x-main-dashboard>
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>{{ trans('site.paymentHistory.title') }}</h3>
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
                            <table class="table table-striped" data-urlView="{{ route('paymentDatatable') }}"
                                id="table1">
                                <thead>
                                    <tr>
                                        <th>{{ trans('site.paymentHistory.s-n') }}</th>
                                        <th>{{ trans('site.paymentHistory.name') }}</th>
                                        <th>{{ trans('site.paymentHistory.type') }}</th>
                                        <th>{{ trans('site.paymentHistory.paymentID') }}</th>
                                        <th>{{ trans('site.paymentHistory.credit') }}</th>
                                        <th>{{ trans('site.paymentHistory.amt') }}</th>
                                        <th>{{ trans('site.paymentHistory.date') }}</th>
                                        <th>{{ trans('site.paymentHistory.action') }}</th>
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

</x-main-dashboard>
