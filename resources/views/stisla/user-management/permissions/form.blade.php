@extends('stisla.layouts.app-form')

@section('rowForm')
  @if (isset($d))
    @method('PUT')
  @endif
  @csrf
  <div class="row">
    <div class="col-md-6">
      @include('stisla.includes.forms.inputs.input-name', ['required' => true, 'icon' => false])
    </div>
    <div class="col-md-6">
      @include('stisla.includes.forms.selects.select', [
          'id' => 'permission_group_id',
          'name' => 'permission_group_id',
          'options' => $groupOptions,
          'label' => 'Group',
          'required' => true,
      ])
    </div>

  </div>
@endsection
