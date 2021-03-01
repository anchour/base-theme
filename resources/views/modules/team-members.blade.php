<div class="container section-title-wrapper">
  @include('components.title')
</div>

@if ($members = get_sub_field('team_members'))
  <div class="container">
    <div class="row">
      <div class="xl:w-3/4 flex flex-wrap">
        @foreach ($members as $member)
          <div class="col team-member w-full sm:w-1/2 xl:w-1/3 pb-10">
            <div class="team-member-inner w-48 px-1 mx-auto sm:w-auto sm:px-0 sm:mx-0 rounded-lg bg-white">

              @if ($thumbnail = get_post_thumbnail_id($member->ID))
                {!! App\image($thumbnail) !!}
              @endif

              @if ($name = $member->post_title)
                <div class="text-base uppercase font-sans font-semibold tracking-wide mb-1 mt-4 leading-none">
                  {{ $name }}
                </div>

                <div class="text-base font-serif leading-none">
                  @if ($title = get_field('title', $member->ID))
                    {{ $title }}
                  @endif
                </div>
              @endif

            </div>
          </div>
        @endforeach

      </div>
    </div>
  </div>
@endif
