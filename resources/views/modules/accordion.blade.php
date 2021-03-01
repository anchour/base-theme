@php
$section_row = get_row_index();

@endphp

<div class="container">

  <div class="mb-8">
    @include('components.title')
  </div>

  @ifRows('accordion')

  <div class="row">

    <div class="col accordion-col w-full">
      @rows('accordion')

      @php $row_qty = get_row_index(); @endphp

      <article
        class="accordion-row cursor-pointer relative w-full"
        id="{{ App\get_accordion_row_id() }}"
      >
        <h3 class="accordion-row__title h4 transition mb-0">
          <button
            class="accordion-row__header w-full text-left relative py-4 pr-8 font-normal"
            id="accordion-open-{{$section_row}}.{{$row_qty}}"
            aria-expanded="false"
          >
            {{ get_sub_field('title') }}

            <span class="accordion-row__icon"></span>
          </button>
        </h3>

        <div
          id="accordion-body-{{$section_row}}.{{$row_qty}}"
          class="accordion-row__body overflow-hidden"
          aria-hidden="true"
        >
          <div class="accordion-row__body-inner pb-4 overflow-hidden">
            @rte(get_sub_field('content'))
          </div>
        </div>

      </article>

      @endrows

    </div>

  </div>

  @endif

  @include('components.buttons')

</div>
