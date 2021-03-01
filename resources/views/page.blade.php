@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

    @if (get_theme_support('page-content'))
      @if(empty($post->post_password) || ! empty($post->post_password) && !post_password_required())
        @include('partials.content-page-' . $post->post_name)
      @else
        <div class="container py-8">
          <div class="w-full sm:w-2/3 mx-auto">
            @content
          </div>
        </div>
      @endunless
    @endif

    {{-- No post password, or there *is* a password and it's been filled successfully already. --}}
    @if (empty($post->post_password) || ! empty($post->post_password) && !post_password_required())
      @include('modules.base')
    @endif
  @endwhile
@endsection
