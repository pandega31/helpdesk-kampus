<header class="app-topbar">
    <form class="d-flex" style="width: 340px;" role="search"
          action="{{ route('tickets.index') }}" method="GET">
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="search" name="q" value="{{ request('q') }}"
                   class="form-control" placeholder="Cari judul tiket...">
        </div>
    </form>

    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-person-circle fs-4 text-secondary"></i>
        <span>{{ auth()->user()?->name ?? 'Tamu' }}</span>
    </div>
</header>