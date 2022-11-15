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
      @foreach ($_sidebar_menus as $_group)
        <li class="menu-header">{{ __($_group->group_name) }}</li>

        @php
          $_user = auth()->user();
        @endphp
        @foreach ($_group->menus as $_menu)
          {{-- if single menu --}}
          @if ($_menu->childs->count() === 0)
            @php
              $_menu_condition = $_menu->permission === null || $_user->can($_menu->permission);
            @endphp
            @if ($_menu_condition)
              <li @if (Request::is($_menu->is_active_if_url_includes)) class="active" @endif>
                <a class="nav-link" href="{{ $_menu->fix_url }}" @if ($_menu->is_blank) target="_blank" @endif>
                  <i class="fas fa-{{ $_menu->icon }}"></i>
                  <span>{{ __($_menu->menu_name) }}</span>
                </a>
              </li>
            @endif

            {{-- else with child dropdown menu --}}
          @else
            @php
              $_is_active = $_menu->childs
                  ->pluck('is_active_if_url_includes')
                  ->filter(function ($item) {
                      return Request::is($item);
                  })
                  ->count();
            @endphp
            <li class="nav-item dropdown @if ($_is_active) active @endif">
              <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-users"></i>
                <span>{{ __($_menu->menu_name) }}</span>
              </a>
              <ul class="dropdown-menu">
                @foreach ($_menu->childs as $_child_menu)
                  <li @if (Request::is($_child_menu->is_active_if_url_includes)) class="active" @endif>
                    <a class="nav-link" href="{{ $_child_menu->fix_url }}" @if ($_child_menu->is_blank) target="_blank" @endif>
                      {{ __($_child_menu->menu_name) }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @endif
        @endforeach
      @endforeach
    </ul>
  </aside>
</div>
