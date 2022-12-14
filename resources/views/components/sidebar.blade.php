@php
$links = [
    // [
    //     'href' => 'dashboard',
    //     'text' => 'Dashboard',
    //     'icon' => 'fire',
    //     'is_multi' => false,
    // ],
    [
        'href' => [
            [
                'section_text' => 'Barang',
                'section_list' => [['href' => 'packages.index', 'text' => 'Daftar Barang'], ['href' => 'packages.create', 'text' => 'Input Barang']],
            ],
        ],
        'text' => 'Barang',
        'icon' => 'box',
        'is_multi' => true,
    ],
    [
        'href' => [
            [
                'section_text' => 'Pengguna',
                'section_list' => [['href' => 'user', 'text' => 'Daftar Pengguna'], ['href' => 'user.new', 'text' => 'Tambah Pengguna']],
            ],
        ],
        'text' => 'User',
        'icon' => 'user',
        'is_multi' => true,
    ],
];
$navigation_links = array_to_object($links);
@endphp

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">UNX</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
            UNX
                {{-- <img class="d-inline-block" width="32px" height="30.61px" src="" alt=""> --}}
            </a>
        </div>
        @foreach ($navigation_links as $link)
            <ul class="sidebar-menu">
                <li class="menu-header">{{ $link->text }}</li>
                @if (!$link->is_multi)
                    <li class="{{ Request::routeIs($link->href) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route($link->href) }}">
                            <i class="fas fa-{{ $link->icon }}"></i>
                            <span>{{ $link->text }}</span>
                        </a>
                    </li>
                @else
                    @foreach ($link->href as $section)
                        @php
                            $routes = collect($section->section_list)
                                ->map(function ($child) {
                                    return Request::routeIs($child->href);
                                })
                                ->toArray();

                            $is_active = in_array(true, $routes);
                        @endphp

                        <li class="dropdown {{ $is_active ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                                <i class="fas fa-{{ $link->icon }}"></i>
                                <span>{{ $section->section_text }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($section->section_list as $child)
                                    <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route($child->href) }}">
                                            {{ $child->text }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                @endif
            </ul>
        @endforeach
    </aside>
</div>
