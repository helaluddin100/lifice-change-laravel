<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Noble<span>UI</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li>

            </li>
            <li class="nav-item nav-category">web apps</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button" aria-expanded="false"
                    aria-controls="users">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Users</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="users">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link">Users</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Un Verified</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Block</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.business.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="message-square"></i>
                    <span class="link-title">Business Type</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.country.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="flag"></i>
                    <span class="link-title">Country</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.district.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="hexagon"></i>
                    <span class="link-title">Districts</span>
                </a>

            </li>


            <li class="nav-item">
                <a href="{{ route('admin.packages.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="hexagon"></i>
                    <span class="link-title">Packages</span>
                </a>

            </li>


            <li class="nav-item">
                <a href="{{ route('admin.templates.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="hexagon"></i>
                    <span class="link-title">Templates</span>
                </a>

            </li>

            <li class="nav-item">
                <a href="{{ route('admin.courier.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="hexagon"></i>
                    <span class="link-title">Couriers</span>
                </a>

            </li>



            <li class="nav-item">
                <a href="{{ route('admin.courierUser.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="hexagon"></i>
                    <span class="link-title">Courier Setup Users</span>
                </a>

            </li>



            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#subscriptions" role="button" aria-expanded="false"
                    aria-controls="subscriptions">
                    <i class="link-icon" data-feather="subscriptions"></i>
                    <span class="link-title">Subscriptions</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="subscriptions">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.subscription.index') }}" class="nav-link">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Un Verified</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Block</a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</nav>
