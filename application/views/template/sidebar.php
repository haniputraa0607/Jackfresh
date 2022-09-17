<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url();?>main/index">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Jack Fresh</div>
            </a>


            <hr class="sidebar-divider my-0">


            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct"
                    aria-expanded="true" aria-controls="collapseProduct">
                    <i class="fas fa-fw fa-warehouse"></i>
                    <span>Product</span>
                </a>
                <div id="collapseProduct" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-dark py-2 collapse-inner rounded">
                        <a class="collapse-item text-light" href="utilities-color.html">New Product</a>
                        <a class="collapse-item text-light" href="utilities-color.html">List Product</a>
                        <a class="collapse-item text-light" href="utilities-color.html">List Unit</a>
                        <a class="collapse-item text-light" href="utilities-color.html">List Unit</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClient"
                    aria-expanded="true" aria-controls="collapseClient">
                    <i class="fas fa-fw fa-handshake"></i>
                    <span>Client</span>
                </a>
                <div id="collapseClient" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-dark py-2 collapse-inner rounded">
                        <a class="collapse-item text-light" href="utilities-color.html">New Client</a>
                        <a class="collapse-item text-light" href="utilities-color.html">List Client</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaction"
                    aria-expanded="true" aria-controls="collapseTransaction">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>Transaction</span>
                </a>
                <div id="collapseTransaction" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-dark py-2 collapse-inner rounded">
                        <a class="collapse-item text-light" href="utilities-color.html">New Purchase Request</a>
                        <a class="collapse-item text-light" href="utilities-color.html">List Purchase Request</a>
                        <a class="collapse-item text-light" href="utilities-color.html">List Transaction</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">


            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->