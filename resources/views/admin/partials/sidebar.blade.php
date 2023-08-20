<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{asset('images/logo_white.png')}}" alt="ADINKRA LOGO" class="w-100 brand-image elevation-1"
        style="opacity: .8">
        {{-- <span class="brand-text font-weight-light">ADINKRA</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('images/avatar.svg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->first_name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">



                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link @yield('dashboard_active')">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('orders', ['type' => 'orders'])}}" class="nav-link @yield('orders_active')">
                        <i class="nav-icon fas fa-shopping-cart  "></i>
                        <p>
                            Orders
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{route('products')}}" class="nav-link @yield('products_active')">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Products
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item @yield('site-pages-has-treeview') @yield('product_menu_open')">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('products')}}" class="nav-link @yield('products_active')">

                                <i class="far fa-circle nav-icon"></i>
                                <p>All products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('add-product')}}" class="nav-link @yield('add_product_active')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New product</p>
                            </a>
                        </li>
                  {{--       <li class="nav-item">
                            <a href="{{ route('admin.mustang') }}" class="nav-link @yield('mustang_active')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Mustang labels</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.taxes') }}" class="nav-link @yield('taxes_active')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tax</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.shipping') }}" class="nav-link @yield('shpping_active')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Shipping</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.coupons') }}" class="nav-link  @yield('coupons_active')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Coupons</p>
                            </a>
                        </li>
                   {{--      <li class="nav-item">
                            <a href="{{ route('admin.warranties') }}" class="nav-link @yield('warranties_active')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Warranties</p>
                            </a>
                        </li> --}}
                   {{--      <li class="nav-item">
                            <a href="{{ route('tags') }}" class="nav-link @yield('tags_active')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tags</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ route('attributes') }}" class="nav-link @yield('attributes_active')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Attributes</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item @yield('site-pages-has-treeview') @yield('filter_menu_open')">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-filter"></i>
                      <p>
                        Filters
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                   {{--  <li class="nav-item">
                        <a href="{{route('cars.filters')}}" class="nav-link @yield('filter_active')">

                            <i class="far fa-circle nav-icon"></i>
                            <p>All filters</p>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="{{ route('collections') }}" class="nav-link @yield('collections_active')">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Collections</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories') }}" class="nav-link @yield('categories_active')">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('materials') }}" class="nav-link @yield('materials_active')">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Materials</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('conditions') }}" class="nav-link @yield('conditions_active')">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Condition</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item @yield('site-pages-has-treeview') @yield('users_menu_open')">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Users
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
              {{--   <li class="nav-item">
                    <a href="{{route('admin.distributors')}}" class="nav-link @yield('distributors_active')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Distributors</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{route('admin.users')}}" class="nav-link @yield('end_user_active')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>End users</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item @yield('site-pages-has-treeview') @yield('mailing_menu_open')">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Mailing list
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('admin.mailing.subscribers')}}" class="nav-link @yield('subscribers_active')">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Subscribers</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.mailing.newsletter') }}" class="nav-link @yield('newsletter_active')">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Newsletters</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.mailing.custom-jewelry') }}" class="nav-link @yield('custom_active')">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Custom jewelry request</p>
                </a>
            </li>
        </ul>
    </li>
{{--     <li class="nav-item @yield('site-pages-has-treeview') @yield('tickets_menu_open')">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-question-circle"></i>
            <p>
                Support tickets
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('admin.tickets.categories')}}" class="nav-link @yield('tickets_category_active')">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Categories</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.tickets.list') }}" class="nav-link @yield('tickets_active')">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manage tickets</p>
                </a>
            </li>
        </ul>
    </li> --}}
{{--     <li class="nav-item">
        <a href="{{route('blog-list')}}" class="nav-link @yield('blog_active')">
            <i class="nav-icon fas fa-blog"></i>
            <p>
                Blog
            </p>
        </a>
    </li> --}}

    <li class="nav-item @yield('site-pages-has-treeview') @yield('site-pages-menu-open')">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-globe"></i>
            <p>
                Site Pages
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('pages.home')}}" class="nav-link @yield('homepage_active')">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Home Page</p>
                </a>
            </li>
        </ul>
    </li>


</ul>
</nav>
</div>
</aside>