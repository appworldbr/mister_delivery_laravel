


<li class="nav-item {{ Request::is('settings*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('settings.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Configurações</span>
    </a>
</li>
<li class="nav-item {{ Request::is('userAddresses*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('userAddresses.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>User Addresses</span>
    </a>
</li>

<li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('users.index') !!}">
        <i class="nav-icon icon-cursor"></i>
        <span>Users</span>
    </a>
</li>
<li class="nav-item {{ Request::is('workSchedules*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('workSchedules.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Horarios de trabalho</span>
    </a>
</li>
<li class="nav-item {{ Request::is('deliveryAreas*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('deliveryAreas.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Delivery Areas</span>
    </a>
</li>
<li class="nav-item {{ Request::is('foodCategories*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('foodCategories.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Food Categories</span>
    </a>
</li>
