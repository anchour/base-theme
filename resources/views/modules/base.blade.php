@rows('modules')
  @php
  $layout = str_replace('_', '-', get_row_layout());

  if ($id = get_sub_field('id')) {
    $id = sanitize_title($id);

    $layout .= "-{$id}";
  }
  @endphp

  <section {!! App\module_attributes($layout) !!}>
    @include("flexible-layout.{$layout}")
  </section>
@endrows
