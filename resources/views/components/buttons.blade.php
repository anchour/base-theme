@php
$key = $key ?? 'buttons';
@endphp

@ifRows($key)

<div class="mt-6">

  @rows($key)
  @php

  switch(get_sub_field('button_style')) {
    case 'Primary':
      $className = 'btn btn-primary';
      break;
    case 'Secondary':
      $className = 'btn btn-secondary';
      break;
    case 'Text':
    default:
      $className = 'text-link';
  }

  @endphp

  <a {!! App\link_attributes() !!} class="{{ $className }} mr-2">
    @subfield('button_text', 'Learn more')
  </a>
  @endrows

</div>

@endif
