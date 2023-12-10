<style>
    @font-face {
        font-family: "simple-line-icons";
        src: url({{url('/')}}/fonts/vendor/simple-line-icons/Simple-Line-Icons.eot?85e8c542d5e137beecf94e0132812855);
    src: url({{url('/')}}/fonts/vendor/simple-line-icons/Simple-Line-Icons.eot?85e8c542d5e137beecf94e0132812855) format("embedded-opentype"),
    url({{url('/')}}/fonts/vendor/simple-line-icons/Simple-Line-Icons.woff2?3826fa1cb2348dd93948a50cbd2b8fb6) format("woff2"),
    url({{url('/')}}/fonts/vendor/simple-line-icons/Simple-Line-Icons.ttf?3ec13a24af3fdda1110771d3541915a2) format("truetype"),
    url({{url('/')}}/fonts/vendor/simple-line-icons/Simple-Line-Icons.woff?5c9febce52054ae0b96ddd3e2d173e1a) format("woff"),
    url({{url('/')}}/fonts/vendor/simple-line-icons/Simple-Line-Icons.svg?f1515a459c88508908124cfdab38ced9) format("svg");
    font-weight: normal;
    font-style: normal;
    }
    @font-face {
    font-family: CoreUI-Icons-Linear-Free;
    src: url({{url('/')}}/fonts/vendor/@coreui/icons/CoreUI-Icons-Linear-Free.eot?b5c93177864186615ed5c7090d5a934a);
    src: url({{url('/')}}/fonts/vendor/@coreui/icons/CoreUI-Icons-Linear-Free.eot?b5c93177864186615ed5c7090d5a934a#iefix) format("embedded-opentype"), url(/fonts/vendor/@coreui/icons/CoreUI-Icons-Linear-Free.ttf?49a8e66ae5644253b2bf811d96e0d0da) format("truetype"), url(/fonts/vendor/@coreui/icons/CoreUI-Icons-Linear-Free.woff?6779cfb19973abd1449d93e9eb09b32e) format("woff"), url(/fonts/vendor/@coreui/icons/CoreUI-Icons-Linear-Free.svg?a141262bd3f1f2e2a026c22e42dfd712#CoreUI-Icons-Linear) format("svg");
    font-weight: 400;
    font-style: normal
}
@font-face {
    font-family: "FontAwesome";
    src: url({{url('/')}}/fonts/vendor/font-awesome/fontawesome-webfont.eot?8b43027f47b20503057dfbbaa9401fef);
    src: url({{url('/')}}/fonts/vendor/font-awesome/fontawesome-webfont.eot?8b43027f47b20503057dfbbaa9401fef) format("embedded-opentype"),
         url({{url('/')}}/fonts/vendor/font-awesome/fontawesome-webfont.woff2?20fd1704ea223900efa9fd4e869efb08) format("woff2"), url(/fonts/vendor/font-awesome/fontawesome-webfont.woff?f691f37e57f04c152e2315ab7dbad881) format("woff"), url(/fonts/vendor/font-awesome/fontawesome-webfont.ttf?1e59d2330b4c6deb84b340635ed36249) format("truetype"), url(/fonts/vendor/font-awesome/fontawesome-webfont.svg?c1e38fd9e0e74ba58f7a2b77ef29fdd3) format("svg");
    font-weight: normal;
    font-style: normal;
}


</style>
<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/categories') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.category.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/items') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.item.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/discounts') }}"><i class="nav-icon icon-umbrella"></i> {{ trans('admin.discount.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            {{-- <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li> --}}
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
