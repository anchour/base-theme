@php
global $post;
$testimonials = get_sub_field('testimonials');
$count = get_sub_field('sections_per_row') ?: 3;
@endphp

<div class="container">

  @include('components.title')
  @include('components.content')

  <div class="row">

    <div class="col w-full carousel">
      <div class="md:flex md:flex-row md:flex-wrap -mx-4 mobile-slick-slider">
        @foreach ($testimonials as $index => $post)
        @php
        setup_postdata($post);
        @endphp

        <div class="testimonial__col w-full md:w-1/{{ $count }} p-4 lg:py-10">

          <div class="testimonial__wrap w-full relative z-10">

            <div class="testimonial__content text-base rte mb-6">
              @content

            </div>

            <div class="testimonial__name ">
              <span class="font-semibold">@title</span>
              @if ($title = get_field('title', get_the_ID()))
                &ndash; <i>{{ $title }}</i>
              @endif
            </div>

          </div>

        </div>

        @endforeach
      </div>

      <div class="carousel-content__controls relative inline-block px-4"> </div>

      @php wp_reset_postdata(); @endphp

    </div>

  </div>

</div>
