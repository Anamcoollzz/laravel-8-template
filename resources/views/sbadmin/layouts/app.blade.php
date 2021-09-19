<!DOCTYPE html>
<html>

@include('includes.head')

<body class="theme-red">
  @include('includes.page-loader')

  <!-- Overlay For Sidebars -->
  <div class="overlay"></div>
  <!-- #END# Overlay For Sidebars -->

  @include('includes.search-bar')
  @include('includes.top-bar')

  <section>
    @include('includes.left-sidebar')
    @include('includes.right-sidebar')
  </section>

  <section class="content">
    @yield('content')
  </section>

  @include('includes.scripts')
</body>

</html>
