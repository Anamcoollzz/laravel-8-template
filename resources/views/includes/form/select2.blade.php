@if (is_stisla_template())
  @include('includes.form.select', ['select2'=>true, 'multiple'=>$multiple??false])

  @if (!defined('SELECT2_IMPORT'))
    @php
      define('SELECT2_IMPORT', true);
    @endphp

    @push('js')
      <script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    @endpush

    @push('css')
      <link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}">
    @endpush

    @push('scripts')
      <script>
        $(function() {

        });
      </script>
    @endpush
  @endif
@else

  <div class="form-group">
    <label @isset($id) for="{{ $id }}" @endisset>
      {{ $label }}
      @if ($required ?? false) <span class="text-danger">*</span> @endif
    </label>
    <select @if ($multiple ?? false) multiple @endif
      name="{{ $name ?? $id }}" @isset($id) id="{{ $id }}" @endisset
      class="form-control {{ $multiple ?? false ? 'select2multiple' : 'select2' }}">
      @foreach ($options as $value => $text)
        <option @if ($selected ?? false === $value) selected @endif
          value="{{ $value }}">{{ $text }}</option>
      @endforeach
    </select>
  </div>

  @if (!defined('SELECT2_MULTIPLE'))
    @php
      define('SELECT2_MULTIPLE', true);
    @endphp
    @push('scripts')
      <script>
        $(function() {
          $('.select2multiple').select2({
            // tags: true
            // multiple: true
          });
        });
      </script>
    @endpush
  @endif
@endif
