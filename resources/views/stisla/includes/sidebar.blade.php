<div class="main-sidebar">
  <aside id="sidebar-wrapper">

    <div class="sidebar-brand">
      @if (config('stisla.logo_aplikasi') != '')
        <a href="{{ url('') }}">
          <img style="max-width: 60%;" src="{{ asset(config('stisla.logo_aplikasi')) }}"></a>
      @else
        <a href="{{ url('') }}">{{ $_app_name }}</a>
      @endif
    </div>

    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ url('') }}">{{ $_app_name_mobile }}</a>
    </div>

    <ul class="sidebar-menu">
      <li class="menu-header">{{ __('Navigasi') }}</li>

      <li @if (Route::is('dashboard.index')) class="active" @endif>
        <a class="nav-link" href="{{ route('dashboard.index') }}">
          <i class="fa fa-fire"></i>
          <span>{{ __('Dashboard') }}</span>
        </a>
      </li>

      <li>
        <a class="nav-link" href="#">
          <i class="fa fa-bars"></i>
          <span>{{ __('Menu') }}</span>
        </a>
      </li>

      <li class="nav-item dropdown {{-- active --}}">
        <a href="#" class="nav-link has-dropdown">
          <i class="fa fa-caret-square-down"></i>
          <span>{{ __('Menu Dropdown') }}</span>
        </a>
        <ul class="dropdown-menu">
          @foreach (range(1, 3) as $sub)
            <li {{-- class="active" --}}>
              <a class="nav-link" href="#">{{ __('Sub Menu') . $loop->iteration }}</a>
            </li>
          @endforeach
        </ul>
      </li>

      <li @if (Route::is('datatable.index')) class="active" @endif>
        <a class="nav-link" href="{{ route('datatable.index') }}">
          <i class="fa fa-table"></i>
          <span>{{ __('Datatable') }}</span>
        </a>
      </li>

      <li @if (Route::is('form.index')) class="active" @endif>
        <a class="nav-link" href="{{ route('form.index') }}">
          <i class="fa fa-file-alt"></i>
          <span>{{ __('Form') }}</span>
        </a>
      </li>

      <li class="menu-header">{{ __('Menu Lainnya') }}</li>


      <li @if (Route::is('profile.index')) class="active" @endif>
        <a class="nav-link" href="{{ route('profile.index') }}">
          <i class="fa fa-user"></i>
          <span>{{ __('Profil') }}</span>
        </a>
      </li>
      <li>
        <a class="nav-link" href="{{ route('logout') }}">
          <i class="fa fa-sign-out-alt"></i>
          <span>{{ __('Keluar') }}</span>
        </a>
      </li>

    </ul>
  </aside>
</div>
