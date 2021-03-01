@php

$size = get_sub_field('content_width');
$image = get_sub_field('background_image');

@endphp

@unless (empty($image))
  <div
    class="absolute inset-0 bg-cover bg-center lazyload z-0"
    data-bgset="@srcset($image)"
  >
    <div class="absolute inset-0 z-10 bg-black opacity-25"> </div>
  </div>
@endunless

<div class="container relative z-10"">
  <div class="row">
    <div class="w-full px-4 lg:px-8">
      @include('partials.shortcodes.brandmark')
      @include('components.title')
      @include('components.content')
    </div>

    <div class="px-4 w-full flex justify-center">
      @include('components.buttons')
    </div>
  </div>

</div>
