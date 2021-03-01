@php
// Allow title to be overridden by passing it to this partial.
$title = !empty($title) ? $title : get_sub_field('title');
$tag =  $tag ?? 'h2';
$className = $className ?? 'section-title'
@endphp

@if ($title)
  <{{ $tag }} class="{{ $className }}">{!! do_shortcode($title) !!}</{{ $tag }}>
@endif
