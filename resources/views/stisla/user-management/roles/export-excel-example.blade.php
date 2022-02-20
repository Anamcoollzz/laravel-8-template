<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        {{-- <th class="text-center">#</th> --}}
        <th>name</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $item)
        <tr>
          {{-- <td>{{ $loop->iteration }}</td> --}}
          <td>
            {{ $item->name }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
