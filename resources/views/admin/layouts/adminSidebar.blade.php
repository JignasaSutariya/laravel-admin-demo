
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

      <li class="@if(Request::is('admin/countries') ||Request::is('admin/countries/*') ) active @endif treeview">
        <a href="{{url('admin/countries')}}">
          <i class="fa fa-globe"></i> <span>Country/State/City</span>
        </a>
      </li>

      <li class="@if(Request::is('admin/categories') ||Request::is('admin/categories/*') ) active @endif treeview">
        <a href="{{url('admin/categories')}}">
          <i class="fa fa-globe"></i> <span>Categories</span>
        </a>
      </li>

      <li class="@if(Request::is('admin/sub-categories') ||Request::is('admin/sub-categories/*') ) active @endif treeview">
        <a href="{{url('admin/sub-categories')}}">
          <i class="fa fa-globe"></i> <span>Sub Categories</span>
        </a>
      </li>

      <li class="@if(Request::is('admin/products') ||Request::is('admin/products/*') ) active @endif treeview">
        <a href="{{url('admin/products')}}">
          <i class="fa fa-globe"></i> <span>Products</span>
        </a>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
