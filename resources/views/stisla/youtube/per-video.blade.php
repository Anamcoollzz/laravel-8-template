@extends('stisla.layouts.app')

@section('title')
  {{ $title }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Menampilkan halaman ' . $title) }}.</p>
    <div class="row">
      <div class="col-12">
        <div id="areaAdd" class="row"></div>
      </div>

    </div>
  </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

@push('scripts')
  <script>
    var i = 0;

    var seconds = [];
    for (let a = 5; a < 100; a += 3) {
      seconds.push(a);
    }
    console.log('seconds', seconds)

    function getRandom(items) {
      var item = items[Math.floor(Math.random() * items.length)];
      return item;
    }

    function addNewFrame() {
      var youtubeVideoId = '{{ $videoId ?? '' }}';
      console.log('youtubeVideoId', youtubeVideoId);
      if (youtubeVideoId !== undefined) {
        var youtubeEmbed = "https://www.youtube.com/embed/" + youtubeVideoId + "?autoplay=1&mute=1";
        var youtubeTitle = 'Judul Video';
        $('#areaAdd').append('<div class="col-md-4"><div class="card"><div class="card-body" id="cardBody' + youtubeVideoId + '"><iframe id="frame' + youtubeVideoId +
          '" width="420" height="345" src="' + youtubeEmbed +
          '" frameborder="0" name="youtube embed" allow="autoplay; encrypted-media" allowfullscreen></iframe><br /><h6 class="text-bold text-primary text-center">' + youtubeTitle +
          '</h6></div></div></div>');
        setTimeout(function() {
          $('#frame' + youtubeVideoId).width($('#cardBody' + youtubeVideoId + '').width())
          $('#frame' + youtubeVideoId).height($('#cardBody' + youtubeVideoId + '').width() * 345 / 420)
        }, 1000)
        i++;
      }
    }

    function loop() {
      let secondTimeout = getRandom(seconds);
      console.log('second', secondTimeout)
      addNewFrame();
      setTimeout(function() {
        loop();
      }, secondTimeout * 1000);
    }

    $(document).ready(function() {

      loop();
    });
  </script>
@endpush

@push('modals')
@endpush
