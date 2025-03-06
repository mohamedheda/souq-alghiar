<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('/') }}" class="brand-link">
        {{--        <img src="{{asset("logo.png")}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">@lang('dashboard.souq-alghiar')</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('img/user2-160x160.jpg') }}"
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item  {{ in_array(request()->route()->getName(),['/'])? 'menu-open': '' }}">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            @lang('dashboard.Home')
                        </p>
                    </a>
                </li>
                <li class="nav-item  {{ in_array(request()->route()->getName(),['users.index', 'users.create', 'users.edit', 'users.show'])? 'menu-open': '' }}">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            @lang('dashboard.users')
                        </p>
                    </a>
                </li>
                <li class="nav-item  {{ in_array(request()->route()->getName(),['marks.index', 'marks.update', 'marks.edit', 'marks.show'])? 'menu-open': '' }}">
                    <a href="{{ route('marks.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            @lang('dashboard.marks')
                        </p>
                    </a>
                </li>
                <li class="nav-item  {{ in_array(request()->route()->getName(),['categories.index', 'categories.update', 'categories.edit', 'categories.show'])? 'menu-open': '' }}">
                    <a href="{{ route('categories.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            @lang('dashboard.categories')
                        </p>
                    </a>
                </li>
                @permission('roles-read')
                    <li class="nav-item  {{ in_array(request()->route()->getName(),['roles.index','roles.create','roles.edit','roles.mangers','managers.create','managers.edit'])? 'menu-open': '' }}">
                        <a href="{{ route('roles.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                @lang('dashboard.roles_and_permissions')
                            </p>
                        </a>
                    </li>
                @endpermission
                <li
                    class="nav-item  {{ in_array(request()->route()->getName(),['settings.edit'])? 'menu-open': '' }} {{ Route::currentRouteName()=='settings.edit'?'activeNav':'' }}">
                    <a href="{{ route('settings.edit', auth()->user()->id) }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            @lang('dashboard.Settings')
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
