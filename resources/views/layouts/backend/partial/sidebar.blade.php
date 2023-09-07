<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('backend') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::guard('admin')->user()->image != '' && file_exists('backend/upload/admin/'.Auth::guard('admin')->user()->image) ? url('backend/upload/admin/'. Auth::guard('admin')->user()->image) :  url('backend//dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.profile.view') }}" class="nav-link {{ request()->is('admin/profile*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview  {{ request()->is('admin/category*') || request()->is('admin/subcategory*') || request()->is('admin/sub-subcategory*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Manage Category
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.category.view') }}" class="nav-link {{ request()->is('admin/category*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Root Category</p>
                            </a>
                            <a href="{{ route('admin.subcategory.view') }}" class="nav-link {{ request()->is('admin/subcategory*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sub Category</p>
                            </a>
                            <a href="{{ route('admin.sub_subcategory.view') }}" class="nav-link {{ request()->is('admin/sub-subcategory*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sub Sub-Category</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.video.view') }}" class="nav-link {{ request()->is('admin/video*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-video"></i>
                        <p>
                            Video
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.cms.view') }}" class="nav-link {{ request()->is('admin/cms*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            CMS
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
