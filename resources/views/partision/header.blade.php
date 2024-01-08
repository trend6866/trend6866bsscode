@php
    $currantLang = \Auth::user()->lang;
    if ($currantLang == null) {
        $currantLang = 'en';
    }
    $user = \Auth::user();
    $current_store = \App\Models\Store::where('id', $user->current_store)->first();


    $displaylang = App\Models\Utility::languages();
    $theme_id = !empty($theme_id) ? $theme_id : APP_THEME();
    $settings = App\Models\Setting::pluck('value','name')->toArray();

    if(empty($settings['disable_lang'])){
        $settings = App\Models\Utility::Seting();
    }
    $toDisable = explode(',',$settings['disable_lang']);

        foreach($displaylang as $key => $data){
            if (str_contains($settings['disable_lang'], $key)) {
               unset($displaylang[$key]);
            }

        }

        $store =  App\Models\Store::where('id',getCurrentStore())->first();
                    $slug = $store->slug;
                    $theme_url = route('landing_page',$slug);
                    $plan = \App\Models\Plan::find(\Auth::user()->plan);
                    $plano = \App\Models\Plan::where('name','Renew')->first();
@endphp

@if (isset($cust_theme_bg) && $cust_theme_bg == 'on')
    <header class="dash-header transprent-bg">
    @else
        <header class="dash-header">
