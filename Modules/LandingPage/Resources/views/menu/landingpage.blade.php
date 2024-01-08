<li class="dash-item dash-hasmenu {{ (Request::route()->getName() == 'admin.landingpage.index' || Request::route()->getName() == 'admin.discover.index' || Request::route()->getName() == 'admin.custom_page.index' || Request::route()->getName() == 'admin.homesection.index' || Request::route()->getName() == 'admin.features.index' || Request::route()->getName() == 'admin.discover.index' || Request::route()->getName() == 'admin.screenshots.index' || Request::route()->getName() == 'admin.pricing_plan.index' || Request::route()->getName() == 'admin.faq.index' || Request::route()->getName() == 'admin.testimonials.index' || Request::route()->getName() == 'admin.join_us.index') ? ' active' : '' }}">
    <a href="{{ route('admin.landingpage.index') }}" class="dash-link">
        <span class="dash-micon"><i class="ti ti-license"></i></span><span class="dash-mtext">{{__('Landing Page')}}</span>
    </a>
</li>

