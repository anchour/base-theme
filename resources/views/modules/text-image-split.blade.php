@php
$flip = get_sub_field('image_first');
$img = get_sub_field('image');
@endphp

{{-- Override max width from md+ so the image scales better as a whole. --}}
<div class="container">
  <div class="row @if ($flip) md:flex-row-reverse @endif xl:justify-between">
    <div class="col w-full py-6 md:py-0 md:w-1/2 xl:w-5/12 md:flex md:items-center md:justify-center">
      <div class="flex-1 relative text-image-split__content">
        @include('components.subtitle')
        @include('components.title')
        @include('components.content')
        @include('components.buttons')
      </div>
    </div>

    <div class="col relative w-full md:w-1/2 xl:px-0">
      <div class="text-image-split__image">
        @include('components.image')
      </div>
    </div>
  </div>

</div>
