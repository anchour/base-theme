<div class="lg:flex">

  <div class="mailing-list-signup__content bg-red-400 border-red-400 text-center relative w-full text-white p-4 lg:flex lg:items-center lg:justify-center sm:p-6 lg:w-1/3">
    <div class="max-w-sm mx-auto">
      @include('components.title')

      <div class="rte">
        @subfield('content')
      </div>

      @include('components.buttons')
    </div>
  </div>

  <div class="mailing-list-signup__form-wrap w-full flex flex-wrap lg:items-center lg:w-2/3 p-4 pt-8 sm:p-8 md:p-12 lg:p-12 lg:px-24 xl:py-20 xl:px-32">
    @if ($form = get_sub_field('form'))
      {!! gravity_form($form, false, false, false, [], true, null, false) !!}
    @endif
  </div>

</div>
