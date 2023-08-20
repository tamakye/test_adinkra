<div class="card p-0 user-sidenav">
    <div class="card-body">
        <div class="list-group list-group-flush">
            <a href="{{ route('profile') }}" class="list-group-item list-group-item-action @yield('my-account-active')" aria-current="true">
                <i class="fa fa-home mr-2"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('my-orders') }}" class="list-group-item list-group-item-action @yield('my-orders-active')">
                <i class="fa fa-box mr-2"></i>
                <span>My Orders</span>
            </a>
            <a href="{{ route('my-wishlist') }}" class="list-group-item list-group-item-action @yield('my-wishlist-active')">
                <i class="fa fa-heart mr-2"></i>
                <span>My wishlist</span>
            </a>

            <a href="{{ route('address') }}" class="list-group-item list-group-item-action @yield('address-active')">
                <i class="fa fa-map-pin mr-2"></i>
                <span>My address</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action @yield('accountActive')">
                <i class="fa fa-user-alt mr-2"></i>
                <span>My Account</span>
            </a>
        </div>
    </div>
</div>