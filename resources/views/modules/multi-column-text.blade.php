<div class="container">
  @include('components.title')

  @ifRows('columns')
    <div class="row">
      @rows('columns')
      @php
          $link = get_sub_field('link');
          $linkText = get_sub_field('link_text');

          if ($link && empty($linkText)) {
            $linkText = $link['title'];
          }
      @endphp

        <div class="col w-full mb-8 md:mb-0 md:w-auto md:flex-1">
          <div class="relative z-10 xl:w-3/4">
            @include('components.title', ['tag' => 'h3', 'className' => 'mb-3 h4'])
            @include('components.content')

            @if ($link = get_sub_field('link'))

              <a @link($link) class="text-link inline-block mt-3">
                {!! $linkText ? $linkText : 'Read more' !!}
              </a>

            @endif
            {{-- @include('components.buttons') --}}
          </div>
        </div>

      @endrows
    </div>
  @endif

  @include('components.buttons')
</div>
