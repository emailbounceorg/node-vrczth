<header>
    <nav class="navbar navbar-expand navbar-light header-color-auto navbar-top border-bottom">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto ms-auto mb-lg-0">
                    <div class="d-flex hideDomainCheckOnMobile">
                        <form id="formIDCheckEmail" method="post">
                            <div class="d-flex flex-nowrap">
                                <input type="email" name="emailChecks" id="emailChecks"
                                    class=" h-100 fs-7 form-control position-relative"
                                    placeholder="Check validity of an email">
                                <span id="email_check_status" class="position-absolute"></span>
                                <button id="email_check" class="btn btn-primary btn-md h-100 lh-sm text-nowrap ms-2"
                                    data-url="{{ route('email-cleaner-check') }}"
                                    type="submit">{{ trans('site.Emailupload.button') }}</button>
                            </div>
                        </form>
                    </div>
                </ul>

                <div class="dropdown">

                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">

                        <div class="user-menu d-flex mt--35">
                            <div class="user-name text-end me-3">
                                <div class="me-3 list-style-type-none">
                                    <a class="dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown"
                                        data-bs-display="static" aria-expanded="false">
                                        <i class="bi bi-translate bi-sub fs-3"></i>
                                        <span
                                            class="badge badge-notification bg-primary me-2 mt-5">{{ Config::get('languages')[App::getLocale()] }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end notification-dropdown"
                                        aria-labelledby="dropdownMenuButton">
                                        @foreach (Config::get('languages') as $lang => $language)
                                            @if ($lang != App::getLocale())
                                                <li class="dropdown-item notification-item">
                                                    <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}">
                                                        {{ $language ?? 'need to add' }}</a>
                                                </li>
                                            @else
                                                <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}">
                                                    {{ $language }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </a>


                </div>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">{{ auth()->user()->name }}</h6>
                                <p class="mb-0 text-sm text-gray-600">
                                    @if (auth()->user()->role == 'admin')
                                        Admin
                                    @else
                                        User
                                    @endif
                                </p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" />
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ auth()->user()->name }}</h6>
                        </li>
                        {{-- <li>
                            <a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i>
                                My
                                Profile</a>
                        </li> --}}
                        {{-- <li>
                            <a class="dropdown-item" href="{{ route('settings') }}"><i class="icon-mid bi bi-gear me-2"></i>
                                Settings</a>
                        </li> --}}
                        {{-- <li>
                            <a class="dropdown-item" href="#"><i class="icon-mid bi bi-wallet me-2"></i>
                                Wallet</a>
                        </li> --}}
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('signout') }}"><i
                                    class="icon-mid bi bi-box-arrow-left me-2"></i>
                                Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
