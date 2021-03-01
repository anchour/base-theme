@php
$projects = get_sub_field('carousel_projects');
$useContainer = get_sub_field('container');
@endphp

@if (count($projects) > 0)

@if ($useContainer)
  <div class="container">
@endif

@include('components.title')
<div class="project-carousel project-carousel-{{ get_row_index() }}">

  <div class="carousel-images carousel-images-{{ get_row_index() }} slick-carousel">
    @each('partials.carousel.images', collect($projects), 'project')
  </div>

  <div class="container @if($useContainer) px-0 @endif relative md:flex md:justify-between">

    <div class="carousel-content carousel-content-{{ get_row_index() }} slick-carousel w-full md:w-1/2">
      @each('partials.carousel.content', collect($projects), 'project')
    </div>

    @if (count($projects) > 1)

      <div class="w-full md:w-1/2 md:flex md:justify-end">
        <div class="carousel-content__controls relative mt-2 md:mt-3"> </div>
      </div>

    @endif

  </div>

</div>

@if ($useContainer)
  </div>
@endif

@endif
