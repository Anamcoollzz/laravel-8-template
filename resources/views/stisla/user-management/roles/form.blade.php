@extends('stisla.layouts.app-form')

@section('rowForm')
  @if (isset($d))
    @method('PUT')
  @endif
  @csrf
  <div class="row">
    <div class="col-md-12">
      @include('stisla.includes.forms.inputs.input-name', ['required' => true, 'icon' => false])
    </div>
    <div class="col-md-12">
      <h5>Hak akses</h5>
    </div>
    @foreach ($permissionGroups as $group)
      <div class="col-md-12">
        <div class="mb-2"><strong>{{ $group->group_name }}</strong></div>
      </div>
      @php
        $i = 0;
      @endphp
      <div class="col-md-12 mb-4">
        <div class="row group-permission">
          @foreach ($group->permissions as $item)
            <div class="col-md-3">
              <label class="colorinput d-flex align-items-center">
                <div>
                  <input @if ($i === 0) onchange="onChangeFirst(event)" @endif name="permissions[]" value="{{ $item->name }}" type="checkbox" class="colorinput-input"
                    @if (isset($d) && $d->name === 'superadmin') disabled @endif @if (isset($d) && in_array($item->name, $rolePermissions)) checked @endif />
                  <span class="colorinput-color bg-primary"></span>
                </div>
                &nbsp;&nbsp;
                {{ $item->name }}
              </label>
            </div>
            @php
              $i++;
            @endphp
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
@endsection

@push('scripts')
  <script>
    function onChangeFirst(e) {
      //   alert(e.target.checked);
      $(e.target).parents('.group-permission').find('input').prop('checked', e.target.checked);
    }
  </script>
@endpush
