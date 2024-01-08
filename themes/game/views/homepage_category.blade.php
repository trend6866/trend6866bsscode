

<div class="row">
    @foreach ($landing_categories as $category)
    <div class="col-lg-3 col-xl-3 col-sm-6 col-md-6 col-12  category-card-one">
        <div class="category-card-inner">
            <div class="category-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M6.90943 6.54321H4.72843C4.52625 6.54321 4.3623 6.70713 4.3623 6.90934V9.09034C4.3623 9.29255 4.52625 9.45646 4.72843 9.45646H6.90943C7.11161 9.45646 7.27556 9.29255 7.27556 9.09034V6.90934C7.27556 6.70713 7.11161 6.54321 6.90943 6.54321ZM6.54331 8.72422H5.09455V7.27546H6.54331V8.72422Z" fill="white"/>
                    <path d="M11.2715 6.54321H9.09049C8.88832 6.54321 8.72437 6.70713 8.72437 6.90934V9.09034C8.72437 9.29255 8.88832 9.45646 9.09049 9.45646H11.2715C11.4736 9.45646 11.6376 9.29255 11.6376 9.09034V6.90934C11.6376 6.70713 11.4737 6.54321 11.2715 6.54321ZM10.9053 8.72422H9.45661V7.27546H10.9053V8.72422Z" fill="white"/>
                    <path d="M15.6339 8.72379H13.819V4.72828C13.819 4.52607 13.655 4.36215 13.4529 4.36215H11.6376V2.54728C11.6376 2.34507 11.4737 2.18115 11.2715 2.18115H4.7285C4.52632 2.18115 4.36237 2.34507 4.36237 2.54728V4.36215H2.54713C2.34495 4.36215 2.181 4.52607 2.181 4.72828V8.72379H0.366124C0.16395 8.72379 0 8.88771 0 9.08992V13.4527C0 13.6549 0.16395 13.8188 0.366124 13.8188H2.54709C2.74926 13.8188 2.91321 13.6549 2.91321 13.4527V11.6374H4.36234V13.4527C4.36234 13.6549 4.52629 13.8188 4.72846 13.8188H6.90946C7.11164 13.8188 7.27559 13.6549 7.27559 13.4527V11.6374H8.72434V13.4527C8.72434 13.6549 8.88829 13.8188 9.09047 13.8188H11.2714C11.4736 13.8188 11.6376 13.6549 11.6376 13.4527V11.6374H13.0867V13.4527C13.0867 13.6549 13.2506 13.8188 13.4528 13.8188H15.6338C15.836 13.8188 15.9999 13.6549 15.9999 13.4527V9.08992C16 8.88771 15.8361 8.72379 15.6339 8.72379ZM15.2678 13.0865H13.819V11.2713C13.819 11.0691 13.655 10.9052 13.4529 10.9052H11.2715C11.0693 10.9052 10.9054 11.0691 10.9054 11.2713V13.0865H9.45663V11.2713C9.45663 11.0691 9.29268 10.9052 9.0905 10.9052H6.9095C6.70732 10.9052 6.54337 11.0691 6.54337 11.2713V13.0865H5.09462V11.2713C5.09462 11.0691 4.93067 10.9052 4.7285 10.9052H2.54713C2.34495 10.9052 2.181 11.0691 2.181 11.2713V13.0865H0.732249V9.45604H2.54709C2.74926 9.45604 2.91321 9.29213 2.91321 9.08992V5.0944H4.72846C4.93063 5.0944 5.09458 4.93049 5.09458 4.72828V2.9134H10.9053V4.72828C10.9053 4.93049 11.0693 5.0944 11.2715 5.0944H13.0867V9.08992C13.0867 9.29213 13.2507 9.45604 13.4528 9.45604H15.2677V13.0865H15.2678Z" fill="white"/>
                </svg>
            </div>
            <div class="cate-info">
                <h5>{{$category->name}}</h5>
                @php
                    $landing_categories_products_count = App\Models\product::where('category_id', $category->id)->where('theme_id', APP_THEME())->count();
                @endphp
                <a href="{{route('page.product-list',[$slug,'main_category' => $category->id ])}}"> {{ __('Show more')}}
                    <span>[{{$landing_categories_products_count}}]</span>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>