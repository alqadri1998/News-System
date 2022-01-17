<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>NEWS CMS | Admin</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('cms/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('cms/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('cms/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="{{asset('cms/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">News System</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset('cms/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2"
                         alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{Auth::user()->name}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('cms.admin.dashboard')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    @if(auth('admin')->check())
                        @if(auth()->user()->can('create-admin') || auth()->user()->can('read-admins'))
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-star"></i>
                                    <p>
                                        Admins
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if(auth()->user()->can('read-admins'))
                                        <li class="nav-item">
                                            <a href="{{route('admins.index')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Index</p>
                                            </a>
                                        </li>
                                    @endif
                                    @if(auth()->user()->can('create-admin'))
                                        <li class="nav-item">
                                            <a href="{{route('admins.create')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif

                    @if(auth('admin')->check())
                        @if(auth()->user()->can('create-category') || auth()->user()->can('read-categories'))
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Categories
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if(auth()->user()->can('read-categories'))
                                        <li class="nav-item">
                                            <a href="{{route('categories.index')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Index</p>
                                            </a>
                                        </li>
                                    @endif
                                    @if(auth()->user()->can('create-category'))
                                        <li class="nav-item">
                                            <a href="{{route('categories.create')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif

                    @if(auth()->user()->can('create-article') || auth()->user()->can('read-articles'))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-pen"></i>
                                <p>
                                    Articles
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth()->user()->can('read-articles'))
                                    <li class="nav-item">
                                        <a href="{{route('articles.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Index</p>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('create-article'))
                                    <li class="nav-item">
                                        <a href="{{route('articles.create')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Create</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if(auth('admin')->check())
                        @if(auth()->user()->can('create-author') || auth()->user()->can('read-authors'))
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Authors
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if(auth()->user()->can('read-authors'))
                                        <li class="nav-item">
                                            <a href="{{route('authors.index')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Index</p>
                                            </a>
                                        </li>
                                    @endif
                                    @if(auth()->user()->can('create-author'))
                                        <li class="nav-item">
                                            <a href="{{route('authors.create')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif

                    @if(auth('admin')->check())
                        @if(auth()->user()->can('create-user') || auth()->user()->can('read-users'))
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Users
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if(auth()->user()->can('read-users'))
                                        <li class="nav-item">
                                            <a href="{{route('users.index')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Index</p>
                                            </a>
                                        </li>
                                    @endif
                                    @if(auth()->user()->can('create-user'))
                                        <li class="nav-item">
                                            <a href="{{route('users.create')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif

                    @if(auth('admin')->check())
                        @if(auth()->user()->can('create-role') || auth()->user()->can('read-roles') ||
                            auth()->user()->can('create-permission') || auth()->user()->can('read-permission'))
                            <li class="nav-header">Roles & Permission</li>
                            @if(auth()->user()->can('create-role') || auth()->user()->can('read-roles'))
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-signature"></i>
                                        <p>
                                            Roles
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('read-roles')
                                            <li class="nav-item">
                                                <a href="{{route('roles.index')}}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Index</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create-role')
                                            <li class="nav-item">
                                                <a href="{{route('roles.create')}}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Create</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endif

                            @if(auth()->user()->can('create-permission') || auth()->user()->can('read-permission'))
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-sign"></i>
                                        <p>
                                            Permissions
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('read-permissions')
                                            <li class="nav-item">
                                                <a href="{{route('permissions.index')}}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Index</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create-permission')
                                            <li class="nav-item">
                                                <a href="{{route('permissions.create')}}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Create</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endif
                        @endif
                    @endif

                    <li class="nav-header">Settings & Contact
                    <li class="nav-item">
                        <a @if(auth('admin')->check())
                           href="{{route('admins.edit',[Auth::user()->id])}}"
                           @elseif(auth('author')->check())
                           href="{{route('author.edit',[Auth::user()->id])}}"
                           @endif
                           class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Edit Profile</p>
                        </a>
                    </li>
                    @if(auth('admin')->check())
                        @can('read-contact-requests')
                            <li class="nav-item">
                                <a href="{{route('contact-requests.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-phone"></i>
                                    <p>Contact Requests</p>
                                </a>
                            </li>
                        @endcan
                    @endif
                    <li class="nav-item">
                        <a @if(auth('admin')->check())
                           href="{{route('cms.admin.password_reset_view')}}"
                           @else
                           href="#"
                           @endif
                           class="nav-link">
                            <i class="nav-icon fas fa-lock"></i>
                            <p>Reset Password</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a @if(auth('admin')->check())
                           href="{{route('cms.admin.logout')}}"
                           @else
                           href="{{route('cms.author.logout')}}"
                           @endif
                           class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <@yield('content')
<!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2020 <a href="#">News System</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('cms/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('cms/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('cms/dist/js/adminlte.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('cms/dist/js/demo.js')}}"></script>

@yield('scripts')
</body>
</html>
