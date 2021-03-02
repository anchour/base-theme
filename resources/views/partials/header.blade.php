<header class="banner py-4 lg:py-7">
  <div class="container">
    <div class="row">
      <div class="col w-1/2 sm:w-1/3 lg:w-1/6 relative z-50">
        @include('partials.brand')
      </div>

      @if (has_nav_menu('primary_navigation'))

        <div data-primary-navigation class="col primary-navigation-outer w-full pt-16 pb-4 lg:py-0 lg:w-auto lg:flex lg:justify-end lg:items-center lg:flex-1">
          <nav class="nav-primary mt-12 lg:mt-0">
            {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
          </nav>
        </div>

      @endif

    </div>

    @if (has_nav_menu('primary_navigation'))

      <button type="button" data-toggle="[data-primary-navigation]" class="nav-toggle lg:hidden absolute right-0 top-0 z-50 text-primary-dark w-12 h-11 mt-2 mr-4">
        <span class="nav-toggle__icon-bar nav-toggle__icon-bar--first"></span>
        <span class="nav-toggle__icon-bar nav-toggle__icon-bar--middle"></span>
        <span class="nav-toggle__icon-bar nav-toggle__icon-bar--last"></span>
      </button>

    @endif
  </div>
</header>
