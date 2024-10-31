<div id="sidebar">
    <div class="sidebar-wrapper border-end active">
        @include('layouts.admin.sidebar-head')
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">{{ trans('site.sideBar.menu') }}</li>

                <li class="sidebar-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>{{ trans('site.sideBar.dashboard') }}</span>
                    </a>
                </li>
                @if (auth()->user()->role == 'admin')
                    <li class="sidebar-item {{ request()->is('admin/pricing') ? 'active' : '' }}">
                        <a href="{{ route('pricing') }}" class="sidebar-link">
                            <i class="bi bi-tags-fill"></i>
                            <span>{{ trans('site.sideBar.price') }}</span>
                        </a>
                    </li>
                @endif

                {{-- @if (auth()->user()->role == 'user') --}}
                <li class="sidebar-item {{ request()->is('admin/pricing-details') ? 'active' : '' }}">
                    <a href="{{ route('PricingDetails') }}" class="sidebar-link">
                        <i class="bi bi-coin"></i>
                        <span>{{ trans('site.sideBar.price-details') }}</span>
                    </a>
                </li>
                {{-- @endif --}}




                <li class="sidebar-item {{ request()->is('admin/upload') ? 'active' : '' }}">
                    <a href="{{ route('upload') }}" class="sidebar-link">
                        <i class="bi bi-cloud-upload-fill"></i>
                        <span>{{ trans('site.sideBar.upload') }}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/processed-list') ? 'active' : '' }}">
                    <a href="{{ route('FinishedView') }}" class="sidebar-link">
                        <i class="bi bi-list-ul"></i>
                        <span>{{ trans('site.sideBar.finished-list') }}</span>
                    </a>
                </li>

                @if (auth()->user()->role == 'admin')
                    <li class="sidebar-item {{ request()->is('admin/users') ? 'active' : '' }}">
                        <a href="{{ route('users') }}" class="sidebar-link">
                            <i class="bi bi-person-lines-fill"></i>
                            <span>{{ trans('site.sideBar.users') }}</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-item {{ request()->is('admin/payment-history') ? 'active' : '' }}">
                    <a href="{{ route('paymentHistory') }}" class="sidebar-link">
                        <i class="bi bi-receipt"></i>
                        <span>{{ trans('site.sideBar.payment-history') }}</span>
                    </a>
                </li>


                <li class="sidebar-item {{ request()->is('admin/responders') ? 'active' : '' }}">
                    <a href="{{ route('responders') }}" class="sidebar-link">
                        <i class="bi bi-envelope-check-fill"></i>
                        <span>{{ trans('site.sideBar.responders') }}</span>
                    </a>
                </li>

                @if (auth()->user()->role == 'user')
                    <li class="sidebar-item {{ Route::currentRouteName() == 'timezone' ? 'active' : '' }}">
                        <a href="{{ route('timezone') }}" class="sidebar-link">
                            <i class="bi bi-clock-history"></i>
                            <span>{{ trans('site.sideBar.timezone') }}</span>
                        </a>
                    </li>
                @endif


                @if (auth()->user()->role == 'admin')
                    <li
                        class="sidebar-item has-sub {{ Route::currentRouteName() == 'settings' || Route::currentRouteName() == 'SMTPSettings' || Route::currentRouteName() == 'autoresponder.setting' || Route::currentRouteName() == 'TermsAndConditions' || Route::currentRouteName() == 'invoiceSettings'  ? 'active' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-gear-fill"></i>
                            <span>{{ trans('site.sideBar.settings') }}</span>
                        </a>

                        <ul class="submenu" style="submenu-height: 521px;">
                            <li class="submenu-item">
                                <a href="{{ route('SMTPSettings') }}" class="submenu-link">
                                    {{ trans('site.settings.menu.smtp') }}
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('settings') }}" class="submenu-link">
                                    {{ trans('site.settings.menu.general-settings') }}
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('autoresponder.setting') }}" class="submenu-link">
                                    {{ trans('site.sideBar.autoresponder') }}
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('TermsAndConditions') }}" class="submenu-link">
                                    {{ trans('site.sideBar.terms_and_conditions') }}
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('invoiceSettings') }}" class="submenu-link">
                                    {{ trans('site.sideBar.invoice') }}
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="https://ommune.com/mailtidy-documentation/" target="_blank" class="sidebar-link">
                            <i class="bi bi-filetype-doc"></i>
                            <span>Documentation</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <ul class="vs"> {{ trans('site.Version') }}:{{ getLogo()['version'] }} </ul>
    </div>
</div>
