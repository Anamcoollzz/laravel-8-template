<form action="{{ $formAction }}" enctype="multipart/form-data" method="POST">
  @csrf
  <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Impor Data') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @if ($note ?? false)
            <div class="mb-4">
              <div class="alert alert-info alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                  <div class="alert-title">{{ __('Catatan!') }}</div>
                  {{ $note }}
                </div>
              </div>
            </div>
          @endif

          @include('stisla.includes.forms.inputs.input', [
              'type' => 'file',
              'accept' => '*',
              'id' => 'import_file',
              'label' => __('Berkas Excel'),
              'required' => true,
              'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
              'hint' => __('Hanya menerima berkas excel'),
          ])

          <div class="text-center">
            <a href="{{ $downloadLink }}" class="text-primary">
              <strong>Unduh contoh template impor</strong>
            </a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          @include('stisla.includes.forms.buttons.btn-primary', ['type' => 'submit', 'label' => __('Impor')])
        </div>
      </div>
    </div>
  </div>
</form>
