@extends('stisla.layouts.app-form')

@section('rowForm')
  @if (isset($d))
    @method('PUT')
  @endif
  @csrf
  <div class="row">
    <div class="col-md-12">
      @include('stisla.includes.forms.inputs.input-name', ['required' => true, 'icon' => false, 'name' => 'group_name', 'label' => 'Group'])
    </div>

  </div>
@endsection