@endif
<div class="header-wrapper">
    <div class="me-auto dash-mob-drp">
        <ul class="list-unstyled">
            <li class="dash-h-item mob-hamburger">
                <a href="#!" class="dash-head-link" id="mobile-collapse">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="dropdown dash-h-item drp-company">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="theme-avtar">
                        <img alt="#" style="height:inherit;"
                            src="{{ !empty(Auth::guard('admin')->user()->profile_image) ? get_file(Auth::guard('admin')->user()->profile_image, APP_THEME()) : asset(Storage::url('uploads/profile/avatar.png')) }}"
                            class="header-avtar">

                    </span>
                    <span class="hide-mob ms-2">
                        @if (!Auth::guest())
                            {{ __('Hi, ') }}{{ !empty(Auth::guard('admin')->user()) ? Auth::guard('admin')->user()->name : '' }}!
                        @else
                            {{ __('Guest') }}
                        @endif
                    </span>
                    <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                </a>
                <div class="dropdown-menu dash-h-dropdown">

                    <a href="{{ route('admin.profile') }}" class="dropdown-item">
                        <i class="ti ti-user"></i>
                        <span>{{ __('Profile') }}</span>
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" id="form_logout">
                        <a href="route('admin.logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="dropdown-item">
                            <i class="ti ti-power"></i>
                            @csrf
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="ms-auto">
        <ul class="list-unstyled">
                @impersonating($guard = null)
                    <li class="dropdown dash-h-item drp-company">
                        <a class="btn btn-danger btn-sm me-3"
                            href="{{ route('admin.exit.admin') }}"><i class="ti ti-ban"></i>
                            {{ __('Exit Admin Login') }}
                        </a>
                    </li>
                @endImpersonating
                @if (Auth::user()->can('Create Admin Store'))
                @if($plano->name != $plan->name)
                <li class="dropdown dash-h-item drp-language">
                        <a class="dropdown drp-company bg-success w-100 dash-head-link p-2 " href="{{ $theme_url }}">
                            <i class="ti ti-eye "></i>
                            </a>
                        <a href="#!" class="dropdown-item dash-head-link dropdown-toggle arrow-none me-0 cust-btn bg-primary" data-size="lg"
                            data-url="{{ route('admin.stores.create') }}" data-ajax-popup="true"
                            data-title="{{ __('Create New Store') }}">
                            <i class="ti ti-circle-plus"></i>
                            <span class="text-store">{{ __('Create New Store') }}</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->can('Change Admin Store'))
                    <li class="dash-h-item drp-language menu-lnk has-item">
                        @php
                            $store_id = Auth::guard('admin')->user()->current_store;
                            $store = App\Models\Store::find($store_id);
                        @endphp
                        <a class="dash-head-link arrow-none me-0 cust-btn megamenu-btn bg-warning" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false"
                            data-bs-placement="bottom" data-bs-original-title="Select your bussiness">
                            <i class="ti ti-building-store me-1"></i>
                            <span class="hide-mob">{{ $store->name }}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        @php
                            if (Auth::guard('admin')->user()->type != 'admin')
                            {
                                // $user = App\Models\Admin::find(\Auth::guard('admin')->user()->created_by);
                                $user_1 = App\Models\Admin::where('id',\Auth::user()->id)->first();
                                $assign_store = $user_1->is_assign;
                                $value = explode(',',$assign_store);
                                $user = App\Models\Store::whereIn('id',$value)->get();
                            }
                            else
                            {
                                $user = Auth::guard('admin')->user();
                            }
                        @endphp

                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                            @if (Auth::guard('admin')->user()->type != 'admin')
                                @foreach ($user as $store)
                                    @if ($store->is_active)
                                        <a href="@if (Auth::guard('admin')->user()->current_store == $store->id) # @else {{ route('admin.changes_store', $store->id) }} @endif"
                                            class="dropdown-item">
                                            @if (Auth::guard('admin')->user()->current_store == $store->id)
                                                <i class="ti ti-checks text-primary"></i>
                                            @endif
                                            {{ $store->name }}
                                        </a>
                                    @else
                                        <a href="#!" class="dropdown-item">
                                            <i class="ti ti-lock"></i>
                                            <span>{{ $store->name }}</span>
                                            @if (isset($store->pivot->permission))
                                                @if ($store->pivot->permission == 'admin')
                                                    <span class="badge bg-dark">{{ __($store->pivot->permission) }}</span>
                                                @else
                                                    <span class="badge bg-dark">{{ __('Shared') }}</span>
                                                @endif
                                            @endif
                                        </a>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($user->stores as $store)

                                    @if ($store->is_active)
                                        <a href="@if (Auth::guard('admin')->user()->current_store == $store->id) # @else {{ route('admin.changes_store', $store->id) }} @endif"
                                            class="dropdown-item">
                                            @if (Auth::guard('admin')->user()->current_store == $store->id)
                                                <i class="ti ti-checks text-primary"></i>
                                            @endif
                                            {{ $store->name }}
                                        </a>
                                    @else
                                        <a href="#!" class="dropdown-item">
                                            <i class="ti ti-lock"></i>
                                            <span>{{ $store->name }}</span>
                                            @if (isset($store->pivot->permission))
                                                @if ($store->pivot->permission == 'admin')
                                                    <span class="badge bg-dark">{{ __($store->pivot->permission) }}</span>
                                                @else
                                                    <span class="badge bg-dark">{{ __('Shared') }}</span>
                                                @endif
                                            @endif
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        {{-- <div class="mega-menu menu-dropdown">
                            <div class="mega-menu-container container">
                                <ul class="row">
                                    @foreach (Auth::guard('admin')->user()->stores as $store)
                                    <li class="col-sm-3 col-12">
                                        <ul class="megamenu-list arrow-list">
                                            <li>
                                                @if ($store->is_active)
                                                    <a href="@if (Auth::guard('admin')->user()->current_store == $store->id) # @else {{ route('admin.changes_store', $store->id) }} @endif"
                                                        class="dropdown-item">
                                                        @if (Auth::guard('admin')->user()->current_store == $store->id)
                                                            <i class="ti ti-checks text-primary"></i>
                                                        @endif
                                                        {{ $store->name }}
                                                    </a>
                                                @else
                                                    <a href="#!" class="dropdown-item">
                                                        <i class="ti ti-lock"></i>
                                                        <span>{{ $store->name }}</span>
                                                        @if (isset($store->pivot->permission))
                                                            @if ($store->pivot->permission == 'admin')
                                                                <span class="badge bg-dark">{{ __($store->pivot->permission) }}</span>
                                                            @else
                                                                <span class="badge bg-dark">{{ __('Shared') }}</span>
                                                            @endif
                                                        @endif
                                                    </a>
                                                @endif

                                            </li>
                                        </ul>
                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>                --}}
                        {{-- </div> --}}
                    </li>
                @endif
                @endif

            {{-- <li class="dropdown dash-h-item drp-language">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-world nocolor"></i>
                    <span class="drp-text hide-mob">{{ __('EN') }}</span>
                </a>
            </li> --}}
            <li class="dropdown dash-h-item drp-language">
                <a class="dash-head-link dropdown-toggle arrow-none me-0 bg-info" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-world nocolor me-1"></i>
                    <span class="">{{ Str::upper($currantLang) }}</span>
                    <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                </a>

                <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                    @foreach ($displaylang as $key => $lang)
                        <a href="{{ route('admin.change.language', $key) }}"
                            class="dropdown-item {{ $currantLang == $key ? 'text-primary' : '' }}">
                            <span>{{ Str::ucfirst($lang) }}</span>
                        </a>
                    @endforeach
                    @if (Auth::user()->type == 'superadmin')
                        <a href="{{ route('admin.manage.language', [$currantLang]) }}"
                            class="dropdown-item border-top py-1 text-primary">{{ __('Manage Languages') }}
                        </a>
                    @endif
                </div>
            </li>
        </ul>
    </div>
</div>
</header>
