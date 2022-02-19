<!DOCTYPE html>
<html lang="en">

<head>
  @include('stisla.includes.others.meta-title')
  @include('stisla.includes.others.css')

</head>

<body>
  <div id="app">
    <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          @yield('content')
        </div>
        @include('stisla.includes.auth.auth-bg')
      </div>
    </section>
  </div>

  @include('stisla.includes.others.js-auth')

</body>

</html>
