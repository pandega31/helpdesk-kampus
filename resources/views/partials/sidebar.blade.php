@php $user = auth()->user(); @endphp

<aside class="app-sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <i class="bi bi-mortarboard-fill"></i> Helpdesk Kampus
    </a>

    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('tickets.index') }}"
               class="{{ request()->routeIs('tickets.index', 'tickets.show') ? 'active' : '' }}">
                <i class="bi bi-ticket-detailed"></i>
                {{ $user->isStaff() ? 'Daftar Tiket' : 'Tiket Saya' }}
            </a>
        </li>

        @unless ($user->isStaff())
            <li>
                <a href="{{ route('tickets.create') }}"
                   class="{{ request()->routeIs('tickets.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-square"></i> Buat Tiket
                </a>
            </li>
        @endunless

        <li>
            <a href="{{ route('complaints.index') }}"
               class="{{ request()->routeIs('complaints.*') ? 'active' : '' }}">
                <i class="bi bi-chat-left-text"></i> Keluhan Umum
            </a>
        </li>

        @if ($user->isAdmin())
            <li>
                <a href="{{ route('categories.index') }}"
                   class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> Kelola Kategori
                </a>
            </li>
        @endif

        <li>
            <a href="{{ route('profile.edit') }}"
               class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person"></i> Profil
            </a>
        </li>
    </ul>

    <div class="sidebar-user">
        <i class="bi bi-person-circle fs-3"></i>
        <div>
            {{ $user->name }}
            <small>{{ ucfirst($user->role) }}</small>
        </div>
    </div>
</aside>