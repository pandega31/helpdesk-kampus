<header class="app-topbar">
    <form class="d-flex" style="width: 340px;" role="search"
          action="{{ route('tickets.index') }}" method="GET">
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="search" name="q" value="{{ request('q') }}"
                   class="form-control" placeholder="Cari judul tiket...">
        </div>
    </form>

    <div class="dropdown">
        <a href="#" class="d-flex align-items-center gap-2 text-decoration-none text-dark dropdown-toggle"
           data-bs-toggle="dropdown">
            <i class="bi bi-person-circle fs-4 text-secondary"></i>
            <span>{{ auth()->user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">Keluar</button>
                </form>
            </li>
        </ul>
    </div>
</header>