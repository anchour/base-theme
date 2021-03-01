@php
// Allow content to be overridden by passing it to this partial
$content = !empty($content) ? $content : get_sub_field('content');
@endphp

@if ($content)

  <div class="rte">
    {!! $content !!}
  </div>

@endif
