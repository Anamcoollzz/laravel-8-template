@if (config('app.template') === 'stisla')
  <button type="submit" class="btn btn-primary btn-save-form btn-icon icon-left">
    <i class="fas fa-check"></i>
    {{ $label ?? __('Simpan') }}
  </button>
@else
  <button type="submit" class="btn btn-primary waves-effect  waves-light">{{ __('Save') }}</button>
@endif
