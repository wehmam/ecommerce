<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Oke Shop<sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ is_null(Request::segment(2))  ? "active" : ""  }}">
        <a class="nav-link" href="{{ url("/backend") }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ Request::segment(2) == "category" ? "active" : ""  }}">
        <a class="nav-link" href="{{ url("/backend/category") }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Category</span></a>
    </li>

    <li class="nav-item {{ Request::segment(2) == "product" ? "active" : ""  }}">
        <a class="nav-link" href="{{ url("/backend/product") }}">
            <i class="fa fa-shopping-bag"></i>
            <span>Product</span></a>
    </li>

    <li class="nav-item {{ Request::segment(2) == "orders" ? "active" : ""  }}">
        <a class="nav-link" href="{{ url("/backend/orders") }}">
            <i class="fa fa-shopping-basket"></i>
            <span>Orders</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
</ul>
<!-- End of Sidebar -->
