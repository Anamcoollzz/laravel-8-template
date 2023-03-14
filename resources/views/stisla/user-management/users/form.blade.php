@extends('stisla.layouts.app-form')

@section('rowForm')
  @isset($d)
    @method('PUT')
  @endisset

  @csrf
  <div class="row">
    <div class="col-md-6">
      @include('stisla.includes.forms.inputs.input-name', ['required' => true])
    </div>
    <div class="col-md-6">
      @include('stisla.includes.forms.inputs.input', [
          'id' => 'phone_number',
          'name' => 'phone_number',
          'label' => __('No HP'),
          'type' => 'text',
          'required' => false,
          'icon' => 'fas fa-phone',
      ])
    </div>
    <div class="col-md-6">
      @include('stisla.includes.forms.inputs.input', [
          'id' => 'birth_date',
          'name' => 'birth_date',
          'label' => __('Tanggal Lahir'),
          'type' => 'date',
          'required' => false,
          'icon' => 'fas fa-calendar',
      ])
    </div>
    <div class="col-md-6">
      @include('stisla.includes.forms.inputs.input', [
          'id' => 'address',
          'name' => 'address',
          'label' => __('Alamat'),
          'type' => 'text',
          'required' => false,
          'icon' => 'fas fa-map-marker-alt',
      ])
    </div>
    @if (count($roleOptions) > 1)
      {{-- <div class="col-md-6">
                    @include('stisla.includes.forms.selects.select', ['id' => 'role', 'name' => 'role', 'options' => $roleOptions, 'label' => 'Role', 'required' => true])
                  </div> --}}
      <div class="col-md-6">
        @include('stisla.includes.forms.selects.select2', [
            'id' => 'role',
            'name' => 'role',
            'options' => $roleOptions,
            'label' => __('Pilih Role'),
            'required' => true,
            'multiple' => true,
        ])
      </div>
    @elseif(count($roleOptions) == 1)
      <input type="hidden" name="role" value="{{ collect($roleOptions)->first() }}">
    @endif
    <div class="col-md-6">
      @include('stisla.includes.forms.inputs.input-email')
    </div>
    <div class="col-md-6">
      @include('stisla.includes.forms.inputs.input-password', [
          'hint' => isset($d) ? 'Password bisa dikosongi' : false,
          'required' => !isset($d),
          'value' => isset($d) ? '' : null,
      ])
    </div>
  </div>
@endsection
