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
          <i class="fas fa-fire"></i>
          <span>{{ __('Dashboard') }}</span>
        </a>
      </li>

      <li @if (Route::is('crud-examples.index') || Route::is('crud-examples.create') || Route::is('crud-examples.edit')) class="active" @endif>
        <a class="nav-link" href="{{ route('crud-examples.index') }}">
          <i class="fas fa-atom"></i>
          <span>{{ __('Contoh CRUD') }}</span>
        </a>
      </li>

      @if (config('app.show_example_menu'))
        <li>
          <a class="nav-link" href="#">
            <i class="fas fa-bars"></i>
            <span>{{ __('Menu') }}</span>
          </a>
        </li>

        <li class="nav-item dropdown {{-- active --}}">
          <a href="#" class="nav-link has-dropdown">
            <i class="fas fa-caret-square-down"></i>
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
            <i class="fas fa-table"></i>
            <span>{{ __('Datatable') }}</span>
          </a>
        </li>

        <li @if (Route::is('form.index')) class="active" @endif>
          <a class="nav-link" href="{{ route('form.index') }}">
            <i class="fas fa-file-alt"></i>
            <span>{{ __('Form') }}</span>
          </a>
        </li>
      @endif

      <li class="menu-header">{{ __('Menu Lainnya') }}</li>

      @if (auth()->user()->can('Pengguna') ||
    auth()->user()->can('Role'))
        <li class="nav-item dropdown @if (Route::is('user-management.users.index') ||
          Route::is('user-management.roles.index') || Route::is('user-management.roles.edit') ||
          Route::is('user-management.users.edit') || Route::is('user-management.users.create')) active @endif">
          <a href="#" class="nav-link has-dropdown">
            <i class="fas fa-users"></i>
            <span>{{ __('Manajemen Pengguna') }}</span>
          </a>
          <ul class="dropdown-menu">
            @can('Pengguna')
              <li @if (Route::is('user-management.users.index') || Route::is('user-management.users.edit') || Route::is('user-management.users.create')) class="active" @endif>
                <a class="nav-link" href="{{ route('user-management.users.index') }}">
                  {{ __('Data Pengguna') }}
                </a>
              </li>
            @endcan

            @can('Role')
              <li @if (Route::is('user-management.roles.index') || Route::is('user-management.roles.edit')) class="active" @endif>
                <a class="nav-link" href="{{ route('user-management.roles.index') }}">
                  {{ __('Data Role') }}
                </a>
              </li>
            @endcan
          </ul>
        </li>
      @endif

      @can('Profil')
        <li @if (Route::is('profile.index')) class="active" @endif>
          <a class="nav-link" href="{{ route('profile.index') }}">
            <i class="fas fa-user"></i>
            <span>{{ __('Profil') }}</span>
          </a>
        </li>
      @endcan

      @can('Pengaturan')
        <li @if (Route::is('settings.index')) class="active" @endif>
          <a class="nav-link" href="{{ route('settings.index') }}">
            <i class="fas fa-cogs"></i>
            <span>{{ __('Pengaturan') }}</span>
          </a>
        </li>
      @endcan

      <li>
        <a class="nav-link" href="{{ route('logout') }}">
          <i class="fas fa-sign-out-alt"></i>
          <span>{{ __('Keluar') }}</span>
        </a>
      </li>

    </ul>
  </aside>
</div>
