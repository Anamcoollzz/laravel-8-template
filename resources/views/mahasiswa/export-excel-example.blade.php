<table class="table table-striped" id="datatable">
  <thead>
    <tr>
      @if ($isExport === false)
        <th class="text-center">{{ __('#') }}</th>
      @endif
		<th class="text-center">{{ __('Full Name') }}</th>
		<th class="text-center">{{ __('Birth Date') }}</th>
		<th class="text-center">{{ __('Select2') }}</th>
		<th class="text-center">{{ __('Select') }}</th>
		<th class="text-center">{{ __('Colorpicker') }}</th>
		<th class="text-center">{{ __('Number') }}</th>
		<th class="text-center">{{ __('Image') }}</th>
		<th class="text-center">{{ __('File') }}</th>
		<th class="text-center">{{ __('Password') }}</th>
		<th class="text-center">{{ __('Email') }}</th>
		<th class="text-center">{{ __('Time') }}</th>
		<th class="text-center">{{ __('Address') }}</th>
		<th class="text-center">{{ __('Gender') }}</th>

      @if ($isExport === false)
        <th>{{ __('Aksi') }}</th>
      @endif
    </tr>
  </thead>
  <tbody>

    @foreach ($data as $item)
      <tr>
        @if ($isExport === false)
          <td>{{ $loop->iteration }}</td>
        @endif
		<td>{{ $item->name }}</td>
		<td>{{ $item->birth_date }}</td>
		<td>{{ $item->select2 }}</td>
		<td>{{ $item->select }}</td>
		<td>{{ $item->colorpicker }}</td>
		<td>{{ $item->number }}</td>
		<td>{{ $item->image }}</td>
		<td>{{ $item->file }}</td>
		<td>{{ $item->password }}</td>
		<td>{{ $item->email }}</td>
		<td>{{ $item->time }}</td>
		<td>{{ $item->address }}</td>
		<td>{{ \App\Models\Mahasiswa::TYPES['gender'][$item->gender] }}</td>

        @if ($isExport === false)
          <td>
            {{-- @can('Mahasiswa Ubah') --}}
              @include('includes.form.buttons.btn-edit', ['link'=>route('mahasiswas.edit', [$item->id])])
            {{-- @can('Mahasiswa Hapus') --}}
              @include('includes.form.buttons.btn-delete', ['link'=>route('mahasiswas.destroy', [$item->id])])
            {{-- @endcan --}}
          </td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
