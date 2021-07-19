@if (config('app.template') === 'stisla')
  @include('includes.form.buttons.btn-reset')
@else
  <button type="reset" class="btn btn-default waves-effect waves-red">{{ __('Reset') }}</button>
@endif
