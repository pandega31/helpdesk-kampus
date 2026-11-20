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
            {{-- Tahap 3: ganti href dengan route('tickets.index') --}}
            <a href="#"><i class="bi bi-ticket-detailed"></i> Daftar Tiket</a>
        </li>
        <li>
            {{-- Tahap 4: halaman keluhan umum --}}
            <a href="#"><i class="bi bi-chat-left-text"></i> Keluhan Umum</a>
        </li>
        <li>
            <a href="{{ route('categories.index') }}"
               class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Kelola Kategori
            </a>
        </li>
        <li>
            {{-- Tahap 4: kelola user --}}
            <a href="#"><i class="bi bi-people"></i> Kelola User</a>
        </li>
        <li>
            {{-- Tahap 4: profil --}}
            <a href="#"><i class="bi bi-person"></i> Profil</a>
        </li>
    </ul>

    <div class="sidebar-user">
        <i class="bi bi-person-circle fs-3"></i>
        <div>
            Admin
            <small>Administrator</small>
        </div>
    </div>
</aside>