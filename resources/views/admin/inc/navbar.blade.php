<li class="nav-item has-sub">
    <a href="#">
        <i class="feather icon-home"></i><span class="menu-title">Страницы</span>
    </a>
    <ul class="menu-content">
        <li class="menu-item @yield('section.home')">
            <a href="{{ route('admin.section.view', 'home') }}"><i class="feather icon-circle"></i>Главная</a>
        </li>
        <li class="menu-item @yield('section.about')">
            <a href="{{ route('admin.section.view', 'about') }}"><i class="feather icon-circle"></i>О нас</a>
        </li>
        <li class="menu-item @yield('section.products')">
            <a href="{{ route('admin.section.view', 'products') }}"><i class="feather icon-circle"></i>Продукты</a>
        </li>
        <li class="menu-item @yield('section.contacts')">
            <a href="{{ route('admin.section.view', 'contacts') }}"><i class="feather icon-circle"></i>Контакты</a>
        </li>
    </ul>
</li>
<li class="nav-item has-sub">
    <a href="#">
        <i class="feather icon-file"></i><span class="menu-title">Заявки</span>
    </a>
    <ul class="menu-content">
        <li class="menu-item @yield('application.application')">
            <a href="{{ route('admin.application.application') }}"><i class="feather icon-circle"></i>Заявки</a>
        </li>
        <li class="menu-item @yield('application.order')">
            <a href="{{ route('admin.application.order') }}"><i class="feather icon-circle"></i>Заказы</a>
        </li>
    </ul>
</li>
