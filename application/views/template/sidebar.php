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

            <li class="nav-item <?php if($menu_active=='dashboard'){ echo 'active'; } ?>">
                <a class="nav-link" href="<?php echo base_url() ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>


            <li class="nav-item <?php if($menu_active=='product'){ echo 'active'; } ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct"
                    aria-expanded="true" aria-controls="collapseProduct">
                    <i class="fas fa-fw fa-warehouse"></i>
                    <span>Product</span>
                </a>
                <div id="collapseProduct" class="collapse <?php if($menu_active=='product'){ echo 'show'; } ?>" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-dark py-2 collapse-inner rounded">
                        <a class="collapse-item text-secondary <?php if($submenu_active=='create-product'){ echo 'active'; } ?>" href="<?php echo base_url() ?>product/create_product">New Product</a>
                        <a class="collapse-item text-secondary <?php if($submenu_active=='list-product'){ echo 'active'; } ?>" href="<?php echo base_url() ?>product">List Product</a>
                        <a class="collapse-item text-secondary <?php if($submenu_active=='create-unit'){ echo 'active'; } ?>" href="<?php echo base_url() ?>product/unit_create">New Unit</a>
                        <a class="collapse-item text-secondary <?php if($submenu_active=='list-unit'){ echo 'active'; } ?>" href="<?php echo base_url() ?>product/unit_list">List Unit</a>
                    </div>
                </div>
            </li>

            <li class="nav-item <?php if($menu_active=='client'){ echo 'active'; } ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClient"
                    aria-expanded="true" aria-controls="collapseClient">
                    <i class="fas fa-fw fa-handshake"></i>
                    <span>Client</span>
                </a>
                <div id="collapseClient" class="collapse <?php if($menu_active=='client'){ echo 'show'; } ?>" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-dark py-2 collapse-inner rounded">
                        <a class="collapse-item text-secondary <?php if($submenu_active=='create-client'){ echo 'active'; } ?>" href="<?php echo base_url() ?>client/create_client">New Client</a>
                        <a class="collapse-item text-secondary <?php if($submenu_active=='list-client'){ echo 'active'; } ?>" href="<?php echo base_url() ?>client">List Client</a>
                    </div>
                </div>
            </li>

            <li class="nav-item <?php if($menu_active=='transaction'){ echo 'active'; } ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaction"
                    aria-expanded="true" aria-controls="collapseTransaction">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>Transaction</span>
                </a>
                <div id="collapseTransaction" class="collapse <?php if($menu_active=='transaction'){ echo 'show'; } ?>" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-dark py-2 collapse-inner rounded">
                        <a class="collapse-item text-secondary <?php if($submenu_active=='create-purchase'){ echo 'active'; } ?>" href="<?php echo base_url() ?>transaction/create_purchase">New Purchase Request</a>
                        <a class="collapse-item text-secondary <?php if($submenu_active=='list-purchase'){ echo 'active'; } ?>" href="<?php echo base_url() ?>transaction/purchase_list">List Purchase Request</a>
                        <a class="collapse-item text-secondary <?php if($submenu_active=='create-transaction'){ echo 'active'; } ?>" href="<?php echo base_url() ?>transaction/create_transaction">New Transaction</a>
                        <a class="collapse-item text-secondary <?php if($submenu_active=='list-transaction'){ echo 'active'; } ?>" href="<?php echo base_url() ?>transaction">List Transaction</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">


            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->