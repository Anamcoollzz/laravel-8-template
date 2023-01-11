<div class="card-header-action">
  @if (str_contains($mysqlStatus, 'running'))
    @include('stisla.includes.forms.buttons.btn-primary', ['link' => route('ubuntu.mysql', ['action' => 'stop']), 'label' => 'Stop MySQL'])
    @include('stisla.includes.forms.buttons.btn-primary', [
        'link' => route('ubuntu.mysql', ['action' => 'restart']),
        'label' => 'Restart MySQL',
    ])
  @else
    @include('stisla.includes.forms.buttons.btn-primary', ['link' => route('ubuntu.mysql', ['action' => 'start']), 'label' => 'Start MySQL'])
  @endif
</div>
