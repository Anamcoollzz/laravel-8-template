<form action="{{ $formAction }}" enctype="multipart/form-data" method="POST">
  @csrf
  <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Impor Data') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @include('includes.form.input', ['type'=>'file', 'accept'=>'*', 'id'=>'import_file', 'label'=>__('Berkas
          Excel'), 'required'=>true, 'accept'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
          <div class="text-center">
            <a href="{{ $downloadLink }}" class="text-primary">
              <strong>Unduh contoh template impor</strong>
            </a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Impor</button>
        </div>
      </div>
    </div>
  </div>
</form>
