        <!-- sidebar -->
        <div class="sidebar px-4 py-4 py-md-4 me-0" id="mainHeader">
            <div class="d-flex flex-column h-100">
                <a href="index.html" class="mb-0 brand-icon">
                    <span class="logo-icon">
                        <i class="bi bi-bag-check-fill fs-4"></i>
                    </span>
                    <span class="logo-text">eBazar</span>
                </a>
                <!-- Menu: main ul -->
                <ul class="menu-list flex-grow-1 mt-3">
                    <li><a class="m-link active" href="index.php"><i class="icofont-home fs-5"></i> <span>Dashboard</span></a></li>
                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-product" href="#">
                            <i class="icofont-chart-flow fs-5"></i><span>Products</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
                            <!-- Menu: Sub menu ul -->
                            <ul class="sub-menu collapse" id="menu-product">
                            <li><a class="m-link" href="product-list.php"><i class="icofont-focus fs-5"></i> <span>Product List</span></a></li>
                            <li><a class="m-link" href="product-add.php"><i class="icofont-focus fs-5"></i> <span>Product Add</span></a></li>
                            </ul>
                    </li>

                    <li><a class="m-link" href="product-add.php"><i class="icofont-truck-loaded fs-5"></i><span>Order</span></a></li>
                    <li><a class="m-link" href="product-add.php"><i class="icofont-funky-man fs-5"></i> <span>Users</span></a></li>
                </ul>
                <!-- Menu: menu collepce btn -->
                <button type="button" class="btn btn-link sidebar-mini-btn text-light">
                    <span class="ms-2"><i class="icofont-bubble-right"></i></span>
                </button>
            </div>
        </div>
