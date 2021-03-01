@php $projects = collect(get_sub_field('projects')); @endphp

<div class="container">

  @unless ($projects->isEmpty())

    <div class="row">

      @each('components.project-card', $projects, 'project')

    </div>

  @endunless

  @include('components.buttons')

</div>

