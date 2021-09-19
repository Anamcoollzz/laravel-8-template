<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
  <!-- User Info -->
  <div class="user-info">
    <div class="image">
      <img src="{{ asset('assets/images/user.png') }}" width="48" height="48"
        alt="{{ Auth::user()->name ?? 'Hairul Anam' }}" />
    </div>
    <div class="info-container">
      <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ Auth::user()->name ?? 'Hairul Anam' }}</div>
      <div class="email">{{ Auth::user()->email ?? 'hairulanam21@gmail.com' }}</div>
      <div class="btn-group user-helper-dropdown">
        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="true">keyboard_arrow_down</i>
        <ul class="dropdown-menu pull-right">
          <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profil</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="javascript:void(0);"><i class="material-icons">group</i>Menu 1</a></li>
          <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Menu 2</a></li>
          <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Menu 3</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="javascript:void(0);"><i class="material-icons">input</i>Keluar</a></li>
        </ul>
      </div>
    </div>
  </div>
  <!-- #User Info -->
  <!-- Menu -->
  <div class="menu">
    <ul class="list">
      <li class="header">{{ __('MENU UTAMA') }}</li>
      <li>
        <a href="{{ route('dashboard.index') }}">
          <i class="material-icons">home</i>
          <span>{{ __('Dashboard') }}</span>
        </a>
      </li>
      <li>
        <a href="../../pages/typography.html">
          <i class="material-icons">text_fields</i>
          <span>Nama Menu</span>
        </a>
      </li>

      <li>
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">swap_calls</i>
          <span>Dengan Sub Menu</span>
        </a>
        <ul class="ml-menu">
          @foreach (range(1, 5) as $item)
            <li>
              <a href="../../pages/ui/alerts.html">Menu {{ $item }}</a>
            </li>
          @endforeach
        </ul>
      </li>

      <li>
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">widgets</i>
          <span>Dengan Sub Sub Menu</span>
        </a>
        <ul class="ml-menu">

          @foreach (range(1, 4) as $item)
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span>Menu {{ $item }}</span>
              </a>
              <ul class="ml-menu">
                @foreach (range(1, 4) as $item2)
                  <li>
                    <a href="../../pages/widgets/cards/basic.html">Sub Menu {{ $item2 }}</a>
                  </li>
                @endforeach
              </ul>
            </li>
          @endforeach
        </ul>
      </li>

      <li>
        <a href="{{ route('settings.index') }}">
          <i class="material-icons">settings</i>
          <span>{{ __('Settings') }}</span>
        </a>
      </li>
      <li>
        <a href="../changelogs.html">
          <i class="material-icons">update</i>
          <span>{{ __('Whats New') }}</span>
        </a>
      </li>
      <li>
        <a href="../changelogs.html">
          <i class="material-icons">input</i>
          <span>{{ __('Logout') }}</span>
        </a>
      </li>

      {{-- <li class="header">LABELS</li>
      <li>
        <a href="javascript:void(0);">
          <i class="material-icons col-red">donut_large</i>
          <span>Important</span>
        </a>
      </li>
      <li>
        <a href="javascript:void(0);">
          <i class="material-icons col-amber">donut_large</i>
          <span>Warning</span>
        </a>
      </li>
      <li>
        <a href="javascript:void(0);">
          <i class="material-icons col-light-blue">donut_large</i>
          <span>Information</span>
        </a>
      </li> --}}
    </ul>
  </div>
  <!-- #Menu -->
  <!-- Footer -->
  <div class="legal">
    <div class="copyright">
      &copy; {{ $_since->value < date('Y') ? $_since->value . ' - ' . date('Y') : date('Y') }} <a
        href="javascript:void(0);">{{ $_application_name->value }} -
        {{ $_company_name->value }}</a>.
    </div>
    <div class="version">
      <b>{{ __('Version') }}: </b> {{ $_application_version->value }}
    </div>
  </div>
  <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->
