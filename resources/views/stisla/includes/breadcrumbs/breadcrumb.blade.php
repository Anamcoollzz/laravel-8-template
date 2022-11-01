<div class="section-header-breadcrumb">
  @foreach ($breadcrumbs as $item)
    @isset($item['link'])
      <div class="breadcrumb-item active">
        <a href="{{ $item['link'] }}">{{ $item['label'] }}</a>
      </div>
    @else
      <div class="breadcrumb-item">{{ $item['label'] }}</div>
    @endisset
  @endforeach

</div>
