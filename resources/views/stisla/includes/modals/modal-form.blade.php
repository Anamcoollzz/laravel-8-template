<form action="{{ $formAction }}" id="formAction" enctype="multipart/form-data" method="POST" onsubmit="onSubmitForm(event)">
  @csrf
  <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Impor Data') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          @include('stisla.includes.forms.buttons.btn-primary', ['type' => 'submit', 'label' => __('Simpan')])
        </div>
      </div>
    </div>
  </div>
</form>
