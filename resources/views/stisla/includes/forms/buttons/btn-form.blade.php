<div class="card">
  <div class="card-header">
    <h4>
      @if ($icon ?? false)
        <i class="{{ $icon }}"></i>
      @endif
      Aksi
    </h4>
  </div>
  <div class="card-body">
    @include('includes.form.buttons.btn-save')
    @include('includes.form.buttons.btn-reset')
  </div>
</div>
