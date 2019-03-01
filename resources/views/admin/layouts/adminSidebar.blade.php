
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->

    <ul class="sidebar-menu">
      <li class="header"></li>

      <li class="@if(Request::is('admin/dashboard')) active @endif treeview">
        <a href="{{url('admin/dashboard')}}">
          <i class="fa fa-tachometer"></i> <span>Dashboard</span>
        </a>
      </li>

      <li class="header"></li>

      <li class="@if(Request::is('admin/users') ||Request::is('admin/users/*') ) active @endif treeview">
        <a href="{{url('admin/users')}}">
          <i class="fa fa-user-circle-o"></i> <span>Users</span>
        </a>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
