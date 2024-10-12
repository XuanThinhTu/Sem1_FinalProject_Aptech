<div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="{{ asset('admincss/img/avatar-6.jpg') }}" alt="..."
                    class="img-fluid rounded-circle">
            </div>
            <div class="title">
                <h1 class="h5">Mark Stephen</h1>
                <p>Web Designer</p>
            </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}"> <i class="icon-home"></i>Home </a>
            </li>
            <li class="{{ Request::is('admin/categories') ? 'active' : '' }}">
                <a href="{{ url('/admin/categories') }}"> <i class="icon-grid"></i>Categories </a>
            </li>
            <li class="{{ Request::is('admin/items') ? 'active' : '' }}">
                <a href="{{ url('/admin/items') }}"> <i class="icon-grid"></i>Items </a>
            </li>
            <li class="{{ Request::is('/admin/users') ? 'active' : '' }}">
                <a href="{{ url('/admin/users') }}"> <i class="icon-grid"></i>Users </a>
            </li>
            <li class="{{ Request::is('/admin/auctions') ? 'active' : '' }}">
                <a href="{{ url('/admin/auctions') }}"> <i class="icon-grid"></i>Auctions </a>
            </li>
            <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i
                        class="icon-windows"></i>Example dropdown </a>
                <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                    <li><a href="#">Page</a></li>
                    <li><a href="#">Page</a></li>
                    <li><a href="#">Page</a></li>
                </ul>
            </li>
        </ul>
    </nav>
