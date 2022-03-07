<div class="section-header">
  <h1>{{ $title }}</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
    </div>
    <div class="breadcrumb-item active">
      <a href="{{ $routeIndex }}">{{ $title }}</a>
    </div>
    <div class="breadcrumb-item">{{ $fullTitle }}</div>
  </div>
</div>
