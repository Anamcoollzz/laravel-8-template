<!DOCTYPE html>
<html lang="en">

<head>
  @include('stisla.includes.others.meta-title')
  @include('stisla.includes.others.css')

</head>

<body>
  <div id="app">
    @yield('content')
  </div>

  @include('stisla.includes.others.js')

</body>

</html>
