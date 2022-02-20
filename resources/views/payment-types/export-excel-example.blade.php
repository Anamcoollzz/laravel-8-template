<table class="table table-striped" id="datatable">
  <thead>
    <tr>
      @if ($isExport === false)
        <th class="text-center">{{ __('#') }}</th>
      @endif
		<th class="text-center">{{ __('Nama Pembayaran') }}</th>
		<th class="text-center">{{ __('Tagihan') }}</th>
		<th class="text-center">{{ __('Jenis Waktu Pembayaran') }}</th>

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
		<td>{{ $item->type_name }}</td>
		<td>{{ $item->bill_amount }}</td>
		<td>{{ $item->payment_time_type }}</td>

        @if ($isExport === false)
          <td>
            {{-- @can('Jenis Pembayaran Ubah') --}}
              @include('includes.form.buttons.btn-edit', ['link'=>route('payment-types.edit', [$item->id])])
            {{-- @can('Jenis Pembayaran Hapus') --}}
              @include('includes.form.buttons.btn-delete', ['link'=>route('payment-types.destroy', [$item->id])])
            {{-- @endcan --}}
          </td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
