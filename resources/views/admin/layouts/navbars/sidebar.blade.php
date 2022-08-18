<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  
  <div class="logo">
    <a href="/" class="simple-text logo-normal">
      TEST PROJECT
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>      
      <li class="nav-item{{ $activePage == 'country' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.country.index') }}">
          <i class="material-icons">location_ons</i>
            <p>{{ __('Manage Country') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'state' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.state.index') }}">
          <i class="material-icons">location_ons</i>
            <p>{{ __('Manage State') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'city' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.city.index') }}">
          <i class="material-icons">location_ons</i>
          <p>{{ __('Manage City') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'user' ? ' active' : '' }}">
        <a class="nav-link" href="{{ url('admin/user') }}">
          <i class="material-icons">people</i>
            <p>{{ __('Manage Customer') }}</p>
        </a>
      </li>      
    </ul>
  </div>
</div>
